@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb Navigation with Glass Card --}}
        <nav class="mb-8" aria-label="Breadcrumb">
            <div class="glass-card rounded-2xl p-4 inline-block border light:border-gray-200 dark:border-white/5">
                <ol class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest">
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="light:text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                            Inventory
                        </a>
                    </li>
                    <li class="light:text-gray-300 dark:text-gray-600">/</li>
                    <li class="light:text-gray-500 dark:text-gray-400">Edit</li>
                    <li class="light:text-gray-300 dark:text-gray-600">/</li>
                    <li class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
                        #{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
                    </li>
                </ol>
            </div>
        </nav>

        {{-- Main Form Card --}}
        <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
            
            {{-- Header --}}
            <div class="px-8 py-6 border-b border-white/5 light:border-gray-200 bg-white/5 light:bg-gray-50/50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg animate-float">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">Modify Product</h1>
                        <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400 mt-1">
                            Updating details for <span class="font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">{{ $product->name }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="p-8">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    {{-- Product Name --}}
                    <div class="space-y-2">
                        <label for="name" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Product Name
                        </label>
                        <input type="text" 
                               class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 placeholder:light:text-gray-400 placeholder:dark:text-gray-500" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1 mt-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Category Selection --}}
                    <div class="space-y-2">
                        <label for="category_id" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            Category
                        </label>
                        <div class="relative">
                            <select id="category_id" name="category_id" required
                                    class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 appearance-none cursor-pointer">
                                <option value="" disabled>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2">
                        <label for="description" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            Description
                        </label>
                        <textarea class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 min-h-[120px]" 
                                  id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Price --}}
                        <div class="space-y-2">
                            <label for="price" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                <svg class="w-3 h-3 light:text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Price
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <span class="text-xs font-black light:text-gray-500 dark:text-gray-400">KES</span>
                                </div>
                                <input type="number" step="0.01" min="0"
                                       class="w-full portal-input p-5 pl-16 text-sm font-black outline-none focus:ring-1 focus:ring-purple-600" 
                                       id="price" name="price" value="{{ old('price', $product->price) }}" required>
                            </div>
                            @error('price')
                                <p class="text-[9px] font-bold uppercase text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div class="space-y-2">
                            <label for="stock" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                <svg class="w-3 h-3 light:text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                                Quantity
                            </label>
                            <input type="number" min="0"
                                   class="w-full portal-input p-5 text-sm font-black outline-none focus:ring-1 focus:ring-purple-600" 
                                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')
                                <p class="text-[9px] font-bold uppercase text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Product Image --}}
                    <div class="glass-card rounded-2xl p-6 border border-white/5 light:border-gray-200">
                        <div class="space-y-4">
                            <label for="image" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                <svg class="w-3 h-3 light:text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Media
                            </label>
                            
                            <div class="flex flex-col md:flex-row items-center gap-8">
                                @if($product->image_url)
                                    <div class="relative group text-center">
                                        <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Current Image</p>
                                        <div class="relative">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                                 class="w-28 h-28 rounded-xl object-cover ring-2 ring-white/10 light:ring-gray-200 shadow-lg">
                                            <div class="absolute inset-0 rounded-xl ring-1 ring-inset ring-white/20"></div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex-1 w-full">
                                    <div class="flex flex-col items-center justify-center border-2 border-dashed border-white/10 light:border-gray-200 rounded-2xl p-6 transition-all hover:border-purple-500/50">
                                        <svg class="w-10 h-10 light:text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <input type="file" id="image" name="image" accept="image/*"
                                               class="block w-full text-[9px] light:text-gray-500 dark:text-gray-400
                                                      file:mr-4 file:py-2 file:px-4
                                                      file:rounded-xl file:border-0
                                                      file:text-[8px] file:font-black file:uppercase file:tracking-widest
                                                      file:bg-gradient-to-r file:from-purple-500/10 file:to-blue-500/10
                                                      file:text-purple-600 dark:file:text-purple-400
                                                      hover:file:from-purple-500/20 hover:file:to-blue-500/20
                                                      transition-all cursor-pointer">
                                        <p class="text-[8px] light:text-gray-400 dark:text-gray-500 mt-3 font-medium">
                                            Upload a new image to replace the existing one. JPG or PNG only. Max 2MB.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-[9px] font-bold uppercase text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-8 flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 px-6 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Details
                            </span>
                        </button>
                        <a href="{{ route('admin.products.index') }}" 
                           class="flex-1 inline-flex items-center justify-center glass-card border border-white/5 light:border-gray-200 light:text-gray-600 dark:text-gray-300 text-[10px] font-black uppercase tracking-widest py-5 px-6 rounded-2xl hover:scale-105 transition-all">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel Changes
                            </span>
                        </a>
                    </div>
                </form>
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