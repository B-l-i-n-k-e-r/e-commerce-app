@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-4">{{ __('Order Details') }}</h1>

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <p>{{ __('Order Number:') }} <span class="font-semibold">{{ $order->order_number ?? $order->id }}</span></p>
            <p>{{ __('Order Date:') }} {{ $order->created_at->format('M d, Y h:i A') }}</p>
            <p>{{ __('Status:') }} <span class="{{ $order->status === 'shipped' ? 'text-green-400' : ($order->status === 'processing' ? 'text-yellow-400' : 'text-red-400') }}">{{ ucfirst($order->status) }}</span></p>

            {{-- Display other order details here --}}

            <h2 class="text-lg font-semibold mt-6 mb-2">{{ __('Order Items') }}</h2>
            {{-- Loop through order items if you loaded them --}}
            {{-- @if ($order->orderItems->isNotEmpty())
                <ul>
                    @foreach ($order->orderItems as $item)
                        <li>{{ $item->product->name }} - Quantity: {{ $item->quantity }} - Price: ${{ number_format($item->price, 2) }}</li>
                    @endforeach
                </ul>
            @else
                <p>{{ __('No items in this order.') }}</p>
            @endif --}}

            <div class="mt-6">
                <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">{{ __('Back to All Orders') }}</a>
            </div>
        </div>
    </div>
@endsection