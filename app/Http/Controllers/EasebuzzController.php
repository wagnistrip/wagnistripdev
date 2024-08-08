<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\Easebuzz\EasebuzzService;

class EasebuzzController extends Controller
{
    protected $easebuzzService;

    public function __construct(EasebuzzService $easebuzzService)
    {
        $this->easebuzzService = $easebuzzService;
    }

    public function initiatePayment(Request $request)
{
    $validator = Validator::make($request->all(), [
        'amount' => 'required|numeric',
        'productinfo' => 'required',
        'firstname' => 'required',
        'email' => 'required|email',
        'phone' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);
    }

    $txnid = 'txn_' . Str::random(10);
    $data = $request->all();
    $data['txnid'] = $txnid;

    $response = $this->easebuzzService->initiatePayment($data);

    if ($response['status'] == 1) {
        $redirectUrl = $this->easebuzzService->getPaymentRedirectUrl($response['data']);
        return response()->json([
            'success' => true,
            'redirect_url' => $redirectUrl
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Payment initiation failed',
            'data' => $response
        ]);
    }
}

    
    public function success()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Payment was successful'
        ]);
    }
    
    public function failure()
    {
        return response()->json([
            'status' => 'failure',
            'message' => 'Payment failed'
        ]);
    }
    
}
