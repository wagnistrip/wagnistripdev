<?php

namespace App\Http\Controllers\Airline\Payment;

use App\Http\Controllers\Controller;

use App\Services\PayPalService;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    private $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    public function createPayment(Request $request)
    {
        try {
            $order = $this->payPalService->createPayment($request->amount);
            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function executePayment(Request $request)
    {
        try {
            $result = $this->payPalService->capturePayment($request->orderID);

            if ($result['status'] === 'COMPLETED') {
                return response()->json([
                    'status' => 'success',
                    'payment' => $result,
                ]);
            }

            return response()->json(['error' => 'Payment not completed.'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cancelPayment()
    {
        return response()->json(['status' => 'cancelled']);
    }
}
