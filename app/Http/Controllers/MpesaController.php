<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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

    public function getAccessToken()
    {
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        return $response->json();
    }

    /**
     * Initiate STK Push
     *
     * @param Request $request
     * @return JsonResponse|View|RedirectResponse
     */
    public function stkPush(Request $request): JsonResponse|View|RedirectResponse
    {
        $accessToken = $this->getAccessToken()['access_token'];

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $callbackUrl = env('MPESA_CALLBACK_URL');

        $payload = [
            "BusinessShortCode" => $this->shortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $request->amount,
            "PartyA" => $request->phone,
            "PartyB" => $this->shortcode,
            "PhoneNumber" => $request->phone,
            "CallBackURL" => $callbackUrl,
            "AccountReference" => "BokinceX",
            "TransactionDesc" => "Order Payment"
        ];

        $response = Http::withToken($accessToken)
            ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', $payload);

        $responseData = $response->json();

        if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0') {
            // Store phone and amount in session for possible later use or polling
            session([
                'phone_number' => $request->phone,
                'amount' => $request->amount,
            ]);

         return view('stk_success', [
    'phone' => $request->phone,
    'amount' => $request->amount,
]);


        } else {
            return back()->withErrors(['mpesa_error' => $responseData['errorMessage'] ?? 'STK Push request failed. Please try again.'])->withInput();
        }
    }

    /**
     * M-Pesa callback to handle payment confirmation
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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

            DB::table('mpesa_transactions')->insert([
                'receipt_number' => $mpesaReceiptNumber,
                'phone' => $phone,
                'amount' => $amount,
                'transaction_date' => now(),
                'status' => 'Success'
            ]);
        } else {
            $resultCode = $data['ResultCode'] ?? null;
            $resultDesc = $data['ResultDesc'] ?? null;

            DB::table('mpesa_transactions')->insert([
                'receipt_number' => null,
                'phone' => null,
                'amount' => null,
                'transaction_date' => now(),
                'status' => 'Failed',
                'error_code' => $resultCode,
                'error_message' => $resultDesc
            ]);
        }

        return response()->json(['Response' => 'Callback received successfully'], 200);
    }

    public function confirmTransaction(Request $request)
{
    $request->validate([
        'mpesaMessage' => 'required|string',
    ]);

    $inputMessage = $request->input('mpesaMessage');

    // Retrieve stored details from session
    $amount = session('amount');
    $accountRef = 'BokinceX'; // You can store this in session too if dynamic
    $receipt = session('mpesa_receipt'); // Set this during callback if needed

    if (!$amount || !$accountRef) {
        return back()->withErrors(['mpesaMessage' => 'Transaction session expired. Please try again.']);
    }

    // Check if message contains expected amount and account reference
    $amountMatch = str_contains($inputMessage, (string)$amount) || str_contains($inputMessage, 'Ksh' . number_format($amount, 2));
    $accountMatch = str_contains($inputMessage, $accountRef);
    $receiptMatch = $receipt ? str_contains($inputMessage, $receipt) : true;

    if ($amountMatch && $accountMatch && $receiptMatch) {
        return redirect()->route('order.confirmation');
    } else {
        return back()->withErrors([
            'mpesaMessage' => 'The M-Pesa confirmation message does not match your transaction. Please ensure you pasted the correct message.'
        ])->withInput();
    }
}


}

