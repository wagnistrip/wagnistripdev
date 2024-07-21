<?php
// app/Services/RazorpayService.php

namespace App\Services;

use Razorpay\Api\Api;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function createPaymentLink($amount, $currency = 'INR', $upi_id)
    {

        $paymentLinkData = [
            'type' => 'link',
            'amount' => $amount * 100, // Amount in paisa
            'currency' => $currency,
            'description' => 'Payment Description',
            'callback_url' => route('payment.callback'), // Add your callback URL here
            'callback_method' => 'get',
            'expire_by' => strtotime('+1 day'),
            'customer' => [
                'name' => 'Customer Name',
                'email' => 'customer@example.com',
                'contact' => '9123456789'
            ],
            'upi_link' => true
        ];
        $paymentLink = $this->api->invoice->create($paymentLinkData);
        // Generate UPI URI scheme (replace with actual VPA)
        $vpa = $upi_id;
        $upiUri = "upi://pay?pa=$vpa&am=$amount&cu=$currency";
        // Return response with both short_url and upi_uri
        return response()->json([
            'status' => 'success',
            'payment_link' => $paymentLink['short_url'],
            'upi_uri' => $upiUri
        ]);
        // return $this->api->invoice->create($paymentLinkData);
    }

    public function createOrder($amount, $currency = 'INR' , $id ,$method)
    {
        $orderData = [
            "receipt"=> "Wagnistrip_000".$id,
            'amount' => $amount * 100, // Amount in paisa
            'currency' => $currency,
            'payment_capture' => 1,
            'method' => $method
        ];
        $order = $this->api->order->create($orderData);
        return $order;
    }
}
