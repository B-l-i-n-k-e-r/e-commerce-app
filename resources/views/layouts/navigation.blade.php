<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">

<nav x-data="{ 
    open: false, 
    profileDropdownOpen: false, 
    notificationsOpen: false,
    unreadCount: {{ auth()->user()->unreadNotifications->count() ?? 0 }},
    notifications: {{ json_encode(auth()->user()->unreadNotifications->take(5)->map(function($n) {
        return ['id' => $n->id, 'data' => $n->data];
    })) ?? '[]' }},
    
    toggleNotifications() {
        this.notificationsOpen = !this.notificationsOpen;
        if(this.notificationsOpen) {
            this.profileDropdownOpen = false;
            this.fetchNotifications();
        }
    },
    
    closeNotifications() {
        this.notificationsOpen = false;
    },
    
    fetchNotifications() {
        console.log('Fetching notifications...');
    },
    
    markRead(id, index) {
        fetch(`/notifications/${id}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                this.notifications.splice(index, 1);
                this.unreadCount = this.notifications.length;
            }
        });
    }
}" 
     class="fixed top-0 w-full z-50 px-4 sm:px-6 py-4 transition-all duration-500" 
     :class="{ 'bg-white/95 dark:bg-gray-950/95 backdrop-blur-xl shadow-lg': window.scrollY > 50, 'bg-transparent': window.scrollY <= 50 }"
     @keydown.escape="open = false; profileDropdownOpen = false; notificationsOpen = false"
     x-init="window.addEventListener('scroll', () => { $el.classList.toggle('shadow-lg', window.scrollY > 50) })">
    
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between glass-card-nav py-3 px-6 rounded-2xl shadow-2xl border border-white/10 dark:border-white/5 light:border-gray-300">
            
            {{-- Logo Section --}}
            <div class="flex items-center gap-3 group cursor-pointer">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl rotate-12 group-hover:rotate-0 transition-all duration-500 flex items-center justify-center shadow-lg shadow-blue-600/40">
                        <span class="text-white font-black text-sm -rotate-12 group-hover:rotate-0 transition-transform">B</span>
                    </div>
                    <span class="text-base font-black uppercase tracking-[0.3em] light:text-gray-900 dark:text-white">
                        Bokince<span class="text-blue-600 italic">X</span>
                    </span>
                </a>
            </div>

            {{-- Navigation Links --}}
            <div class="hidden md:flex items-center gap-2">
                @if(Auth::check() && Auth::user()->is_admin)
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Dashboard</x-nav-link>
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Users</x-nav-link>
                    <x-nav-link :href="route('admin.admin.product.listing')" :active="request()->routeIs('admin.admin.product.listing')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Inventory</x-nav-link>
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Categories</x-nav-link>
                    <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Orders</x-nav-link>
                    <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Reports</x-nav-link>
                
                @elseif(Auth::check() && Auth::user()->is_manager)
                    <x-nav-link :href="route('manager.dashboard')" :active="request()->routeIs('manager.dashboard')" class="text-[10px] font-black uppercase tracking-widest light:text-blue-700 dark:text-blue-400">
                        <span class="mr-1 text-sm">💼</span> Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('admin.admin.product.listing')" :active="request()->routeIs('admin.admin.product.listing')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Stock</x-nav-link>
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Categories</x-nav-link>
                    <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Orders</x-nav-link>
                    <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Reports</x-nav-link>

                @else
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Home</x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600">Products</x-nav-link>
                    <x-nav-link :href="route('cart.view')" :active="request()->routeIs('cart.view')" class="text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:text-blue-600 relative group">
                        Cart
                        @php $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0; @endphp
                        <span class="cart-count-badge absolute -top-2 -right-4 flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-purple-600 text-[8px] font-black text-white shadow-lg shadow-blue-600/30 {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                    </x-nav-link>
                @endif
            </div>

            {{-- Right Side Actions --}}
            <div class="flex items-center gap-3">
                @if(Auth::check())
                    {{-- Notifications Dropdown --}}
                    <div class="relative">
                        <button @click="toggleNotifications" 
                                class="p-2.5 glass-card-nav rounded-xl hover:scale-105 transition-all duration-300 border border-white/10 dark:border-white/5 light:border-gray-300 relative group">
                            <svg class="h-5 w-5 light:text-gray-700 dark:text-gray-200 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-12 0v3.157c0 1.108-.806 2.057-1.904 2.95l-1.405 1.405M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-show="unreadCount > 0" class="absolute top-1 right-1 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                            </span>
                        </button>

                        {{-- Notifications Panel --}}
                        <div x-show="notificationsOpen" 
                             @click.away="closeNotifications"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-3 w-80 origin-top-right glass-card-dropdown rounded-2xl p-4 border border-white/15 dark:border-white/10 shadow-2xl z-50" 
                             style="display: none;">
                            <div class="flex items-center justify-between mb-3 px-2">
                                <h3 class="text-[8px] font-black uppercase tracking-[0.3em] light:text-gray-500 dark:text-gray-400">Activity Feed</h3>
                                <span class="text-[8px] font-black text-blue-600">Live</span>
                            </div>
                            <div class="max-h-64 overflow-y-auto custom-scroll">
                                <template x-if="notifications.length > 0">
                                    <div class="space-y-1">
                                        <template x-for="(n, i) in notifications" :key="n.id">
                                            <a href="#" @click.prevent="markRead(n.id, i)" class="block px-4 py-3 text-[10px] font-medium light:text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800/50 rounded-xl transition-colors" x-text="n.data.message"></a>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="notifications.length === 0">
                                    <div class="px-4 py-8 text-center">
                                        <p class="text-[10px] font-black uppercase tracking-widest light:text-gray-500 dark:text-gray-400">All caught up!</p>
                                        <p class="text-[8px] light:text-gray-400 dark:text-gray-500 mt-1">No new notifications</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Profile Dropdown --}}
                    <div class="relative">
                        <button @click="profileDropdownOpen = !profileDropdownOpen; if(profileDropdownOpen) notificationsOpen = false" 
                                class="flex items-center gap-3 p-1 pr-4 glass-card-nav rounded-xl hover:scale-105 transition-all duration-300 border border-white/10 dark:border-white/5 light:border-gray-300 group">
                            <img class="rounded-lg h-8 w-8 object-cover ring-2 ring-white/30" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            <div class="hidden md:flex flex-col items-start">
                                <span class="text-xs font-black light:text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                                @if(Auth::user()->is_admin)
                                    <span class="text-[7px] uppercase font-black text-red-600 dark:text-red-400">System Admin</span>
                                @elseif(Auth::user()->is_manager)
                                    <span class="text-[7px] uppercase font-black text-blue-600 dark:text-blue-400">Management</span>
                                @else
                                    <span class="text-[7px] uppercase font-black light:text-gray-500 dark:text-gray-400">Customer</span>
                                @endif
                            </div>
                            <svg class="w-3 h-3 light:text-gray-600 dark:text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- Profile Dropdown Menu --}}
                        <div x-show="profileDropdownOpen" 
                             @click.away="profileDropdownOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-3 w-56 glass-card-dropdown rounded-2xl p-2 border border-white/15 dark:border-white/10 shadow-2xl z-50" 
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-white/15 dark:border-white/10 light:border-gray-200">
                                <p class="text-[8px] font-black uppercase tracking-widest light:text-gray-500 dark:text-gray-400">Signed in as</p>
                                <p class="text-xs font-black light:text-gray-900 dark:text-white mt-1 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-3 text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800/50 rounded-xl transition-colors mt-1">
                                <svg class="w-4 h-4 mr-3 light:text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                            </a>

                            <hr class="my-1 border-white/15 dark:border-white/10 light:border-gray-200">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-3 text-[10px] font-black uppercase tracking-widest text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-xl transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- Mobile Menu Button --}}
                <button @click="open = !open" class="md:hidden p-2.5 glass-card-nav rounded-xl hover:scale-105 transition-all duration-300 border border-white/10 dark:border-white/5 light:border-gray-300">
                    <svg class="h-5 w-5 light:text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="md:hidden mt-4 glass-card-nav rounded-2xl p-4 border border-white/10 dark:border-white/5 light:border-gray-300">
        <div class="space-y-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block px-4 py-3 text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800/50 rounded-xl transition-colors">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="block px-4 py-3 text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800/50 rounded-xl transition-colors">Market</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.view')" :active="request()->routeIs('cart.view')" class="block px-4 py-3 text-[10px] font-black uppercase tracking-widest light:text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800/50 rounded-xl transition-colors relative">
                Cart
                <span class="cart-count-badge ml-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-purple-600 text-[8px] font-black text-white {{ $cartCount > 0 ? '' : 'hidden' }}">
                    {{ $cartCount }}
                </span>
            </x-responsive-nav-link>
        </div>
    </div>
</nav>

<style>
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-track { background: transparent; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .dark .custom-scroll::-webkit-scrollbar-thumb { background: #334155; }
    
    .glass-card-nav { backdrop-filter: blur(20px); }
    .light .glass-card-nav { background: rgba(255, 255, 255, 0.95); border: 1px solid rgba(0, 0, 0, 0.15); }
    .dark .glass-card-nav { background: rgba(17, 24, 39, 0.95); border: 1px solid rgba(255, 255, 255, 0.1); }
    
    .glass-card-dropdown { backdrop-filter: blur(20px); }
    .light .glass-card-dropdown { 
        background: rgba(255, 255, 255, 0.98); 
        border: 1px solid rgba(0, 0, 0, 0.2); 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); 
    }
    .dark .glass-card-dropdown { 
        background: rgba(17, 24, 39, 0.98); 
        border: 1px solid rgba(255, 255, 255, 0.15); 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5); 
    }
    
    body { padding-top: 80px; }
</style>