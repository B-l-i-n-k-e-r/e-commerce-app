<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;


$statuses = Order::getStatuses();
$paymentMethods = Order::getPaymentMethods();

class OrderAdminController extends Controller
{
    // Status constants that match your actual database values
    protected const ORDER_STATUSES = [
        'Pending' => 'Pending',
        'Completed' => 'Completed', 
        'Cancelled' => 'Cancelled'
    ];

    // Payment methods that match your actual values
    protected const PAYMENT_METHODS = [
        'M-Pesa' => 'M-Pesa',
        'PayPal' => 'PayPal',
        'Credit Card' => 'Credit Card'
    ];

    // Show all orders with pagination
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
                    ->latest()
                    ->paginate(10);
                    
        return view('admin.orders.index', compact('orders'));
    }

    // Show form to edit order
    public function edit(Order $order)
    {
        $order->load(['user', 'items.product']);
        
        return view('admin.orders.edit', [
            'order' => $order,
            'statuses' => self::ORDER_STATUSES,
            'paymentMethods' => self::PAYMENT_METHODS
        ]);
    }

    // Update order
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', self::ORDER_STATUSES),
            'payment_method' => 'required|string|in:' . implode(',', self::PAYMENT_METHODS),
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')
               ->with('success', 'Order updated successfully.');
    }

    // Archive order
    public function archive(Order $order)
    {
        // Only allow archiving if status is Completed
        if ($order->status !== 'Completed') {
            return back()->with('error', 'Only completed orders can be archived.');
        }

        // Soft delete the order
        $order->delete();

        return back()->with('success', 'Order archived successfully.');
    }
}