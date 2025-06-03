@extends('layouts.app')

@section('content')
    <div class="flex justify-center py-8">
        <div class="w-full max-w-6xl px-4">
            <h1 class="text-2xl font-semibold mb-6 text-center">{{ __('My Orders') }}</h1>

            {{-- Search Form --}}
            <form method="GET" action="{{ route('orders.index') }}" class="mb-6">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search orders by number or status..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                >
            </form>

            @if ($orders->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4">
                            <p>{{ __('Order Number:') }} <span class="font-semibold">{{ $order->order_number ?? $order->id }}</span></p>
                            <p>{{ __('Order Date:') }} {{ $order->created_at->format('M d, Y') }}</p>
                            <p>
                                {{ __('Status:') }}
                                <span class="{{ $order->status === 'shipped' ? 'text-green-400' : ($order->status === 'processing' ? 'text-yellow-400' : 'text-red-400') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <a href="{{ route('order.show', $order->id) }}" class="text-blue-500 hover:underline text-sm">
                                {{ __('View Details') }}
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->appends(['search' => request('search')])->links() }}
                </div>
            @else
                <p class="text-center">{{ __('No Order found !!.') }}</p>
            @endif
        </div>
    </div>
@endsection
