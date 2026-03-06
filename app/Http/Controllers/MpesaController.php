<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Order; // Ensure the model is imported

class MpesaController extends Controller
{
    private $consumerKey;
    private $consumerSecret;
    private $shortcode;
    private $passkey;

    public function __construct()
    {
        $this->consumerKey = env('MPESA_CONSUMER_KEY');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET');
        $this->shortcode = env('MPESA_SHORTCODE');
        $this->passkey = env('MPESA_PASSKEY');
    }

    /**
     * Get M-Pesa Access Token
     */
    public function getAccessToken()
    {
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        return $response->json();
    }

    /**
     * Initiate STK Push
     */
    public function stkPush(Request $request)
    {
        $accessTokenResponse = $this->getAccessToken();
        
        if (!isset($accessTokenResponse['access_token'])) {
            return back()->with('error', 'Failed to generate access token.');
        }

        $accessToken = $accessTokenResponse['access_token'];
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        // Fetch order with items and products for the receipt
        $order = Order::with('items.product')->findOrFail($request->order_id);

        $payload = [
            "BusinessShortCode" => $this->shortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $request->amount,
            "PartyA" => $request->phone,
            "PartyB" => $this->shortcode,
            "PhoneNumber" => $request->phone,
            "CallBackURL" => env('MPESA_CALLBACK_URL'),
            "AccountReference" => "Order #" . $order->id,
            "TransactionDesc" => "Payment for BokinceX"
        ];

        try {
            $response = Http::timeout(60)->withToken($accessToken)
                ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', $payload);

            $responseData = $response->json();

            if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0') {
                $order->update(['merchant_request_id' => $responseData['MerchantRequestID']]);

                // Redirect to receipt view with the $order variable
                return view('stk_success', compact('order'));
            }

            return back()->with('error', $responseData['errorMessage'] ?? 'Push failed');

        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Error: ' . $e->getMessage());
            return back()->with('error', 'Connection to M-Pesa timed out.');
        }
    }

    /**
     * M-Pesa callback to handle payment confirmation
     */
    public function mpesaCallback(Request $request): JsonResponse
    {
        Log::info('M-PESA CALLBACK:', $request->all());

        $data = $request->input('Body.stkCallback');

        if (isset($data['ResultCode']) && $data['ResultCode'] == 0) {
            $metadata = collect($data['CallbackMetadata']['Item']);

            $mpesaReceiptNumber = $metadata->where('Name', 'MpesaReceiptNumber')->first()['Value'] ?? null;
            $phone = $metadata->where('Name', 'PhoneNumber')->first()['Value'] ?? null;
            $amount = $metadata->where('Name', 'Amount')->first()['Value'] ?? null;

            // Update order status if merchant_request_id matches
            $order = Order::where('merchant_request_id', $data['MerchantRequestID'])->first();
            if ($order) {
                $order->update(['status' => 'Paid']);
            }

            DB::table('mpesa_transactions')->insert([
                'receipt_number' => $mpesaReceiptNumber,
                'phone' => $phone,
                'amount' => $amount,
                'transaction_date' => now(),
                'status' => 'Success'
            ]);
        } else {
            DB::table('mpesa_transactions')->insert([
                'receipt_number' => null,
                'status' => 'Failed',
                'error_code' => $data['ResultCode'] ?? null,
                'error_message' => $data['ResultDesc'] ?? null,
                'transaction_date' => now(),
            ]);
        }

        return response()->json(['Response' => 'Callback received successfully'], 200);
    }

    /**
     * Manual confirmation logic (if needed)
     */
    public function confirmTransaction(Request $request)
    {
        $request->validate(['mpesaMessage' => 'required|string']);

        $inputMessage = $request->input('mpesaMessage');
        $amount = session('cart_total'); // Using cart_total from your checkout logic
        $accountRef = 'Order'; 

        $amountMatch = str_contains($inputMessage, (string)$amount);
        
        if ($amountMatch) {
            return redirect()->route('checkout.confirmation')->with('success', 'Payment verified!');
        }

        return back()->withErrors(['mpesaMessage' => 'The message does not match. Check the amount.']);
    }
} // End of Class