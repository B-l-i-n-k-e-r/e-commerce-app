@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb & Title with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <nav class="flex mb-3" aria-label="Breadcrumb">
                        <div class="glass-card rounded-xl p-2 inline-block border light:border-gray-200 dark:border-white/5">
                            <ol class="flex items-center space-x-2 text-[9px] font-black uppercase tracking-widest">
                                <li>
                                    <a href="{{ route('admin.orders.index') }}" class="light:text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                        Order Queue
                                    </a>
                                </li>
                                <li class="light:text-gray-300 dark:text-gray-600">/</li>
                                <li class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
                                    Fulfillment #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                </li>
                            </ol>
                        </div>
                    </nav>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Order <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400">#{{ $order->id }}</span>
                        </h1>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="glass-card rounded-xl p-1 border light:border-gray-200 dark:border-white/5">
                        <span class="inline-flex px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest bg-gradient-to-r 
                            @php
                                $status = strtolower($order->status);
                                $colors = [
                                    'pending' => 'from-amber-500/10 to-amber-500/10 border-amber-500/20 light:text-amber-700 dark:text-amber-400',
                                    'processing' => 'from-blue-500/10 to-blue-500/10 border-blue-500/20 light:text-blue-700 dark:text-blue-400',
                                    'delivered' => 'from-emerald-500/10 to-emerald-500/10 border-emerald-500/20 light:text-emerald-700 dark:text-emerald-400',
                                    'cancelled' => 'from-rose-500/10 to-rose-500/10 border-rose-500/20 light:text-rose-700 dark:text-rose-400',
                                ];
                                $colorSet = $colors[$status] ?? 'from-gray-500/10 to-gray-500/10 border-gray-500/20 light:text-gray-700 dark:text-gray-400';
                            @endphp
                            {{ $colorSet }}">
                            Current: {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Info Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Customer Info --}}
            <div class="glass-card rounded-[2rem] p-6 shadow-2xl border light:border-gray-200 dark:border-white/5 relative overflow-hidden group hover:scale-105 transition-all duration-300">
                <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-purple-500 to-blue-500"></div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Customer Profile</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Account Name</p>
                        <p class="text-sm font-black light:text-gray-900 dark:text-white mt-1">{{ $order->user->name ?? 'Guest User' }}</p>
                    </div>
                    @if($order->user)
                    <div>
                        <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Email Address</p>
                        <p class="text-xs font-medium text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 truncate">{{ $order->user->email }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Shipping Details --}}
            <div class="lg:col-span-2 glass-card rounded-[2rem] p-6 shadow-2xl border light:border-gray-200 dark:border-white/5 relative overflow-hidden group hover:scale-105 transition-all duration-300">
                <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-emerald-500 to-blue-500"></div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2 4 4L17 6l2 2-8 8-4-4-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Logistics Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Recipient</p>
                        <p class="text-sm font-black light:text-gray-900 dark:text-white mt-1">{{ $order->shipping_name }}</p>
                        <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest mt-4">Contact</p>
                        <p class="text-xs font-medium light:text-gray-700 dark:text-gray-300 mt-1">{{ $order->contact_number }}</p>
                    </div>
                    <div>
                        <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Delivery Address</p>
                        <p class="text-xs font-medium light:text-gray-700 dark:text-gray-300 leading-relaxed mt-1">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Update Section --}}
        @if(auth()->user()?->isManager())
            <div class="glass-card rounded-[2rem] p-8 mb-8 shadow-2xl border border-purple-500/20 light:border-purple-200 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600/5 to-blue-600/5"></div>
                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-md">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-black light:text-gray-900 dark:text-white uppercase tracking-tight">Administrative Actions</h3>
                        </div>
                        <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400">Update the order status to trigger customer notifications and inventory adjustments.</p>
                    </div>
                    
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex flex-wrap items-center gap-4">
                        @csrf
                        @method('PUT')
                        <div class="min-w-[200px] relative">
                            <select name="status" class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 appearance-none cursor-pointer">
                                @foreach(['pending', 'processing', 'delivered', 'cancelled'] as $status)
                                    <option value="{{ $status }}" {{ strtolower($order->status) === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <button type="submit" 
                                class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-8 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                            <span class="flex items-center gap-2">
                                Apply Status
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="glass-card rounded-2xl p-6 mb-8 border border-amber-500/20 light:border-amber-200">
                <div class="flex items-center gap-4">
                    <div class="p-2 rounded-xl bg-gradient-to-br from-amber-500/10 to-amber-500/10 border border-amber-500/20">
                        <svg class="w-5 h-5 light:text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black light:text-amber-800 dark:text-amber-300 uppercase tracking-wider">Read-Only Access</p>
                        <p class="text-[10px] font-medium light:text-amber-600 dark:text-amber-400">Your account does not have authorization to modify order statuses.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Purchased Items Table --}}
        <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
            <div class="px-8 py-5 border-b border-white/5 light:border-gray-200 bg-white/5 light:bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="text-xs font-black light:text-gray-900 dark:text-white uppercase tracking-widest">Order Manifest</h2>
                </div>
            </div>
            
            @if($order->items->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 light:border-gray-200">
                                <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Product Name</th>
                                <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content text-center">Quantity</th>
                                <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content text-right">Unit Price</th>
                                <th class="py-5 px-8 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 light:divide-gray-100">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors">
                                    <td class="py-5 px-8">
                                        <span class="text-sm font-black light:text-gray-900 dark:text-white">
                                            {{ $item->product->name ?? 'Product Unavailable' }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 fit-content text-center">
                                        <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black bg-gradient-to-r from-purple-500/10 to-blue-500/10 border border-purple-500/20 light:text-purple-700 dark:text-purple-400">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 fit-content text-right">
                                        <span class="text-sm font-medium light:text-gray-500 dark:text-gray-400">
                                            KES {{ number_format($item->price, 2) }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 fit-content text-right">
                                        <span class="text-sm font-black light:text-gray-900 dark:text-white">
                                            KES {{ number_format($item->quantity * $item->price, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-white/5 light:bg-gray-50/80">
                            <tr>
                                <td colspan="3" class="py-6 px-8 text-right font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest text-[9px]">Grand Total</td>
                                <td class="py-6 px-8 text-right font-black text-2xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 fit-content">
                                    KES {{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="py-20 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-xs font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">No items found</p>
                        <p class="text-[9px] light:text-gray-300 dark:text-gray-600 mt-2">This order manifest appears to be empty.</p>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="mt-8 flex justify-center">
            <a href="{{ route('admin.orders.index') }}" 
               class="group inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest light:text-gray-400 dark:text-gray-500 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                Return to Order Queue
            </a>
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

    /* Fit content utility */
    .fit-content {
        width: 1%;
        white-space: nowrap;
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