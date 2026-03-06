@extends('layouts.app')

@section('content')
{{-- Custom styling for strict column fitting --}}
<style>
    .fit-content {
        white-space: nowrap !important;
        width: auto;
    }
    .table-standard th, .table-standard td {
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
</style>

<div class="min-h-screen bg-gray-50 dark:bg-gray-950 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Navigation --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                        <li><a href="{{ route('manager.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                        <li><span class="mx-1">/</span></li>
                        <li class="text-gray-900 dark:text-white">Order View</li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                    Order #{{ $order->id }}
                </h1>
            </div>
            
            <a href="{{ route('manager.dashboard') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl font-bold text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Order Items Table --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide">Purchased Items</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse table-standard">
                            <thead>
                                <tr class="text-gray-500 uppercase text-xs font-bold border-b border-gray-100 dark:border-gray-700">
                                    <th class="py-4 px-6">Product</th>
                                    <th class="py-4 px-6 fit-content text-center">Price</th>
                                    <th class="py-4 px-6 fit-content text-center">Quantity</th>
                                    <th class="py-4 px-6 text-right fit-content">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                                @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            {{ $item->product->name ?? 'Discontinued Product' }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center text-gray-600 dark:text-gray-400">
                                        KES {{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center font-medium text-gray-900 dark:text-white">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="py-4 px-6 text-right fit-content font-bold text-gray-900 dark:text-white">
                                        KES {{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-900/80">
                                <tr>
                                    <td colspan="3" class="py-5 px-6 text-right font-bold text-gray-600 dark:text-gray-400 uppercase text-xs">Total Amount Due</td>
                                    <td class="py-5 px-6 text-right font-bold text-xl text-blue-600 dark:text-blue-400 fit-content">
                                        KES {{ number_format($order->total_amount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Customer Info --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Customer Details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Name:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->shipping_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email:</span>
                            <span class="font-semibold text-blue-600">{{ $order->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Phone:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->contact_number }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 block mb-1">Shipping Address:</span>
                            <span class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $order->shipping_address }}</span>
                        </div>
                    </div>
                </div>

                {{-- Status Info --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Payment Status</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Current Status:</span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                                {{ $order->status == 'Completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $order->status }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Method:</span>
                            <span class="font-bold text-gray-900 dark:text-white uppercase">{{ $order->payment_method }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Date:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection