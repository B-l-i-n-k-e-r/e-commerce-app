<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
    <h1>Order Details</h1>

    @if ($order)
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Shipping Address:</strong><br>{{ nl2br($order->shipping_address) }}</p>
        <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Order Status:</strong> {{ $order->order_status }}</p>

        <h2>Items in Your Order</h2>
        @if ($order->items->count() > 0)
            <ul>
                @foreach ($order->items as $item)
                    <li>
                        {{ $item->product->name ?? 'Product Not Found' }} (Quantity: {{ $item->quantity }}) - ${{ number_format($item->price, 2) }} each
                    </li>
                @endforeach
            </ul>
        @else
            <p>No items in this order.</p>
        @endif

        <p><a href="{{ route('products.index') }}">Continue Shopping</a></p>
    @else
        <p>Order not found.</p>
    @endif
</body>
</html>