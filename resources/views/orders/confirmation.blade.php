@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-12 px-4 sm:px-6 lg:px-8 flex justify-center">
    <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-green-100 dark:border-green-900">
        {{-- Success Header --}}
        <div class="bg-green-500 p-8 text-center text-white">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full mb-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-3xl font-black mb-2">Order Confirmed!</h1>
            <p class="text-green-50 text-lg">Thank you for your purchase. Your order is being processed.</p>
        </div>

        <div class="p-8">
            {{-- Order Summary Header --}}
            <div class="flex flex-col md:flex-row justify-between mb-8 pb-6 border-b border-gray-100 dark:border-gray-700 gap-4">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Order Reference</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status</p>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Payment Method</p>
                    <p class="text-gray-700 dark:text-gray-300 font-medium capitalize">{{ $order->payment_method ?? 'Not specified' }}</p>
                </div>
            </div>

            {{-- Items Table: min-w-max ensures columns fit content --}}
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Summary of Items</h2>
            <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-gray-700 mb-8">
                <table class="min-w-max w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3 font-bold uppercase text-xs whitespace-nowrap">Product</th>
                            <th class="px-6 py-3 font-bold uppercase text-xs text-center whitespace-nowrap">Qty</th>
                            <th class="px-6 py-3 font-bold uppercase text-xs text-right whitespace-nowrap">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $item->product->name }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                    Ksh {{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700 font-bold">
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-right text-gray-600 dark:text-gray-300">Total Amount:</td>
                            <td class="px-6 py-4 text-right text-blue-600 dark:text-blue-400 text-lg whitespace-nowrap">
                                Ksh {{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-200 dark:shadow-none transition duration-200 text-center">
                    Continue Shopping
                </a>
                <a href="{{ route('order.show', $order->id) }}" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-8 rounded-xl transition duration-200 text-center">
                    Track Order
                </a>
            </div>
        </div>
    </div>
</div>
@endsection