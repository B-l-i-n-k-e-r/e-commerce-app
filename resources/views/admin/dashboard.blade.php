@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full page-bg relative overflow-hidden">
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            {{-- Welcome Header with Glass Card --}}
            <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="light:bg-gradient-to-br light:from-purple-100 light:to-blue-100 dark:bg-blue-600/20 p-4 rounded-2xl animate-float">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="light:text-purple-600 dark:text-blue-400">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-black light:text-gray-900 dark:text-white tracking-tighter">
                            Welcome back, <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400 dark:bg-gradient-to-r">Admin!</span>
                        </h1>
                        <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 mt-2">System overview and management portal.</p>
                    </div>
                </div>
            </div>

            {{-- Management Navigation Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Manage Users --}}
                <div class="glass-card rounded-[2rem] p-6 hover:scale-105 transition-all duration-300 border light:border-gray-200 dark:border-white/5 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 light:bg-gradient-to-br light:from-purple-500 light:to-purple-600 dark:bg-gradient-to-br dark:from-sky-500 dark:to-blue-700 rounded-xl rotate-12 group-hover:rotate-0 transition-all duration-500 flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <span class="text-[8px] font-black uppercase tracking-[0.3em] light:text-purple-600 dark:text-blue-400">Management</span>
                    </div>
                    <h2 class="text-2xl font-black light:text-gray-900 dark:text-white mb-2 tracking-tight">Manage Users</h2>
                    <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">View, edit permissions, and manage system accounts.</p>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest light:text-purple-600 dark:text-blue-400 light:hover:text-purple-800 dark:hover:text-blue-300 transition-colors group">
                        Go To Users
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ml-1 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Manage Products --}}
                <div class="glass-card rounded-[2rem] p-6 hover:scale-105 transition-all duration-300 border light:border-gray-200 dark:border-white/5 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 light:bg-gradient-to-br light:from-blue-500 light:to-blue-600 dark:bg-gradient-to-br dark:from-purple-500 dark:to-purple-700 rounded-xl rotate-12 group-hover:rotate-0 transition-all duration-500 flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>
                            </svg>
                        </div>
                        <span class="text-[8px] font-black uppercase tracking-[0.3em] light:text-blue-600 dark:text-purple-400">Inventory</span>
                    </div>
                    <h2 class="text-2xl font-black light:text-gray-900 dark:text-white mb-2 tracking-tight">Manage Products</h2>
                    <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">Inventory control: Add, update, or remove stock items.</p>
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest light:text-blue-600 dark:text-purple-400 light:hover:text-blue-800 dark:hover:text-purple-300 transition-colors group">
                        Go to Products
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ml-1 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Manage Orders --}}
                <div class="glass-card rounded-[2rem] p-6 hover:scale-105 transition-all duration-300 border light:border-gray-200 dark:border-white/5 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 light:bg-gradient-to-br light:from-purple-500 light:to-blue-600 dark:bg-gradient-to-br dark:from-green-500 dark:to-emerald-700 rounded-xl rotate-12 group-hover:rotate-0 transition-all duration-500 flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v20M17 5H9.5M17 12h-5M17 19h-5"/><path d="M5 5h14v14H5z"/>
                            </svg>
                        </div>
                        <span class="text-[8px] font-black uppercase tracking-[0.3em] light:text-purple-600 dark:text-green-400">Sales</span>
                    </div>
                    <h2 class="text-2xl font-black light:text-gray-900 dark:text-white mb-2 tracking-tight">Manage Orders</h2>
                    <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">Process sales, track shipping, and view order history.</p>
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest light:text-purple-600 dark:text-green-400 light:hover:text-purple-800 dark:hover:text-green-300 transition-colors group">
                        Go to Orders
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ml-1 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Statistics Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Revenue --}}
                <div class="glass-card rounded-[2rem] p-8 shadow-2xl border light:border-gray-200 dark:border-white/5 text-center group hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 light:bg-gradient-to-br light:from-purple-500 light:to-purple-600 dark:bg-gradient-to-br dark:from-green-600 dark:to-emerald-800 rounded-2xl rotate-12 group-hover:rotate-0 transition-all duration-500 flex items-center justify-center shadow-lg mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v20M17 5H9.5M17 12h-5M17 19h-5"/>
                        </svg>
                    </div>
                    <h2 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.3em] mb-3">Total Revenue</h2>
                    <p class="text-4xl font-black text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-green-400 dark:to-emerald-400 dark:bg-gradient-to-r">
                        Ksh {{ number_format($totalRevenue, 2) }}
                    </p>
                </div>

                {{-- Total Orders --}}
                <div class="glass-card rounded-[2rem] p-8 shadow-2xl border light:border-gray-200 dark:border-white/5 text-center group hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 light:bg-gradient-to-br light:from-blue-500 light:to-blue-600 dark:bg-gradient-to-br dark:from-blue-600 dark:to-cyan-800 rounded-2xl rotate-12 group-hover:rotate-0 transition-all duration-500 flex items-center justify-center shadow-lg mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                    </div>
                    <h2 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.3em] mb-3">Total Orders</h2>
                    <p class="text-4xl font-black text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-cyan-400 dark:bg-gradient-to-r">
                        {{ number_format($totalOrders) }}
                    </p>
                </div>

                {{-- Total Products --}}
                <div class="glass-card rounded-[2rem] p-8 shadow-2xl border light:border-gray-200 dark:border-white/5 text-center group hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 light:bg-gradient-to-br light:from-purple-500 light:to-blue-600 dark:bg-gradient-to-br dark:from-purple-600 dark:to-pink-800 rounded-2xl rotate-12 group-hover:rotate-0 transition-all duration-500 flex items-center justify-center shadow-lg mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h2 class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.3em] mb-3">Total Products</h2>
                    <p class="text-4xl font-black text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-purple-400 dark:to-pink-400 dark:bg-gradient-to-r">
                        {{ number_format($totalProducts) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Base page background logic */
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

        /* Light mode gradient colors - Purple & Blue theme */
        .light .from-purple-500 { --tw-gradient-from: #a855f7; }
        .light .to-purple-600 { --tw-gradient-to: #9333ea; }
        .light .from-blue-500 { --tw-gradient-from: #3b82f6; }
        .light .to-blue-600 { --tw-gradient-to: #2563eb; }
        .light .from-purple-100 { --tw-gradient-from: #f3e8ff; }
        .light .to-blue-100 { --tw-gradient-to: #dbeafe; }
        
        /* Light mode text gradients */
        .light .from-purple-600 { --tw-gradient-from: #9333ea; }
        .light .to-blue-600 { --tw-gradient-to: #2563eb; }
        
        /* Light mode text colors */
        .light .text-purple-600 { color: #9333ea; }
        .light .text-blue-600 { color: #2563eb; }
        
        /* Dark mode gradients (keeping original) */
        .dark .from-sky-500 { --tw-gradient-from: #0ea5e9; }
        .dark .to-blue-700 { --tw-gradient-to: #1d4ed8; }
        .dark .from-purple-500 { --tw-gradient-from: #a855f7; }
        .dark .to-purple-700 { --tw-gradient-to: #7e22ce; }
        .dark .from-green-500 { --tw-gradient-from: #22c55e; }
        .dark .to-emerald-700 { --tw-gradient-to: #047857; }
        .dark .from-green-600 { --tw-gradient-from: #16a34a; }
        .dark .to-emerald-800 { --tw-gradient-to: #065f46; }
        .dark .from-blue-600 { --tw-gradient-from: #2563eb; }
        .dark .to-cyan-800 { --tw-gradient-to: #155e75; }
        .dark .from-purple-600 { --tw-gradient-from: #9333ea; }
        .dark .to-pink-800 { --tw-gradient-to: #9d174d; }

        /* Dark mode gradient text */
        .dark .from-blue-400 { --tw-gradient-from: #60a5fa; }
        .dark .to-purple-400 { --tw-gradient-to: #c084fc; }
        .dark .from-green-400 { --tw-gradient-from: #4ade80; }
        .dark .to-emerald-400 { --tw-gradient-to: #34d399; }
        .dark .from-blue-400 { --tw-gradient-from: #60a5fa; }
        .dark .to-cyan-400 { --tw-gradient-to: #22d3ee; }
        .dark .from-purple-400 { --tw-gradient-from: #c084fc; }
        .dark .to-pink-400 { --tw-gradient-to: #f472b6; }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px) rotate(12deg); }
            50% { transform: translateY(-10px) rotate(10deg); }
            100% { transform: translateY(0px) rotate(12deg); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Layout cleanup */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
    </style>
@endsection