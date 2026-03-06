@extends('layouts.app')

@section('content')
<style>
    /* Global layout resets and Standard Font Family */
    body { 
        margin: 0; 
        padding: 0; 
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    
    /* Strict fit-content constraints */
    .fit-content {
        width: 1%;
        white-space: nowrap;
    }
    .table-nowrap td, .table-nowrap th {
        white-space: nowrap;
    }
</style>

<div class="min-h-screen bg-gray-50 dark:bg-gray-950 antialiased">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                    Manage <span class="text-blue-600 dark:text-blue-500">Products</span>
                </h1>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Control your inventory and product visibility.</p>
            </div>
            
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Add New Product
            </a>
        </div>

        {{-- Products Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-nowrap">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-900/50 text-gray-400 uppercase text-[10px] font-bold tracking-widest border-b border-gray-100 dark:border-gray-700">
                            <th class="py-5 px-6 fit-content">Asset</th>
                            <th class="py-5 px-6 fit-content">Product Name</th>
                            <th class="py-5 px-6">Description</th>
                            <th class="py-5 px-6 fit-content text-right">Unit Price</th>
                            <th class="py-5 px-6 fit-content text-center">Stock Level</th>
                            <th class="py-5 px-6 text-right fit-content">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                            <td class="py-4 px-6 fit-content">
                                <div class="relative w-12 h-12">
                                    <img src="{{ $product->image_url ? asset($product->image_url) : asset('images/no-image-placeholder.jpg') }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                </div>
                            </td>
                            <td class="py-4 px-6 fit-content">
                                <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $product->name }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($product->description, 60) }}</span>
                            </td>
                            <td class="py-4 px-6 fit-content text-right font-bold text-gray-900 dark:text-white text-sm">
                                KES {{ number_format($product->price, 2) }}
                            </td>
                            <td class="py-4 px-6 fit-content text-center">
                                @php
                                    $stockColor = $product->stock <= 5 ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $stockColor }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right fit-content">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit Product">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Delete Product">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <p class="text-gray-500 font-medium">Your inventory is empty.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection