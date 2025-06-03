<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    
<nav x-data="navComponent()" class="bg-gray-500 dark:bg-gray-800 border-b border-blue-300 dark:border-gray-700 py-2" @keydown.escape="closeDropdowns">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <div class="flex">
        <div class="shrink-0 flex items-center">
          <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
          </a>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
          @if(Auth::check() && Auth::user()->is_admin)
            <!-- Admin links -->
            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Admin Dashboard</x-nav-link>
            <x-nav-link :href="route('admin.admin.product.listing')" :active="request()->routeIs('admin.admin.product.listing')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Manage Products</x-nav-link>
            <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Manage Orders</x-nav-link>
            <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Reports</x-nav-link>
          @else
            <!-- User links -->
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Dashboard</x-nav-link>
            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">🛍Products</x-nav-link>
            <x-nav-link :href="route('cart.view')" :active="request()->routeIs('cart.view')" class="relative text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">
              🛒Cart
              @if (session('cart') && count(session('cart')) > 0)
                @php $cartCount = collect(session('cart'))->sum('quantity'); @endphp
                <span class="absolute top-0 right-[-0.5rem] bg-red-500 text-white text-xs rounded-full px-1 py-0.5">{{ $cartCount }}</span>
              @endif
            </x-nav-link>
          @endif
        </div>
      </div>

      {{-- RIGHT SIDE --}}
      <div class="flex items-center relative">
        @if(Auth::check())
          {{-- Notification Bell --}}
          <div class="ms-4 relative" x-data="notificationDropdown()" @keydown.escape.stop="close()" @click.away="close()">
            <button @click="toggle()" aria-haspopup="true" :aria-expanded="open.toString()" aria-controls="notification-list" type="button" class="inline-flex items-center p-2 border border-transparent rounded-full text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-12 0v3.157c0 1.108-.806 2.057-1.904 2.95l-1.405 1.405M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-red-100 bg-red-600 rounded-full" style="display:none;"></span>
            </button>

            <div x-show="open" x-transition class="absolute right-0 z-50 mt-2 w-80 origin-top-right rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="notification-button" tabindex="-1" id="notification-list">
              <template x-if="notifications.length > 0">
                <template x-for="(notification, index) in notifications" :key="notification.id">
                  <a href="#" @click.prevent="markRead(notification.id, index)" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer" role="menuitem" tabindex="0" x-text="notification.data.message"></a>
                </template>
              </template>
              <template x-if="notifications.length === 0">
                <span class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">No new notifications</span>
              </template>
            </div>
          </div>
        @endif

        {{-- Profile Dropdown --}}
        <div @click="profileDropdownOpen = !profileDropdownOpen" class="inline-flex items-center px-3 py-2 border text-sm font-medium rounded-md text-gray-800 dark:text-gray-400 bg-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 cursor-pointer relative" x-data="{ profileDropdownOpen: false }" @keydown.escape.stop="profileDropdownOpen = false" @click.away="profileDropdownOpen = false">
          <img class="rounded-full h-8 w-8 object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
          <div class="ml-2">{{ optional(Auth::user())->name }}</div>
          <svg class="ms-1 fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>

          <div x-show="profileDropdownOpen" x-transition class="absolute right-0 mt-2 w-48 bg-gray-400 dark:bg-gray-700 border rounded shadow-md z-50" style="display: none;">
            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-400 dark:text-gray-400 dark:hover:bg-gray-600">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-400 dark:text-gray-400 dark:hover:bg-gray-600">Log Out</a>
            </form>
          </div>
        </div>
      </div>

      {{-- Hamburger --}}
      <div class="-me-2 flex items-center sm:hidden">
        <button @click="open = !open" :aria-expanded="open.toString()" aria-controls="responsive-menu" class="p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Responsive Nav --}}
  <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden pt-2 pb-3 space-y-1" id="responsive-menu">
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
    <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">Products</x-responsive-nav-link>
    <x-responsive-nav-link :href="route('cart.view')" :active="request()->routeIs('cart.view')">Cart</x-responsive-nav-link>
  </div>
</nav>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
  function navComponent() {
    return {
      open: false,
      profileDropdownOpen: false,
      closeDropdowns() {
        this.open = false;
        this.profileDropdownOpen = false;
      }
    }
  }

  function notificationDropdown() {
    return {
      open: false,
      notifications: [],
      unreadCount: 0,

      toggle() {
        this.open = !this.open;
        if (this.open) {
          this.fetchNotifications();
        }
      },

      close() {
        this.open = false;
      },

      fetchNotifications() {
        fetch('/notifications')
          .then(res => res.json())
          .then(data => {
            this.notifications = data;
            this.unreadCount = this.notifications.filter(n => !n.read_at).length;
          })
          .catch(() => {
            this.notifications = [];
            this.unreadCount = 0;
          });
      },

      markRead(id, index) {
        fetch(`/notifications/mark-as-read/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
          .then(res => {
            if (res.ok) {
              this.notifications.splice(index, 1);
              this.unreadCount = this.notifications.filter(n => !n.read_at).length;
            }
          });
      }
    }
  }
</script>
