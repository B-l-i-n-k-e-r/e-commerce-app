<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }
        
        // Get all categories for filter dropdown
        $categories = Category::all();
        
        // Paginate 10 per page
        $products = $query->paginate(10);
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        // Fetch categories to populate the dropdown in the view
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image_url = $imagePath;
        } else {
            $product->image_url = null;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        // Fetch categories for the edit page as well
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
            
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image_url = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $orderItems = OrderItem::where('product_id', $product->id)->with('order')->get();
        $hasNonDeliveredOrders = false;

        foreach ($orderItems as $orderItem) {
            if ($orderItem->order && $orderItem->order->status !== 'delivered') {
                $hasNonDeliveredOrders = true;
                break;
            }
        }

        if ($hasNonDeliveredOrders) {
            return redirect()->route('admin.products.index')->with('error', 'Cannot delete product because it is included in orders that are not yet delivered.');
        }

        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        try {
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Product Deletion Error: " . $e->getMessage());
            return redirect()->route('admin.products.index')->with('error', 'Make sure you archive your order and try again!!!');
        }
    }

    public function lowStock()
    {
        $products = Product::where('stock', '<', 10)->get();
        return view('admin.products.low_stock', compact('products'));
    }
}