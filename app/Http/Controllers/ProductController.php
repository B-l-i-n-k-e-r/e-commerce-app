<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends BaseController
{
    // 1. Product Listing and Details
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // 2. Cart Management
    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'product_code' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image_url' => $product->image_url ?? null,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('products.show', $id)->with('success', 'Product added to cart successfully!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            session()->put('cart', $cart);
            $this->updateCartTotal();
            return redirect()->route('cart.view')->with('success', 'Cart updated successfully!');
        }

        return redirect()->route('cart.view')->with('error', 'Product not found in cart.');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            $this->updateCartTotal();
            return redirect()->route('cart.view')->with('success', 'Product removed from cart successfully!');
        }

        return redirect()->route('cart.view')->with('error', 'Product not found in cart.');
    }

    public function updateQuantityAjax(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);
    $cart = session()->get('cart', []);


    if (isset($cart[$id])) {
        $quantity = $request->input('quantity');
        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);
        $this->updateCartTotal();

        $subtotal = $cart[$id]['quantity'] * $cart[$id]['price'];

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'total' => session('cart_total', 0),
        ]);
    }

    return response()->json(['success' => false, 'message' => 'Product not found in cart.'], 404);
}

    private function updateCartTotal()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        session(['cart_total' => $total]);
    }

    // 3. Checkout Process
    public function checkout()
    {
        $cart = session()->get('cart');

        if (empty($cart)) {
            return redirect()->route('products.index')->with('warning', 'Your cart is empty. Please add items to checkout.');
        }

        $this->updateCartTotal();
        return view('checkout.index', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:500',
        ]);

        session(['shipping_info' => $validatedData]);
        $cart = session()->get('cart');
        $totalAmount = session('cart_total', 0);

        if (!$cart) {
            return redirect()->route('checkout.index')->with('error', 'Your cart is empty.');
        }

        try {
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = auth()->id();
            $order->total_amount = $totalAmount;
            $order->status = 'pending';
            $order->name = $validatedData['name'];
            $order->email = $validatedData['email'];
            $order->shipping_address = $validatedData['shipping_address'];
            $order->save();

            foreach ($cart as $productId => $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->save();
            }

            DB::commit();
            session(['order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating order: ' . $e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'Failed to create order. Please try again.');
        }
        return redirect()->route('checkout.payment');
    }

    private function simulatePayment($paymentMethod)
    {
        switch ($paymentMethod) {
            case 'credit_card':
                return rand(1, 100) <= 90;
            case 'paypal':
                return rand(1, 100) <= 80;
            case 'mpesa':
                return rand(1, 100) <= 95;
            default:
                return false;
        }
    }

    public function showOrderConfirmation()
    {
        $orderId = session('order_id');
        if (!$orderId) {
            return redirect()->route('products.index')->with('error', 'No order ID found. Please complete the checkout process.');
        }
        $order = Order::findOrFail($orderId);
        return view('checkout.confirmation', compact('order'));
    }

    public function showPaymentOptions()
    {
        $orderId = session('order_id');

        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'No order found. Please complete checkout again.');
        }

        $order = Order::findOrFail($orderId);
        $cart = session()->get('cart');
        $shippingInfo = session()->get('shipping_info');
        $total = session('cart_total', 0);

        return view('checkout.payment', [
            'order' => $order,
            'cartItems' => $cart,
            'shippingInfo' => $shippingInfo,
            'total' => $total,
        ]);
    }

    public function processOrder(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,mpesa',
        ]);

        $orderId = session('order_id');
        if (!$orderId) {
            return redirect()->route('checkout.payment')->with('error', 'No order found. Please complete checkout again.');
        }

        $order = Order::findOrFail($orderId);
        $paymentMethod = $validatedData['payment_method'];
        $totalAmount = session('cart_total', 0);

        $paymentSuccessful = $this->simulatePayment($paymentMethod);

        if ($paymentSuccessful) {
            $order->status = 'completed';
            $order->payment_method = $paymentMethod;
            $order->save();

            Mail::to($order->email)->send(new OrderConfirmation($order));

            session()->forget(['cart', 'shipping_info', 'order_id', 'cart_total']);

            return redirect()->route('checkout.confirmation');
        } else {
            $order->status = 'failed';
            $order->payment_method = $paymentMethod;
            $order->save();

            return redirect()->route('checkout.payment')->with('error', 'Payment failed. Please try a different payment method.');
        }
    }
    
}