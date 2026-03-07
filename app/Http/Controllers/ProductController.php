<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\User; // Added for notification targeting
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use App\Notifications\NewOrderReceived; // Import the new Notification class
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification; // Added for sending to multiple users

class ProductController extends BaseController
{
    /**
     * 1. Product Listing and Details
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * 2. Cart Management
     */
    
    // Standard Redirect Add to Cart
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
        $this->updateCartTotal();

        return redirect()->route('products.show', $id)->with('success', 'Product added to cart successfully!');
    }

    // AJAX Add to Cart (for Home/Listing pages)
    public function addToCartAjax(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
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
        $this->updateCartTotal();

        return response()->json([
            'success' => true,
            'message' => 'Added to cart!',
            'count' => array_sum(array_column($cart, 'quantity')),
            'ids' => array_keys($cart)
        ]);
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // AJAX Quantity Update (for Cart Page)
    public function updateQuantityAjax(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int)$request->input('quantity');
            session()->put('cart', $cart);
            $this->updateCartTotal();

            return response()->json([
                'success' => true,
                'subtotal' => $cart[$id]['quantity'] * $cart[$id]['price'],
                'total' => session('cart_total', 0),
                'count' => array_sum(array_column($cart, 'quantity')),
                'ids' => array_keys($cart)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart.'], 404);
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

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'count' => array_sum(array_column($cart, 'quantity')),
            'ids' => array_keys($cart)
        ]);
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

    /**
     * 3. Checkout Process
     */
    public function checkout()
    {
        $cart = session()->get('cart');

        if (empty($cart)) {
            return redirect()->route('products.index')->with('warning', 'Your cart is empty.');
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
            return redirect()->route('checkout.index')->with('error', 'Failed to create order.');
        }

        return redirect()->route('checkout.payment');
    }

    public function showPaymentOptions()
    {
        $orderId = session('order_id');
        if (!$orderId) return redirect()->route('checkout.index');

        $order = Order::findOrFail($orderId);
        return view('checkout.payment', [
            'order' => $order,
            'cartItems' => session()->get('cart'),
            'shippingInfo' => session()->get('shipping_info'),
            'total' => session('cart_total', 0),
        ]);
    }

    public function processOrder(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,mpesa',
        ]);

        $orderId = session('order_id');
        $order = Order::findOrFail($orderId);
        $paymentMethod = $validatedData['payment_method'];

        if ($this->simulatePayment($paymentMethod)) {
            $order->status = 'completed';
            $order->payment_method = $paymentMethod;
            $order->save();

            // 1. Send Email
            Mail::to($order->email)->send(new OrderConfirmation($order));

            // 2. TRIGGER NOTIFICATION: Notify Admins and Managers
            $staff = User::whereIn('role', ['admin', 'manager'])->get();
            Notification::send($staff, new NewOrderReceived($order));

            session()->forget(['cart', 'shipping_info', 'order_id', 'cart_total']);

            return redirect()->route('checkout.confirmation');
        } else {
            $order->status = 'failed';
            $order->save();
            return redirect()->route('checkout.payment')->with('error', 'Payment failed.');
        }
    }

    public function showOrderConfirmation()
    {
        $orderId = session('order_id');
        if (!$orderId) return redirect()->route('products.index');
        
        $order = Order::findOrFail($orderId);
        return view('checkout.confirmation', compact('order'));
    }

    private function simulatePayment($paymentMethod)
    {
        $rates = ['credit_card' => 90, 'paypal' => 80, 'mpesa' => 95];
        return rand(1, 100) <= ($rates[$paymentMethod] ?? 0);
    }
}