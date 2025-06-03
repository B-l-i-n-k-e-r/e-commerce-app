@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-6 rounded-md shadow-md bg-white">
        <h1 class="text-2xl font-semibold mb-4 text-center">Edit Product</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" value="{{ $product->name }}" required>
            </div>

            <div>
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="4" required>{{ $product->description }}</textarea>
            </div>

            <div>
                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" name="price" value="{{ $product->price }}" required min="0" step="0.01">
            </div>

            <div>
                <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="stock" name="stock" value="{{ $product->stock }}" required min="0">
            </div>

            <div>
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="image">
                 @if($product->image)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full">
                @endif
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Update Product</button>
        </form>
    </div>
@endsection
