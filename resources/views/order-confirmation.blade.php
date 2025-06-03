@extends('layouts.app')

@section('content')
    <h1>Order Confirmation</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p>Thank you for your purchase!</p>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>

    <h3>Order Items:</h3>
    <ul>
        @foreach ($order->items as $item)
            <li>{{ $item->product->name }} - {{ $item->quantity }} x ${{ $item->product->price }}</li>
        @endforeach
    </ul>

    <p><strong>Total Paid:</strong> ${{ $order->total_amount }}</p>
    <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</p>


    <a href="{{ route('products.index') }}">Continue Shopping</a>
@endsection

