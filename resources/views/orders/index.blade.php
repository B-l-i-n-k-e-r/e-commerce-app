@extends('layouts.app')

@section('content')
    <div class="flex justify-center py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="w-full max-w-6xl px-4">
            <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-white text-center">{{ __('My Orders') }}</h1>

            {{-- Search & Filter Section --}}
            <div class="mb-8">
                <form method="GET" action="{{ route('orders.index') }}" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by order ID, status, or product..."
                        class="w-full pl-10 pr-4 py-3 border-none shadow-sm rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-200 transition-all duration-200"
                    >
                </form>
            </div>

            @if ($orders->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                        <div class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg rounded-2xl p-6 border border-gray-100 dark:border-gray-700 transition-shadow duration-300 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Order ID') }}</p>
                                        <h3 class="text-lg font-black text-gray-900 dark:text-white">#{{ $order->order_number ?? $order->id }}</h3>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap
                                        {{ $order->status === 'delivered' || $order->status === 'shipped' ? 'bg-green-100 text-green-700' : 
                                           ($order->status === 'processing' || $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <div class="space-y-2 mb-6 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">{{ __('Date:') }}</span>
                                        <span class="text-gray-800 dark:text-gray-300 font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">{{ __('Total Amount:') }}</span>
                                        <span class="text-blue-600 dark:text-blue-400 font-bold whitespace-nowrap">Ksh {{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('order.show', $order->id) }}" 
                               class="block w-full text-center py-2 px-4 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold hover:bg-blue-600 hover:text-white transition-colors duration-200">
                                {{ __('View Order Details') }}
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $orders->appends(['search' => request('search')])->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-sm border border-dashed border-gray-300 dark:border-gray-600">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('No orders found') }}</h3>
                    <p class="text-gray-500 mt-2">{{ __('It looks like you haven\'t placed any orders yet.') }}</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-6 text-blue-600 font-bold hover:underline">
                        {{ __('Start Shopping') }} &rarr;
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection