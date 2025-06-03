@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-semibold text-gray-900 mb-6">Manage Orders</h1>

        <div class="bg-white rounded-md shadow-md overflow-x-auto">
            @if($orders->isEmpty())
                <div class="p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No orders found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are currently no orders in the system.</p>
                </div>
            @else
                <table class="min-w-full table-auto divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipping Address</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Number</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            @php
                                $statusClasses = [
                                    'Pending' => 'text-yellow-500',
                                    'Completed' => 'text-green-600',
                                    'Cancelled' => 'text-red-600',
                                ];
                                
                                $paymentMethodClasses = [
                                    'M-Pesa' => 'text-green-600',
                                    'PayPal' => 'text-blue-600',
                                    'Credit Card' => 'text-purple-600',
                                    'Cash on Delivery' => 'text-gray-600',
                                ];
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $order->user->name ?? 'N/A' }}
                                    <br>
                                    <span class="text-blue-500 text-xs">{{ $order->user->email ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $order->shipping_name }},<br>{{ $order->shipping_address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->contact_number }}</td>
                                <td class="px-6 py-4">
                                    @if($order->items->isNotEmpty())
                                        <ul class="list-disc list-inside">
                                            @foreach($order->items as $item)
                                                <li>{!! $item->product->name ?? '<span class="text-red-500">Product Not Found</span>' !!}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-500">No items in this order.</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    {{ $order->items->sum('quantity') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold {{ $paymentMethodClasses[$order->payment_method] ?? 'text-gray-700' }}">
                                    {{ $order->payment_method }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="{{ $statusClasses[$order->status] ?? 'text-gray-700' }} font-medium">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs"
                                           aria-label="Edit order {{ $order->id }}">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.orders.archive', $order->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to archive this order?')"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-xs"
                                                    aria-label="Archive order {{ $order->id }}">
                                                Archive
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 px-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection