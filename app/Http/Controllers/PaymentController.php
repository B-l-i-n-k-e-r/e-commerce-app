<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    // Show payment page for a specific order
    public function showPaymentPage($order_id)
    {
        $order = Order::with('items.product')->findOrFail($order_id);

        return view('payment', compact('order'));
    }

    // Process payment for the order
    public function processPayment(Request $request, $order_id)
    {
        $request->validate([
            'payment_method' => 'required|string|in:credit card,paypal,mpesa',
        ]);

        $order = Order::findOrFail($order_id);

        // Simulate payment success: update payment method and status
        $order->payment_method = $request->payment_method;
        $order->status = 'paid';
        $order->save();

        // Redirect to the order confirmation page, passing order_id as route param
        // CORRECTED ROUTE NAME HERE
        return redirect()->route('order.user.confirmation', ['order_id' => $order->id])
                         ->with('success', 'Payment successful!');
    }

    // Show order confirmation page
    public function confirmOrder($order_id)
    {
        $order = Order::with('items.product')->findOrFail($order_id);

        // IMPORTANT: The blade file must be named as 'orders.confirmation' or adjust here
        return view('orders.confirmation', compact('order'));
    }
}