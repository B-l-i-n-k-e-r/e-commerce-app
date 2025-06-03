@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-blue-500 mb-4">Your Shopping Cart</h2>

        @if (empty($cart))
            <p class="text-gray-400">Your cart is empty.</p>
            <p><a href="{{ route('products.index') }}" class="text-blue-500 hover:text-blue-600 transition-colors duration-200">Continue Shopping</a></p>
        @else
            <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-md text-gray-400">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900">
                        <tr class="cart-header">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Product Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-500 divide-y divide-gray-900">
                        @foreach ($cart as $id => $item)
                            <tr class="cart-item">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if (!empty($item['image_url']))
                                            <div class="h-10 w-10 flex-shrink-0 mr-2">
                                                <img src="{{ asset($item['image_url']) }}" class="h-full w-full object-cover rounded">
                                            </div>
                                        @endif
                                        <span class="product-name">{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $item['product_code'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-300">${{ number_format($item['price'], 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input w-16 rounded-md bg-gray-900 border-gray-700 text-yellow-700" data-id="{{ $id }}">
                                        <button type="button" class="update-button ml-2 px-3 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold" data-id="{{ $id }}">Update</button>
                                        <span class="updating-message ml-2 text-xs text-gray-500" style="display:none;">Updating...</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap subtotal text-gray-300">${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="remove-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-button text-red-500 hover:text-red-600 font-semibold">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php
                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['quantity'] * $item['price'];
                }
            @endphp

            <p class="mt-4 text-xl font-semibold text-gray-300">Total: <span id="cart-total" class="text-green-500">${{ number_format($total, 2) }}</span></p>
            <div><p class="mt-2"><a href="{{ route('checkout.view') }}" class="inline-block px-4 py-2 rounded-md bg-green-600 hover:bg-green-700 text-white font-semibold">Proceed to Checkout</a></p></div>
            <div>
             <p class="text-sm">
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-gray-800 transition-colors duration-200">
            <svg class="w-4 h-4 inline-block mr-1 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>Continue Shopping</a></p>
             </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInputs = document.querySelectorAll('.quantity-input');

        quantityInputs.forEach(input => {
            input.addEventListener('input', function () {
                const value = this.value;
                const updateButton = this.nextElementSibling;

                if (!/^[1-9][0-9]*$/.test(value)) {
                    this.classList.add('is-invalid');
                    updateButton.disabled = true;
                } else {
                    this.classList.remove('is-invalid');
                    updateButton.disabled = false;
                }
            });
        });

        const updateButtons = document.querySelectorAll('.update-button');
        updateButtons.forEach(button => {
            button.addEventListener('click', function () {
                console.log('Update button clicked!');
                const itemId = this.dataset.id;
                const quantityInput = this.previousElementSibling;
                const newQuantity = quantityInput.value;
                const updatingMessageSpan = this.nextElementSibling;

                updatingMessageSpan.style.display = 'inline';

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
                        subtotalElement.textContent = `$${parseFloat(data.subtotal).toFixed(2)}`;

                        const totalElement = document.querySelector('#cart-total');
                        totalElement.textContent = `${parseFloat(data.total).toFixed(2)}`;

                        const successMsg = document.createElement('span');
                        successMsg.textContent = 'Updated!';
                        successMsg.style.color = 'green';
                        successMsg.style.marginLeft = '5px';
                        quantityInput.parentNode.appendChild(successMsg);
                        setTimeout(() => successMsg.remove(), 1500);
                    } else {
                        alert('Error updating cart.');
                    }
                })
                .catch(error => {
                    updatingMessageSpan.style.display = 'none';
                    console.error('Error:', error);
                    alert('Error updating cart.');
                });
            });
        });
    });
</script>
@endpush