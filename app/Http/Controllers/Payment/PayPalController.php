<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal;

class PayPalController extends Controller
{
    public function createPayment(Request $request)
    {
        $paypal = new PayPal;
        $paypal->setApiCredentials(config('paypal'));
        $paypal->setAccessToken($paypal->getAccessToken());

        $order = $paypal->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->amount
                    ]
                ]
            ],
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.success')
            ]
        ]);

        return response()->json($order);
    }

    public function capturePayment(Request $request)
    {

        return $request;
        $paypal = new PayPal;
        $paypal->setApiCredentials(config('paypal'));
        $paypal->setAccessToken($paypal->getAccessToken());

        $result = $paypal->capturePaymentOrder($request->orderID);

        return response()->json($result);
    }

    public function success()
    {
        return 'Payment successful!';
    }

    public function cancel()
    {
        return 'Payment cancelled!';
    }
}
