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
                    <li class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">Create New</li>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Create New <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">Category</span>
                        </h1>
                        <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400 mt-1">Add a new category to organize your products</p>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="p-8">
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-8">
                    @csrf

                    {{-- Category Name --}}
                    <div class="space-y-2">
                        <label for="name" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            Category Name
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                               class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 placeholder:light:text-gray-400 placeholder:dark:text-gray-500" 
                               placeholder="e.g. Electronics, Clothing, Books" required>
                        @error('name') 
                            <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1 mt-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2">
                        <label for="description" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            Description (Optional)
                        </label>
                        <textarea name="description" id="description" rows="4" 
                                  class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 min-h-[120px] placeholder:light:text-gray-400 placeholder:dark:text-gray-500" 
                                  placeholder="Describe this category...">{{ old('description') }}</textarea>
                        @error('description') 
                            <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1 mt-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Preview Card (Visual helper) --}}
                    <div class="glass-card rounded-2xl p-6 border border-white/5 light:border-gray-200 mt-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-black text-lg shadow-lg" id="preview-icon">
                                {{ old('name') ? strtoupper(substr(old('name'), 0, 1)) : 'C' }}
                            </div>
                            <div class="flex-1">
                                <div class="text-xs font-black light:text-gray-900 dark:text-white uppercase tracking-tight" id="preview-name">
                                    {{ old('name') ?: 'Category Name' }}
                                </div>
                                <div class="text-[9px] font-medium light:text-gray-500 dark:text-gray-400 mt-1" id="preview-desc">
                                    {{ old('description') ?: 'Category description will appear here' }}
                                </div>
                            </div>
                            <div class="px-3 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-widest bg-gradient-to-r from-purple-500/10 to-blue-500/10 border border-purple-500/20 light:text-purple-700 dark:text-purple-400">
                                Preview
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-8 flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 px-6 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Category
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
                previewName.textContent = this.value || 'Category Name';
                previewIcon.textContent = this.value ? this.value.charAt(0).toUpperCase() : 'C';
            });
        }

        if (descInput) {
            descInput.addEventListener('input', function() {
                previewDesc.textContent = this.value || 'Category description will appear here';
            });
        }
    });
</script>
@endsection