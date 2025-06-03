<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderItem;
use App\Models\Order;
 
class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }
 
    public function store(Request $request)
    {
        // Validate request (you may want to add your validation rules here)
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validation for image
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Store the image in storage/app/public/images
            $imagePath = $image->store('images', 'public');  // This will store it in storage/app/public/images

            // Set the image_url to the stored file path
            $product->image_url = $imagePath;
        } else {
            // Handle the case where no image is uploaded, set to null or a default
            $product->image_url = null;
        }

        // Save product to the database
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $productData = $validated; // Start with validated data

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            // Store image
            $image->storeAs('public/images', $filename);
            // Save relative path
            $imagePath = $image->store('images', 'public');

            $product->image_url = $imagePath;

            // Delete the previous image if it exists in 'public/images'
            if ($product->image_url && Storage::exists('public/images/' . $product->image_url)) {
                Storage::delete('public/images/' . $product->image_url);
            }
        }

        $product->update($productData);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Get all order items associated with this product and their orders
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

        // If no non-delivered orders contain this product, proceed with deletion
        if ($product->image_url && Storage::exists('public/images/' . $product->image_url)) {
            Storage::delete('public/images/' . $product->image_url);
        }

        try {
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Log the full error message to help diagnose
            \Log::error("Product Deletion Error: " . $e->getMessage());
            return redirect()->route('admin.products.index')->with('Make sure you archive your order and try again!!!.');
        }
    }
}