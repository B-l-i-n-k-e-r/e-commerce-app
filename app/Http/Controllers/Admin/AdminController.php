<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalUsers = User::count(); // Get the total number of users

        return View::make('admin.dashboard', compact('totalRevenue', 'totalOrders', 'totalProducts', 'totalUsers')); // Pass $totalUsers to the view
    }

    public function reports()
    {
        $orders = Order::latest()->get();
        return View::make('admin.reports', compact('orders'));
    }
}
