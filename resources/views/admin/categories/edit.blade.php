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
                        <a href="{{ route('admin.categories.index') }}" class="light:text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            Categories
                        </a>
                    </li>
                    <li class="light:text-gray-300 dark:text-gray-600">/</li>
                    <li class="light:text-gray-500 dark:text-gray-400">Edit</li>
                    <li class="light:text-gray-300 dark:text-gray-600">/</li>
                    <li class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
                        {{ $category->name }}
                    </li>
                </ol>
            </div>
        </nav>

        {{-- Header with Delete Button --}}
        <div class="glass-card rounded-[2.5rem] p-6 mb-8 border light:border-gray-200 dark:border-white/5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-black text-2xl shadow-lg animate-float">
                        {{ strtoupper(substr($category->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">Category</span>
                        </h1>
                        <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 mt-1">Update the details for "{{ $category->name }}".</p>
                    </div>
                </div>

                {{-- Delete Action --}}
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone if no products are attached.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-[9px] font-black uppercase tracking-widest text-red-500 hover:bg-red-500/10 light:hover:bg-red-50 rounded-xl transition-all group">
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Category
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Form Card --}}
        <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
            
            {{-- Form Header --}}
            <div class="px-8 py-6 border-b border-white/5 light:border-gray-200 bg-white/5 light:bg-gray-50/50">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-black light:text-gray-900 dark:text-white uppercase tracking-tight">Category Information</h2>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-8 md:p-10">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- Name Field --}}
                    <div class="space-y-2">
                        <label for="name" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            Category Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $category->name) }}" 
                               class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 placeholder:light:text-gray-400 placeholder:dark:text-gray-500" 
                               placeholder="e.g., Electronics, Clothing, Books" 
                               required>
                        @error('name')
                            <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1 mt-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description Field --}}
                    <div class="space-y-2">
                        <label for="description" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            Description
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="5" 
                                  class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 min-h-[120px] placeholder:light:text-gray-400 placeholder:dark:text-gray-500 resize-none" 
                                  placeholder="Provide a brief overview of what this category contains...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1 mt-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Preview Card --}}
                    <div class="glass-card rounded-2xl p-6 border border-white/5 light:border-gray-200 mt-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-black text-xl shadow-lg" id="preview-icon">
                                {{ strtoupper(substr($category->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-black light:text-gray-900 dark:text-white uppercase tracking-tight" id="preview-name">
                                    {{ $category->name }}
                                </div>
                                <div class="text-[10px] font-medium light:text-gray-500 dark:text-gray-400 mt-1 line-clamp-2" id="preview-desc">
                                    {{ $category->description ?: 'No description provided' }}
                                </div>
                            </div>
                            <div class="px-3 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-widest bg-gradient-to-r from-purple-500/10 to-blue-500/10 border border-purple-500/20 light:text-purple-700 dark:text-purple-400">
                                Live Preview
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="pt-8 flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 px-6 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Update Category
                            </span>
                        </button>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="flex-1 inline-flex items-center justify-center glass-card border border-white/5 light:border-gray-200 light:text-gray-600 dark:text-gray-300 text-[10px] font-black uppercase tracking-widest py-5 px-6 rounded-2xl hover:scale-105 transition-all">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel
                            </span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="mt-8 glass-card rounded-2xl p-6 border border-blue-500/20 light:border-blue-200">
            <div class="flex gap-4">
                <div class="shrink-0 p-2 rounded-xl bg-gradient-to-br from-blue-500/10 to-blue-500/10 border border-blue-500/20">
                    <svg class="w-5 h-5 light:text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-black light:text-blue-800 dark:text-blue-300 uppercase tracking-wider">Quick Tip</h4>
                    <p class="text-[10px] font-medium light:text-blue-600/70 dark:text-blue-400/70 mt-1 leading-relaxed">
                        Updating the category name will also refresh its URL slug. This may affect SEO if the category is already indexed by search engines.
                    </p>
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

    /* Line clamp for preview */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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

<script>
    // Live preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const descInput = document.getElementById('description');
        const previewName = document.getElementById('preview-name');
        const previewDesc = document.getElementById('preview-desc');
        const previewIcon = document.getElementById('preview-icon');

        if (nameInput) {
            nameInput.addEventListener('input', function() {
                previewName.textContent = this.value || '{{ $category->name }}';
                previewIcon.textContent = this.value ? this.value.charAt(0).toUpperCase() : '{{ strtoupper(substr($category->name, 0, 1)) }}';
            });
        }

        if (descInput) {
            descInput.addEventListener('input', function() {
                previewDesc.textContent = this.value || '{{ $category->description ?: "No description provided" }}';
            });
        }
    });
</script>
@endsection