@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-semibold text-green-700 mb-6 text-center">All Products</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">
            @foreach($products as $product)
                <div class="bg-gray-700 rounded-md shadow-md overflow-hidden max-w-md mx-auto">
                    <div class="relative h-48"> 
                        @if($product->image_url)
                            <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-t-md">
                        @else
                            <img src="{{ asset('images/no-image-placeholder.jpg') }}" alt="No Image" class="w-full h-full object-cover rounded-t-md">
                        @endif
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent opacity-50"></div>
                    </div>
                    <div class="p-6 text-center"> {{-- Center text within the card --}}
                        <h5 class="text-lg font-semibold text-gray-200 mb-2">{{ $product->name }}</h5>
                        <p class="text-gray-400 text-sm mb-3">{{ Str::limit($product->description, 100) }}</p>
                        <p class="text-green-400 font-bold text-xl mb-4">Price: ${{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="inline-block px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md transition-colors duration-200 w-full text-center">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection