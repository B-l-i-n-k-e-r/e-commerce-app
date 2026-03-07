<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BokinceX | Premium Commerce Portal</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,900" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .page-bg {
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, hsla(260,100%,95%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(190,100%,92%,1) 0, transparent 50%);
        }

        .dark .page-bg {
            background-color: #030712;
            background-image: none;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dark .glass-card {
            background: #0b1120;
            border: 1px solid #1e293b;
            backdrop-filter: none;
        }

        .portal-input {
            border: 1px solid #334155;
            background: #0f172a;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .portal-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
        }

        .text-glow {
            text-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(12deg); }
            50% { transform: translateY(-15px) rotate(10deg); }
            100% { transform: translateY(0px) rotate(12deg); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 3px;
        }

        @keyframes slideUp {
            from { transform: translateY(100%) translateX(-50%); opacity: 0; }
            to { transform: translateY(0) translateX(-50%); opacity: 1; }
        }

        .toast-active {
            animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .product-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #cart-sidebar {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #checkout-modal {
            transition: opacity 0.4s ease;
        }

        /* Functional state for protocol selection - keeps original look but adds indicator */
        .protocol-active {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
            color: #3b82f6 !important;
        }

        /* Filter animations */
        .product-card {
            transition: opacity 0.3s ease, transform 0.3s ease, display 0.3s ease allow-discrete;
        }
        
        #filter-dropdown {
            transition: opacity 0.2s ease;
        }
        
        #filter-dropdown:not(.hidden) {
            animation: fadeIn 0.2s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="page-bg text-gray-900 dark:text-gray-100 antialiased selection:bg-blue-600 selection:text-white transition-colors duration-500 min-h-screen overflow-x-hidden">
    
    <div class="fixed top-0 left-0 h-[3px] bg-blue-600 z-[100] w-full origin-left scale-x-0 transition-transform duration-300" id="progress-bar"></div>

    <div id="toast-container" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[100] pointer-events-none"></div>

    <div id="cart-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[70] hidden opacity-0 transition-opacity duration-500" onclick="toggleCart()"></div>
    
    <aside id="cart-sidebar" class="fixed top-0 right-0 h-full w-full max-w-md bg-[#0b1120] border-l border-white/5 z-[80] translate-x-full shadow-2xl p-8 flex flex-col">
        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-blue-600 text-[10px] font-black uppercase tracking-[0.3em]">Your Secure</p>
                <h2 class="text-2xl font-black uppercase tracking-tight">Cart <span class="text-blue-600 italic">X</span></h2>
            </div>
            <button onclick="toggleCart()" class="w-12 h-12 rounded-xl border border-gray-800 flex items-center justify-center hover:bg-white/5 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div id="cart-items" class="flex-1 overflow-y-auto space-y-6">
            <div class="text-center py-20 opacity-20">
                <p class="text-xs font-black uppercase tracking-widest">Cart is currently empty</p>
            </div>
        </div>

        <div class="mt-auto pt-8 border-t border-gray-800">
            <div class="flex justify-between items-center mb-6">
                <span class="text-[10px] font-black uppercase tracking-widest text-gray-500">Amount</span>
                <span id="cart-total" class="text-2xl font-black text-blue-600">KSH 0.00</span>
            </div>
            <button onclick="handleCheckout()" class="w-full py-5 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-500 transition-all active:scale-95 shadow-lg shadow-blue-600/20">
                Proceed to Checkout
            </button>
        </div>
    </aside>

    <div id="checkout-modal" class="fixed inset-0 bg-[#030712]/95 backdrop-blur-2xl z-[150] hidden items-center justify-center p-4 md:p-10 overflow-y-auto">
        <div class="max-w-5xl w-full glass-card rounded-[2.5rem] overflow-hidden flex flex-col md:flex-row relative">
            
            <button onclick="closeCheckout()" class="absolute top-6 right-6 z-[160] w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-red-500/20 hover:text-red-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div id="checkout-gate" class="w-full md:w-1/2 p-10 md:p-16 border-r border-white/5">
                <span class="text-blue-600 text-[10px] font-black uppercase tracking-[0.3em]">Access Point</span>
                <h3 class="text-4xl font-black text-white mt-2 mb-8 uppercase tracking-tighter">Identity</h3>
                
                <div class="space-y-8">
                    <div class="group p-6 rounded-2xl border border-white/10 hover:border-blue-600/50 bg-white/5 transition-all cursor-pointer" onclick="showGuestForm()">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h4 class="font-black text-sm uppercase tracking-widest">Guest Operator</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Proceed without account creation. Transactional data will be sent via encrypted email.</p>
                    </div>

                    <a href="{{ route('login') }}" class="block p-6 rounded-2xl border border-white/5 hover:border-blue-600/50 transition-all bg-black/20">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-8 h-8 rounded-lg border border-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <h4 class="font-black text-sm uppercase tracking-widest">Login</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Sign in for synchronized history and accelerated logistics.</p>
                    </a>
                </div>
            </div>

            <div id="guest-billing-section" class="hidden w-full md:w-1/2 p-10 md:p-16 bg-white/[0.02] flex-col">
                <div class="flex items-center gap-3 mb-8">
                    <button onclick="hideGuestForm()" class="text-blue-600 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Logistics & Billing</span>
                </div>

                <form id="payment-protocol-form" class="space-y-6 flex-1 overflow-y-auto pr-2 custom-scroll" onsubmit="handleFinalSubmit(event)">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[9px] font-black uppercase text-gray-500 tracking-widest">First Name</label>
                            <input type="text" required class="w-full p-4 portal-input text-xs font-bold text-white uppercase outline-none focus:ring-1 focus:ring-blue-600">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-black uppercase text-gray-500 tracking-widest">Last Name</label>
                            <input type="text" required class="w-full p-4 portal-input text-xs font-bold text-white uppercase outline-none focus:ring-1 focus:ring-blue-600">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black uppercase text-gray-500 tracking-widest">Contact Email</label>
                        <input type="email" required class="w-full p-4 portal-input text-xs font-bold text-white uppercase outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black uppercase text-gray-500 tracking-widest">Location Address</label>
                        <input type="text" required placeholder="STREET, APARTMENT, SUITE" class="w-full p-4 portal-input text-xs font-bold text-white uppercase outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[9px] font-black uppercase text-gray-500 tracking-widest">City</label>
                            <input type="text" required class="w-full p-4 portal-input text-xs font-bold text-white uppercase outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-black uppercase text-gray-500 tracking-widest">Phone</label>
                            <input type="text" required placeholder="+254..." class="w-full p-4 portal-input text-xs font-bold text-white uppercase outline-none">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-white/5">
                        <p class="text-[9px] font-black uppercase text-blue-600 tracking-widest mb-4">Payment Method</p>
                        <input type="hidden" id="selected-protocol-value" value="">
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button" onclick="selectProtocol('mpesa', this)" class="protocol-btn p-4 rounded-xl border border-white/10 hover:border-blue-600 bg-white/5 transition-all text-[9px] font-black uppercase">M-Pesa</button>
                            <button type="button" onclick="selectProtocol('card', this)" class="protocol-btn p-4 rounded-xl border border-white/10 hover:border-blue-600 bg-white/5 transition-all text-[9px] font-black uppercase">Card</button>
                            <button type="button" onclick="selectProtocol('crypto', this)" class="protocol-btn p-4 rounded-xl border border-white/10 hover:border-blue-600 bg-white/5 transition-all text-[9px] font-black uppercase">Paypal</button>
                        </div>
                    </div>

                    <button type="submit" id="finalize-btn" class="w-full py-5 bg-blue-600 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-blue-500 transition-all shadow-xl shadow-blue-600/20 active:scale-95">
                        Confirm
                    </button>
                </form>
            </div>

            <div id="checkout-summary" class="w-full md:w-1/2 p-10 md:p-16 bg-blue-600 flex flex-col justify-between text-white">
                <div>
                    <span class="text-white/60 text-[10px] font-black uppercase tracking-[0.3em]">Order Summary</span>
                    <h3 class="text-4xl font-black mt-2 mb-10 uppercase tracking-tighter">Items</h3>
                    
                    <div id="manifest-items" class="space-y-6 opacity-90">
                        </div>
                </div>

                <div class="mt-12 pt-8 border-t border-white/20">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black uppercase tracking-widest">Total</span>
                        <span id="manifest-total" class="text-3xl font-black">KSH 0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header class="fixed top-0 w-full z-50 px-6 py-6 transition-all duration-500" id="main-header">
        <div class="max-w-7xl mx-auto flex items-center justify-between glass-card py-4 px-8 rounded-2xl shadow-2xl">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="w-10 h-10 bg-blue-600 rounded-xl rotate-12 group-hover:rotate-0 transition-all duration-500 flex items-center justify-center shadow-lg shadow-blue-600/40">
                    <span class="text-white font-black text-sm -rotate-12 group-hover:rotate-0 transition-transform">B</span>
                </div>
                <span class="text-base font-black uppercase tracking-[0.3em]">
                    Bokince<span class="text-blue-600 italic">X</span>
                </span>
            </div>

            <nav class="hidden md:flex items-center gap-8">
                <a href="#explore" class="text-[10px] font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 hover:text-blue-600 transition-colors">Collection</a>
                <div class="h-4 w-px bg-gray-200 dark:bg-gray-800"></div>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-lg hover:bg-blue-500 transition-all">Portal</a>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-blue-600 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-lg hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/30">Register</a>
                @endauth
            </nav>

            <button class="md:hidden w-10 h-10 flex items-center justify-center" onclick="toggleMobileMenu()">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>

    <main class="relative min-h-screen flex items-center pt-24 overflow-hidden">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center relative z-10">
            <div class="space-y-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-blue-600/10 border border-blue-600/20">
                    <div class="h-1.5 w-1.5 rounded-full bg-blue-600 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600">Protocol Active</span>
                </div>

                <h1 class="text-6xl lg:text-8xl font-black tracking-tighter leading-[0.95] text-glow">
                    The Art of <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400">Commerce.</span>
                </h1>

                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium leading-relaxed max-w-lg">
                    A secure sanctuary for the finest products. Experience commerce with military-grade precision.Let's go shopping...
                </p>

                <div class="flex flex-wrap items-center gap-6">
                    <a href="#explore" class="group px-10 py-5 bg-blue-600 rounded-xl transition-all hover:bg-blue-500 hover:shadow-[0_0_30px_rgba(37,99,235,0.4)] active:scale-95">
                        <span class="text-[11px] font-black uppercase tracking-widest text-white flex items-center gap-2">
                            Start Exploring
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            <div class="relative flex justify-center">
                <div class="relative w-full max-w-md aspect-[3/4] bg-blue-900/20 rounded-[3rem] p-1 animate-float border border-white/5 shadow-2xl">
                    <div class="w-full h-full bg-[#0b1120] rounded-[2.8rem] overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1000&auto=format&fit=crop" 
                             class="w-full h-full object-cover dark:opacity-40 grayscale hover:grayscale-0 transition-all duration-700" 
                             alt="Hero Product">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0b1120] via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 p-6 bg-[#0f172a] border border-blue-500/20 rounded-2xl shadow-xl">
                            <div class="w-10 h-1 bg-blue-600 mb-4 rounded-full"></div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-blue-400 mb-1">Featured Asset</p>
                            <h3 class="text-2xl font-black tracking-tight text-white uppercase">Vanta Black Watch</h3>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-400">KSH 1,299</span>
                                <button onclick="quickAdd('Vanta Black Watch', 1299, this)" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-500 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <section id="explore" class="max-w-7xl mx-auto px-6 py-32">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 gap-6 relative">
            <div class="flex items-center gap-6">
                <div>
                    <span class="text-blue-600 text-[10px] font-black uppercase tracking-[0.3em]">Curated Selection</span>
                    <h2 class="text-4xl font-black tracking-tight mt-2">Available <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400">Products</span></h2>
                </div>
                
                <button onclick="toggleCart()" class="flex items-center gap-3 px-6 py-3 bg-white/5 border border-white/10 rounded-2xl hover:bg-blue-600 hover:border-blue-600 transition-all duration-300 group">
                    <span class="text-[10px] font-black uppercase tracking-widest">Cart</span>
                    <div id="cart-count" class="w-5 h-5 bg-blue-600 text-white rounded flex items-center justify-center text-[10px] font-black group-hover:bg-white group-hover:text-blue-600 transition-colors">0</div>
                </button>
            </div>
            
            <div class="flex gap-3 relative">
                <button id="filter-btn" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-800 text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all flex items-center gap-2">
                    Filter <svg id="filter-chevron" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <button id="view-all-btn" class="px-6 py-3 rounded-xl bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-600/20 hover:bg-blue-500 transition-all">
                    View All
                </button>

                <div id="filter-dropdown" class="hidden absolute top-full right-0 mt-3 w-56 glass-card rounded-2xl p-4 z-[60] shadow-2xl border border-blue-500/10">
                    <p class="text-[8px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-2">Classification</p>
                    <div class="flex flex-col gap-1" id="category-list"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" id="product-grid">
            @forelse ($products ?? [] as $product)
                <div class="product-card group relative glass-card rounded-3xl p-4 hover:scale-105 transition-all duration-300" data-category="{{ strtolower($product->category->name ?? 'Premium') }}">
                    <div class="aspect-square w-full overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800 relative">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <button onclick="quickAdd('{{ $product->name }}', {{ $product->price }}, this)" class="absolute bottom-3 right-3 bg-blue-600 text-white p-3 rounded-xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 shadow-xl hover:scale-110 active:scale-90 z-30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                    <div class="mt-4 px-2">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-black text-sm uppercase tracking-tight">{{ $product->name }}</h3>
                            <span class="font-black text-sm text-blue-600">KSH {{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                @php $mocks = [['Watch', 1299, 'Tech'], ['Sneakers', 4500, 'Fashion'], ['Camera', 12000, 'Tech'], ['Headphones', 3500, 'Tech'], ['Jacket', 2800, 'Fashion'], ['Sunglasses', 1500, 'Fashion']]; @endphp
                @foreach($mocks as $mock)
                <div class="product-card group relative glass-card rounded-3xl p-4 hover:scale-105 transition-all duration-300" data-category="{{ strtolower($mock[2]) }}">
                    <div class="aspect-square w-full rounded-2xl bg-gray-800 relative overflow-hidden">
                        <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-900"></div>
                        <button onclick="quickAdd('{{ $mock[0] }}', {{ $mock[1] }}, this)" class="absolute bottom-3 right-3 bg-blue-600 text-white p-3 rounded-xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 shadow-xl z-30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-black text-sm uppercase text-white">{{ $mock[0] }}</h3>
                        <p class="text-blue-600 font-bold">KSH {{ $mock[1] }}</p>
                    </div>
                </div>
                @endforeach
            @endforelse
        </div>
    </section>

    <script>
        let cartItems = [];

        // Cart Functions
        function toggleCart() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-overlay');
            const isOpen = !sidebar.classList.contains('translate-x-full');
            if (isOpen) {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 500);
            } else {
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    sidebar.classList.remove('translate-x-full');
                }, 10);
            }
        }

        function handleCheckout() {
            if (cartItems.length === 0) return;
            toggleCart();
            
            const manifest = document.getElementById('manifest-items');
            manifest.innerHTML = cartItems.map(item => `
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-black uppercase tracking-widest">${item.name}</span>
                    <span class="text-xs font-bold">KSH ${item.price.toLocaleString()}</span>
                </div>
            `).join('');
            
            const total = cartItems.reduce((sum, item) => sum + item.price, 0);
            document.getElementById('manifest-total').innerText = `KSH ${total.toLocaleString()}`;

            const modal = document.getElementById('checkout-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => modal.style.opacity = '1', 10);
        }

        // Payment Protocol Functions
        function selectProtocol(method, btn) {
            document.getElementById('selected-protocol-value').value = method;
            
            document.querySelectorAll('.protocol-btn').forEach(el => el.classList.remove('protocol-active'));
            btn.classList.add('protocol-active');
        }

        function handleFinalSubmit(e) {
            e.preventDefault();
            const protocol = document.getElementById('selected-protocol-value').value;
            
            if (!protocol) {
                alert("Please select a Payment Protocol.");
                return;
            }

            const btn = document.getElementById('finalize-btn');
            btn.disabled = true;
            btn.innerHTML = `<span class="animate-pulse">Initializing Protocol...</span>`;

            setTimeout(() => {
                if (protocol === 'mpesa') {
                    window.location.href = "{{ url('/payment') }}";
                } else {
                    alert("Protocol " + protocol.toUpperCase() + " currently offline. Please use M-Pesa.");
                    btn.disabled = false;
                    btn.innerHTML = "Finalize Transaction";
                }
            }, 1000);
        }

        // Checkout UI Functions
        function showGuestForm() {
            document.getElementById('checkout-gate').classList.add('hidden');
            document.getElementById('guest-billing-section').classList.remove('hidden');
            document.getElementById('guest-billing-section').classList.add('flex');
            document.getElementById('checkout-summary').classList.replace('bg-blue-600', 'bg-[#0f172a]');
        }

        function hideGuestForm() {
            document.getElementById('guest-billing-section').classList.add('hidden');
            document.getElementById('checkout-gate').classList.remove('hidden');
            document.getElementById('checkout-summary').classList.replace('bg-[#0f172a]', 'bg-blue-600');
        }

        function closeCheckout() {
            const modal = document.getElementById('checkout-modal');
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                hideGuestForm();
            }, 400);
        }

        function updateCartUI() {
            const container = document.getElementById('cart-items');
            const totalEl = document.getElementById('cart-total');
            const countEl = document.getElementById('cart-count');
            countEl.innerText = cartItems.length;
            if (cartItems.length === 0) {
                container.innerHTML = `<div class="text-center py-20 opacity-20"><p class="text-xs font-black uppercase tracking-widest">Vault is currently empty</p></div>`;
                totalEl.innerText = `KSH 0.00`;
                return;
            }
            container.innerHTML = cartItems.map((item, index) => `
                <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/5">
                    <div class="flex-1">
                        <p class="text-[10px] font-black uppercase tracking-widest text-white">${item.name}</p>
                        <p class="text-xs font-bold text-blue-600">KSH ${item.price.toLocaleString()}</p>
                    </div>
                    <button onclick="removeFromCart(${index})" class="text-gray-500 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `).join('');
            const total = cartItems.reduce((sum, item) => sum + item.price, 0);
            totalEl.innerText = `KSH ${total.toLocaleString()}`;
        }

        function removeFromCart(index) {
            cartItems.splice(index, 1);
            updateCartUI();
        }

        function quickAdd(productName, price, btnElement = null) {
            cartItems.push({ name: productName, price: price });
            updateCartUI();
            if(document.getElementById('cart-sidebar').classList.contains('translate-x-full')) {
                toggleCart();
            }
        }

        // Filter Functions - FIXED VERSION
        document.addEventListener('DOMContentLoaded', function() {
            initFilter();
            populateCategories();
        });

        function initFilter() {
            const filterBtn = document.getElementById('filter-btn');
            const filterDropdown = document.getElementById('filter-dropdown');
            const filterChevron = document.getElementById('filter-chevron');
            
            if (!filterBtn || !filterDropdown || !filterChevron) return;
            
            filterBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                filterDropdown.classList.toggle('hidden');
                filterChevron.style.transform = filterDropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            });

            document.addEventListener('click', function(e) {
                if (!filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
                    filterDropdown.classList.add('hidden');
                    filterChevron.style.transform = 'rotate(0deg)';
                }
            });

            const viewAllBtn = document.getElementById('view-all-btn');
            if (viewAllBtn) {
                viewAllBtn.addEventListener('click', function() {
                    filterProducts('all');
                    filterDropdown.classList.add('hidden');
                    filterChevron.style.transform = 'rotate(0deg)';
                    
                    document.querySelectorAll('#category-list button').forEach(btn => {
                        btn.classList.remove('bg-blue-600', 'text-white');
                        btn.classList.add('text-gray-400');
                    });
                    
                    const allBtn = Array.from(document.querySelectorAll('#category-list button')).find(btn => btn.getAttribute('data-category-filter') === 'all');
                    if (allBtn) {
                        allBtn.classList.remove('text-gray-400');
                        allBtn.classList.add('bg-blue-600', 'text-white');
                    }
                });
            }
        }

        function populateCategories() {
            const productGrid = document.getElementById('product-grid');
            if (!productGrid) return;
            
            const products = productGrid.querySelectorAll('.product-card');
            const categories = new Set();
            
            products.forEach(product => {
                const category = product.dataset.category;
                if (category) categories.add(category);
            });

            if (categories.size === 0) {
                ['tech', 'fashion', 'premium'].forEach(cat => categories.add(cat));
            }

            const categoryList = document.getElementById('category-list');
            if (!categoryList) return;
            
            categoryList.innerHTML = '';

            const allBtn = createCategoryButton('all', 'All Products', true);
            categoryList.appendChild(allBtn);

            categories.forEach(category => {
                const btn = createCategoryButton(category, category.charAt(0).toUpperCase() + category.slice(1));
                categoryList.appendChild(btn);
            });
        }

        function createCategoryButton(category, label, isActive = false) {
            const btn = document.createElement('button');
            btn.className = `w-full text-left px-3 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all ${isActive ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5'}`;
            btn.setAttribute('data-category-filter', category);
            btn.textContent = label;
            
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                filterProducts(category);
                
                document.querySelectorAll('#category-list button').forEach(b => {
                    b.classList.remove('bg-blue-600', 'text-white');
                    b.classList.add('text-gray-400');
                });
                this.classList.remove('text-gray-400');
                this.classList.add('bg-blue-600', 'text-white');
                
                document.getElementById('filter-dropdown').classList.add('hidden');
                document.getElementById('filter-chevron').style.transform = 'rotate(0deg)';
            });
            
            return btn;
        }

        function filterProducts(category) {
            const productGrid = document.getElementById('product-grid');
            const products = productGrid.querySelectorAll('.product-card');
            
            products.forEach(product => {
                if (category === 'all') {
                    product.style.display = 'block';
                    setTimeout(() => {
                        product.style.opacity = '1';
                        product.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    const productCategory = product.dataset.category?.toLowerCase() || '';
                    if (productCategory === category.toLowerCase()) {
                        product.style.display = 'block';
                        setTimeout(() => {
                            product.style.opacity = '1';
                            product.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        product.style.opacity = '0';
                        product.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            product.style.display = 'none';
                        }, 300);
                    }
                }
            });

            showFilterToast(category);
        }

        function showFilterToast(category) {
            const toastContainer = document.getElementById('toast-container');
            if (!toastContainer) return;
            
            const toast = document.createElement('div');
            toast.className = 'glass-card px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-blue-600 border border-blue-600/20 shadow-2xl toast-active';
            toast.textContent = category === 'all' ? 'Showing all products' : `Filtering: ${category}`;
            
            toastContainer.innerHTML = '';
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 400);
            }, 2000);
        }

        // Scroll Progress
        window.addEventListener('scroll', () => {
            const h = document.documentElement;
            const percent = (h.scrollTop) / (h.scrollHeight - h.clientHeight) * 100;
            document.getElementById('progress-bar').style.transform = `scaleX(${percent/100})`;
        });

        // Dark Mode
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            // Implement mobile menu functionality if needed
            alert('Mobile menu coming soon');
        }
    </script>
</body>
</html>