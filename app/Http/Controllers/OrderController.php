<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    // Create new order WITHOUT payment_method
    public function createOrder(Request $request): RedirectResponse
    {
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
        $order->total_amount = $this->calculateTotalAmount();
        $order->status = 'pending';
        // payment_method NOT set here
        $order->save();

        // Attach cart items to order
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // Clear user's cart
        $cartItems->each->delete();

        // Redirect to payment method selection form
        return redirect()->route('payment.method', ['order_id' => $order->id]);
    }

    // Show payment method selection form
    public function showPaymentMethodForm(Order $order): View
    {
        // Optionally, verify ownership here
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.payment_method', compact('order'));
    }

    // Save payment method submitted by user
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

        // Redirect to confirmation or payment processing page
        return redirect()->route('orders.showConfirmation', $order->id)
                         ->with('success', 'Payment method saved successfully.');
    }

    // Helper: Calculate total cart amount for logged-in user
    private function calculateTotalAmount(): float
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        return $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    // Show order details
    public function show(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    // Show order confirmation page
    public function showConfirmation(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.confirmation', compact('order'));
    }

    // Archive an order (optional)
    public function archive(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->status = 'archived';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order archived successfully.');
    }
}
