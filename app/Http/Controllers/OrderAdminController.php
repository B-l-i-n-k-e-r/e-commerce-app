<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderAdminController extends Controller
{
    // These constants should match exactly what you want to store in the DB
    protected const ORDER_STATUSES = [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'delivered' => 'Delivered', 
        'cancelled' => 'Cancelled'
    ];

    protected const PAYMENT_METHODS = [
        'M-Pesa' => 'M-Pesa',
        'PayPal' => 'PayPal',
        'Credit Card' => 'Credit Card'
    ];

    public function index(): View
    {
        $orders = Order::with(['user', 'items.product'])
                    ->latest()
                    ->paginate(10);
                    
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        $order->load(['user', 'items.product']);
        
        return view('admin.orders.edit', [
            'order' => $order,
            'statuses' => self::ORDER_STATUSES,
            'paymentMethods' => self::PAYMENT_METHODS
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        // We validate against the KEYS of our array (pending, processing, etc.)
        $request->validate([
            'status' => 'required|string|in:' . implode(',', array_keys(self::ORDER_STATUSES)),
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order status updated successfully!');
    }

    public function archive(Order $order): RedirectResponse
    {
        // Matching your logic: only archived if status is 'delivered' or 'completed'
        // Adjust the string to match your DB casing
        if (strtolower($order->status) !== 'delivered' && strtolower($order->status) !== 'completed') {
            return back()->with('error', 'Only delivered or completed orders can be archived.');
        }

        $order->delete(); // This assumes you are using SoftDeletes on your Order model

        return redirect()->route('admin.orders.index')->with('success', 'Order archived successfully.');
    }
}