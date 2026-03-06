@extends('layouts.app')

@section('content')
<style>
    /* Global layout resets and Standard Font Family */
    body { 
        margin: 0; 
        padding: 0; 
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    
    /* Strict fit-content constraints for administrative tables */
    .fit-content {
        width: 1%;
        white-space: nowrap;
    }
    .table-nowrap td, .table-nowrap th {
        white-space: nowrap;
    }
</style>

<div class="min-h-screen bg-gray-50 dark:bg-gray-950 antialiased">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        {{-- Dashboard Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                    Manager <span class="text-blue-600 dark:text-blue-500">Dashboard</span>
                </h1>
                <div class="flex items-center gap-2 mt-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Live Store Operations</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-2 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                </div>
                <div class="pr-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase">System Status</p>
                    <p class="text-xs font-bold text-gray-900 dark:text-white">All Systems Operational</p>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            {{-- Total Orders Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Transaction Volume</h2>
                        <p class="text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ number_format($total_orders) }}</p>
                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mt-2 uppercase">Total Orders Processed</p>
                    </div>
                    <div class="p-5 bg-blue-50 dark:bg-blue-900/20 rounded-2xl text-blue-600 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    </div>
                </div>
            </div>

            {{-- Low Stock Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Inventory Alert</h2>
                        <p class="text-5xl font-extrabold text-orange-600 dark:text-orange-500 tracking-tight">{{ $low_stock }}</p>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mt-2 uppercase">Items require restocking</p>
                    </div>
                    <div class="p-5 bg-orange-50 dark:bg-orange-900/20 rounded-2xl text-orange-600 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders Table Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/30">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-wider">Recent Orders</h2>
                <span class="text-[10px] font-bold bg-blue-600 text-white px-3 py-1 rounded-full uppercase">Latest 10</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-nowrap">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-900/50 text-gray-400 uppercase text-[10px] font-bold tracking-widest">
                            <th class="py-5 px-8 fit-content">ID</th>
                            <th class="py-5 px-8">Customer Detail</th>
                            <th class="py-5 px-8 fit-content">Status</th>
                            <th class="py-5 px-8 fit-content">Revenue</th>
                            <th class="py-5 px-8 text-right fit-content">Management</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                        @forelse($recent_orders as $order)
                        <tr class="hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors">
                            <td class="py-5 px-8 fit-content">
                                <span class="font-mono font-bold text-blue-600 dark:text-blue-400">#{{ $order->id }}</span>
                            </td>
                            <td class="py-5 px-8">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $order->user->name ?? 'Guest User' }}</span>
                                    <span class="text-[10px] text-gray-400 font-semibold uppercase">{{ $order->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-8 fit-content">
                                @php
                                    $statusClasses = [
                                        'delivered' => 'bg-green-100 text-green-700 border-green-200',
                                        'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                    ];
                                    $currentClass = $statusClasses[strtolower($order->status)] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase border {{ $currentClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-5 px-8 fit-content">
                                <span class="font-bold text-gray-900 dark:text-white">KES {{ number_format($order->total_amount, 2) }}</span>
                            </td>
                            <td class="py-5 px-8 text-right fit-content">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-[10px] font-bold uppercase tracking-widest rounded-xl hover:shadow-md transition-all">
                                    View File
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center">
                                <p class="text-sm font-semibold text-gray-400 uppercase tracking-widest italic">No Transaction Records Found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection