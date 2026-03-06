@extends('layouts.app')

@section('content')
<style>
    /* Global layout resets and Standard Font Family */
    body { 
        margin: 0; 
        padding: 0; 
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Custom Focus Ring for consistent branding */
    .focus-ring {
        transition: all 0.2s ease-in-out;
    }
    .focus-ring:focus {
        outline: none;
        ring: 2px;
        ring-color: #2563eb; /* Blue-600 */
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
</style>

<div class="min-h-screen bg-gray-50 dark:bg-gray-950 antialiased py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        
        {{-- Breadcrumb Navigation --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                <li><a href="{{ route('admin.products.index') }}" class="hover:text-blue-600">Inventory</a></li>
                <li><span class="mx-1">/</span></li>
                <li class="text-gray-900 dark:text-white">New Product</li>
            </ol>
        </nav>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Product Creation</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Populate the fields below to add a new asset to your store.</p>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    {{-- Product Name --}}
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Identification</label>
                        <input type="text" 
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm font-medium focus-ring placeholder-gray-400" 
                               id="name" name="name" placeholder="e.g. Premium Wireless Headphones" required>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Specifications & Story</label>
                        <textarea class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm font-medium focus-ring placeholder-gray-400" 
                                  id="description" name="description" rows="4" placeholder="Detail the features and benefits..." required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Price --}}
                        <div>
                            <label for="price" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Price Points</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-xs font-bold">KES</span>
                                </div>
                                <input type="number" 
                                       class="w-full py-3 pl-14 pr-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm font-bold focus-ring" 
                                       id="price" name="price" required min="0" step="0.01" placeholder="0.00">
                            </div>
                        </div>

                        {{-- Stock --}}
                        <div>
                            <label for="stock" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Inventory Count</label>
                            <input type="number" 
                                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm font-bold focus-ring" 
                                   id="stock" name="stock" required min="0" placeholder="0">
                        </div>
                    </div>

                    {{-- Product Image --}}
                    <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <label for="image" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 text-center">Visual Asset</label>
                        <div class="flex flex-col items-center">
                            <input type="file" 
                                   class="block w-full text-xs text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-xs file:font-bold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100 transition-all cursor-pointer" 
                                   id="image" name="image">
                            <p class="text-[10px] text-gray-400 mt-3 font-medium">Resolution: 800x800px recommended. JPG or PNG only.</p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-6 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-2xl transition-all shadow-lg shadow-blue-500/20 active:scale-[0.98]">
                            Publish Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="flex-1 inline-flex items-center justify-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-bold py-4 px-6 rounded-2xl hover:bg-gray-50 transition-all">
                            Discard & Return
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection