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
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'contact' => 'required|string|max:20',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $totalAmount = collect($cart)->sum(fn($item) => $item['quantity'] * $item['price']);

        $order = null;

        DB::transaction(function () use ($request, $cart, $totalAmount, &$order) {
            // Create order record
            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_name' => $request->name,
                'shipping_address' => $request->address,
                'contact_number' => $request->contact,
                'email' => $request->email,
                'total_amount' => $totalAmount,
                'status' => 'Pending',
                'payment_method' => 'M-pesa',
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

            // NOTE: We do NOT clear the cart here anymore.
            // If payment fails, the user can still see their items.
        });

  if (!$order) {
            return redirect()->back()->with('error', 'Failed to create order. Please try again.');
        }

        return redirect()->route('payment.method', ['order_id' => $order->id]);
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

        return redirect()->route('checkout.confirmation');
    }

    public function showConfirmation()
    {
        // If the user gets here via a direct redirect from M-Pesa callback:
        $orderId = session('order_id');
        
        if (!$orderId) {
            return redirect()->route('products.index')->with('error', 'No order ID found.');
        }

        $order = Order::findOrFail($orderId);

        // Safety net: Clear cart here if it wasn't cleared in processOrder
        session()->forget(['cart', 'order_id', 'cart_total']);

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