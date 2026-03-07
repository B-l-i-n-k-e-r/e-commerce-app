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
                            <path d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Product Categories <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400">Categories</span>
                        </h1>
                        <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 mt-1">Organize your products with custom categories.</p>
                    </div>
                </div>
                
                <a href="{{ route('admin.categories.create') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-8 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                    <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Category
                </a>
            </div>
        </div>

        {{-- Categories Table Glass Card --}}
        <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 light:border-gray-200">
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Name</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Description</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center fit-content">Products</th>
                            <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-right fit-content">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 light:divide-gray-100">
                        @forelse($categories as $category)
                        <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors group">
                            <td class="py-4 px-6 fit-content">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-black text-xs shadow-lg">
                                        {{ strtoupper(substr($category->name, 0, 1)) }}
                                    </div>
                                    <span class="font-black light:text-gray-900 dark:text-white text-sm uppercase tracking-tight">
                                        {{ $category->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-xs font-medium light:text-gray-600 dark:text-gray-400">
                                    {{ $category->description ?? 'No description provided' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 fit-content text-center">
                                <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-gradient-to-r from-purple-500/10 to-blue-500/10 light:from-purple-500/5 light:to-blue-500/5 border border-purple-500/20 light:text-purple-700 dark:text-purple-400">
                                    {{ $category->products_count ?? 0 }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right fit-content">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                       class="p-2.5 light:text-gray-400 dark:text-gray-500 hover:text-purple-600 hover:bg-purple-500/10 light:hover:bg-purple-50 rounded-xl transition-all"
                                       title="Edit Category">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    @if(($category->products_count ?? 0) == 0)
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2.5 light:text-gray-400 dark:text-gray-500 hover:text-red-600 hover:bg-red-500/10 light:hover:bg-red-50 rounded-xl transition-all"
                                                title="Delete Category">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">No categories found</p>
                                    <p class="text-[9px] light:text-gray-300 dark:text-gray-600 mt-2">Create your first category to organize products</p>
                                    <a href="{{ route('admin.categories.create') }}" 
                                       class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-3 px-6 rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Add Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($categories, 'links') && $categories->hasPages())
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
        @endif
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

    /* Light mode gradient colors */
    .light .from-purple-100 { --tw-gradient-from: #f3e8ff; }
    .light .to-blue-100 { --tw-gradient-to: #dbeafe; }
    .light .from-purple-600 { --tw-gradient-from: #9333ea; }
    .light .to-blue-600 { --tw-gradient-to: #2563eb; }
    .light .from-purple-500\/5 { --tw-gradient-from: rgba(168, 85, 247, 0.05); }
    .light .to-blue-500\/5 { --tw-gradient-to: rgba(59, 130, 246, 0.05); }

    /* Light mode text colors */
    .light .text-purple-700 { color: #7e22ce; }

    /* Dark mode text colors */
    .dark .text-purple-400 { color: #c084fc; }

    /* Fit content utility */
    .fit-content {
        width: 1%;
        white-space: nowrap;
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