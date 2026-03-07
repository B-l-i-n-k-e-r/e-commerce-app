<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product; // Added to fetch current prices
use Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    // Show orders for logged-in user with optional search
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $query = Order::where('user_id', Auth::id());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%");
            });
        }

        $orders = $query->latest()->paginate(12);

        return view('orders.index', compact('orders'));
    }

    /**
     * Manager/Admin method to update order status
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->status = $validated['status'];
        $order->save();

        $order->user->notify(new OrderStatusUpdated($order));

        return back()->with('success', 'Order status updated and customer notified.');
    }

    /**
     * Create new order using SESSION cart
     */
    public function createOrder(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string|max:15',
        ]);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->shipping_name = $validated['name'];
        $order->shipping_address = $validated['address'];
        $order->contact_number = $validated['contact'];
        $order->total_amount = $this->calculateTotalAmount($cart);
        $order->status = 'pending';
        $order->save();

        // Attach session items to the order
        foreach ($cart as $id => $details) {
            $order->items()->create([
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        // Clear the session cart
        session()->forget('cart');

        return redirect()->route('payment.method', ['order_id' => $order->id]);
    }

    public function showPaymentMethodForm(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.payment_method', compact('order'));
    }

    public function savePaymentMethod(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $order->payment_method = $request->payment_method;
        $order->save();

        return redirect()->route('orders.showConfirmation', $order->id)
                         ->with('success', 'Payment method saved successfully.');
    }

    /**
     * Helper: Calculate total from SESSION array
     */
    private function calculateTotalAmount(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function show(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function showConfirmation(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.confirmation', compact('order'));
    }

    public function archive(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->status = 'archived';
        $order->save();

        $order->user->notify(new OrderStatusUpdated($order));

        return redirect()->route('orders.index')->with('success', 'Order archived successfully.');
    }
}