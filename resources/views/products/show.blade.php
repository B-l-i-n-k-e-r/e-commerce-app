@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 container mx-auto py-12 px-4 sm:px-6 lg:px-8 flex justify-center items-center min-h-[80vh]">
        <div class="glass-card rounded-[2.5rem] shadow-2xl overflow-hidden max-w-4xl w-full border light:border-gray-200 dark:border-white/5">
            @if ($product)
                <div class="flex flex-col md:flex-row">
                    {{-- Product Image Section --}}
                    <div class="md:w-1/2 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center p-8">
                        <div class="relative w-full aspect-square rounded-2xl overflow-hidden shadow-2xl group">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity z-10"></div>
                            <img 
                                src="{{ $product->image_url ? asset($product->image_url) : asset('images/no-image-placeholder.jpg') }}" 
                                alt="{{ $product->name }}" 
                                class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700"
                            >
                            
                            {{-- Stock Badge --}}
                            @if($product->stock <= 5)
                                <div class="absolute top-4 left-4 px-3 py-1.5 rounded-full bg-gradient-to-r from-rose-500/90 to-rose-500/90 text-[8px] font-black text-white uppercase tracking-widest shadow-lg z-20">
                                    Low Stock
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Product Info Section --}}
                    <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                        {{-- Breadcrumb Navigation --}}
                        <nav class="mb-6">
                            <div class="glass-card rounded-xl p-2 inline-block border light:border-gray-200 dark:border-white/5">
                                <ol class="flex items-center space-x-2 text-[9px] font-black uppercase tracking-widest">
                                    <li>
                                        <a href="{{ route('products.index') }}" class="light:text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"/>
                                            </svg>
                                            Catalog
                                        </a>
                                    </li>
                                    <li class="light:text-gray-300 dark:text-gray-600">/</li>
                                    <li class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
                                        {{ $product->name }}
                                    </li>
                                </ol>
                            </div>
                        </nav>

                        {{-- Product Title --}}
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter leading-tight">
                                {{ $product->name }}
                            </h1>
                        </div>
                        
                        {{-- Category Badge --}}
                        @if($product->category)
                        <div class="mb-4">
                            <span class="inline-flex px-3 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-widest bg-gradient-to-r from-purple-500/10 to-blue-500/10 border border-purple-500/20 light:text-purple-700 dark:text-purple-400">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        @endif
                        
                        {{-- Description --}}
                        <div class="mb-6">
                            <p class="text-xs font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mb-2">Description</p>
                            <p class="text-sm font-medium light:text-gray-600 dark:text-gray-300 leading-relaxed">
                                "{{ $product->description }}"
                            </p>
                        </div>

                        {{-- Price Section --}}
                        <div class="glass-card rounded-2xl p-6 mb-6 border light:border-gray-200 dark:border-white/5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-1">Price</p>
                                    <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">
                                        Ksh {{ number_format($product->price, 2) }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500/10 to-green-500/10 border border-emerald-500/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 light:text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-[8px] font-medium light:text-gray-400 dark:text-gray-500 mt-3">Tax included / Free shipping</p>
                        </div>

                        {{-- Stock Status --}}
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-emerald-500' : 'bg-rose-500' }} animate-pulse"></div>
                            <p class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                {{ $product->stock > 0 ? $product->stock . ' units in stock' : 'Out of stock' }}
                            </p>
                        </div>

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="mb-6 glass-card rounded-xl p-4 border border-emerald-500/20 animate-pulse">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black light:text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Success!</p>
                                        <p class="text-[8px] font-medium light:text-gray-600 dark:text-gray-400">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Error Message --}}
                        @if (session('error'))
                            <div class="mb-6 glass-card rounded-xl p-4 border border-rose-500/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-red-500 flex items-center justify-center text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black light:text-rose-700 dark:text-rose-400 uppercase tracking-widest">Error!</p>
                                        <p class="text-[8px] font-medium light:text-gray-600 dark:text-gray-400">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Action Form --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="group w-full flex items-center justify-center gap-3 px-8 py-5 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[11px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                {{ $product->stock > 0 ? 'ADD TO CART' : 'OUT OF STOCK' }}
                            </button>
                        </form>

                        {{-- Additional Info --}}
                        <div class="mt-8 pt-6 border-t border-white/5 light:border-gray-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="glass-card rounded-xl p-3 border light:border-gray-200 dark:border-white/5">
                                    <p class="text-[7px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Product ID</p>
                                    <p class="text-xs font-black light:text-gray-900 dark:text-white">#{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                                <div class="glass-card rounded-xl p-3 border light:border-gray-200 dark:border-white/5">
                                    <p class="text-[7px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Category</p>
                                    <p class="text-xs font-black light:text-gray-900 dark:text-white">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="py-20 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Product not found</h2>
                        <a href="{{ route('products.index') }}" class="mt-4 group inline-flex items-center gap-2 text-[9px] font-black uppercase tracking-widest light:text-purple-600 dark:text-purple-400 hover:text-purple-800 transition-colors">
                            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Return to shop
                        </a>
                    </div>
                </div>
            @endif
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

    /* Disabled button state */
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endsection