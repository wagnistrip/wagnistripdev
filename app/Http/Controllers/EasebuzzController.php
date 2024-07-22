<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EasebuzzController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'upi_id' => 'required|string',
            'amount' => 'required|numeric',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
        ]);
    
        $upiId = $request->upi_id;
        $amount = $request->amount;
        $customerName = urlencode($request->customer_name);
        $note = urlencode('Flight Booking');
        $transactionId = uniqid();
        $apiUrl = env('EASEBUZZ_API_URL') . '/payment/initiateLink'; 
        $response = Http::post($apiUrl, [
            'api_key' => env('EASEBUZZ_API_KEY'),
            'api_secret' => env('EASEBUZZ_API_SECRET'),
            'txnid' => $transactionId,
            'amount' => $amount,
            'firstname' => $customerName,
            'email' => $request->customer_email,
            'phone' => $request->customer_phone,
            'productinfo' => 'Flight Booking',
            'surl' => route('payment.success'),
            'furl' => route('payment.failure'),
            'udf1' => $upiId,
            'service_provider' => 'payu_paisa'
        ]);
    
        $rawResponse = $response->body();
        Log::info('Raw Payment API response', ['response' => $rawResponse]);
    
        $responseBody = $response->json();
        Log::info('Parsed Payment API response', ['response' => $responseBody]);
    
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $responseBody,
                'message' => 'Payment successful'
            ]);
        } else {
            Log::error('Payment initiation failed', ['response' => $responseBody]);
            return response()->json([
                'success' => false,
                'error' => 'Payment initiation failed',
                'data' => $responseBody
            ], 500);
        }
    }
    
    
    private function sendSms($phone, $message)
    {
        // Here you can integrate any SMS gateway to send the message
        // Example using Twilio:
        // Http::post('https://api.twilio.com/2010-04-01/Accounts/your_account_sid/Messages.json', [
        //     'From' => 'your_twilio_number',
        //     'To' => $phone,
        //     'Body' => $message,
        // ]);

        // Log the message for now
        Log::info("SMS sent to $phone with message: $message");
    }

    public function paymentSuccess(Request $request)
    {
        // Handle the success response here
        return response()->json(['message' => 'Payment successful']);
    }

    public function paymentFailure(Request $request)
    {
        // Handle the failure response here
        return response()->json(['message' => 'Payment failed']);
    }

    
}
