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
        <div class="glass-card rounded-[2.5rem] p-10 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5 text-center">
            <div class="flex items-center justify-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg animate-float">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter mb-4">
                {{ __('My') }} 
                <span class="light:text-transparent light:bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400 dark:bg-gradient-to-r dark:text-transparent dark:bg-clip-text">
                    {{ __('Orders') }}
                </span>
            </h1>
            <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Track your purchases and view order history in one place.
            </p>
        </div>

        {{-- Search Bar --}}
        <div class="glass-card rounded-2xl p-6 mb-8 border light:border-gray-200 dark:border-white/5">
            <form method="GET" action="{{ route('orders.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search by order ID, status, or product..."
                        class="w-full portal-input pl-12 p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600"
                    >
                </div>
                <button type="submit" class="md:w-auto px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg transition-all active:scale-95">
                    Filter Orders
                </button>
            </form>
        </div>

        @if ($orders->isNotEmpty())
            {{-- Order Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($orders as $order)
                    <div class="group glass-card rounded-[2rem] overflow-hidden border light:border-gray-200 dark:border-white/5 hover:scale-[1.02] transition-all duration-300 flex flex-col p-8">
                        
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Order ID') }}</p>
                                <h3 class="text-xl font-black light:text-gray-900 dark:text-white tracking-tighter">#{{ $order->order_number ?? $order->id }}</h3>
                            </div>
                            
                            {{-- Status Badge --}}
                            @php
                                $statusClasses = match($order->status) {
                                    'delivered', 'shipped' => 'from-emerald-500/20 to-green-500/20 text-emerald-500 border-emerald-500/20',
                                    'processing', 'pending' => 'from-amber-500/20 to-orange-500/20 text-amber-500 border-amber-500/20',
                                    default => 'from-rose-500/20 to-red-500/20 text-rose-500 border-rose-500/20',
                                };
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border bg-gradient-to-br {{ $statusClasses }}">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="space-y-4 mb-8 flex-grow">
                            <div class="flex justify-between items-center border-b light:border-gray-100 dark:border-white/5 pb-3">
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">{{ __('Date') }}</span>
                                <span class="text-sm font-medium light:text-gray-900 dark:text-gray-200">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">{{ __('Total Amount') }}</span>
                                <span class="text-lg font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">
                                    Ksh {{ number_format($order->total_amount, 2) }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('order.show', $order->id) }}" 
                           class="group/btn block w-full py-4 px-4 glass-card border light:border-gray-200 dark:border-white/5 text-[10px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-purple-600 hover:to-blue-600 rounded-xl transition-all text-center">
                            <span class="flex items-center justify-center gap-2">
                                {{ __('Order Details') }}
                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(method_exists($orders, 'links') && $orders->hasPages())
                <div class="mt-12">
                    {{ $orders->appends(['search' => request('search')])->links() }}
                </div>
            @endif

        @else
            {{-- Empty State --}}
            <div class="glass-card rounded-[2.5rem] p-20 text-center border light:border-gray-200 dark:border-white/5">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-gray-500/10 flex items-center justify-center text-gray-400 mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black light:text-gray-900 dark:text-white uppercase tracking-tight mb-2">{{ __('No orders found') }}</h3>
                <p class="text-sm font-medium text-gray-500 mb-8">{{ __('It looks like you haven\'t placed any orders yet.') }}</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest light:text-purple-600 dark:text-purple-400 hover:text-purple-800 transition-colors">
                    {{ __('Start Shopping') }}
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    .page-bg { min-height: 100vh; width: 100%; }
    .light .page-bg { background-color: #f8fafc; }
    .dark .page-bg { background-color: #030712; }

    .glass-card { backdrop-filter: blur(20px); transition: all 0.3s ease; }
    .light .glass-card { background: rgba(255, 255, 255, 0.85); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); }
    .dark .glass-card { background: rgba(11, 17, 32, 0.9); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4); }

    .portal-input { border-radius: 1rem; transition: all 0.3s ease; }
    .light .portal-input { background: #ffffff; border: 1px solid #e2e8f0; color: #0f172a; }
    .dark .portal-input { background: #0f172a; border: 1px solid #1e293b; color: #ffffff; }

    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-5px); } }
    .animate-float { animation: float 6s ease-in-out infinite; }
</style>
@endsection