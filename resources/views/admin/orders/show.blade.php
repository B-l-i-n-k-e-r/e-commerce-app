@extends('layouts.app')

@section('content')
{{-- Custom styling for strict column fitting --}}
<style>
    .fit-content {
        white-space: nowrap !important;
        width: auto;
    }
    .table-standard th, .table-standard td {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
</style>

<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Header Navigation with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-6 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <nav class="flex mb-3" aria-label="Breadcrumb">
                        <div class="glass-card rounded-xl p-2 inline-block border light:border-gray-200 dark:border-white/5">
                            <ol class="flex items-center space-x-2 text-[9px] font-black uppercase tracking-widest">
                                <li>
                                    <a href="{{ route('manager.dashboard') }}" class="light:text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                        Dashboard
                                    </a>
                                </li>
                                <li class="light:text-gray-300 dark:text-gray-600">/</li>
                                <li class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
                                    Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                </li>
                            </ol>
                        </div>
                    </nav>
                    
                    {{-- Order Title with Status Badge --}}
                    <div class="flex items-center gap-4 flex-wrap">
                        <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Order Details
                        </h1>
                        @php
                            $statusColors = [
                                'completed' => 'from-emerald-500/10 to-emerald-500/10 border-emerald-500/20 light:text-emerald-700 dark:text-emerald-400',
                                'pending' => 'from-amber-500/10 to-amber-500/10 border-amber-500/20 light:text-amber-700 dark:text-amber-400',
                                'processing' => 'from-blue-500/10 to-blue-500/10 border-blue-500/20 light:text-blue-700 dark:text-blue-400',
                                'cancelled' => 'from-rose-500/10 to-rose-500/10 border-rose-500/20 light:text-rose-700 dark:text-rose-400',
                                'delivered' => 'from-emerald-500/10 to-emerald-500/10 border-emerald-500/20 light:text-emerald-700 dark:text-emerald-400'
                            ];
                            $status = strtolower($order->status);
                            $colorSet = $statusColors[$status] ?? 'from-gray-500/10 to-gray-500/10 border-gray-500/20 light:text-gray-700 dark:text-gray-400';
                        @endphp
                        <span class="inline-flex px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-gradient-to-r {{ $colorSet }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
                
                <a href="{{ route('manager.dashboard') }}" 
                   class="group inline-flex items-center justify-center gap-2 glass-card border light:border-gray-200 dark:border-white/5 light:text-gray-600 dark:text-gray-300 text-[10px] font-black uppercase tracking-widest py-3 px-6 rounded-xl hover:scale-105 transition-all">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Order Items Table --}}
            <div class="lg:col-span-2">
                <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
                    <div class="px-6 py-4 border-b border-white/5 light:border-gray-200 bg-white/5 light:bg-gray-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h2 class="text-xs font-black light:text-gray-900 dark:text-white uppercase tracking-widest">Purchased Items</h2>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse table-standard">
                            <thead>
                                <tr class="border-b border-white/5 light:border-gray-200">
                                    <th class="py-4 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Product</th>
                                    <th class="py-4 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content text-center">Price</th>
                                    <th class="py-4 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content text-center">Quantity</th>
                                    <th class="py-4 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-right fit-content">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 light:divide-gray-100">
                                @foreach($order->items as $item)
                                <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500/10 to-blue-500/10 border border-purple-500/20 flex items-center justify-center text-xs font-black light:text-purple-700 dark:text-purple-400">
                                                {{ strtoupper(substr($item->product->name ?? 'P', 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-black light:text-gray-900 dark:text-white">
                                                {{ $item->product->name ?? 'Discontinued Product' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center">
                                        <span class="text-xs font-medium light:text-gray-600 dark:text-gray-400">
                                            KES {{ number_format($item->price, 2) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center">
                                        <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black bg-gradient-to-r from-purple-500/10 to-blue-500/10 border border-purple-500/20 light:text-purple-700 dark:text-purple-400">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right fit-content">
                                        <span class="text-sm font-black light:text-gray-900 dark:text-white">
                                            KES {{ number_format($item->price * $item->quantity, 2) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-white/5 light:bg-gray-50/80">
                                <tr>
                                    <td colspan="3" class="py-5 px-6 text-right font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest text-[9px]">Total Amount Due</td>
                                    <td class="py-5 px-6 text-right font-black text-2xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 fit-content">
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
                <div class="glass-card rounded-[2rem] p-6 shadow-2xl border light:border-gray-200 dark:border-white/5 relative overflow-hidden group hover:scale-105 transition-all duration-300">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-purple-500 to-blue-500"></div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Customer Details</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Name:</span>
                            <span class="text-xs font-black light:text-gray-900 dark:text-white">{{ $order->shipping_name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Email:</span>
                            <span class="text-xs font-medium text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">{{ $order->email }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Phone:</span>
                            <span class="text-xs font-black light:text-gray-900 dark:text-white">{{ $order->contact_number }}</span>
                        </div>
                        <div class="pt-4 border-t border-white/5 light:border-gray-200">
                            <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-2">Shipping Address:</span>
                            <span class="text-xs font-medium light:text-gray-700 dark:text-gray-300 leading-relaxed block">{{ $order->shipping_address }}</span>
                        </div>
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="glass-card rounded-[2rem] p-6 shadow-2xl border light:border-gray-200 dark:border-white/5 relative overflow-hidden group hover:scale-105 transition-all duration-300">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-emerald-500 to-blue-500"></div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Payment Information</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Method:</span>
                            <span class="text-xs font-black light:text-gray-900 dark:text-white uppercase">{{ $order->payment_method }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Date:</span>
                            <span class="text-xs font-medium light:text-gray-700 dark:text-gray-300">{{ $order->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
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

    /* Fit content utility */
    .fit-content {
        white-space: nowrap !important;
        width: auto;
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