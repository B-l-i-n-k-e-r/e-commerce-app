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

    /* Column Fit-Content Logic */
    .fit-content {
        width: 1%;
        white-space: nowrap;
    }

    /* Screen-only styles */
    .no-print { display: flex; }
    .print-only-header { display: none; }

    /* Print-specific logic */
    @media print {
        @page {
            size: landscape;
            margin: 1cm;
        }

        body * { visibility: hidden; }

        .print-container, .print-container * {
            visibility: visible;
        }

        .print-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: white !important;
        }

        .print-only-header {
            display: block !important;
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
            color: black !important;
        }

        .no-print, button, .filter-section, nav {
            display: none !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            border: 1px solid #000 !important;
        }

        th, td {
            border: 1px solid #ddd !important;
            padding: 6px !important;
            font-size: 8pt !important;
            color: black !important;
        }

        .wrap-print { white-space: normal !important; }
        th { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; }
    }
</style>

<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-full mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Header & Total Sales with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 no-print">
                <div class="flex items-center gap-4">
                    <div class="light:bg-gradient-to-br light:from-purple-100 light:to-blue-100 dark:bg-blue-600/20 p-4 rounded-2xl animate-float">
                        <svg class="w-8 h-8 light:text-purple-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Sales <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400">Reports</span>
                        </h1>
                        <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 mt-1">Audit transactions and export financial data.</p>
                    </div>
                </div>
                
                <div class="glass-card rounded-2xl px-8 py-5 border light:border-gray-200 dark:border-white/5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest block">Total Revenue</span>
                        <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">Ksh {{ number_format($totalSales, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Section with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5 filter-section">
            <form action="{{ route('admin.reports') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
                <div>
                    <label class="block text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mb-3">Order Status</label>
                    <div class="relative">
                        <select name="status" class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 appearance-none cursor-pointer">
                            <option value="">All Statuses</option>
                            @foreach(['pending', 'processing', 'delivered', 'cancelled'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mb-3">From Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600">
                </div>

                <div>
                    <label class="block text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mb-3">To Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                           class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600">
                </div>

                <div class="lg:col-span-2 flex gap-3">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-4 rounded-xl shadow-lg transition-all active:scale-95">
                        Update View
                    </button>
                    <a href="{{ route('admin.reports') }}" 
                       class="px-6 py-4 glass-card border light:border-gray-200 dark:border-white/5 light:text-gray-600 dark:text-gray-300 text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 transition-all">
                        Reset
                    </a>
                    <button type="button" onclick="window.print()" 
                            class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-500 hover:to-green-500 text-white px-6 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Export PDF
                    </button>
                </div>
            </form>
        </div>

        {{-- Active Filters Display --}}
        @if(request('status') || request('start_date') || request('end_date'))
        <div class="flex items-center gap-2 mb-4 px-2">
            <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Active Filters:</span>
            @if(request('status'))
            <a href="{{ route('admin.reports', array_merge(request()->except('status'), ['status' => null])) }}" 
               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg glass-card text-[8px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:text-rose-500 transition-all group">
                <span>Status: {{ ucfirst(request('status')) }}</span>
                <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
            @if(request('start_date'))
            <a href="{{ route('admin.reports', array_merge(request()->except('start_date'), ['start_date' => null])) }}" 
               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg glass-card text-[8px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:text-rose-500 transition-all group">
                <span>From: {{ request('start_date') }}</span>
                <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
            @if(request('end_date'))
            <a href="{{ route('admin.reports', array_merge(request()->except('end_date'), ['end_date' => null])) }}" 
               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg glass-card text-[8px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:text-rose-500 transition-all group">
                <span>To: {{ request('end_date') }}</span>
                <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
            <a href="{{ route('admin.reports') }}" 
               class="text-[8px] font-black light:text-purple-600 dark:text-purple-400 hover:underline ml-2">
                Clear All
            </a>
        </div>
        @endif

        {{-- Results Summary - FIXED: Removed pagination methods --}}
        <div class="flex justify-between items-center mb-4 px-2">
            <p class="text-[10px] font-medium light:text-gray-500 dark:text-gray-400">
                Showing <span class="font-black light:text-purple-600 dark:text-purple-400">{{ $orders->count() }}</span> 
                transaction{{ $orders->count() != 1 ? 's' : '' }}
            </p>
        </div>

        {{-- Main Report Table with Glass Card --}}
        <div class="print-container glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
            <h1 class="print-only-header">Sales Order Report ({{ request('status') ? ucfirst(request('status')) : 'All Statuses' }})</h1>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 light:border-gray-200">
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">ID</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Customer</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Date</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-right fit-content">Amount</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center fit-content">Status</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Method</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Address</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center fit-content">Qty</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Products</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 light:divide-gray-100">
                        @forelse($orders as $order)
                            @php
                                $statusColors = [
                                    'pending' => 'from-amber-500/10 to-amber-500/10 border-amber-500/20 light:text-amber-700 dark:text-amber-400',
                                    'processing' => 'from-blue-500/10 to-blue-500/10 border-blue-500/20 light:text-blue-700 dark:text-blue-400',
                                    'delivered' => 'from-emerald-500/10 to-emerald-500/10 border-emerald-500/20 light:text-emerald-700 dark:text-emerald-400',
                                    'cancelled' => 'from-rose-500/10 to-rose-500/10 border-rose-500/20 light:text-rose-700 dark:text-rose-400',
                                ];
                                $status = strtolower($order->status);
                                $colorSet = $statusColors[$status] ?? 'from-gray-500/10 to-gray-500/10 border-gray-500/20 light:text-gray-700 dark:text-gray-400';
                            @endphp
                            <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 fit-content">
                                    <span class="font-mono font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="py-4 px-6 fit-content">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-black text-xs shadow-lg">
                                            {{ $order->user ? strtoupper(substr($order->user->name, 0, 1)) : 'G' }}
                                        </div>
                                        <span class="text-xs font-black light:text-gray-900 dark:text-white">{{ $order->user->name ?? 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 fit-content">
                                    <span class="text-xs font-medium light:text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="py-4 px-6 fit-content text-right">
                                    <span class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">Ksh {{ number_format($order->total_amount, 2) }}</span>
                                </td>
                                <td class="py-4 px-6 fit-content text-center">
                                    <span class="inline-flex px-2 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-gradient-to-r {{ $colorSet }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 fit-content">
                                    <span class="inline-flex px-2 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest light:bg-gray-100 dark:bg-white/5 light:text-gray-600 dark:text-gray-400">
                                        M-PESA
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-xs font-medium light:text-gray-600 dark:text-gray-400 wrap-print leading-relaxed">{{ $order->shipping_address }}</span>
                                </td>
                                <td class="py-4 px-6 fit-content text-center">
                                    <span class="font-black light:text-gray-900 dark:text-white text-xs">{{ $order->items->sum('quantity') }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="space-y-1 max-w-[200px]">
                                        @foreach($order->items->take(3) as $item)
                                            <div class="flex items-center gap-2 text-[9px]">
                                                <span class="w-1 h-1 rounded-full bg-gradient-to-br from-purple-500 to-blue-500"></span>
                                                <span class="font-medium light:text-gray-600 dark:text-gray-400 truncate" title="{{ $item->product->name ?? 'Unknown' }}">
                                                    {{ $item->product->name ?? 'Unknown' }}
                                                </span>
                                                <span class="font-black light:text-gray-900 dark:text-white ml-auto">{{ $item->quantity }}x</span>
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 3)
                                            <div class="text-[8px] font-black light:text-purple-600 dark:text-purple-400 mt-1">
                                                +{{ $order->items->count() - 3 }} more items
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <p class="text-xs font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">No transactions found</p>
                                        <p class="text-[9px] light:text-gray-300 dark:text-gray-600 mt-2">Try adjusting your filter criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination - REMOVED since you're using Collection, not paginator --}}
        </div>

        {{-- Product Demand Summary with Glass Card --}}
        @if(!empty($productOrderCounts) && count($productOrderCounts) > 0)
        <div class="no-print mt-12">
            <div class="glass-card rounded-[2.5rem] p-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">Product Demand</h2>
                        <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400 mt-1">Orders per product in current filter</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($productOrderCounts as $productName => $orderCount)
                        <div class="glass-card rounded-xl p-4 border light:border-gray-200 dark:border-white/5 hover:scale-105 transition-all duration-300">
                            <p class="text-[9px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest truncate mb-2" title="{{ $productName }}">{{ $productName }}</p>
                            <div class="flex items-end justify-between">
                                <p class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">{{ $orderCount }}</p>
                                <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">orders</p>
                            </div>
                            <div class="mt-2 h-1 w-full bg-white/5 light:bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-purple-600 to-blue-600 rounded-full" style="width: {{ min(100, ($orderCount / max(array_values($productOrderCounts))) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
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

    /* Portal Input Styles */
    .light .portal-input {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        color: #0f172a;
        transition: all 0.3s ease;
    }
    
    .light .portal-input:focus {
        border-color: #9333ea;
        box-shadow: 0 0 0 1px #9333ea;
        outline: none;
    }

    .light .portal-input::placeholder {
        color: #94a3b8;
    }

    .dark .portal-input {
        background: #0f172a;
        border: 1px solid #1e293b;
        border-radius: 1rem;
        color: #ffffff;
        transition: all 0.3s ease;
    }
    
    .dark .portal-input:focus {
        border-color: #9333ea;
        box-shadow: 0 0 0 1px #9333ea;
        outline: none;
    }

    .dark .portal-input::placeholder {
        color: #334155;
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
</style>
@endsection