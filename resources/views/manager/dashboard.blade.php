@extends('layouts.app')

@section('content')
<style>
    /* Global layout resets and Standard Font Family */
    body { 
        margin: 0; 
        padding: 0; 
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        overflow-x: hidden;
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

<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        {{-- Dashboard Header with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-8 mb-10 shadow-2xl border light:border-gray-200 dark:border-white/5">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="light:bg-gradient-to-br light:from-purple-100 light:to-blue-100 dark:bg-blue-600/20 p-4 rounded-2xl animate-float">
                        <svg class="w-8 h-8 light:text-purple-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Manager Dashboard <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400">Dashboard</span>
                        </h1>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            <p class="text-xs font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">Live Store Operations</p>
                        </div>
                    </div>
                </div>
                
                <div class="glass-card rounded-2xl p-3 border light:border-gray-200 dark:border-white/5 flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/>
                            <rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/>
                            <rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                    </div>
                    <div class="pr-4">
                        <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">System Status</p>
                        <p class="text-xs font-black light:text-gray-900 dark:text-white">All Systems Operational</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            {{-- Total Orders Card --}}
            <div class="glass-card rounded-[2rem] p-8 shadow-2xl border light:border-gray-200 dark:border-white/5 relative overflow-hidden group hover:scale-105 transition-all duration-300">
                <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-purple-500 to-blue-500"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Transaction Volume</p>
                        <p class="text-5xl font-black light:text-gray-900 dark:text-white tracking-tight">{{ number_format($total_orders) }}</p>
                        <p class="text-[10px] font-black light:text-gray-500 dark:text-gray-400 mt-2 uppercase tracking-widest">Total Orders Processed</p>
                    </div>
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 border border-purple-500/20 text-purple-600 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="8" cy="21" r="1"/>
                            <circle cx="19" cy="21" r="1"/>
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Low Stock Card --}}
            <div class="glass-card rounded-[2rem] p-8 shadow-2xl border light:border-gray-200 dark:border-white/5 relative overflow-hidden group hover:scale-105 transition-all duration-300">
                <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-amber-500 to-orange-500"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Inventory Alert</p>
                        <p class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-600 tracking-tight">{{ $low_stock }}</p>
                        <p class="text-[10px] font-black light:text-gray-500 dark:text-gray-400 mt-2 uppercase tracking-widest">Items require restocking</p>
                    </div>
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-amber-500/10 to-orange-500/10 border border-amber-500/20 text-amber-600 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                            <path d="M12 9v4"/>
                            <path d="M12 17h.01"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders Table Section with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
            <div class="px-8 py-6 border-b border-white/5 light:border-gray-200 bg-white/5 light:bg-gray-50/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-black light:text-gray-900 dark:text-white uppercase tracking-widest">Recent Orders</h2>
                </div>
                <span class="text-[8px] font-black bg-gradient-to-r from-purple-600 to-blue-600 text-white px-3 py-1.5 rounded-xl uppercase tracking-widest shadow-lg">
                    Latest 5
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-nowrap">
                    <thead>
                        <tr class="border-b border-white/5 light:border-gray-200">
                            <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">ID</th>
                            <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Customer Detail</th>
                            <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Status</th>
                            <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Price</th>
                            <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-right fit-content">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 light:divide-gray-100">
                        @forelse($recent_orders as $order)
                        <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors group">
                            <td class="py-5 px-8 fit-content">
                                <span class="font-mono font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="py-5 px-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-black text-xs shadow-lg">
                                        {{ $order->user ? strtoupper(substr($order->user->name, 0, 1)) : 'G' }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black light:text-gray-900 dark:text-white">{{ $order->user->name ?? 'Guest User' }}</span>
                                        <span class="text-[9px] font-medium light:text-gray-400 dark:text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-8 fit-content">
                                @php
                                    $statusColors = [
                                        'delivered' => 'from-emerald-500/10 to-emerald-500/10 border-emerald-500/20 light:text-emerald-700 dark:text-emerald-400',
                                        'processing' => 'from-blue-500/10 to-blue-500/10 border-blue-500/20 light:text-blue-700 dark:text-blue-400',
                                        'pending' => 'from-amber-500/10 to-amber-500/10 border-amber-500/20 light:text-amber-700 dark:text-amber-400',
                                        'cancelled' => 'from-rose-500/10 to-rose-500/10 border-rose-500/20 light:text-rose-700 dark:text-rose-400',
                                    ];
                                    $currentClass = $statusColors[strtolower($order->status)] ?? 'from-gray-500/10 to-gray-500/10 border-gray-500/20 light:text-gray-700 dark:text-gray-400';
                                @endphp
                                <span class="inline-flex px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-gradient-to-r {{ $currentClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-5 px-8 fit-content">
                                <span class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">KES {{ number_format($order->total_amount, 2) }}</span>
                            </td>
                            <td class="py-5 px-8 text-right fit-content">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="group inline-flex items-center gap-2 px-4 py-2 glass-card border light:border-gray-200 dark:border-white/5 text-[9px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-300 rounded-xl hover:scale-105 transition-all">
                                    <span>View File</span>
                                    <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">No Transaction Records Found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base page background */
    .page-bg {
        min-height: 100vh;
        width: 100%;
    }

    .light .page-bg { background-color: #f8fafc; }
    .dark .page-bg { background-color: #030712; }

    /* Glassmorphism Logic */
    .light .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
    }

    .dark .glass-card {
        background: rgba(11, 17, 32, 0.9);
        backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
    }

    /* Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
</style>
@endsection