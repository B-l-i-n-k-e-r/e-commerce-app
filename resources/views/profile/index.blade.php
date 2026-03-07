@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-200px)] px-4 py-10">
        <div class="w-full max-w-md">
            {{-- Glass Card Profile Container --}}
            <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden transition-all duration-300 hover:scale-105">
                
                {{-- Gradient Header Bar --}}
                <div class="h-24 bg-gradient-to-r from-purple-600 to-blue-600"></div>

                <div class="px-8 pb-8">
                    <div class="relative text-center">
                        {{-- Profile Photo with Animated Border --}}
                        <div class="relative -mt-12 mb-4 inline-block group">
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-600 to-blue-600 blur-lg opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                            <img src="{{ $user->profile_photo_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="relative h-24 w-24 rounded-2xl object-cover ring-4 ring-white/20 light:ring-gray-200 shadow-2xl mx-auto">
                            <div class="absolute bottom-1 right-1 h-4 w-4 bg-emerald-500 border-2 border-white dark:border-gray-900 rounded-full shadow-lg" title="Online"></div>
                        </div>

                        {{-- User Name with Gradient --}}
                        <h2 class="text-2xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter mb-1">
                            {{ $user->name }}
                        </h2>
                        <p class="text-sm font-medium light:text-gray-500 dark:text-gray-400 mb-4">
                            {{ $user->email }}
                        </p>

                        {{-- Role Badge with Gradient --}}
                        <div class="mb-6">
                            @if($user->is_admin)
                                <span class="inline-flex px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-gradient-to-r from-rose-500/10 to-rose-500/10 border border-rose-500/20 light:text-rose-700 dark:text-rose-400">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        System Administrator
                                    </span>
                                </span>
                            @elseif($user->is_manager)
                                <span class="inline-flex px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-gradient-to-r from-blue-500/10 to-blue-500/10 border border-blue-500/20 light:text-blue-700 dark:text-blue-400">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Manager
                                    </span>
                                </span>
                            @else
                                <span class="inline-flex px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest light:bg-gray-100 dark:bg-white/5 light:text-gray-600 dark:text-gray-400">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Customer
                                    </span>
                                </span>
                            @endif
                        </div>

                        {{-- Action Buttons --}}
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('profile.edit') }}" 
                               class="group flex items-center justify-center gap-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-6 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95">
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Account Settings
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Additional Stats Card --}}
                        <div class="mt-6 pt-6 border-t border-white/5 light:border-gray-200">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="glass-card rounded-xl p-3 border light:border-gray-200 dark:border-white/5">
                                    <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Member Since</p>
                                    <p class="text-xs font-black light:text-gray-900 dark:text-white">{{ $user->created_at->format('M Y') }}</p>
                                </div>
                                <div class="glass-card rounded-xl p-3 border light:border-gray-200 dark:border-white/5">
                                    <p class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Last Updated</p>
                                    <p class="text-xs font-black light:text-gray-900 dark:text-white">{{ $user->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Success Toast --}}
                        @if(session('success'))
                            <div x-data="{ show: true }" 
                                 x-show="show" 
                                 x-init="setTimeout(() => show = false, 3000)"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute top-4 right-4 glass-card rounded-xl p-3 border border-emerald-500/20 shadow-2xl">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black light:text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Profile Updated!</p>
                                        <p class="text-[8px] font-medium light:text-gray-500 dark:text-gray-400">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
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

    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
</style>

{{-- Alpine.js for toast animation --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('toast', () => ({
            show: true
        }))
    })
</script>
@endsection