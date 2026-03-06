@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
            
            {{-- Header Section --}}
            <div class="p-8 pb-0 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-50 dark:bg-green-900/20 rounded-2xl mb-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/15/M-PESA_LOGO-01.svg" alt="M-Pesa" class="w-12 h-12 object-contain">
                </div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase italic tracking-tighter">M-Pesa Payment</h2>
                <p class="text-gray-500 dark:text-gray-400 font-bold text-sm mt-1">Order Ref: <span class="text-blue-600">#{{ $order->id }}</span></p>
            </div>

            <div class="p-8">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-700 text-xs font-bold">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Amount Summary (Fit Content Strategy) --}}
                <div class="mb-8 overflow-x-auto">
                    <table class="min-w-max w-full bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                        <tbody>
                            <tr class="border-b dark:border-gray-800">
                                <td class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Amount Due</td>
                                <td class="py-4 px-6 text-xl font-black text-green-600 dark:text-green-400 text-right whitespace-nowrap">
                                    KES {{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Main Payment Form --}}
                <form method="POST" action="{{ route('stkpush') }}" id="paymentForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div>
                        <label for="phone" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Phone Number</label>
                        <input type="text" id="phone" name="phone" required 
                               value="{{ $order->contact_number }}" 
                               placeholder="2547XXXXXXXX"
                               class="w-full px-5 py-4 rounded-2xl border-2 border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-green-500 focus:ring-0 transition-all font-bold text-lg">
                        <p class="text-[10px] text-gray-400 mt-2 font-medium italic">Enter the number that will receive the M-Pesa PIN prompt.</p>
                    </div>

                    {{-- Hidden Amount field for form submission --}}
                    <input type="hidden" name="amount" value="{{ $order->total_amount }}">

                    <button type="submit" class="w-full bg-[#007c00] hover:bg-[#005f00] text-white py-5 rounded-2xl font-black text-lg shadow-xl shadow-green-100 dark:shadow-none transition-all active:scale-95 flex items-center justify-center gap-3" id="payBtn">
                        CONFIRM & PAY NOW
                    </button>
                </form>

                {{-- Status Message --}}
                <div id="pollingStatus" class="mt-6 text-center hidden">
                    <div class="flex items-center justify-center gap-3 text-green-600 dark:text-green-400 animate-pulse font-black text-sm uppercase italic">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Waiting for PIN input...
                    </div>
                </div>

                {{-- Cancel Action --}}
                <div class="mt-8 pt-6 border-t dark:border-gray-700 text-center">
                    <form method="POST" action="{{ route('order.cancel', $order->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors">
                            Cancel Order & Back to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <p class="text-center mt-6 text-[10px] text-gray-400 uppercase font-black tracking-widest">
            🔒 Secured by Safaricom Daraja API
        </p>
    </div>
</div>

{{-- Logic preserved exactly as requested --}}
<script>
    const orderId = "{{ $order->id }}";
    const payBtn = document.getElementById('payBtn');
    const statusMsg = document.getElementById('pollingStatus');
    const paymentForm = document.getElementById('paymentForm');

    paymentForm.addEventListener('submit', function(e) {
        setTimeout(() => {
            statusMsg.classList.remove('hidden');
            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin mr-2"></span>Processing...';
        }, 10);
        
        setTimeout(startPolling, 8000);
    });

    function startPolling() {
        const checkStatus = setInterval(async () => {
            try {
                const response = await fetch(`/order/status/${orderId}`);
                const data = await response.json();

                if (data.status === 'completed' || data.status === 'paid' || data.status === 'success') {
                    clearInterval(checkStatus);
                    window.location.href = "{{ route('checkout.confirmation') }}?order_id=" + orderId;
                }
            } catch (error) {
                console.error("Error checking status:", error);
            }
        }, 3000);
    }
</script>
@endsection