@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-10 flex items-center gap-3">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04 Pel.056 6.108 0 00.5 8.42 12.07 12.07 0 0010.118 6.53 12.07 12.07 0 0010.118-6.53 12.07 12.07 0 00.5-8.42z"/></svg>
            {{ __('Secure Checkout') }}
        </h1>

        @if (empty($cart))
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-xl border border-gray-100 dark:border-gray-700">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Your cart is empty!</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-8">You need items in your cart to proceed with checkout.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl transition-all">
                    {{ __('Back to Shop') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                {{-- Shipping Form (Left Side) --}}
                <div class="lg:col-span-7">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-8 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="bg-blue-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs">1</span>
                                {{ __('Shipping Information') }}
                            </h2>
                        </div>
                        
                        <form method="POST" action="{{ route('checkout.createOrder') }}" class="p-8 space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                           class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                           class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Delivery Address</label>
                                <textarea id="address" name="address" rows="3" required placeholder="Apartment, Street, City..."
                                          class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">{{ old('address') }}</textarea>
                                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="contact" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                    <input type="text" id="contact" name="contact" value="{{ old('contact') }}" required placeholder="0712 345 678"
                                           class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                    @error('contact') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="payment_method" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Payment Choice</label>
                                    <select id="payment_method" name="payment_method" required
                                            class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 p-3">
                                        <option value="">-- Choose --</option>
                                        <option value="mpesa">M-PESA</option>
                                        <option value="card">Credit/Debit Card</option>
                                        <option value="cod">Cash on Delivery</option>
                                    </select>
                                    @error('payment_method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t dark:border-gray-700">
                                <a href="{{ route('cart.view') }}" class="text-sm font-bold text-gray-500 hover:text-gray-800 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    Return to Cart
                                </a>
                                <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-xl shadow-lg transition-transform active:scale-95">
                                    COMPLETE PURCHASE
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Order Summary (Right Side) --}}
                <div class="lg:col-span-5">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-8">
                        <div class="p-8 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="bg-gray-900 dark:bg-white dark:text-gray-900 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs">2</span>
                                {{ __('Order Summary') }}
                            </h2>
                        </div>
                        
                        <div class="p-8">
                            <div class="overflow-x-auto">
                                <table class="min-w-max w-full mb-6">
                                    <thead>
                                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest border-b dark:border-gray-700">
                                            <th class="pb-3 px-2">Item</th>
                                            <th class="pb-3 px-2 text-center">Qty</th>
                                            <th class="pb-3 px-2 text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                                        @foreach ($cart as $id => $item)
                                            <tr>
                                                <td class="py-4 px-2 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <div class="h-10 w-10 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                                                            <img src="{{ !empty($item['image_url']) ? asset($item['image_url']) : asset('images/no-image-placeholder.jpg') }}" class="object-cover h-full w-full">
                                                        </div>
                                                        <span class="font-bold text-sm text-gray-900 dark:text-white">{{ Str::limit($item['name'], 20) }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-2 text-center text-sm font-medium text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                                    x{{ $item['quantity'] }}
                                                </td>
                                                <td class="py-4 px-2 text-right text-sm font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                                    Ksh {{ number_format($item['quantity'] * $item['price'], 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="space-y-4 pt-6 border-t dark:border-gray-700">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Subtotal</span>
                                    <span class="font-bold">Ksh {{ number_format($totalAmount, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Shipping</span>
                                    <span class="text-green-500 font-bold">Calculated at next step</span>
                                </div>
                                <div class="flex justify-between items-end pt-4">
                                    <span class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tighter">Total Due</span>
                                    <span class="text-3xl font-black text-blue-600 dark:text-blue-400">Ksh {{ number_format($totalAmount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 text-xs text-center border-t dark:border-gray-700">
                            🔒 256-bit SSL Encrypted Security
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection