@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Top Row: Welcome & Recent Orders --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                
                {{-- Welcome Widget --}}
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                            <span class="text-3xl">🤗</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ __('Hello, :name!', ['name' => Auth::user()->name]) }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ __("Welcome back to BokinceX. Ready to find something amazing today?") }}
                        </p>
                        <div class="mt-8">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 font-bold hover:underline">
                                {{ __('Browse Catalog') }}
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Recent Orders Widget --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Your Recent Orders') }}</h2>
                            @if ($recentOrders->isNotEmpty())
                                <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800">
                                    {{ __('View All') }}
                                </a>
                            @endif
                        </div>

                        @if ($recentOrders->isNotEmpty())
                            <div class="space-y-4">
                                @foreach ($recentOrders->take(3) as $order)
                                    <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600">
                                        <div class="flex items-center gap-4">
                                            <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 dark:text-white">#{{ $order->order_number ?? $order->id }}</p>
                                                <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="block text-xs font-bold uppercase tracking-wider mb-1 {{ $order->status === 'delivered' ? 'text-green-600' : ($order->status === 'processing' ? 'text-yellow-600' : 'text-blue-600') }}">
                                                {{ $order->status }}
                                            </span>
                                            <a href="{{ route('order.show', $order->id) }}" class="text-sm text-blue-600 font-medium hover:underline">{{ __('Details') }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400 italic">{{ __('No recent orders found.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Featured Products Section --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center gap-2 mb-8">
                        <span class="text-2xl">🔥</span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Featured Products') }}</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($products->take(8) as $product)
                            <div class="group bg-gray-50 dark:bg-gray-700/30 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-600 hover:shadow-md transition-all duration-300">
                                <div class="relative aspect-square overflow-hidden bg-gray-200">
                                    <img src="{{ $product->image_url ? asset($product->image_url) : asset('images/no-image-placeholder.jpg') }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-5">
                                    <h5 class="font-bold text-gray-900 dark:text-white truncate mb-1">{{ $product->name }}</h5>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs mb-3 line-clamp-2">
                                        {{ $product->description }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-black text-green-600 dark:text-green-400 whitespace-nowrap">
                                            Ksh {{ number_format($product->price, 2) }}
                                        </span>
                                        <a href="{{ route('products.index') }}" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 text-center">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-10 py-4 bg-gray-900 dark:bg-white dark:text-gray-900 text-white font-black rounded-xl hover:scale-105 transition-all duration-200 shadow-lg">
                            <span class="mr-2">🛍️</span>
                            {{ __('GO SHOPPING') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection