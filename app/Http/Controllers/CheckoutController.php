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
            Log::info('Before Order Create');

            // Create order with payment_method = null initially
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

            Log::info('Order Created', ['order_id' => $order->id]);

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

            // Store order info in session
            session([
                'order_id' => $order->id,
                'cart_total' => $totalAmount,
            ]);

            // Clear cart after order created
            session()->forget('cart');
        });

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

    public function processOrder(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,mpesa',
        ]);

        $orderId = session('order_id');

        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'No order found. Please complete checkout again.');
        }

        $order = Order::findOrFail($orderId);
        $paymentMethod = $validatedData['payment_method'];

        // Save payment method and update order status
        $order->payment_method = $paymentMethod;
        $order->status = 'completed'; // Or handle logic depending on payment success
        $order->save();

        // Clear session info after successful order processing
        session()->forget(['cart', 'shipping_info', 'order_id', 'cart_total']);

        // Send order confirmation email
        Mail::to($order->email)->send(new OrderConfirmation($order));

        return redirect()->route('checkout.confirmation');
    }

    public function showConfirmation()
    {
        $orderId = session('order_id');
        if (!$orderId) {
            return redirect()->route('products.index')->with('error', 'No order ID found for confirmation.');
        }

        $order = Order::findOrFail($orderId);
        return view('checkout.confirmation', compact('order'));
    }
}
