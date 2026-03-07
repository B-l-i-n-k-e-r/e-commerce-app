<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // 1. Import your Product model

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 2. Fetch products from the database
        // We use 'with' to eager load categories if you have that relationship set up
        $products = Product::with('category')->get(); 

        // 3. Pass the $products variable to the view
        return view('home', compact('products'));
    }
}