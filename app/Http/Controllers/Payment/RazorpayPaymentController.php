<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\RazorpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RazorpayPaymentController extends Controller
{
    protected $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    public function createOrder(Request $request)
    {
        // Validate the incoming request data

        // return $request;

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|max:3'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $method = $request->input('method');
        $order_id = Order::latest()->first();
        $id =  $order_id ?? 1 ;
        $order = $this->razorpayService->createOrder($amount, $currency , $id , $method);
        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'receipt' => $order['receipt'],
            'currency' => $order['currency'],
            'key' => env('RAZORPAY_KEY'),
            'entity' => $order['entity']
        ]);
    }

    public function createPaymentLink(Request $request)
    {

        $amount = $request->input('amount');
        $description = $request->input('description');
        $upi_id = $request->input('upi_id');

        $paymentLink = $this->razorpayService->createPaymentLink($amount, 'INR',  $upi_id);

        return response()->json([
            'status' => 'success',
            'payment_link' => $paymentLink
        ]);
    }

    public function handlePaymentCallback(Request $request)
    {

        return $request;
        // Handle payment success or failure
        return response()->json(['status' => 'success']);
    }
}
