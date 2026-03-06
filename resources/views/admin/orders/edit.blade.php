@extends('layouts.app')

@section('content')
<style>
    /* Global layout resets and Standard Font Family */
    body { 
        margin: 0; 
        padding: 0; 
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Strict fit-content constraints */
    .fit-content {
        width: 1%;
        white-space: nowrap;
    }
    
    .focus-ring {
        transition: all 0.2s ease-in-out;
    }
    .focus-ring:focus {
        outline: none;
        ring: 2px;
        ring-color: #2563eb;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
</style>

<div class="min-h-screen bg-gray-50 dark:bg-gray-950 antialiased py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb & Title --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                        <li><a href="{{ route('admin.orders.index') }}" class="hover:text-blue-600 transition-colors">Order Queue</a></li>
                        <li><span class="mx-1">/</span></li>
                        <li class="text-gray-900 dark:text-white">Fulfillment #{{ $order->id }}</li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                    Order <span class="text-blue-600">Details</span>
                </h1>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 shadow-sm">
                    Current: {{ $order->status }}
                </span>
            </div>
        </div>

        {{-- Order Info Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Customer Info --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">Customer Profile</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Account Name</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $order->user->name ?? 'Guest User' }}</p>
                    </div>
                    @if($order->user)
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Email Address</p>
                        <p class="text-sm font-medium text-blue-600 truncate">{{ $order->user->email }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Shipping Details --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">Logistics Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Recipient</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $order->shipping_name }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase mt-3">Contact</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $order->contact_number }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Delivery Address</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 leading-relaxed">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Update Section --}}
        @if(auth()->user()?->isManager())
            <div class="bg-blue-600 rounded-3xl p-8 mb-8 shadow-2xl shadow-blue-500/20 text-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-md">
                        <h3 class="text-xl font-bold tracking-tight mb-1">Administrative Actions</h3>
                        <p class="text-blue-100 text-sm">Update the order status to trigger customer notifications and inventory adjustments.</p>
                    </div>
                    
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex flex-wrap items-center gap-4">
                        @csrf
                        @method('PUT')
                        <div class="min-w-[200px]">
                            <select name="status" class="w-full bg-blue-700 border-none text-white text-sm font-bold rounded-xl py-3 px-4 focus:ring-2 focus:ring-white transition-all appearance-none cursor-pointer">
                                @foreach(['pending', 'processing', 'delivered', 'cancelled'] as $status)
                                    <option value="{{ $status }}" {{ strtolower($order->status) === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-white text-blue-600 hover:bg-blue-50 font-bold py-3 px-8 rounded-xl transition-all active:scale-95 shadow-lg">
                            Apply Status
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="mb-8 bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-900/50 rounded-2xl p-5 flex items-center gap-4">
                <div class="p-2 bg-amber-100 dark:bg-amber-900/50 rounded-lg text-amber-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-amber-900 dark:text-amber-100">Read-Only Access</p>
                    <p class="text-xs text-amber-700 dark:text-amber-300">Your account does not have authorization to modify order statuses.</p>
                </div>
            </div>
        @endif

        {{-- Purchased Items Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
                <h2 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest">Order Manifest</h2>
            </div>
            
            @if($order->items->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50 text-gray-400 uppercase text-[10px] font-bold tracking-widest border-b border-gray-100 dark:border-gray-700">
                                <th class="py-5 px-8">Product Name</th>
                                <th class="py-5 px-8 fit-content text-center">Quantity</th>
                                <th class="py-5 px-8 fit-content text-right">Unit Price</th>
                                <th class="py-5 px-8 fit-content text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                    <td class="py-5 px-8">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                            {{ $item->product->name ?? 'Product Unavailable' }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 fit-content text-center">
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs font-bold text-gray-700 dark:text-gray-300">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 fit-content text-right">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            KES {{ number_format($item->price, 2) }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 fit-content text-right">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            KES {{ number_format($item->quantity * $item->price, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-900/80">
                            <tr>
                                <td colspan="3" class="py-6 px-8 text-right font-bold text-gray-400 uppercase tracking-widest text-[10px]">Grand Total</td>
                                <td class="py-6 px-8 text-right font-extrabold text-xl text-blue-600 dark:text-blue-500 fit-content">
                                    KES {{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="p-20 text-center">
                    <p class="text-gray-400 italic text-sm font-medium">No records found for this shipment manifest.</p>
                </div>
            @endif
        </div>
        
        <div class="mt-8 flex justify-center">
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                Return to Order Queue
            </a>
        </div>
    </div>
</div>
@endsection