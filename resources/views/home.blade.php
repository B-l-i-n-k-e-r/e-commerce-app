<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BokinceX | Home</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        .page-bg { 
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, hsla(260,100%,95%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(190,100%,92%,1) 0, transparent 50%);
            min-height: 100vh;
        }

        .dark .page-bg { background-color: #030712; background-image: none; }

        .glass-card { 
            background: rgba(255, 255, 255, 0.7); 
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.05); 
        }

        .dark .glass-card { background: #0b1120; border: 1px solid #1e293b; backdrop-filter: none; }

        .product-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-card:hover { 
            transform: translateY(-8px); 
            border-color: #3b82f6; 
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.1);
        }
        .text-glow { text-shadow: 0 0 30px rgba(59, 130, 246, 0.3); }
    </style>
</head>
<body class="page-bg text-gray-900 dark:text-gray-100 antialiased selection:bg-blue-600 selection:text-white transition-colors duration-500">

    <header class="fixed top-0 w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between glass-card py-4 px-8 rounded-2xl shadow-2xl">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-blue-600 rounded-xl rotate-12 group-hover:rotate-0 transition-all flex items-center justify-center">
                    <span class="text-white font-black text-sm -rotate-12 group-hover:rotate-0">B</span>
                </div>
                <span class="text-base font-black uppercase tracking-[0.3em]">Bokince<span class="text-blue-600 italic">X</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="#featured" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-colors">Featured</a>
                <a href="#shop" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-colors">Catalog</a>
                
                <a href="{{ route('cart.view') }}" class="relative p-2 text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 10-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span id="cart-count-badge" class="absolute top-0 right-0 w-4 h-4 bg-blue-600 text-[8px] font-black rounded-full flex items-center justify-center text-white hidden">0</span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="text-[10px] font-black uppercase tracking-widest px-6 py-3 border border-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all">Portal</a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-lg hover:bg-blue-500 transition-all">Access</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="pt-32 pb-20">
        <section class="max-w-7xl mx-auto px-6 mb-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-blue-600 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">New Season Drop</span>
                    <h1 class="text-5xl lg:text-7xl font-black tracking-tighter leading-none mb-6">
                        EQUIP YOUR <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-400">LIFESTYLE.</span>
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 text-lg mb-8 max-w-md uppercase text-sm tracking-wide">High-performance gear curated for the modern operator.</p>
                    <a href="#shop" class="inline-block px-10 py-5 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-500 shadow-xl shadow-blue-600/20 transition-all active:scale-95">
                        Browse Collection
                    </a>
                </div>
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative glass-card rounded-[2rem] overflow-hidden aspect-video">
                        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700" alt="Hero">
                    </div>
                </div>
            </div>
        </section>

        <section id="shop" class="max-w-7xl mx-auto px-6">
            <div class="flex items-end justify-between mb-12 border-b border-black/5 dark:border-white/5 pb-8">
                <h2 class="text-3xl font-black uppercase tracking-tighter text-glow">The Catalog</h2>
                <div class="flex gap-4">
                    <button class="text-[9px] font-black uppercase tracking-widest text-blue-600">All</button>
                    <button class="text-[9px] font-black uppercase tracking-widest text-gray-500 hover:text-blue-600 transition-colors">Tech</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    <div class="product-card glass-card rounded-3xl p-5 group">
                        <div class="aspect-square rounded-2xl bg-gray-100 dark:bg-gray-900 mb-6 overflow-hidden relative">
                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover opacity-90 group-hover:scale-110 group-hover:opacity-100 transition-all duration-700" loading="lazy">
                            <button onclick="quickAdd('{{ $product->id }}')" class="absolute bottom-4 right-4 bg-blue-600 text-white p-4 rounded-xl translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all shadow-2xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest">{{ $product->category->name ?? 'Premium' }}</p>
                            <h3 class="text-lg font-black uppercase tracking-tight">{{ $product->name }}</h3>
                            <p class="text-xl font-bold text-gray-400 dark:text-white/50 group-hover:text-blue-600 transition-colors">KSH {{ number_format($product->price) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center opacity-20">
                        <p class="text-sm font-black uppercase tracking-[0.5em]">Inventory Data Unavailable</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <footer class="border-t border-black/5 dark:border-white/5 py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 dark:text-gray-600">© 2026 BOKINCEX PROTOCOL. ALL RIGHTS RESERVED.</span>
        </div>
    </footer>

    <script>
        let cart = JSON.parse(localStorage.getItem('bokince_cart')) || [];

        function updateBadge() {
            const badge = document.getElementById('cart-count-badge');
            if (!badge) return;
            const count = cart.length;
            if (count > 0) {
                badge.innerText = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        function quickAdd(productId) {
            cart.push(productId);
            localStorage.setItem('bokince_cart', JSON.stringify(cart));
            updateBadge();

            fetch(`/cart/add-ajax/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => console.log('BokinceX Protocol: Cart Synced'))
            .catch(err => console.error('BokinceX Protocol: Sync Error', err));
        }

        window.addEventListener('storage', (event) => {
            if (event.key === 'bokince_cart') {
                cart = JSON.parse(event.newValue) || [];
                updateBadge();
            }
        });
        
        updateBadge();
    </script>
</body>
</html>