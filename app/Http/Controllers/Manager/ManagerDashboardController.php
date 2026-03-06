<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        // 1. Calculate the data
        $total_orders = Order::count();
        
        // Use the name your Blade is looking for: $low_stock
        $low_stock = Product::where('stock', '<', 10)->count();

        // Get the actual product list for the sidebar/table
        $low_stock_products = Product::where('stock', '<', 10)->get();

        // FIX: Change ->limit(5)->get() to ->paginate(5)
        // This provides the Paginator object that has the 'hasPages' method
        $recent_orders = Order::with('user')->latest()->paginate(5);

        // 2. Pass them to the view
        return view('manager.dashboard', compact(
            'total_orders', 
            'low_stock', 
            'low_stock_products', 
            'recent_orders'
        ));
    }
}