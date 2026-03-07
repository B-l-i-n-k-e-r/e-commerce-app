<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\Order;
use Carbon\Carbon;

class MpesaController extends Controller
{
    private $consumerKey;
    private $consumerSecret;
    private $shortcode;
    private $passkey;

    public function __construct()
    {
        $this->consumerKey = config('services.mpesa.key');
        $this->consumerSecret = config('services.mpesa.secret');
        $this->shortcode = config('services.mpesa.shortcode');
        $this->passkey = config('services.mpesa.passkey');
    }

    /**
     * Get M-Pesa Access Token
     */
    public function getAccessToken()
    {
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)->get($url);

        if ($response->failed()) {
            Log::error('M-Pesa Token Error: ' . $response->body());
            return null;
        }

        return $response->json()['access_token'] ?? null;
    }

    /**
     * Initiate STK Push
     */
    public function stkPush(Request $request)
    {
        $accessToken = $this->getAccessToken();
        
        if (!$accessToken) {
            return back()->with('error', 'Failed to generate access token.');
        }

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $order = Order::findOrFail($request->order_id);

        // Sanitize phone to 254...
        $phone = preg_replace('/^(?:\+254|0)?(7|1)/', '254$1', str_replace(' ', '', $request->phone));

        $payload = [
            "BusinessShortCode" => $this->shortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => (int)$request->amount,
            "PartyA" => $phone,
            "PartyB" => $this->shortcode,
            "PhoneNumber" => $phone,
            "CallBackURL" => config('services.mpesa.callback'),
            "AccountReference" => "Order " . $order->id,
            "TransactionDesc" => "Payment for BokinceX"
        ];

        try {
            $response = Http::withToken($accessToken)
                ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', $payload);

            $responseData = $response->json();

            if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0') {
                $order->update([
                    'merchant_request_id' => $responseData['MerchantRequestID'],
                    'status' => 'Pending Payment'
                ]);

                // Pass both 'order' and 'response' to your Blade template
                return view('stk_success', [
                    'order' => $order,
                    'response' => $responseData
                ]);
            }

            return back()->with('error', $responseData['CustomerMessage'] ?? 'STK Push failed.');

        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Exception: ' . $e->getMessage());
            return back()->with('error', 'Connection to M-Pesa failed.');
        }
    }

    /**
     * M-Pesa callback to handle payment confirmation
     */
    public function mpesaCallback(Request $request): JsonResponse
    {
        Log::info('M-PESA CALLBACK RECEIVED:', $request->all());

        $data = $request->input('Body.stkCallback');
        $merchantRequestId = $data['MerchantRequestID'];

        if (isset($data['ResultCode']) && $data['ResultCode'] == 0) {
            $metadata = collect($data['CallbackMetadata']['Item']);

            $receiptNumber = $metadata->where('Name', 'MpesaReceiptNumber')->first()['Value'] ?? null;
            $phone = $metadata->where('Name', 'PhoneNumber')->first()['Value'] ?? null;
            $amount = $metadata->where('Name', 'Amount')->first()['Value'] ?? null;

            $order = Order::where('merchant_request_id', $merchantRequestId)->first();
            if ($order) {
                $order->update([
                    'status' => 'Paid',
                    'payment_method' => 'mpesa'
                ]);
            }

            DB::table('mpesa_transactions')->insert([
                'receipt_number' => $receiptNumber,
                'phone' => $phone,
                'amount' => $amount,
                'transaction_date' => now(),
                'status' => 'Success',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('mpesa_transactions')->insert([
                'status' => 'Failed',
                'error_code' => $data['ResultCode'] ?? null,
                'error_message' => $data['ResultDesc'] ?? null,
                'transaction_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }

    /**
     * Polling endpoint for frontend status checks
     */
    public function checkPaymentStatus($order_id)
    {
        $order = Order::select('status')->findOrFail($order_id);
        return response()->json(['status' => $order->status]);
    }
}