@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-700 rounded-lg shadow-md overflow-hidden max-w-xl mx-auto p-6"> {{-- Reduced max-w-3xl to max-w-xl --}}
            <h1 class="text-3xl font-semibold text-blue-400 mb-4 text-center">Product Details</h1>

            @if ($product)
                <div class="md:flex items-start gap-8">
                    {{-- Product Image --}}
                    <div class="md:w-1/3 flex-shrink-0">
                        <div class="relative aspect-w-1 aspect-h-1 rounded-md overflow-hidden">
                            @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="object-cover w-full h-full">
                            @else
                                <img src="{{ asset('images/no-image-placeholder.jpg') }}" alt="No Image" class="object-cover w-full h-full">
                            @endif
                        </div>
                    </div>

                    {{-- Product Details --}}
                    <div class="md:w-2/3">
                        <h2 class="text-2xl font-semibold text-blue-400 mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-300 mb-4">{{ $product->description }}</p>
                        <p class="text-green-400 font-bold text-xl mb-4">Price: ${{ number_format($product->price, 2) }}</p>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                            @csrf
                            <button type="submit" class="inline-block px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-md transition-colors duration-200">
                                Add to Cart
                                <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.293 2.293c-.63.63-.184 1.707.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                            </button>
                        </form>

                        <p class="text-sm">
                            <a href="{{ route('products.index') }}" class="text-blue-400 hover:text-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 inline-block mr-1 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                                Back to Product List
                            </a>
                        </p>

                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4" role="alert">
                                <strong class="font-bold">Success!</strong>
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-gray-300 text-center py-4">Product not found.</p>
            @endif
        </div>
    </div>
@endsection