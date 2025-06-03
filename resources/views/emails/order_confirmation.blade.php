@component('mail::message')
# Your Order Confirmation

Thank you for your recent order! We're excited to get it shipped to you.

**Order Details:**

Order ID: {{ $order->id }}
Name: {{ $order->name }}
Email: {{ $order->email }}

**Shipping Address:**

{{ $order->shipping_address }}

**Order Items:**

@component('mail::table')
| Product | Quantity | Price |
| ------- | -------- | ----- |
@foreach ($order->items as $item)
| {{ $item->product->name ?? 'Product Not Found' }} | {{ $item->quantity }} | ${{ number_format($item->price, 2) }} |
@endforeach
@endcomponent

**Total Amount: ${{ number_format($order->total_amount, 2) }}**

We will notify you when your order has been shipped.

Thanks,
{{ config('app.name') }}
@endcomponent