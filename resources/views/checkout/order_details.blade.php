@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto">
        
        @if ($order)
            {{-- Success Header --}}
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2 italic">Order Confirmed!</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Thank you for your purchase. We're getting your order ready.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Order Info Cards --}}
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-4">Details</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase">Order ID</p>
                                <p class="text-gray-900 dark:text-white font-mono font-bold">#{{ $order->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase">Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-black bg-yellow-100 text-yellow-700 uppercase tracking-tighter">
                                    {{ $order->order_status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-4">Customer Info</h3>
                        <div class="space-y-4 text-sm">
                            <p class="text-gray-900 dark:text-white font-bold">{{ $order->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $order->email }}</p>
                            <div class="pt-2">
                                <p class="text-xs text-gray-400 font-bold uppercase mb-1">Shipping To:</p>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed italic">
                                    {!! nl2br(e($order->shipping_address)) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Items Table --}}
                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b dark:border-gray-700">
                            <h2 class="text-lg font-black text-gray-900 dark:text-white">Items in this Order</h2>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-max w-full text-left">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Product</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center whitespace-nowrap">Qty</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right whitespace-nowrap">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse ($order->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="font-bold text-gray-900 dark:text-white">
                                                    {{ $item->product->name ?? 'Product Not Found' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                <span class="text-gray-600 dark:text-gray-400 font-medium italic">x{{ $item->quantity }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                                <span class="font-bold text-gray-900 dark:text-white">Ksh {{ number_format($item->price, 2) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">No items found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50 dark:bg-gray-900/50">
                                        <td colspan="2" class="px-6 py-4 text-right text-gray-500 font-bold">Total Amount Paid:</td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-2xl font-black text-green-600 dark:text-green-400 whitespace-nowrap">
                                                Ksh {{ number_format($order->total_amount, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Continue Shopping
                        </a>
                        <button onclick="window.print()" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-lg hover:bg-gray-300 transition-all">
                            Print Invoice
                        </button>
                    </div>
                </div>
            </div>

        @else
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-20 text-center shadow-xl border border-gray-100 dark:border-gray-700">
                <span class="text-6xl mb-4 block">🔍</span>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Order not found.</h2>
                <p class="text-gray-500 mt-2">The order ID you requested does not exist in our records.</p>
                <a href="{{ route('products.index') }}" class="mt-6 inline-block text-blue-500 underline font-bold">Return to Catalog</a>
            </div>
        @endif

    </div>
</div>
@endsection