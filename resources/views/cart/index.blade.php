@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-gray-900 dark:text-white">{{ __('Your Shopping Cart') }}</h1>
            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                {{ count($cart) }} {{ count($cart) === 1 ? 'Item' : 'Items' }}
            </span>
        </div>

        @if (empty($cart))
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-sm border border-dashed border-gray-300 dark:border-gray-600">
                <div class="mb-4 text-6xl">🛒</div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Your cart is empty') }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('Looks like you haven\'t added any products to your cart yet.') }}</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all">
                    {{ __('Start Shopping') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Cart Items Table --}}
                <div class="lg:col-span-2">
                    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <table class="min-w-max w-full text-left border-collapse">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap">{{ __('Product') }}</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap">{{ __('Price') }}</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap text-center">{{ __('Quantity') }}</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider whitespace-nowrap text-right">{{ __('Subtotal') }}</th>
                                    <th class="px-6 py-4 whitespace-nowrap"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($cart as $id => $item)
                                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="h-16 w-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 dark:border-gray-600">
                                                    <img src="{{ !empty($item['image_url']) ? asset($item['image_url']) : asset('images/no-image-placeholder.jpg') }}" class="h-full w-full object-cover">
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900 dark:text-white">{{ $item['name'] }}</div>
                                                    <div class="text-xs text-gray-400 font-mono">{{ $item['product_code'] ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-600 dark:text-gray-300">
                                            Ksh {{ number_format($item['price'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-2">
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                                       class="quantity-input w-16 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500" 
                                                       data-id="{{ $id }}">
                                                <button type="button" class="update-button p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" data-id="{{ $id }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                </button>
                                            </div>
                                            <div class="updating-message text-[10px] text-center text-blue-500 font-bold mt-1" style="display:none;">Updating...</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-black text-gray-900 dark:text-white subtotal">
                                            Ksh {{ number_format($item['quantity'] * $item['price'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Order Summary Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 sticky top-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-700">{{ __('Order Summary') }}</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Subtotal</span>
                                @php
                                    $total = array_reduce($cart, function($carry, $item) {
                                        return $carry + ($item['quantity'] * $item['price']);
                                    }, 0);
                                @endphp
                                <span class="font-bold text-gray-900 dark:text-white">Ksh {{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Shipping</span>
                                <span class="text-green-500 font-bold">FREE</span>
                            </div>
                            <div class="pt-4 border-t dark:border-gray-700 flex justify-between items-end">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                <span id="cart-total" class="text-3xl font-black text-blue-600 dark:text-blue-400">Ksh {{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.view') }}" class="block w-full text-center py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-200 dark:shadow-none transition-all duration-200 mb-4">
                            {{ __('PROCEED TO CHECKOUT') }}
                        </a>
                        
                        <a href="{{ route('products.index') }}" class="flex items-center justify-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            {{ __('Continue Shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateButtons = document.querySelectorAll('.update-button');
        updateButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.dataset.id;
                const quantityInput = this.previousElementSibling;
                const newQuantity = quantityInput.value;
                const updatingMessageSpan = this.parentElement.nextElementSibling;

                updatingMessageSpan.style.display = 'block';

                fetch(`/cart/update-quantity/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: newQuantity })
                })
                .then(response => response.json())
                .then(data => {
                    updatingMessageSpan.style.display = 'none';
                    if (data.success) {
                        const subtotalElement = this.closest('tr').querySelector('.subtotal');
                        subtotalElement.textContent = `Ksh ${parseFloat(data.subtotal).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
                        
                        document.querySelectorAll('#cart-total').forEach(el => {
                            el.textContent = `Ksh ${parseFloat(data.total).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
                        });
                    }
                })
                .catch(error => {
                    updatingMessageSpan.style.display = 'none';
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endpush