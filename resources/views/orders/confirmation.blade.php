@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-gray-500 rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-green-700 mb-4">Order Confirmation</h1>
        <p class="text-gray-900 mb-4">Thank you for your order! Your order has been received and is being processed.</p>

        <div class="mb-4">
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Total Amount:</strong> KES {{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>

        @if($order->items && count($order->items))
            <h2 class="text-lg font-semibold mb-2">Items:</h2>
            <ul class="list-disc list-inside text-white">
                @foreach($order->items as $item)
                    <li>{{ $item->product->name }} (x{{ $item->quantity }}) - KES {{ number_format($item->price * $item->quantity, 2) }}</li>
                @endforeach
            </ul>
        @endif

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
