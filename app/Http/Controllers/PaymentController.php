<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Show payment page for a specific order.
     */
    public function showPaymentPage($order_id)
    {
        // Eager load to prevent N+1 query issues in the view
        $order = Order::with(['items.product'])->findOrFail($order_id);

        // Optional: Check if order is already paid to prevent double payment
        if ($order->status === 'paid') {
            return redirect()->route('order.user.confirmation', ['order_id' => $order->id])
                             ->with('info', 'This order has already been paid.');
        }

        return view('payment', compact('order'));
    }

    /**
     * Process simulated payments (Card/PayPal).
     * For M-Pesa, this usually just redirects to the STK Push logic.
     */
    public function processPayment(Request $request, $order_id)
    {
        $request->validate([
            'payment_method' => 'required|string|in:credit card,paypal,mpesa',
        ]);

        $order = Order::findOrFail($order_id);

        // If M-Pesa is chosen, we don't mark as 'paid' yet. 
        // We redirect to the STK initiation logic.
        if ($request->payment_method === 'mpesa') {
            return redirect()->route('mpesa.pay', ['order_id' => $order->id]);
        }

        // For simulated Credit Card/PayPal
        DB::transaction(function () use ($order, $request) {
            $order->update([
                'payment_method' => $request->payment_method,
                'status' => 'paid',
                'paid_at' => now(), // Good practice to track payment time
            ]);
        });

        return redirect()->route('order.user.confirmation', ['order_id' => $order->id])
                         ->with('success', 'Payment successful!');
    }

    /**
     * Show order confirmation page.
     */
    public function confirmOrder($order_id)
    {
        $order = Order::with('items.product')->findOrFail($order_id);
        
        // Ensure the view path matches your file structure
        return view('orders.confirmation', compact('order'));
    }
}