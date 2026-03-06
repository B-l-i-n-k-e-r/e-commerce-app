@extends('layouts.app')

@section('content')
<style>
    /* Standard Font Stack & Global Reset */
    body { 
        margin: 0; 
        padding: 0; 
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    
    /* Force columns to fit content and prevent wrapping */
    .fit-content {
        width: 1%;
        white-space: nowrap;
    }
    .table-nowrap td, .table-nowrap th {
        white-space: nowrap;
    }
</style>

<div class="min-h-screen bg-gray-50 dark:bg-gray-950 antialiased py-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                Manage <span class="text-blue-600 dark:text-blue-500">Orders</span>
            </h1>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Track, process, and archive customer transactions.</p>
        </div>

        {{-- Orders Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            @if($orders->isEmpty())
                <div class="p-20 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-50 dark:bg-gray-900 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">No orders found</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">There are currently no transactions in the queue.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse table-nowrap">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50 text-gray-400 uppercase text-[10px] font-bold tracking-widest border-b border-gray-100 dark:border-gray-700">
                                <th class="py-5 px-6 fit-content">Order ID</th>
                                <th class="py-5 px-6 fit-content">Customer</th>
                                <th class="py-5 px-6">Shipping Destination</th>
                                <th class="py-5 px-6 fit-content">Contact</th>
                                <th class="py-5 px-6 fit-content">Manifest</th>
                                <th class="py-5 px-6 fit-content text-center">Qty</th>
                                <th class="py-5 px-6 fit-content text-right">Revenue</th>
                                <th class="py-5 px-6 fit-content text-center">Method</th>
                                <th class="py-5 px-6 fit-content text-center">Status</th>
                                @if(auth()->user()?->isManager())
                                    <th class="py-5 px-6 fit-content text-right">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                            @foreach($orders as $order)
                                @php
                                    $statusClasses = [
                                        'Pending'   => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'Completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'Cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        'Delivered' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    ];
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                    <td class="py-4 px-6 fit-content">
                                        <span class="font-mono font-bold text-blue-600">#{{ $order->id }}</span>
                                    </td>
                                    <td class="py-4 px-6 fit-content">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $order->user->name ?? 'Guest' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $order->user->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-4 px-6 max-w-xs truncate">
                                        <span class="text-xs text-gray-600 dark:text-gray-400">{{ $order->shipping_address }}</span>
                                    </td>
                                    <td class="py-4 px-6 fit-content">
                                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $order->contact_number }}</span>
                                    </td>
                                    <td class="py-4 px-6 fit-content">
                                        <div class="flex -space-x-2">
                                            @foreach($order->items->take(3) as $item)
                                                <div class="h-7 w-7 rounded-full bg-white dark:bg-gray-700 border-2 border-white dark:border-gray-800 flex items-center justify-center text-[10px] font-bold text-gray-500" title="{{ $item->product->name }}">
                                                    {{ strtoupper(substr($item->product->name, 0, 1)) }}
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 3)
                                                <div class="h-7 w-7 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-gray-400">
                                                    +{{ $order->items->count() - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center font-bold text-gray-900 dark:text-white text-xs">
                                        {{ $order->items->sum('quantity') }}
                                    </td>
                                    <td class="py-4 px-6 fit-content text-right">
                                        <span class="text-sm font-extrabold text-gray-900 dark:text-white">KES {{ number_format($order->total_amount, 2) }}</span>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center">
                                        <span class="text-[10px] font-bold px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md uppercase tracking-tighter">
                                            {{ $order->payment_method }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold border {{ $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-600 border-gray-100' }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>

                                    @if(auth()->user()?->isManager())
                                        <td class="py-4 px-6 fit-content text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                                   class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit Order">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                                </a>
                                                <form method="POST" action="{{ route('admin.orders.archive', $order->id) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            onclick="return confirm('Archive this transaction?')"
                                                            class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg transition-colors" title="Archive Order">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/30">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection