@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-full mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section with Glass Card --}}
        <div class="glass-card rounded-[2.5rem] p-8 mb-8 shadow-2xl border light:border-gray-200 dark:border-white/5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="light:bg-gradient-to-br light:from-purple-100 light:to-blue-100 dark:bg-blue-600/20 p-4 rounded-2xl animate-float">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="light:text-purple-600 dark:text-blue-400">
                            <path d="M12 2v20M17 5H9.5M17 12h-5M17 19h-5"/>
                            <path d="M5 5h14v14H5z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Manage Orders <span class="text-transparent bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400">Orders</span>
                        </h1>
                        <p class="text-sm font-medium light:text-gray-600 dark:text-gray-400 mt-1">Track, process, and archive customer transactions.</p>
                    </div>
                </div>
                
                {{-- Search and Filter Section --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                    {{-- Search Form with Button --}}
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="w-full sm:w-auto">
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search orders..." 
                                       class="portal-input w-full sm:w-64 p-3 pl-10 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2">
                                    <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <button type="submit" 
                                    class="glass-card rounded-xl p-3 border light:border-gray-200 dark:border-white/5 text-[9px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:bg-purple-500/10 light:hover:bg-purple-50 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Search
                            </button>
                        </div>
                    </form>

                    {{-- Status Filter Dropdown --}}
                    <div class="relative w-full sm:w-auto" x-data="{ open: false, selected: '{{ request('status', 'all') }}' }">
                        <button @click="open = !open" 
                                class="glass-card rounded-xl p-3 border light:border-gray-200 dark:border-white/5 w-full sm:w-40 flex items-center justify-between gap-2 text-[9px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:bg-white/5 transition-all">
                            <span x-text="selected === 'all' ? 'All Orders' : selected.charAt(0).toUpperCase() + selected.slice(1)"></span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-2 w-full glass-card rounded-xl p-1 border light:border-gray-200 dark:border-white/5 shadow-2xl z-50"
                             style="display: none;">
                            
                            <a href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'all'])) }}" 
                               class="block px-4 py-2.5 text-[9px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:bg-purple-500/10 light:hover:bg-purple-50 rounded-lg transition-colors"
                               @click="open = false; selected = 'all'">
                                All Orders
                            </a>
                            <a href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}" 
                               class="block px-4 py-2.5 text-[9px] font-black uppercase tracking-widest light:text-amber-700 dark:text-amber-400 hover:bg-amber-500/10 light:hover:bg-amber-50 rounded-lg transition-colors"
                               @click="open = false; selected = 'pending'">
                                Pending
                            </a>
                            <a href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'processing'])) }}" 
                               class="block px-4 py-2.5 text-[9px] font-black uppercase tracking-widest light:text-blue-700 dark:text-blue-400 hover:bg-blue-500/10 light:hover:bg-blue-50 rounded-lg transition-colors"
                               @click="open = false; selected = 'processing'">
                                Processing
                            </a>
                            <a href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'completed'])) }}" 
                               class="block px-4 py-2.5 text-[9px] font-black uppercase tracking-widest light:text-emerald-700 dark:text-emerald-400 hover:bg-emerald-500/10 light:hover:bg-emerald-50 rounded-lg transition-colors"
                               @click="open = false; selected = 'completed'">
                                Completed
                            </a>
                            <a href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'delivered'])) }}" 
                               class="block px-4 py-2.5 text-[9px] font-black uppercase tracking-widest light:text-blue-700 dark:text-blue-400 hover:bg-blue-500/10 light:hover:bg-blue-50 rounded-lg transition-colors"
                               @click="open = false; selected = 'delivered'">
                                Delivered
                            </a>
                            <a href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'cancelled'])) }}" 
                               class="block px-4 py-2.5 text-[9px] font-black uppercase tracking-widest light:text-rose-700 dark:text-rose-400 hover:bg-rose-500/10 light:hover:bg-rose-50 rounded-lg transition-colors"
                               @click="open = false; selected = 'cancelled'">
                                Cancelled
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Filters Display --}}
        @if(request('search') || request('status'))
        <div class="flex items-center gap-2 mb-4 px-2">
            <span class="text-[8px] font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">Active Filters:</span>
            @if(request('search'))
            <a href="{{ route('admin.orders.index', array_merge(request()->except('search'), ['search' => null])) }}" 
               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg glass-card text-[8px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:text-rose-500 transition-all group">
                <span>Search: "{{ request('search') }}"</span>
                <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
            @if(request('status') && request('status') != 'all')
            <a href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => 'all'])) }}" 
               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg glass-card text-[8px] font-black uppercase tracking-widest light:text-gray-600 dark:text-gray-400 hover:text-rose-500 transition-all group">
                <span>Status: {{ ucfirst(request('status')) }}</span>
                <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
            <a href="{{ route('admin.orders.index') }}" 
               class="text-[8px] font-black light:text-purple-600 dark:text-purple-400 hover:underline ml-2">
                Clear All
            </a>
        </div>
        @endif

        {{-- Results Summary --}}
        <div class="flex justify-between items-center mb-4 px-2">
            <p class="text-[10px] font-medium light:text-gray-500 dark:text-gray-400">
                Showing <span class="font-black light:text-purple-600 dark:text-purple-400">{{ $orders->firstItem() ?? 0 }}</span> 
                to <span class="font-black light:text-purple-600 dark:text-purple-400">{{ $orders->lastItem() ?? 0 }}</span> 
                of <span class="font-black light:text-purple-600 dark:text-purple-400">{{ $orders->total() }}</span> orders
            </p>
        </div>

        {{-- Orders Table Glass Card --}}
        <div class="glass-card rounded-[2.5rem] shadow-2xl border light:border-gray-200 dark:border-white/5 overflow-hidden">
            @if($orders->isEmpty())
                <div class="py-20 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 light:text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest">No orders found</h3>
                        <p class="text-[9px] light:text-gray-300 dark:text-gray-600 mt-2">
                            @if(request('search') || request('status'))
                                Try adjusting your search or filter criteria
                            @else
                                There are currently no transactions in the queue.
                            @endif
                        </p>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 light:border-gray-200">
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Order ID</th>
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Customer</th>
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Shipping Destination</th>
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] fit-content">Contact</th>
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Products</th>
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center fit-content">Qty</th>
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-right fit-content">Price</th>
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center fit-content">Payment Method</th>
                                <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center fit-content">Status</th>
                                @if(auth()->user()?->isManager())
                                    <th class="py-5 px-6 text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-right fit-content">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 light:divide-gray-100">
                            @foreach($orders as $order)
                                @php
                                    $statusColors = [
                                        'pending' => ['bg' => 'from-amber-500/10 to-amber-500/10', 'border' => 'border-amber-500/20', 'text' => 'light:text-amber-700 dark:text-amber-400'],
                                        'processing' => ['bg' => 'from-blue-500/10 to-blue-500/10', 'border' => 'border-blue-500/20', 'text' => 'light:text-blue-700 dark:text-blue-400'],
                                        'completed' => ['bg' => 'from-emerald-500/10 to-emerald-500/10', 'border' => 'border-emerald-500/20', 'text' => 'light:text-emerald-700 dark:text-emerald-400'],
                                        'delivered' => ['bg' => 'from-blue-500/10 to-blue-500/10', 'border' => 'border-blue-500/20', 'text' => 'light:text-blue-700 dark:text-blue-400'],
                                        'cancelled' => ['bg' => 'from-rose-500/10 to-rose-500/10', 'border' => 'border-rose-500/20', 'text' => 'light:text-rose-700 dark:text-rose-400'],
                                    ];
                                    $status = strtolower($order->status);
                                    $colorSet = $statusColors[$status] ?? ['bg' => 'from-gray-500/10 to-gray-500/10', 'border' => 'border-gray-500/20', 'text' => 'light:text-gray-700 dark:text-gray-400'];
                                @endphp
                                <tr class="hover:bg-white/5 light:hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-4 px-6 fit-content">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="font-mono font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 transition-all">
                                            #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 fit-content">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-black text-xs shadow-lg">
                                                {{ $order->user ? strtoupper(substr($order->user->name, 0, 1)) : 'G' }}
                                            </div>
                                            <div>
                                                <div class="text-xs font-black light:text-gray-900 dark:text-white">{{ $order->user->name ?? 'Guest' }}</div>
                                                <div class="text-[9px] font-medium light:text-gray-500 dark:text-gray-500">{{ $order->user->email ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 max-w-xs">
                                        <span class="text-xs font-medium light:text-gray-600 dark:text-gray-400 block truncate" title="{{ $order->shipping_address }}">
                                            {{ $order->shipping_address }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 fit-content">
                                        <span class="text-xs font-black light:text-gray-700 dark:text-gray-300">{{ $order->contact_number }}</span>
                                    </td>
                                    <td class="py-4 px-6 min-w-[200px]">
                                        <div class="flex flex-col gap-1">
                                            @foreach($order->items->take(2) as $item)
                                                <div class="flex items-center gap-2 text-xs">
                                                    <span class="font-black light:text-gray-900 dark:text-white">{{ $item->quantity }}x</span>
                                                    <span class="font-medium light:text-gray-600 dark:text-gray-400 truncate" title="{{ $item->product->name }}">
                                                        {{ $item->product->name ?? 'Product Unavailable' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 2)
                                                <div class="text-[9px] font-black light:text-purple-600 dark:text-purple-400 mt-1">
                                                    +{{ $order->items->count() - 2 }} more items
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center">
                                        <span class="font-black light:text-gray-900 dark:text-white text-xs">{{ $order->items->sum('quantity') }}</span>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-right">
                                        <span class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">KES {{ number_format($order->total_amount, 2) }}</span>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center">
                                        <span class="inline-flex px-2 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest light:bg-gray-100 dark:bg-white/5 light:text-gray-600 dark:text-gray-400">
                                            {{ $order->payment_method }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 fit-content text-center">
                                        <span class="inline-flex px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-gradient-to-r {{ $colorSet['bg'] }} border {{ $colorSet['border'] }} {{ $colorSet['text'] }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>

                                    @if(auth()->user()?->isManager())
                                        <td class="py-4 px-6 text-right fit-content">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                                   class="p-2.5 light:text-gray-400 dark:text-gray-500 hover:text-purple-600 hover:bg-purple-500/10 light:hover:bg-purple-50 rounded-xl transition-all"
                                                   title="Edit Order">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('admin.orders.archive', $order->id) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            onclick="return confirm('Archive this transaction?')"
                                                            class="p-2.5 light:text-gray-400 dark:text-gray-500 hover:text-amber-600 hover:bg-amber-500/10 light:hover:bg-amber-50 rounded-xl transition-all"
                                                            title="Archive Order">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <polyline points="21 8 21 21 3 21 3 8"/>
                                                            <rect x="1" y="3" width="22" height="5"/>
                                                            <line x1="10" y1="12" x2="14" y2="12"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-6 border-t border-white/5 light:border-gray-200 bg-white/5 light:bg-gray-50/30">
                    {{ $orders->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Base page background */
    .page-bg {
        min-height: 100vh;
        width: 100%;
    }

    .light .page-bg { background-color: #f8fafc; }
    .dark .page-bg { background-color: #030712; }

    /* Glassmorphism Logic */
    .light .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
    }

    .dark .glass-card {
        background: rgba(11, 17, 32, 0.9);
        backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
    }

    /* Portal Input Styles */
    .light .portal-input {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        color: #0f172a;
        transition: all 0.3s ease;
    }
    
    .light .portal-input:focus {
        border-color: #9333ea;
        box-shadow: 0 0 0 1px #9333ea;
        outline: none;
    }

    .light .portal-input::placeholder {
        color: #94a3b8;
    }

    .dark .portal-input {
        background: #0f172a;
        border: 1px solid #1e293b;
        border-radius: 1rem;
        color: #ffffff;
        transition: all 0.3s ease;
    }
    
    .dark .portal-input:focus {
        border-color: #9333ea;
        box-shadow: 0 0 0 1px #9333ea;
        outline: none;
    }

    .dark .portal-input::placeholder {
        color: #334155;
    }

    /* Fit content utility */
    .fit-content {
        width: 1%;
        white-space: nowrap;
    }

    /* Light mode gradient colors */
    .light .from-purple-100 { --tw-gradient-from: #f3e8ff; }
    .light .to-blue-100 { --tw-gradient-to: #dbeafe; }
    .light .from-purple-600 { --tw-gradient-from: #9333ea; }
    .light .to-blue-600 { --tw-gradient-to: #2563eb; }
    .light .from-purple-500\/5 { --tw-gradient-from: rgba(168, 85, 247, 0.05); }
    .light .to-blue-500\/5 { --tw-gradient-to: rgba(59, 130, 246, 0.05); }

    /* Status badge colors */
    .light .from-amber-500\/10 { --tw-gradient-from: rgba(245, 158, 11, 0.1); }
    .light .to-amber-500\/10 { --tw-gradient-to: rgba(245, 158, 11, 0.1); }
    .light .from-emerald-500\/10 { --tw-gradient-from: rgba(16, 185, 129, 0.1); }
    .light .to-emerald-500\/10 { --tw-gradient-to: rgba(16, 185, 129, 0.1); }
    .light .from-blue-500\/10 { --tw-gradient-from: rgba(59, 130, 246, 0.1); }
    .light .to-blue-500\/10 { --tw-gradient-to: rgba(59, 130, 246, 0.1); }
    .light .from-rose-500\/10 { --tw-gradient-from: rgba(244, 63, 94, 0.1); }
    .light .to-rose-500\/10 { --tw-gradient-to: rgba(244, 63, 94, 0.1); }

    /* Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Pagination styling */
    nav[role="navigation"] {
        @apply flex items-center justify-between;
    }
    
    nav[role="navigation"] a, 
    nav[role="navigation"] span {
        @apply px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all;
    }
    
    nav[role="navigation"] a:hover {
        @apply bg-purple-500/10 text-purple-600;
    }
    
    nav[role="navigation"] span[aria-current="page"] span {
        @apply bg-gradient-to-r from-purple-600 to-blue-600 text-white;
    }
</style>

{{-- Alpine.js for dropdown functionality --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dropdown', () => ({
            open: false,
            toggle() {
                this.open = !this.open;
            }
        }))
    })
</script>
@endsection