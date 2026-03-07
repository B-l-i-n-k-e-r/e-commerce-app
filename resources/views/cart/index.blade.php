@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 container mx-auto py-12 px-4 sm:px-6 lg:px-8 min-h-screen">
        {{-- Header Section with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg animate-float">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            {{ __('Your Shopping') }} <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400">{{ __('Cart') }}</span>
                        </h1>
                    </div>
                </div>
                @if(!empty($cart))
                <div class="glass-card rounded-xl px-4 py-2 border light:border-gray-200 dark:border-white/5">
                    <span class="text-[10px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                        {{ count($cart) }} {{ count($cart) === 1 ? 'Item' : 'Items' }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        @if (empty($cart))
            <div class="glass-card rounded-[2.5rem] p-16 text-center border light:border-gray-200 dark:border-white/5">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-6">
                        <span class="text-6xl">🛒</span>
                    </div>
                    <h3 class="text-2xl font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">{{ __('Your cart is empty') }}</h3>
                    <p class="text-sm font-medium light:text-gray-500 dark:text-gray-400 mb-8">{{ __('Looks like you haven\'t added any products to your cart yet.') }}</p>
                    <a href="{{ route('products.index') }}" class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('Start Shopping') }}
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Cart Items Table --}}
                <div class="lg:col-span-2">
                    <div class="glass-card rounded-[2.5rem] overflow-hidden border light:border-gray-200 dark:border-white/5">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-white/5 light:border-gray-200">
                                        <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">{{ __('Product') }}</th>
                                        <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">{{ __('Price') }}</th>
                                        <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap text-center">{{ __('Quantity') }}</th>
                                        <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap text-right">{{ __('Subtotal') }}</th>
                                        <th class="px-6 py-5 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5 light:divide-gray-100">
                                    @foreach ($cart as $id => $item)
                                        <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-4">
                                                    <div class="h-16 w-16 flex-shrink-0 rounded-xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 border border-white/10 light:border-gray-200 shadow-lg">
                                                        <img src="{{ !empty($item['image_url']) ? asset($item['image_url']) : asset('images/no-image-placeholder.jpg') }}" 
                                                             class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-black light:text-gray-900 dark:text-white uppercase tracking-tight">{{ $item['name'] }}</div>
                                                        <div class="text-[9px] font-medium light:text-gray-400 dark:text-gray-500 font-mono mt-1">{{ $item['product_code'] ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">
                                                    Ksh {{ number_format($item['price'], 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center justify-center gap-2">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                                           class="quantity-input w-16 portal-input p-2 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 text-center" 
                                                           data-id="{{ $id }}">
                                                    <button type="button" class="update-button p-2 glass-card border light:border-gray-200 dark:border-white/5 light:text-gray-600 dark:text-gray-400 hover:text-purple-600 hover:bg-purple-500/10 rounded-xl transition-all" data-id="{{ $id }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="updating-message text-[8px] font-black text-center light:text-purple-600 dark:text-purple-400 mt-1" style="display:none;">Updating...</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="subtotal text-sm font-black light:text-gray-900 dark:text-white">
                                                    Ksh {{ number_format($item['quantity'] * $item['price'], 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="removeFromLocalStorage('{{ $id }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 light:text-gray-400 dark:text-gray-500 hover:text-red-600 hover:bg-red-500/10 light:hover:bg-red-50 rounded-xl transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Order Summary Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="glass-card rounded-[2rem] p-8 border light:border-gray-200 dark:border-white/5 sticky top-8">
                        <h3 class="text-xl font-black light:text-gray-900 dark:text-white uppercase tracking-tight mb-6 border-b border-white/5 light:border-gray-200 pb-4">
                            {{ __('Order Summary') }}
                        </h3>
                        
                        <div class="space-y-4 mb-6">
                            @php
                                $total = array_reduce($cart, function($carry, $item) {
                                    return $carry + ($item['quantity'] * $item['price']);
                                }, 0);
                            @endphp
                            
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">Subtotal</span>
                                <span class="text-sm font-black light:text-gray-900 dark:text-white">Ksh {{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">Shipping</span>
                                <span class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">FREE</span>
                            </div>
                            
                            <div class="pt-6 border-t border-white/5 light:border-gray-200 flex justify-between items-end">
                                <span class="text-sm font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total</span>
                                <span id="cart-total" class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
                                    Ksh {{ number_format($total, 2) }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.view') }}" 
                           class="group w-full flex items-center justify-center gap-3 py-5 px-6 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ __('PROCEED TO CHECKOUT') }}
                        </a>
                        
                        <a href="{{ route('products.index') }}" 
                           class="group flex items-center justify-center gap-2 text-[9px] font-black uppercase tracking-widest light:text-gray-500 dark:text-gray-400 hover:text-purple-600 transition-colors">
                            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ __('Continue Shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    /* Base page background */
    .page-bg { min-height: 100vh; width: 100%; }
    .light .page-bg { background-color: #f8fafc; }
    .dark .page-bg { background-color: #030712; }

    /* Glassmorphism Logic */
    .light .glass-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); }
    .dark .glass-card { background: rgba(11, 17, 32, 0.9); backdrop-filter: blur(20px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4); }

    /* Portal Input Styles */
    .portal-input { border-radius: 0.75rem; transition: all 0.3s ease; }
    .light .portal-input { background: #ffffff; border: 1px solid #e2e8f0; color: #0f172a; }
    .dark .portal-input { background: #0f172a; border: 1px solid #1e293b; color: #ffffff; }

    @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-5px); } 100% { transform: translateY(0px); } }
    .animate-float { animation: float 6s ease-in-out infinite; }
</style>
@endsection

@push('scripts')
<script>
    /**
     * Reusable function to sync local storage with actual server state.
     * Use the 'cart.count' route we defined in ProductController.
     */
    function syncCartWithServer() {
        fetch("{{ route('cart.count') }}")
            .then(res => res.json())
            .then(data => {
                // Update local storage with actual item IDs from the session
                localStorage.setItem('bokince_cart', JSON.stringify(data.ids || []));
                // Dispatch event to update the layout badge instantly
                window.dispatchEvent(new Event('storage'));
            })
            .catch(err => console.error('Bokince Protocol Sync Error:', err));
    }

    // Runs before the page navigates away for a standard DELETE request
    function removeFromLocalStorage(itemId) {
        let cart = JSON.parse(localStorage.getItem('bokince_cart')) || [];
        const updatedCart = cart.filter(id => String(id) !== String(itemId));
        localStorage.setItem('bokince_cart', JSON.stringify(updatedCart));
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Run sync on load to clean up "ghost" items
        syncCartWithServer();

        const updateButtons = document.querySelectorAll('.update-button');
        
        updateButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.dataset.id;
                const row = this.closest('tr');
                const quantityInput = row.querySelector('.quantity-input');
                const newQuantity = quantityInput.value;
                const updatingMessageSpan = row.querySelector('.updating-message');

                updatingMessageSpan.style.display = 'block';
                this.disabled = true;

                fetch(`/cart/update-quantity/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ quantity: newQuantity })
                })
                .then(response => response.json())
                .then(data => {
                    updatingMessageSpan.style.display = 'none';
                    if (data.success) {
                        // 1. Update Subtotal
                        const subtotalElement = row.querySelector('.subtotal');
                        subtotalElement.textContent = `Ksh ${parseFloat(data.subtotal).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
                        
                        // 2. Update Total Summary
                        const cartTotalElement = document.getElementById('cart-total');
                        if (cartTotalElement) {
                            cartTotalElement.textContent = `Ksh ${parseFloat(data.total).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
                        }

                        // 3. Re-sync badge state from server
                        syncCartWithServer();
                    }
                })
                .catch(error => {
                    updatingMessageSpan.style.display = 'none';
                    console.error('Bokince Update Protocol Error:', error);
                })
                .finally(() => {
                    this.disabled = false;
                });
            });
        });
    });
</script>
@endpush