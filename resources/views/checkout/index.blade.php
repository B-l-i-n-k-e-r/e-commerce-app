@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-semibold text-blue-400 mb-6 text-center">Checkout</h1>

    @if (empty($cart))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Empty Cart!</strong>
            <span class="block sm:inline">Your cart is empty. Please add items to checkout.</span>
        </div>
        <p class="mb-4">
            <a href="{{ route('products.index') }}" class="text-blue-400 hover:text-blue-500 transition-colors duration-200">
                Continue Shopping
            </a>
        </p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Order Summary Section --}}
            <div class="bg-gray-700 rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-blue-400 mb-4">Order Summary</h2>
                <ul class="space-y-3">
                    @foreach ($cart as $id => $item)
                        <li class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if (!empty($item['image_url']))
                                    <div class="h-12 w-12 flex-shrink-0 mr-2">
                                        <img src="{{ asset($item['image_url']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover rounded">
                                    </div>
                                @endif
                                <div>
                                    <span class="font-semibold text-gray-300">{{ $item['name'] }}</span>
                                    <span class="text-gray-400 text-sm"> x {{ $item['quantity'] }}</span>
                                </div>
                            </div>
                            <span class="text-gray-300">${{ number_format($item['quantity'] * $item['price'], 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-6 pt-4 border-t border-gray-600 flex justify-between items-center">
                    <span class="text-xl font-semibold text-gray-300">Total:</span>
                    <span class="text-2xl font-bold text-green-400">${{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>

            {{-- Shipping Form --}}
            <div class="bg-gray-700 rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-blue-400 mb-4">Shipping Information</h2>
                <form method="POST" action="{{ route('checkout.createOrder') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Full Name</label>
                        <input type="text" id="name" name="name" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline bg-gray-800 border-gray-600">
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                        <input type="email" id="email" name="email" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline bg-gray-800 border-gray-600">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-gray-300 text-sm font-bold mb-2">Address</label>
                        <textarea id="address" name="address" required
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline bg-gray-800 border-gray-600"></textarea>
                        @error('address')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact" class="block text-gray-300 text-sm font-bold mb-2">Contact Number</label>
                        <input type="text" id="contact" name="contact" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline bg-gray-800 border-gray-600">
                        @error('contact')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_method" class="block text-gray-300 text-sm font-bold mb-2">Payment Method</label>
                        <select id="payment_method" name="payment_method" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:shadow-outline bg-gray-800 border-gray-600">
                            <option value="">-- Select Payment Method --</option>
                            <option value="mpesa">M-PESA</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="cod">Cash on Delivery</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Proceed to Payment
                    </button>
                    <a href="{{ route('cart.view') }}" class="inline-block text-blue-400 hover:text-blue-500 transition-colors duration-200 mt-2">
                        Back to Cart
                    </a>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
