@extends('layouts.app')

@section('content')
<div class="max-w-full mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-semibold text-gray-900 mb-6">Sales Reports</h1>

    <div class="mb-8 bg-white rounded-md shadow-md p-4">
        <strong class="text-lg font-medium">Total Sales:</strong>
        <span class="text-green-600">${{ number_format($totalSales, 2) }}</span>
    </div>

    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Order Details</h2>

    @if($orders->isNotEmpty())
        <div class="bg-white rounded-md shadow-md overflow-x-auto">
            <table class="w-full table-auto divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipping Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products Ordered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $order->user->name ?? 'N/A' }}
                                <br>
                                <span class="text-blue-500 text-sm">{{ $order->user->email ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($order->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">M-Pesa</td>
                            <td class="px-6 py-4">
                                {{ $order->shipping_name }}<br>{{ $order->shipping_address }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->contact_number }}</td>
                            <td class="px-6 py-4">
                                @if($order->items->isNotEmpty())
                                    @if($order->items->count() > 3)
                                        @foreach($order->items->take(3) as $item)
                                            <div class="bg-gray-100 p-2 rounded text-sm mb-1">{{ $item->product->name ?? 'Product Not Found' }}</div>
                                        @endforeach
                                        <button type="button" class="text-blue-500 text-sm show-more-products" data-order-id="{{ $order->id }}">
                                            Show {{ $order->items->count() - 3 }} more
                                        </button>
                                        <button type="button" class="text-blue-500 text-sm show-less-products hidden" data-order-id="{{ $order->id }}">
                                            Show less
                                        </button>
                                        <div id="full-products-{{ $order->id }}" class="hidden mt-2">
                                            @foreach($order->items->skip(3) as $item)
                                                <div class="bg-gray-100 p-2 rounded text-sm mb-1">{{ $item->product->name ?? 'Product Not Found' }}</div>
                                            @endforeach
                                        </div>
                                    @else
                                        @foreach($order->items as $item)
                                            <div class="bg-gray-100 p-2 rounded text-sm mb-1">{{ $item->product->name ?? 'Product Not Found' }}</div>
                                        @endforeach
                                    @endif
                                @else
                                    <span class="text-gray-500">No items in this order.</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                @if($order->items->isNotEmpty())
                                    {{ $order->items->sum('quantity') }}
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No orders found.</p>
    @endif

    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Orders per Product (Summary)</h2>
    <ul class="list-disc list-inside">
        @foreach($productOrderCounts as $productName => $orderCount)
            <li>
                <span class="font-medium">{{ $productName }}</span> -
                <span class="text-blue-600">{{ $orderCount }}</span> orders
            </li>
        @endforeach
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showMoreButtons = document.querySelectorAll('.show-more-products');
        const showLessButtons = document.querySelectorAll('.show-less-products');

        showMoreButtons.forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.dataset.orderId;
                const fullProductsDiv = document.getElementById(`full-products-${orderId}`);
                fullProductsDiv.classList.toggle('hidden');
                this.classList.add('hidden'); // Hide "Show More" button
                const showLessButton = document.querySelector(`.show-less-products[data-order-id="${orderId}"]`);
                showLessButton.classList.remove('hidden');
            });
        });

        showLessButtons.forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.dataset.orderId;
                const fullProductsDiv = document.getElementById(`full-products-${orderId}`);
                fullProductsDiv.classList.toggle('hidden');
                this.classList.add('hidden');  // Hide "Show Less" button
                const showMoreButton = document.querySelector(`.show-more-products[data-order-id="${orderId}"]`);
                showMoreButton.classList.remove('hidden'); // Show "Show More" button
            });
        });
    });
</script>
@endsection
