<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function showCheckout()
    {
        $cart = session()->get('cart', []);
        $totalAmount = collect($cart)->sum(fn($item) => $item['quantity'] * $item['price']);

        $cartItems = collect($cart)->map(function ($item) {
            return (object) [
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        });

        return view('checkout.index', [
            'cart' => $cart,
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function createOrder(Request $request)
    {
        if (!Auth::check()) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'You must be logged in.'], 401);
            }
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'contact' => 'required|string|max:20',
            'payment_method' => 'required|string|in:mpesa,card,cash',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 400);
            }
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $totalAmount = collect($cart)->sum(fn($item) => $item['quantity'] * $item['price']);
        $order = null;

        try {
            DB::beginTransaction();

            // Create order record
            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_name' => $request->name,
                'shipping_address' => $request->address,
                'contact_number' => $request->contact,
                'email' => $request->email,
                'total_amount' => $totalAmount,
                'status' => 'Pending',
                'payment_method' => $request->payment_method, // Use the selected method
            ]);

            // Create order items and reduce stock
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product = Product::findOrFail($productId);
                $product->stock -= $item['quantity'];
                $product->save();
            }

            // Store order info in session for the next steps
            session([
                'order_id' => $order->id,
                'cart_total' => $totalAmount,
            ]);

            DB::commit();

            // For non-MPESA payments, clear cart immediately
            if ($request->payment_method !== 'mpesa') {
                session()->forget(['cart']);
                
                // Send confirmation email for non-MPESA payments
                Mail::to($order->email)->send(new OrderConfirmation($order));
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'order_id' => $order->id,
                    'payment_method' => $request->payment_method,
                    'redirect' => $request->payment_method === 'mpesa' 
                        ? route('payment.method', ['order_id' => $order->id])
                        : route('checkout.confirmation', ['order_id' => $order->id])
                ]);
            }

            // Fallback for non-AJAX requests
            if ($request->payment_method === 'mpesa') {
                return redirect()->route('payment.method', ['order_id' => $order->id]);
            } else {
                return redirect()->route('checkout.confirmation', ['order_id' => $order->id]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation error: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create order. Please try again.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to create order. Please try again.');
        }
    }

    public function showPaymentPage($order_id = null)
    {
        $orderId = $order_id ?? session('order_id');
        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'No order found.');
        }

        $order = Order::with('items.product')->findOrFail($orderId);
        return view('payment', compact('order'));
    }

    /**
     * This processes the final status change. 
     * We clear the cart here because the payment step is considered "finished."
     */
    public function processOrder(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,mpesa',
        ]);

        $orderId = session('order_id');

        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'No order found.');
        }

        $order = Order::findOrFail($orderId);
        
        $order->payment_method = $validatedData['payment_method'];
        $order->status = 'completed'; 
        $order->save();

        // Send order confirmation email
        Mail::to($order->email)->send(new OrderConfirmation($order));

        // NOW we clear the session data
        session()->forget(['cart', 'shipping_info', 'order_id', 'cart_total']);

        return redirect()->route('checkout.confirmation', ['order_id' => $order->id]);
    }

    public function showConfirmation($order_id = null)
{
    // 1. Determine the Order ID from the URL or the session
    $orderId = $order_id ?? session('order_id');
    
    if (!$orderId) {
        return redirect()->route('products.index')->with('error', 'No order ID found.');
    }

    // 2. Fetch the order details
    $order = Order::with('items.product')->findOrFail($orderId);

    // 3. Clear EVERYTHING related to the previous purchase
    // This ensures the cart is empty and session variables are reset
    session()->forget(['cart', 'order_id', 'cart_total', 'shipping_info']);

    return view('checkout.confirmation', compact('order'));
}

    public function cancelOrder($order_id)
    {
        $order = Order::with('items')->findOrFail($order_id);

        // Only allow cancellation of pending orders
        if ($order->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending orders can be canceled.');
        }

        DB::transaction(function () use ($order) {
            // 1. Restore the stock for each product
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            // 2. Delete the order items and the order
            // Alternatively, set status to 'Canceled' instead of deleting
            $order->items()->delete();
            $order->delete();

            // 3. Clear the order_id from session but KEEP the cart
            session()->forget(['order_id', 'cart_total']);
        });

        return redirect()->route('cart.view')->with('success', 'Order canceled and stock restored. You can now modify your cart.');
    }

    /**
     * Check the status of an order for frontend polling.
     */
    public function checkStatus($order_id)
    {
        // We only need the status column to keep the response light
        $order = Order::select('status')->findOrFail($order_id);
        
        return response()->json([
            'status' => strtolower($order->status)
        ]);
    }
}