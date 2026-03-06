@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Order Details') }}</h1>
            <a href="{{ route('orders.index') }}" class="flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to All Orders') }}
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Order Info --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Status Tracker --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Order Number') }}</p>
                            <h2 class="text-xl font-black text-gray-900 dark:text-white">#{{ $order->order_number ?? $order->id }}</h2>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Placed On') }}</p>
                            <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Simple Progress Bar --}}
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $order->status === 'cancelled' ? 'text-red-600 bg-red-200' : 'text-blue-600 bg-blue-200' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200 dark:bg-gray-700">
                            @php
                                $progress = match(strtolower($order->status)) {
                                    'pending' => '25%',
                                    'processing' => '50%',
                                    'shipped', 'delivered' => '100%',
                                    default => '0%'
                                };
                                $color = $order->status === 'cancelled' ? 'bg-red-500' : 'bg-blue-500';
                            @endphp
                            <div style="width:{{ $progress }}" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $color }} transition-all duration-500"></div>
                        </div>
                    </div>
                </div>

                {{-- Order Items Table --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold text-gray-900 dark:text-white">{{ __('Items Purchased') }}</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-max w-full text-left text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4 whitespace-nowrap">{{ __('Product') }}</th>
                                    <th class="px-6 py-4 text-center whitespace-nowrap">{{ __('Quantity') }}</th>
                                    <th class="px-6 py-4 whitespace-nowrap">{{ __('Price') }}</th>
                                    <th class="px-6 py-4 text-right whitespace-nowrap">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($order->items as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                            {{ $item->product->name ?? 'Deleted Product' }}
                                        </td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Ksh {{ number_format($item->price, 2) }}</td>
                                        <td class="px-6 py-4 text-right font-bold whitespace-nowrap text-gray-900 dark:text-white">
                                            Ksh {{ number_format($item->price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">{{ __('No items in this order.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-700 border-t-2 border-gray-200 dark:border-gray-600">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-600 dark:text-gray-300">{{ __('Total Amount:') }}</td>
                                    <td class="px-6 py-4 text-right font-black text-xl text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                        Ksh {{ number_format($order->total_amount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Sidebar Details --}}
            <div class="space-y-6">
                {{-- Shipping Information --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">{{ __('Shipping Address') }}</h3>
                    <div class="text-gray-800 dark:text-gray-200 leading-relaxed">
                        <p class="font-bold text-lg mb-1">{{ $order->shipping_name }}</p>
                        <p>{{ $order->shipping_address }}</p>
                        <p class="mt-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $order->contact_number }}
                        </p>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">{{ __('Payment Method') }}</h3>
                    <div class="flex items-center text-gray-800 dark:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection