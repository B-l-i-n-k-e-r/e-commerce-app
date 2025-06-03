<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $products = Product::all();
        $recentOrders = Order::where('user_id', Auth::id()) // This line ensures we only get orders for the logged-in user
                             ->latest()
                             ->take(3) // Get the 3 most recent orders
                             ->get();

        return view('dashboard.index', compact('products', 'recentOrders'));
    }
}