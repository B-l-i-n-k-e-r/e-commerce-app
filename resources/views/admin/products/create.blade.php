@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto py-6 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow-md">
            <h1 class="text-2xl font-semibold mb-4 text-center">Add New Product</h1>

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" required>
                </div>

                <div>
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="4" required></textarea>
                </div>

                <div>
                    <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                    <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" name="price" required min="0" step="0.01">
                </div>

                <div>
                    <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                    <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="stock" name="stock" required min="0">
                </div>

                <div>
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
                    <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="image">
                </div>

                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Add Product</button>
            </form>
        </div>
    </div>
@endsection
