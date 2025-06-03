<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function confirmTransaction(Request $request)
    {
        $mpesaMessage = $request->input('mpesaMessage');

        // Retrieve expected data from session or database
        $expectedAmount = session('amount');          // e.g., "Ksh1.00"
        $expectedAccountName = session('account_name'); // e.g., "Daraja-Sandbox" or "BokinceX"
        $orderId = session('order_id');

        // Basic validation logic without requiring phone number
        if (
            $orderId &&
            strpos($mpesaMessage, $expectedAmount) !== false &&
            strpos($mpesaMessage, 'Confirmed') !== false &&
            strpos($mpesaMessage, $expectedAccountName) !== false
        ) {
            // Success: redirect to order confirmation page with order ID
            return redirect()->route('order.confirmation', ['order_id' => $orderId])
                             ->with('success', 'Transaction confirmed successfully.');
        } else {
            // Failure: redirect back to payment page with error and old input
            return redirect()->route('payment.method', ['order_id' => $orderId ?? 0])
                             ->withErrors(['mpesaMessage' => 'The M-Pesa confirmation message does not match your transaction. Please try again.'])
                             ->withInput();
        }
    }
}
