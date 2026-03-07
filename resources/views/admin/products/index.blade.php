@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="light:bg-gradient-to-br light:from-purple-100 light:to-blue-100 dark:bg-blue-600/20 p-4 rounded-2xl animate-float">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="light:text-purple-600 dark:text-blue-400">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                            <path d="M3 6h18"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Manage Products <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400">Products</span>
                        </h1>
                        <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 mt-1">Control your inventory and product visibility.</p>
                    </div>
                </div>
                
                <a href="{{ route('admin.products.create') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-8 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                    <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Product
                </a>
            </div>
        </div>

        {{-- Search and Filter Bar --}}
        <div class="glass-card rounded-2xl p-6 mb-6 border light:border-gray-200 dark:border-white/5">
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col md:flex-row gap-4">
                {{-- Search Input --}}
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

                {{-- Category Filter --}}
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

                {{-- Submit Button (for search) --}}
                <button type="submit" class="md:w-auto px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg transition-all active:scale-95">
                    Search
                </button>

                {{-- Clear Filters --}}
                @if(request('search') || request('category'))
                <a href="{{ route('admin.products.index') }}" 
                   class="md:w-auto px-8 py-4 light:bg-gray-100 dark:bg-white/5 light:text-gray-600 dark:text-gray-400 hover:light:bg-gray-200 dark:hover:bg-white/10 text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all inline-flex items-center justify-center">
                    Clear
                </a>
                @endif
            </form>
        </div>

        {{-- Results Summary --}}
        <div class="flex justify-between items-center mb-4 px-2">
            <p class="text-[10px] font-medium light:text-gray-500 dark:text-gray-400">
                Showing <span class="font-black light:text-purple-600 dark:text-purple-400">{{ $products->firstItem() ?? 0 }}</span> 
                to <span class="font-black light:text-purple-600 dark:text-purple-400">{{ $products->lastItem() ?? 0 }}</span> 
                of <span class="font-black light:text-purple-600 dark:text-purple-400">{{ $products->total() }}</span> products
            </p>
            <p class="text-[10px] font-medium light:text-gray-500 dark:text-gray-400">
                Items : <span class="font-black light:text-purple-600 dark:text-purple-400">10</span>
            </p>
        </div>

        {{-- Products Table Glass Card --}}
        <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 light:border-gray-200">
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Image</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Product Name</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Category</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Description</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-right fit-content">Price</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center fit-content">Stock Level</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-right fit-content">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 light:divide-gray-100">
                        @forelse($products as $product)
                        <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors group">
                            <td class="py-4 px-6 fit-content">
                                <div class="relative w-14 h-14">
                                    <img src="{{ $product->image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover rounded-xl ring-2 ring-white/10 light:ring-gray-200 shadow-lg">
                                    <div class="absolute inset-0 rounded-xl ring-1 ring-inset ring-white/20"></div>
                                </div>
                            </td>
                            <td class="py-4 px-6 fit-content">
                                <span class="font-black light:text-gray-900 dark:text-white text-sm uppercase tracking-tight">{{ $product->name }}</span>
                            </td>
                            <td class="py-4 px-6 fit-content">
                                <span class="inline-flex px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-gradient-to-r from-purple-500/10 to-blue-500/10 light:from-purple-500/5 light:to-blue-500/5 border border-purple-500/20 light:text-purple-700 dark:text-purple-400">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-xs font-medium light:text-gray-600 dark:text-gray-400">{{ Str::limit($product->description, 60) }}</span>
                            </td>
                            <td class="py-4 px-6 fit-content text-right">
                                <span class="font-black light:text-gray-900 dark:text-white text-sm tabular-nums">
                                    KES {{ number_format($product->price, 2) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 fit-content text-center">
                                @php
                                    $stockColor = $product->stock <= 5 ? 'from-red-500/10 to-red-500/10 border-red-500/20 light:text-red-700 dark:text-red-400' : 'from-green-500/10 to-green-500/10 border-green-500/20 light:text-green-700 dark:text-green-400';
                                @endphp
                                <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-gradient-to-r {{ $stockColor }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right fit-content">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="p-2.5 light:text-gray-400 dark:text-gray-500 hover:text-purple-600 hover:bg-purple-500/10 light:hover:bg-purple-50 rounded-xl transition-all"
                                       title="Edit Product">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2.5 light:text-gray-400 dark:text-gray-500 hover:text-red-600 hover:bg-red-500/10 light:hover:bg-red-50 rounded-xl transition-all"
                                                title="Delete Product">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">No products found</p>
                                    <p class="text-[9px] light:text-gray-300 dark:text-gray-600 mt-2">
                                        @if(request('search') || request('category'))
                                            Try adjusting your search or filter criteria
                                        @else
                                            Add your first product to get started
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($products, 'links'))
        <div class="mt-8">
            {{ $products->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    /* Global layout resets */
    body { 
        margin: 0; 
        padding: 0; 
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        overflow-x: hidden;
    }
    
    /* Strict fit-content constraints */
    .fit-content {
        width: 1%;
        white-space: nowrap;
    }

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

    /* Select dropdown styles */
    select.portal-input {
        appearance: none;
        background-image: none;
    }

    /* Light mode gradient colors */
    .light .from-purple-100 { --tw-gradient-from: #f3e8ff; }
    .light .to-blue-100 { --tw-gradient-to: #dbeafe; }
    .light .from-purple-600 { --tw-gradient-from: #9333ea; }
    .light .to-blue-600 { --tw-gradient-to: #2563eb; }
    .light .from-purple-500\/5 { --tw-gradient-from: rgba(168, 85, 247, 0.05); }
    .light .to-blue-500\/5 { --tw-gradient-to: rgba(59, 130, 246, 0.05); }

    /* Light mode text colors */
    .light .text-purple-700 { color: #7e22ce; }
    .light .text-green-700 { color: #15803d; }
    .light .text-red-700 { color: #b91c1c; }

    /* Dark mode text colors */
    .dark .text-purple-400 { color: #c084fc; }
    .dark .text-green-400 { color: #4ade80; }
    .dark .text-red-400 { color: #f87171; }

    /* Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    /* Pagination styling */
    nav[role="navigation"] {
        @apply flex items-center justify-between;
    }
    
    nav[role="navigation"] a, 
    nav[role="navigation"] span {
        @apply px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all;
    }
    
    nav[role="navigation"] a:hover {
        @apply bg-purple-500/10 text-purple-600;
    }
    
    nav[role="navigation"] span[aria-current="page"] span {
        @apply bg-gradient-to-r from-purple-600 to-blue-600 text-white;
    }
</style>
@endsection