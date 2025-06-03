{{-- resources/views/checkout/confirmation.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order Confirmation</h1>
        <div class="alert alert-success">
            Your order has been placed successfully!
        </div>

        <h2>Order Details</h2>
        <p>Order ID: {{ $order->id }}</p>
        <p>Shipping To: {{ $order->shipping_name }}, {{ $order->shipping_address }}</p>
        <p>Email: {{ $order->email }}</p>
        <p>Contact Number: {{ $order->contact_number }}</p>
        <p>Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
        <p>Payment Method: {{ $order->payment_method }}</p>
        <p>Order Status: {{ $order->status }}</p>

        <h3>Order Items:</h3>
        <ul>
            @if ($order->items)
                @foreach ($order->items as $item)
                    <li>{{ $item->product->name }} x {{ $item->quantity }} - ${{ number_format($item->price, 2) }}</li>
                @endforeach
            @else
                <li>No items in this order.</li>
            @endif
        </ul>

        <p>Thank you for your order!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
@endsection