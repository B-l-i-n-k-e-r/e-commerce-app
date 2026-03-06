<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<nav x-data="{ open: false, profileDropdownOpen: false }" 
     class="bg-white dark:bg-gray-950 border-b border-gray-100 dark:border-gray-800/50 sticky top-0 z-40" 
     @keydown.escape="open = false; profileDropdownOpen = false">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex items-center gap-10">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="transition-transform hover:scale-105">
                        <x-application-logo class="block h-10 w-auto fill-current text-blue-600" />
                    </a>
                </div>
                
                <div class="hidden space-x-1 sm:flex items-center">
                    @if(Auth::check() && Auth::user()->is_admin)
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">Users</x-nav-link>
                        <x-nav-link :href="route('admin.admin.product.listing')" :active="request()->routeIs('admin.admin.product.listing')">Inventory</x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">Orders</x-nav-link>
                        <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">Reports</x-nav-link>
                    
                    @elseif(Auth::check() && Auth::user()->is_manager)
                        <x-nav-link :href="route('manager.dashboard')" :active="request()->routeIs('manager.dashboard')" class="text-blue-600 font-bold">
                            <span class="mr-1">💼</span> Manager
                        </x-nav-link>
                        <x-nav-link :href="route('admin.admin.product.listing')" :active="request()->routeIs('admin.admin.product.listing')">Stock</x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">Orders</x-nav-link>
                        <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">Insights</x-nav-link>

                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Home</x-nav-link>
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">Market</x-nav-link>
                        <x-nav-link :href="route('cart.view')" :active="request()->routeIs('cart.view')" class="relative">
                            <span>Cart</span>
                            @if (session('cart') && count(session('cart')) > 0)
                                @php $cartCount = collect(session('cart'))->sum('quantity'); @endphp
                                <span class="absolute -top-1 -right-3 flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white ring-2 ring-white dark:ring-gray-950">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if(Auth::check())
                    <div class="relative" x-data="notificationDropdown()" @click.away="close()">
                        <button @click="toggle()" class="p-2.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all relative">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-12 0v3.157c0 1.108-.806 2.057-1.904 2.95l-1.405 1.405M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-show="unreadCount > 0" class="absolute top-2 right-2 flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute right-0 mt-3 w-80 origin-top-right rounded-3xl bg-white dark:bg-gray-900 shadow-2xl border border-gray-100 dark:border-gray-800 p-2 overflow-hidden" style="display:none;">
                            <div class="px-4 py-3 border-b border-gray-50 dark:border-gray-800">
                                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Activity</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <template x-if="notifications.length > 0">
                                    <template x-for="(n, i) in notifications" :key="n.id">
                                        <a href="#" @click.prevent="markRead(n.id, i)" class="block px-4 py-3 text-sm text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/10 rounded-2xl transition-colors mb-1" x-text="n.data.message"></a>
                                    </template>
                                </template>
                                <template x-if="notifications.length === 0">
                                    <div class="px-4 py-8 text-center text-gray-400 text-xs italic">All caught up!</div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="relative ms-2">
                        <button @click="profileDropdownOpen = !profileDropdownOpen" 
                                class="flex items-center gap-3 p-1.5 pr-4 rounded-2xl border border-transparent hover:border-gray-100 dark:hover:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 transition-all">
                            <img class="rounded-xl h-9 w-9 object-cover ring-2 ring-gray-100 dark:ring-gray-800" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            <div class="hidden md:flex flex-col items-start text-left">
                                <span class="text-sm font-bold text-gray-900 dark:text-white leading-none">{{ Auth::user()->name }}</span>
                                @if(Auth::user()->is_admin)
                                    <span class="text-[9px] uppercase font-black text-red-500 mt-1">System Admin</span>
                                @elseif(Auth::user()->is_manager)
                                    <span class="text-[9px] uppercase font-black text-blue-500 mt-1">Management</span>
                                @else
                                    <span class="text-[9px] uppercase font-black text-gray-400 mt-1">Customer</span>
                                @endif
                            </div>
                        </button>

                        <div x-show="profileDropdownOpen" 
                             @click.away="profileDropdownOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl shadow-2xl p-2 z-50" 
                             style="display: none;">
                            <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-2xl transition-colors">Settings</a>
                            <hr class="my-1 border-gray-50 dark:border-gray-800">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-2xl transition-colors font-bold">Log Out</button>
                            </form>
                        </div>
                    </div>
                @endif

                <div class="sm:hidden ms-2">
                    <button @click="open = !open" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="open" x-transition class="sm:hidden border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-950 px-4 py-6 space-y-2">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">Market</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('cart.view')" :active="request()->routeIs('cart.view')">Cart</x-responsive-nav-link>
    </div>
</nav>