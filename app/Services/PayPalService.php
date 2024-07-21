<?php

namespace App\Services;

// use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Srmklive\PayPal\Facades\PayPal;

class PayPalService
{
    protected $paypal;

    public function __construct()
    {
        $this->paypal = PayPal::setProvider();
    }

    public function createPayment($amount)
    {
        $this->paypal->setApiCredentials(config('paypal'));
        $token = $this->paypal->getAccessToken();
        $this->paypal->setAccessToken($token);

        $order = $this->paypal->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ],
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.success')
            ]
        ]);

        return $order;
    }

    public function capturePayment($orderId)
    {
        $this->paypal->setApiCredentials(config('paypal'));
        $token = $this->paypal->getAccessToken();
        $this->paypal->setAccessToken($token);

        $result = $this->paypal->capturePaymentOrder($orderId);

        return $result;
    }
}
