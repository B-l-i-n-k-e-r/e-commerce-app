@extends('layouts.app')

@section('content')
<style>
    /* Global layout resets and Standard Font Family */
    body { 
        margin: 0; 
        padding: 0; 
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Column Fit-Content Logic */
    .fit-content {
        width: 1%;
        white-space: nowrap;
    }

    /* 1. Screen-only styles */
    .no-print { display: flex; }
    .print-only-header { display: none; }

    /* 2. Print-specific logic */
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

<div class="min-h-screen bg-gray-50 dark:bg-gray-950 antialiased py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- Header & Total Sales --}}
    <div class="max-w-full mx-auto mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 no-print">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Sales <span class="text-blue-600">Reports</span></h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Audit transactions and export financial data.</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl px-6 py-4 shadow-xl flex items-center gap-4">
            <div class="h-10 w-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Total Revenue</span>
                <span class="text-2xl font-black text-gray-900 dark:text-white">Ksh {{ number_format($totalSales, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="bg-gray-900 rounded-3xl p-6 shadow-2xl mb-8 no-print filter-section border border-gray-800">
        <form action="{{ route('admin.reports') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Order Status</label>
                <select name="status" class="w-full bg-gray-800 border-gray-700 text-white text-sm rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer">
                    <option value="">All Statuses</option>
                    @foreach(['pending', 'processing', 'delivered', 'cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">From Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-gray-800 border-gray-700 text-white text-sm rounded-xl py-3 px-4">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">To Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-gray-800 border-gray-700 text-white text-sm rounded-xl py-3 px-4">
            </div>

            <div class="lg:col-span-2 flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl text-sm transition shadow-lg shadow-blue-500/20 active:scale-95">
                    Update View
                </button>
                <a href="{{ route('admin.reports') }}" class="px-6 py-3 bg-gray-800 text-gray-400 hover:text-white font-bold rounded-xl text-sm transition border border-gray-700">
                    Reset
                </a>
                <button type="button" onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition flex items-center shadow-lg shadow-emerald-500/20 active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Export PDF
                </button>
            </div>
        </form>
    </div>

    {{-- Main Report Table --}}
    <div class="print-container overflow-x-auto bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700">
        <h1 class="print-only-header">Sales Order Report ({{ request('status') ? ucfirst(request('status')) : 'All Statuses' }})</h1>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-900/50 text-gray-400 uppercase text-[10px] font-bold tracking-widest border-b border-gray-100 dark:border-gray-700">
                    <th class="py-5 px-6 fit-content">ID</th>
                    <th class="py-5 px-6 fit-content">Customer</th>
                    <th class="py-5 px-6 fit-content">Date</th>
                    <th class="py-5 px-6 fit-content text-right">Amount</th>
                    <th class="py-5 px-6 fit-content text-center">Status</th>
                    <th class="py-5 px-6 fit-content">Method</th>
                    <th class="py-5 px-6">Address</th>
                    <th class="py-5 px-6 fit-content text-center">Qty</th>
                    <th class="py-5 px-6">Products</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                        <td class="py-4 px-6 fit-content font-mono text-xs font-bold text-blue-600">#{{ $order->id }}</td>
                        <td class="py-4 px-6 fit-content font-bold text-gray-900 dark:text-white text-xs">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="py-4 px-6 fit-content text-gray-500 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="py-4 px-6 fit-content text-right font-black text-gray-900 dark:text-white text-sm">Ksh {{ number_format($order->total_amount, 2) }}</td>
                        <td class="py-4 px-6 fit-content text-center">
                            <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 fit-content font-bold text-gray-400 text-[10px]">M-PESA</td>
                        <td class="py-4 px-6 text-[11px] text-gray-600 dark:text-gray-400 wrap-print max-w-[200px] leading-relaxed">{{ $order->shipping_address }}</td>
                        <td class="py-4 px-6 fit-content text-center font-bold text-gray-900 dark:text-white">{{ $order->items->sum('quantity') }}</td>
                        <td class="py-4 px-6 text-[10px] text-gray-500 dark:text-gray-400 wrap-print">
                            <div class="space-y-1">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-1">
                                        <span class="h-1 w-1 rounded-full bg-blue-500"></span>
                                        {{ $item->product->name ?? 'Unknown' }}
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-20 text-center text-gray-400 font-medium">No transactions found for the selected period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Screen-only Product Summary --}}
    @if($productOrderCounts)
    <div class="no-print mt-12">
        <div class="flex flex-col gap-1 mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Product Demand</h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold">Orders per product in current filter</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($productOrderCounts as $productName => $orderCount)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <p class="text-[10px] font-bold text-gray-400 uppercase truncate mb-1" title="{{ $productName }}">{{ $productName }}</p>
                    <p class="text-lg font-black text-blue-600">{{ $orderCount }} <span class="text-[10px] text-gray-400 uppercase font-bold">Orders</span></p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection