@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Top Row: Welcome & Recent Orders --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                
                {{-- Welcome Widget --}}
                <div class="lg:col-span-1 glass-card rounded-[2.5rem] p-8 shadow-2xl border light:border-gray-200 dark:border-white/5 group hover:scale-105 transition-all duration-300">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-purple-500 to-blue-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center mb-6 shadow-lg animate-float">
                            <span class="text-3xl text-white">🤗</span>
                        </div>
                        <h3 class="text-2xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter mb-2">
                            {{ __('Hello, :name!', ['name' => Auth::user()->name]) }}
                        </h3>
                        <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ __("Welcome back to BokinceX. Ready to find something amazing today?") }}
                        </p>
                        <div class="mt-8">
                            <a href="{{ route('products.index') }}" class="group inline-flex items-center text-[10px] font-black uppercase tracking-widest light:text-purple-600 dark:text-purple-400 hover:text-purple-800 transition-colors">
                                {{ __('Browse Catalog') }}
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Recent Orders Widget --}}
                <div class="lg:col-span-2 glass-card rounded-[2.5rem] p-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-black light:text-gray-900 dark:text-white uppercase tracking-tight">{{ __('Your Recent Orders') }}</h2>
                        @if ($recentOrders->isNotEmpty())
                            <a href="{{ route('orders.index') }}" class="ml-auto text-[9px] font-black uppercase tracking-widest light:text-purple-600 dark:text-purple-400 hover:text-purple-800 transition-colors">
                                {{ __('View All') }}
                            </a>
                        @endif
                    </div>

                    @if ($recentOrders->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($recentOrders->take(3) as $order)
                                @php
                                    $statusColors = [
                                        'delivered' => 'from-emerald-500/10 to-emerald-500/10 border-emerald-500/20 light:text-emerald-700 dark:text-emerald-400',
                                        'processing' => 'from-blue-500/10 to-blue-500/10 border-blue-500/20 light:text-blue-700 dark:text-blue-400',
                                        'pending' => 'from-amber-500/10 to-amber-500/10 border-amber-500/20 light:text-amber-700 dark:text-amber-400',
                                        'cancelled' => 'from-rose-500/10 to-rose-500/10 border-rose-500/20 light:text-rose-700 dark:text-rose-400',
                                    ];
                                    $currentClass = $statusColors[strtolower($order->status)] ?? 'from-gray-500/10 to-gray-500/10 border-gray-500/20 light:text-gray-700 dark:text-gray-400';
                                @endphp
                                <div class="flex items-center justify-between p-4 glass-card rounded-xl border light:border-gray-200 dark:border-white/5 hover:scale-102 transition-all duration-300">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500/10 to-blue-500/10 border border-purple-500/20 flex items-center justify-center">
                                            <svg class="w-5 h-5 light:text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black light:text-gray-900 dark:text-white">#{{ $order->order_number ?? str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
                                            <p class="text-[9px] font-medium light:text-gray-500 dark:text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right flex items-center gap-4">
                                        <span class="inline-flex px-3 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-widest bg-gradient-to-r {{ $currentClass }}">
                                            {{ $order->status }}
                                        </span>
                                        <a href="{{ route('order.show', $order->id) }}" class="text-[9px] font-black uppercase tracking-widest light:text-purple-600 dark:text-purple-400 hover:text-purple-800 transition-colors">
                                            {{ __('Details') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p class="text-xs font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">{{ __('No recent orders found.') }}</p>
                            <p class="text-[9px] light:text-gray-300 dark:text-gray-600 mt-2">{{ __('Start shopping to see your orders here!') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Featured Products Section --}}
            <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-lg animate-float">
                            <span class="text-lg">🔥</span>
                        </div>
                        <h2 class="text-2xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">{{ __('Featured Products') }}</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse ($products->take(8) as $product)
                            <div class="group glass-card rounded-2xl overflow-hidden border light:border-gray-200 dark:border-white/5 hover:scale-105 transition-all duration-300">
                                <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900">
                                    <img src="{{ $product->image_url ? asset($product->image_url) : asset('images/no-image-placeholder.jpg') }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @if($product->stock <= 5)
                                        <div class="absolute top-3 right-3 px-2 py-1 rounded-lg bg-gradient-to-r from-rose-500/90 to-rose-500/90 text-[8px] font-black text-white uppercase tracking-widest">
                                            Low Stock
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h5 class="text-sm font-black light:text-gray-900 dark:text-white truncate mb-1 uppercase tracking-tight">{{ $product->name }}</h5>
                                    <p class="text-[9px] font-medium light:text-gray-500 dark:text-gray-400 mb-3 line-clamp-2">
                                        {{ $product->description }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-lg font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">
                                                Ksh {{ number_format($product->price, 2) }}
                                            </span>
                                            @if($product->stock > 0)
                                                <p class="text-[7px] font-medium light:text-gray-400 dark:text-gray-500">{{ $product->stock }} available</p>
                                            @else
                                                <p class="text-[7px] font-medium text-rose-500">Out of stock</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('products.index') }}" 
                                           class="p-3 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 text-white hover:from-purple-600 hover:to-blue-600 transition-all shadow-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">{{ __('No products available') }}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12 text-center">
                        <a href="{{ route('products.index') }}" 
                           class="group inline-flex items-center px-10 py-5 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95">
                            <span class="mr-3 text-lg">🛍️</span>
                            {{ __('GO SHOPPING' )}}
                            <svg class="w-4 h-4 ml-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
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

    /* Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    /* Line clamp for product descriptions */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
</style>
@endsection