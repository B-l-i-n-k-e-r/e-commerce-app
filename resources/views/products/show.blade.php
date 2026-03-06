@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 flex justify-center items-center min-h-[80vh]">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full border border-gray-100 dark:border-gray-700">
            @if ($product)
                <div class="flex flex-col md:flex-row">
                    {{-- Product Image Section --}}
                    <div class="md:w-1/2 bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-4">
                        <div class="relative w-full aspect-square rounded-xl overflow-hidden shadow-inner">
                            <img 
                                src="{{ $product->image_url ? asset($product->image_url) : asset('images/no-image-placeholder.jpg') }}" 
                                alt="{{ $product->name }}" 
                                class="object-cover w-full h-full hover:scale-110 transition-transform duration-700"
                            >
                        </div>
                    </div>

                    {{-- Product Info Section --}}
                    <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                        <nav class="mb-4">
                            <a href="{{ route('products.index') }}" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                Back to Catalog
                            </a>
                        </nav>

                        <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-4 leading-tight">
                            {{ $product->name }}
                        </h1>
                        
                        <div class="mb-6">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Description</span>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                "{{ $product->description }}"
                            </p>
                        </div>

                        <div class="mb-8">
                            <p class="text-3xl font-black text-green-600 dark:text-green-400">
                                Ksh {{ number_format($product->price, 2) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1 uppercase font-bold tracking-tighter">Tax included / Free shipping</p>
                        </div>

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 text-sm font-medium rounded-r-lg animate-pulse">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Action Form --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-3 px-8 py-4 bg-gray-900 dark:bg-blue-600 text-white font-black rounded-xl hover:bg-black dark:hover:bg-blue-700 transition-all duration-300 transform active:scale-95 shadow-xl shadow-gray-200 dark:shadow-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                ADD TO CART
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="p-20 text-center">
                    <h2 class="text-2xl font-bold text-gray-500">Product not found.</h2>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block text-blue-500 underline">Return to shop</a>
                </div>
            @endif
        </div>
    </div>
@endsection