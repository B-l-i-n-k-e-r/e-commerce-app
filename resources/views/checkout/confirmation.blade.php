{{-- resources/views/checkout/confirmation.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
            
            {{-- Success Header Banner --}}
            <div class="bg-green-600 p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-white uppercase tracking-tight italic">{{ __('Order Confirmed!') }}</h1>
                <p class="text-green-100 mt-2 font-medium">Your request is being processed. Thank you for choosing BokinceX.</p>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
                    {{-- Order Details --}}
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest border-b dark:border-gray-700 pb-2">
                            Summary
                        </h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Order ID:</span>
                                <span class="font-mono font-bold text-gray-900 dark:text-white">#{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Status:</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-black bg-yellow-100 text-yellow-700 uppercase tracking-tighter">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Payment Method:</span>
                                <span class="font-bold text-gray-900 dark:text-white uppercase text-sm">{{ $order->payment_method }}</span>
                            </div>
                            <div class="pt-2 flex justify-between border-t dark:border-gray-700">
                                <span class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tighter">Total Amount</span>
                                <span class="text-xl font-black text-green-600 dark:text-green-400">Ksh {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Information --}}
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest border-b dark:border-gray-700 pb-2">
                            Shipping To
                        </h2>
                        <div class="text-sm space-y-1">
                            <p class="font-black text-gray-900 dark:text-white text-base">{{ $order->shipping_name }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $order->email }}</p>
                            <p class="text-gray-600 dark:text-gray-400 font-medium">{{ $order->contact_number }}</p>
                            <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-100 dark:border-gray-700">
                                <p class="text-gray-500 dark:text-gray-400 italic leading-relaxed">
                                    {{ $order->shipping_address }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Items Table --}}
                <div class="mb-10">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Itemized Receipt</h3>
                    <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                        <table class="min-w-max w-full text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Product</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center whitespace-nowrap">Quantity</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right whitespace-nowrap">Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($order->items as $item)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $item->product->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400 italic">
                                            x{{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-black text-gray-900 dark:text-white">
                                            Ksh {{ number_format($item->price, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">No items found for this order.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-8 border-t dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                        Questions about your order? <a href="#" class="text-blue-500 font-bold hover:underline">Contact Support</a>
                    </p>
                    <div class="flex gap-4">
                        <button onclick="window.print()" class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all text-sm">
                            Print Invoice
                        </button>
                        <a href="{{ route('products.index') }}" class="px-8 py-3 bg-gray-900 dark:bg-blue-600 text-white font-black rounded-xl hover:scale-105 transition-all shadow-lg text-sm">
                            CONTINUE SHOPPING
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <p class="text-center mt-8 text-[10px] text-gray-400 uppercase font-black tracking-[0.2em]">
            &copy; 2026 BokinceX E-Commerce Portal
        </p>
    </div>
@endsection