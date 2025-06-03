@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Welcome Widget --}}
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-100">
                        <h3 class="text-gray-900 font-semibold text-lg mb-9">{{ __('Welcome🤗, :name!', ['name' => Auth::user()->name]) }}</h3>
                        <p class="text-gray-900">{{ __("Feel free to explore all products offered with BokinceX. Here's a quick overview:") }}</p>
                    </div>
                </div>

                {{-- Recent Orders Widget --}}
                @if ($recentOrders->isNotEmpty())
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-100">
                            <h2 class="text-gray-900 font-semibold text-xl mb-4">{{ __('Recent Orders') }}</h2>
                            <ul>
                                @foreach ($recentOrders as $order)
                                    <li class="text-gray-900 py-2 border-b border-gray-700 last:border-b-0">
                                        {{ __('Order') }}: <span class="font-semibold">{{ $order->order_number ?? $order->id }}</span>
                                        <br>
                                        {{ __('Date') }}: <span class="text-blue-500">{{ $order->created_at->format('M d, Y') }}</span>
                                        <br>
                                        {{ __('Status') }}: <span class="{{ $order->status === 'shipped' ? 'text-green-700' : ($order->status === 'processing' ? 'text-yellow-800' : 'text-red-400') }}">{{ ucfirst($order->status) }}</span>
                                        <a href="{{ route('order.show', $order->id) }}" class="text-green-600 hover:underline text-sm ml-2">{{ __('View Details') }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @if ($recentOrders->count() > 3)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('orders.index') }}" class="text-blue-500 hover:underline text-sm">{{ __('View All Orders') }}</a>
                                </div>
                            @endif
                            {{-- "Show All Orders" Button below the list --}}
                            @if ($recentOrders->isNotEmpty())
                                <div class="mt-4 text-center">
                                    <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md transition-colors duration-200 text-sm">
                                        {{ __('Show All') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Featured Products Section --}}
            <div class="mt-8 text-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl mb-4">{{ __('🔥Featured Products') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($products->take(6) as $product)
                            <div class="bg-gray-700 rounded-md shadow-md overflow-hidden">
                                <div class="relative h-32">
                                    @if($product->image_url)
                                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-t-md">
                                    @else
                                        <img src="{{ asset('images/no-image-placeholder.jpg') }}" alt="No Image" class="w-full h-full object-cover rounded-t-md">
                                    @endif
                                </div>
                                <div class="p-4 text-center">
                                    <h5 class="text-lg font-semibold text-gray-200 mb-2">{{ $product->name }}</h5>
                                    <p class="text-gray-400 text-sm">{{ Str::limit($product->description, 50) }}</p>
                                    <p class="text-green-400 font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-green-600 text-white font-semibold rounded-md transition-colors duration-200">
                            {{ __('Go Shopping🛍️') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection