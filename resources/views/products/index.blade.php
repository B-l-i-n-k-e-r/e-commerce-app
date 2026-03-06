@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                {{ __('Explore Our Collection') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Discover high-quality products curated just for you. Quality and reliability in every purchase.
            </p>
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Dashboard') }}
                </a>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col">
                    
                    {{-- Image Container --}}
                    <div class="relative h-56 overflow-hidden bg-gray-200">
                        <img 
                            src="{{ $product->image_url ? asset($product->image_url) : asset('images/no-image-placeholder.jpg') }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity"></div>
                        
                        {{-- Price Badge on Image --}}
                        <div class="absolute top-4 right-4 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-sm">
                            <span class="text-sm font-bold text-green-600 dark:text-green-400 whitespace-nowrap">
                                Ksh {{ number_format($product->price, 2) }}
                            </span>
                        </div>
                    </div>

                    {{-- Content Container --}}
                    <div class="p-6 flex flex-col flex-grow text-center">
                        <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">
                            {{ $product->name }}
                        </h5>
                        
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 line-clamp-2 flex-grow">
                            {{ $product->description }}
                        </p>

                        <div class="space-y-3">
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="block w-full py-3 px-4 bg-gray-900 dark:bg-blue-600 text-white font-bold rounded-xl hover:bg-gray-800 dark:hover:bg-blue-700 transition-colors duration-200">
                                {{ __('View Details') }}
                            </a>
                            
                            {{-- Optional: Quick Add/Cart button can go here --}}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-10 shadow-sm inline-block">
                        <span class="text-5xl mb-4 block">📦</span>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('No products available') }}</h3>
                        <p class="text-gray-500 mt-2">{{ __('Check back later for new arrivals!') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
@endsection