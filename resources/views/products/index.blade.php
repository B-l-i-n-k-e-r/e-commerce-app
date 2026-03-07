@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 container mx-auto py-12 px-4 sm:px-6 lg:px-8 min-h-screen">
        {{-- Header Section with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-10 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5 text-center">
            <div class="flex items-center justify-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg animate-float">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter mb-4">
                {{ __('Explore Our') }} 
                <span class="light:text-transparent light:bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400 dark:bg-gradient-to-r dark:text-transparent dark:bg-clip-text">
                    {{ __('Collection') }}
                </span>
            </h1>
            <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Discover high-quality products curated just for you. Quality and reliability in every purchase.
            </p>
            <div class="mt-8">
                <a href="{{ route('dashboard') }}" class="group inline-flex items-center text-[10px] font-black uppercase tracking-widest light:text-purple-600 dark:text-purple-400 hover:text-purple-800 transition-colors">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Dashboard') }}
                </a>
            </div>
        </div>

        {{-- Search and Filter Bar --}}
        <div class="glass-card rounded-2xl p-6 mb-8 border light:border-gray-200 dark:border-white/5">
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">
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
                        placeholder="Search products by name or description..."
                        class="w-full portal-input pl-12 p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600"
                    >
                </div>

                <div class="md:w-64 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                    <select 
                        name="category" 
                        class="w-full portal-input pl-12 p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 appearance-none cursor-pointer"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <button type="submit" class="md:w-auto px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg transition-all active:scale-95">
                    Search
                </button>

                @if(request('search') || request('category'))
                <a href="{{ route('products.index') }}" 
                   class="md:w-auto px-8 py-4 light:bg-gray-100 dark:bg-white/5 light:text-gray-600 dark:text-gray-400 hover:light:bg-gray-200 dark:hover:bg-white/10 text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all inline-flex items-center justify-center">
                    Clear
                </a>
                @endif
            </form>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div class="group glass-card rounded-[2rem] overflow-hidden border light:border-gray-200 dark:border-white/5 hover:scale-105 transition-all duration-300 flex flex-col">
                    
                    {{-- Image Container --}}
                    <div class="relative h-56 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900">
                        <img 
                            src="{{ $product->image_url ? asset($product->image_url) : asset('images/no-image-placeholder.jpg') }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        >
                        <div class="absolute top-4 right-4 glass-card rounded-full px-3 py-1.5 border light:border-gray-200 dark:border-white/5 shadow-lg">
                            <span class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">
                                Ksh {{ number_format($product->price, 2) }}
                            </span>
                        </div>
                    </div>

                    {{-- Content Container --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 mb-3">
                            <h5 class="text-base font-black light:text-gray-900 dark:text-white uppercase tracking-tight line-clamp-1">
                                {{ $product->name }}
                            </h5>
                        </div>
                        
                        <p class="text-[10px] font-medium light:text-gray-600 dark:text-gray-400 mb-6 line-clamp-2 flex-grow leading-relaxed">
                            {{ $product->description }}
                        </p>

                        <div class="space-y-3">
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="group block w-full py-3.5 px-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-purple-600/20 transition-all active:scale-95">
                                <span class="flex items-center justify-center gap-2">
                                    {{ __('View Details') }}
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                            </a>
                            
                            {{-- Quick Add to Cart Button --}}
                            <button onclick="quickAddToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, this)" 
                                    class="quick-add-btn w-full py-2.5 px-4 glass-card border light:border-gray-200 dark:border-white/5 text-[9px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:text-purple-600 hover:bg-purple-500/10 rounded-xl transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                Quick Add
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-xs font-medium light:text-gray-300 dark:text-gray-600">No products available.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(method_exists($products, 'links') && $products->hasPages())
        <div class="mt-12">
            {{ $products->withQueryString()->links() }}
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

    .toast-notification {
        position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
        z-index: 9999; animation: slideUp 0.3s ease forwards;
    }
    @keyframes slideUp { from { opacity: 0; transform: translate(-50%, 20px); } to { opacity: 1; transform: translate(-50%, 0); } }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .animate-spin { animation: spin 1s linear infinite; }
</style>

<script>
    function quickAddToCart(productId, productName, productPrice, btnElement) {
        btnElement.disabled = true;
        const originalHTML = btnElement.innerHTML;
        
        btnElement.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Adding...
        `;
        
        // Use the AJAX specific route
        fetch(`/cart/add-ajax/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Invalid JSON Response');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update global cart badge if it exists
                const badges = document.querySelectorAll('.cart-count-badge');
                badges.forEach(badge => {
                    badge.textContent = data.cart_count;
                    badge.classList.remove('hidden');
                });
                
                showToast(`${productName} added to cart!`, 'success');
                animateButtonSuccess(btnElement, originalHTML);
            } else {
                throw new Error(data.message || 'Error');
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            showToast('Failed to add. Try refreshing.', 'error');
            resetButton(btnElement, originalHTML);
        });
    }

    function animateButtonSuccess(btn, original) {
        btn.classList.add('bg-emerald-500', 'text-white');
        btn.innerHTML = '✓ Added!';
        setTimeout(() => {
            btn.classList.remove('bg-emerald-500', 'text-white');
            resetButton(btn, original);
        }, 2000);
    }

    function resetButton(btn, original) {
        btn.disabled = false;
        btn.innerHTML = original;
    }

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast-notification glass-card rounded-xl px-6 py-4 border shadow-2xl ${type === 'success' ? 'border-emerald-500/20' : 'border-rose-500/20'}`;
        toast.innerHTML = `<p class="text-xs font-black dark:text-white">${message}</p>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
</script>
@endsection