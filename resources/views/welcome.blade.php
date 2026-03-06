<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BokinceX | Premium Commerce</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,900" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-white antialiased selection:bg-blue-500 selection:text-white">
    
    <header class="fixed top-0 w-full z-50 px-6 py-8">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2 group cursor-default">
                <div class="w-8 h-8 bg-blue-600 rounded-xl rotate-12 group-hover:rotate-0 transition-transform duration-500 flex items-center justify-center">
                    <span class="text-white font-black text-xs -rotate-12 group-hover:rotate-0 transition-transform">B</span>
                </div>
                <span class="text-sm font-black uppercase tracking-[0.2em] dark:text-white">Bokince<span class="text-blue-600 text-lg italic">X</span></span>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-6">
                    @auth
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-500 transition-colors">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-500 transition-colors">
                                My Account
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            Log In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-2xl hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20 active:scale-95">
                                Join Now
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main class="min-h-screen flex items-center justify-center pt-24 pb-12 px-6">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="space-y-8">
                <div class="space-y-4">
                    <h1 class="text-5xl lg:text-7xl font-black tracking-tighter leading-none">
                        Let's go <br/>
                        <span class="text-blue-600">shopping.</span>
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium leading-relaxed max-w-md">
                        Experience the next evolution of commerce with BokinceX. Curated products, elite pricing, and seamless checkout.
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <a href="#explore" class="bg-gray-900 dark:bg-white dark:text-gray-950 text-white text-[10px] font-black uppercase tracking-widest px-8 py-5 rounded-2xl hover:opacity-90 transition-all shadow-xl active:scale-95">
                        Start Exploring
                    </a>
                    <div class="h-px w-12 bg-gray-200 dark:bg-gray-800"></div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Spring '26 Collection</span>
                </div>

                <div class="flex gap-12 pt-8">
                    <div>
                        <p class="text-2xl font-black">12k+</p>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Active Clients</p>
                    </div>
                    <div>
                        <p class="text-2xl font-black">24h</p>
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Global Delivery</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 bg-blue-600/10 blur-3xl rounded-full"></div>
                <div class="relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-8 rounded-[3rem] shadow-2xl">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-transparent hover:border-blue-500/30 transition-all group">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-black uppercase text-[11px] tracking-widest mb-1">Premium Inventory</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-snug">Hand-picked products from top-tier vendors globally.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-transparent hover:border-blue-500/30 transition-all group">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-black uppercase text-[11px] tracking-widest mb-1">Secure Protocol</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-snug">Military-grade encryption for every transaction.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>