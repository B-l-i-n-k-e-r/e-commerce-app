@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 bg-gray-100">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">Edit Order #{{ $order->id }}</h1>

        <div class="mb-4 bg-white shadow-md rounded-md p-4">
            <strong>User:</strong> <span class="text-blue-600">{{ $order->user->name ?? 'N/A' }}</span>
            @if($order->user)
                (<span class="text-blue-500">{{ $order->user->email }}</span>)
            @endif
        </div>

        <div class="mb-4 bg-white shadow-md rounded-md p-4">
            <strong>Shipping Address:</strong><br>
            <span class="text-gray-700">{{ $order->shipping_name }},</span><br>
            <span class="text-gray-700">{{ $order->shipping_address }}</span><br>
            Contact: <span class="text-gray-700">{{ $order->contact_number }}</span><br>
        </div>

        <div class="mb-4 bg-white shadow-md rounded-md p-4">
            <strong>Order Date:</strong> <span class="text-gray-700">{{ $order->created_at }}</span><br>
            <strong>Total Amount:</strong> <span class="text-green-600">${{ number_format($order->total_amount, 2) }}</span><br>
            <strong>Payment Method:</strong> <span class="text-gray-700">{{ $order->payment_method }}</span><br>
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="mb-4 bg-white shadow-md rounded-md p-4">
            @csrf
            @method('PUT') {{-- Or PATCH --}}

            <div class="mb-4">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Order Status:</label>
                <select name="status" id="status" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Update Status</button>
            <a href="{{ route('admin.orders.index') }}" class="inline-block ml-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Back to Orders</a>
        </form>

        <h2 class="mt-6 mb-4 text-gray-800">Order Items</h2>
        @if($order->items->isNotEmpty())
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border border-gray-300 text-left">Product Name</th>
                        <th class="px-4 py-2 border border-gray-300 text-left">Quantity</th>
                        <th class="px-4 py-2 border border-gray-300 text-left">Price</th>
                        <th class="px-4 py-2 border border-gray-300 text-left">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->product->name ?? 'Product Not Found' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->quantity }}</td>
                            <td class="border border-gray-300 px-4 py-2">${{ number_format($item->price, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2">${{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-700">No items in this order.</p>
        @endif
    </div>
@endsection