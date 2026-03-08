@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    {{-- Ambient Background Blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 container mx-auto py-12 px-4 sm:px-6 lg:px-8 min-h-screen">
        {{-- Header Section --}}
        <div class="glass-card rounded-[2.5rem] p-10 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6">
            <div>
                <h1 class="text-4xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter mb-2">
                    {{ __('Order') }} 
                    <span class="light:text-transparent light:bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400 dark:bg-gradient-to-r dark:text-transparent dark:bg-clip-text">
                        {{ __('Details') }}
                    </span>
                </h1>
                <p class="text-[10px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">
                    {{ __('Transaction Summary & Logistics') }}
                </p>
            </div>
            <a href="{{ route('orders.index') }}" class="group inline-flex items-center text-[10px] font-black uppercase tracking-widest light:text-purple-600 dark:text-purple-400 hover:text-purple-800 transition-colors">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to All Orders') }}
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Order Info --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Status Tracker Card --}}
                <div class="glass-card rounded-[2rem] p-8 border light:border-gray-200 dark:border-white/5">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg animate-float">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Order Reference') }}</p>
                                <h2 class="text-2xl font-black light:text-gray-900 dark:text-white tracking-tighter">#{{ $order->order_number ?? $order->id }}</h2>
                            </div>
                        </div>
                        <div class="md:text-right">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Timestamp') }}</p>
                            <p class="text-sm font-medium light:text-gray-700 dark:text-gray-300">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="relative pt-1">
                        @php
                            $progress = match(strtolower($order->status)) {
                                'pending' => '25%',
                                'processing' => '50%',
                                'shipped', 'delivered' => '100%',
                                default => '0%'
                            };
                            $statusColor = $order->status === 'cancelled' ? 'from-rose-600 to-red-600' : 'from-purple-600 to-blue-600';
                            $glowColor = $order->status === 'cancelled' ? 'shadow-red-500/20' : 'shadow-purple-500/20';
                        @endphp
                        <div class="flex mb-4 items-center justify-between">
                            <span class="text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full border light:border-gray-200 dark:border-white/5 light:bg-white dark:bg-white/5 light:text-gray-600 dark:text-gray-300">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="text-[10px] font-black text-purple-500 uppercase tracking-widest">{{ $progress }} {{ __('Complete') }}</span>
                        </div>
                        <div class="overflow-hidden h-3 mb-4 flex rounded-full light:bg-gray-100 dark:bg-white/5 p-1 border light:border-gray-200 dark:border-white/5">
                            <div style="width:{{ $progress }}" class="rounded-full bg-gradient-to-r {{ $statusColor }} shadow-lg {{ $glowColor }} transition-all duration-1000 ease-out"></div>
                        </div>
                    </div>
                </div>

                {{-- Items Table Card --}}
                <div class="glass-card rounded-[2rem] overflow-hidden border light:border-gray-200 dark:border-white/5">
                    <div class="p-8 border-b light:border-gray-100 dark:border-white/5 bg-white/5">
                        <h3 class="text-[10px] font-black light:text-gray-900 dark:text-white uppercase tracking-[0.2em]">{{ __('Items Purchased') }}</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="light:bg-gray-50/50 dark:bg-white/5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="px-8 py-5">{{ __('Product') }}</th>
                                    <th class="px-8 py-5 text-center">{{ __('Qty') }}</th>
                                    <th class="px-8 py-5">{{ __('Price') }}</th>
                                    <th class="px-8 py-5 text-right">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y light:divide-gray-100 dark:divide-white/5">
                                @forelse ($order->items as $item)
                                    <tr class="group hover:bg-white/5 transition-colors">
                                        <td class="px-8 py-6">
                                            <p class="text-sm font-black light:text-gray-900 dark:text-white uppercase tracking-tight">
                                                {{ $item->product->name ?? 'Deleted Product' }}
                                            </p>
                                        </td>
                                        <td class="px-8 py-6 text-center text-sm font-medium text-gray-500">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-8 py-6 text-sm font-medium light:text-gray-600 dark:text-gray-400">
                                            Ksh {{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <span class="text-sm font-black light:text-gray-900 dark:text-white">
                                                Ksh {{ number_format($item->price * $item->quantity, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-12 text-center text-[10px] font-medium text-gray-500 uppercase tracking-widest">
                                            {{ __('No items found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gradient-to-r from-transparent to-purple-500/5">
                                <tr>
                                    <td colspan="3" class="px-8 py-8 text-right text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
                                        {{ __('Total Investment') }}
                                    </td>
                                    <td class="px-8 py-8 text-right">
                                        <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">
                                            Ksh {{ number_format($order->total_amount, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Logistics Card --}}
                <div class="glass-card rounded-[2rem] p-8 border light:border-gray-200 dark:border-white/5">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Logistics') }}</h3>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black light:text-gray-900 dark:text-white uppercase tracking-tight mb-1">{{ $order->shipping_name }}</p>
                            <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400 leading-relaxed italic">
                                "{{ $order->shipping_address }}"
                            </p>
                        </div>
                        <div class="pt-4 border-t light:border-gray-100 dark:border-white/5 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">{{ __('Contact') }}</span>
                            <span class="text-xs font-black light:text-gray-900 dark:text-white">{{ $order->contact_number }}</span>
                        </div>
                    </div>
                </div>

                {{-- Billing Card --}}
                <div class="glass-card rounded-[2rem] p-8 border light:border-gray-200 dark:border-white/5 bg-gradient-to-br from-transparent to-blue-500/5">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Security & Payment') }}</h3>
                    </div>
                    <div class="flex items-center justify-between p-4 rounded-2xl light:bg-white dark:bg-white/5 border light:border-gray-100 dark:border-white/5">
                        <span class="text-[10px] font-black light:text-gray-600 dark:text-gray-400 uppercase">{{ strtoupper($order->payment_method) }}</span>
                        <div class="flex items-center gap-1">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-[9px] font-black text-emerald-500 uppercase">{{ __('Verified') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-bg { min-height: 100vh; width: 100%; }
    .light .page-bg { background-color: #f8fafc; }
    .dark .page-bg { background-color: #030712; }

    .glass-card { backdrop-filter: blur(20px); transition: all 0.3s ease; }
    .light .glass-card { background: rgba(255, 255, 255, 0.85); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); }
    .dark .glass-card { background: rgba(11, 17, 32, 0.9); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4); }

    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-5px); } }
    .animate-float { animation: float 6s ease-in-out infinite; }
</style>
@endsection