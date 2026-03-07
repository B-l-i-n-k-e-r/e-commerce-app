@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full page-bg relative overflow-hidden">
    <!-- Full-window background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="relative z-10 container mx-auto py-12 px-4 sm:px-6 lg:px-8 min-h-screen">
        <div class="max-w-7xl mx-auto">
            {{-- Header Section with Glass Card --}}
            <div class="glass-card rounded-[2.5rem] p-8 mb-10 shadow-2xl border light:border-gray-200 dark:border-white/5">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg animate-float">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
    {{ __('Secure') }} 
    <span class="light:text-transparent light:bg-clip-text light:bg-gradient-to-r light:from-purple-600 light:to-blue-600 dark:from-blue-400 dark:to-purple-400 dark:bg-gradient-to-r dark:text-transparent dark:bg-clip-text">
        {{ __('Checkout') }}
    </span>
</h1>
                        <p class="text-sm font-medium light:text-gray-500 dark:text-gray-400 mt-1">Complete your purchase securely</p>
                    </div>
                </div>
            </div>

            @if (empty($cart))
                <div class="glass-card rounded-[2.5rem] p-16 text-center border light:border-gray-200 dark:border-white/5">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mb-6">
                            <span class="text-6xl">🛒</span>
                        </div>
                        <h2 class="text-2xl font-black light:text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">{{ __('Your cart is empty!') }}</h2>
                        <p class="text-sm font-medium light:text-gray-500 dark:text-gray-400 mb-8">{{ __('You need items in your cart to proceed with checkout.') }}</p>
                        <a href="{{ route('products.index') }}" class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95">
                            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ __('Back to Shop') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- Shipping Form (Left Side) --}}
                    <div class="lg:col-span-7">
                        <div class="glass-card rounded-[2.5rem] overflow-hidden border light:border-gray-200 dark:border-white/5">
                            <div class="px-8 py-6 border-b border-white/5 light:border-gray-200 bg-white/5 light:bg-gray-50/50">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white text-xs font-black">1</span>
                                    <h2 class="text-xl font-black light:text-gray-900 dark:text-white uppercase tracking-tight">{{ __('Shipping Information') }}</h2>
                                </div>
                            </div>
                            
                            {{-- FIXED: Changed form action to checkout.createOrder --}}
                            <form method="POST" action="{{ route('checkout.createOrder') }}" class="p-8 space-y-6" id="checkoutForm">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="name" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">Full Name</label>
                                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                               class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600">
                                        @error('name') <p class="text-[9px] font-bold uppercase text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="email" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">Email Address</label>
                                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                               class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600">
                                        @error('email') <p class="text-[9px] font-bold uppercase text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="address" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">Delivery Address</label>
                                    <textarea id="address" name="address" rows="3" required placeholder="Apartment, Street, City..."
                                              class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 min-h-[100px]">{{ old('address') }}</textarea>
                                    @error('address') <p class="text-[9px] font-bold uppercase text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="contact" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">Phone Number</label>
                                        <input type="text" id="contact" name="contact" value="{{ old('contact') }}" required placeholder="0712 345 678"
                                               class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600">
                                        @error('contact') <p class="text-[9px] font-bold uppercase text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="payment_method" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">Payment Method</label>
                                        <div class="relative">
                                            <select id="payment_method" name="payment_method" required
                                                    class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 appearance-none cursor-pointer">
                                                <option value="">-- Choose --</option>
                                                <option value="mpesa">M-PESA</option>
                                                <option value="card">Credit/Debit Card</option>
                                                <option value="cash">Cash on Delivery</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('payment_method') <p class="text-[9px] font-bold uppercase text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-white/5 light:border-gray-200">
                                    <a href="{{ route('cart.view') }}" class="group inline-flex items-center gap-1 text-[9px] font-black uppercase tracking-widest light:text-gray-500 dark:text-gray-400 hover:text-purple-600 transition-colors">
                                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                        {{ __('Return to Cart') }}
                                    </a>
                                    <button type="submit" class="group w-full sm:w-auto px-12 py-5 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-500 hover:to-green-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-green-600/20 transition-all active:scale-95">
                                        <span class="flex items-center justify-center gap-2">
                                            {{ __('COMPLETE PURCHASE') }}
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Order Summary (Right Side) --}}
                    <div class="lg:col-span-5">
                        <div class="glass-card rounded-[2rem] overflow-hidden border light:border-gray-200 dark:border-white/5 sticky top-8">
                            <div class="px-8 py-6 border-b border-white/5 light:border-gray-200 bg-white/5 light:bg-gray-50/50">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white text-xs font-black">2</span>
                                    <h2 class="text-xl font-black light:text-gray-900 dark:text-white uppercase tracking-tight">{{ __('Order Summary') }}</h2>
                                </div>
                            </div>
                            
                            <div class="p-8">
                                <div class="space-y-4 mb-6 max-h-96 overflow-y-auto custom-scroll pr-2">
                                    @foreach ($cart as $id => $item)
                                        <div class="flex items-center gap-3 glass-card rounded-xl p-3 border light:border-gray-200 dark:border-white/5">
                                            <div class="h-14 w-14 rounded-xl overflow-hidden flex-shrink-0 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900">
                                                <img src="{{ !empty($item['image_url']) ? asset($item['image_url']) : asset('images/no-image-placeholder.jpg') }}" 
                                                     class="object-cover h-full w-full group-hover:scale-110 transition-transform duration-500">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-black light:text-gray-900 dark:text-white uppercase tracking-tight truncate">{{ $item['name'] }}</p>
                                                <div class="flex items-center justify-between mt-1">
                                                    <span class="text-[9px] font-medium light:text-gray-500 dark:text-gray-400">x{{ $item['quantity'] }}</span>
                                                    <span class="text-xs font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">
                                                        Ksh {{ number_format($item['quantity'] * $item['price'], 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="space-y-4 pt-6 border-t border-white/5 light:border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">Subtotal</span>
                                        <span class="text-sm font-black light:text-gray-900 dark:text-white">Ksh {{ number_format($totalAmount, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">Shipping</span>
                                        <span class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-600">Calculated at next step</span>
                                    </div>
                                    
                                    <div class="pt-6 flex justify-between items-end border-t border-white/5 light:border-gray-200">
                                        <span class="text-sm font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total Amount</span>
                                        <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
                                            Ksh {{ number_format($totalAmount, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-8 py-6 bg-gradient-to-br from-purple-500/5 to-blue-500/5 border-t border-white/5 light:border-gray-200">
                                <div class="flex items-center justify-center gap-2 text-[9px] font-black light:text-purple-700 dark:text-purple-400 uppercase tracking-widest">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    🔒 256-bit SSL Encrypted Security
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const paymentMethod = document.getElementById('payment_method').value;
        
        if (!paymentMethod) {
            alert('Please select a payment method');
            return;
        }
        
        const formData = new FormData(this);
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...</span>';
        submitBtn.disabled = true;
        
        // First, create the order
        fetch('{{ route("checkout.createOrder") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: formData.get('name'),
                email: formData.get('email'),
                address: formData.get('address'),
                contact: formData.get('contact'),
                payment_method: paymentMethod
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Redirect based on payment method
                if (paymentMethod === 'mpesa') {
                    window.location.href = `/payment/${data.order_id}`;
                } else {
                    // For card or COD, go directly to confirmation
                    window.location.href = `/checkout/confirmation/${data.order_id}`;
                }
            } else {
                alert(data.message || 'Error creating order. Please try again.');
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'An error occurred. Please try again.');
            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
</script>

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

    /* Custom scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 4px;
    }
    
    .custom-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    .dark .custom-scroll::-webkit-scrollbar-thumb {
        background: #334155;
    }

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

    /* Animation for spinner */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>
@endsection