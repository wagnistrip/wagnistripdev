<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;


class RazorPaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
        $orderData = [
            'receipt'         => 'rcptid_11',
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 
        ];
    
        $razorpayOrder = $api->order->create($orderData);
    
        $orderId = $razorpayOrder['id'];
    
        return response()->json([
            'orderId'    => $orderId,
            'razorpayId' => env('RAZORPAY_KEY')
        ]);
    }
}
