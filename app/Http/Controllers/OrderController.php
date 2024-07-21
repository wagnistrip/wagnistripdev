<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OrderHotels;
use App\Models\User;
use DB;

class OrderController extends Controller {
    public function create(Request $request)
	{
        // dd($request->all());
        // $user = DB::table('users')->where('id', $id)->first();
        $order = new OrderHotels;
        $order->user_id= Auth::user()->id;
        $order->product_id=Auth::user()->id;
        $order->price=$request['data-amount'];
        $order->amount=$request['data-amount'];
        $order->status=0;
        $order->save();
    
        // $cashfree = config()->get('cashfree');
        $cashfree =[

            'testMode' => env('TEST_MODE', '1'),
            'appID' => env('APP_ID', '1168599c318f1b71027db1f38f958611'),
            'secretKey' => env('SECRET_KEY', 'TEST9c741d444d8c4f2963c4441a98f753f30fc871f7'),
            'orderCurrency' => env('ORDER_CURRENCY', 'INR'),
            'orderPrefix' => env('ORDER_PREFIX', 'MCG-6'),
            
            ];
        $action = ($cashfree['testMode']) ?
                    'https://test.cashfree.com/billpay/checkout/post/submit' :
                    'https://www.cashfree.com/checkout/post/submit';
    
        $appID = $cashfree['appID'];
        $secretKey = $cashfree['secretKey'];
        $orderCurrency = $cashfree['orderCurrency'];
        $returnUrl = url('payments/thankyou');
        $notifyUrl = url('payment/hotel');
    
        $customerName = Auth::user()->name;
        $customerEmail = Auth::user()->email;
        $customerPhone = Auth::user()->ext . Auth::user()->mobile;
        $orderId = $cashfree['orderPrefix'] . $order->id;
        $orderCurrency=$request->curency;
    
        $postData = array(
                "appId" => $appID,
                "orderId" => $orderId,
                "orderAmount" => $order->amount,
                "orderCurrency" => $orderCurrency,
                "orderNote" => $order->id,
                "customerName" => $customerName,
                "customerPhone" => $customerPhone,
                "customerEmail" => $customerEmail,
                "returnUrl" => $returnUrl,
                "notifyUrl" => $notifyUrl,
        );
    
        ksort($postData);
    
        $signatureData = "";
        foreach ($postData as $key => $value) {
                $signatureData .= $key . $value;
        }
        $signature = hash_hmac('sha256', $signatureData, $secretKey, true);
        $signature = base64_encode($signature);
    
        $form = <<<HERE
    
            <form class="redirectForm" method="post" action="$action">
                <input type="hidden" name="appId" value="$appID"/>
                <input type="hidden" name="orderId" value="$orderId"/>
                <input type="hidden" name="orderAmount" value="$order->amount"/>
                <input type="hidden" name="orderCurrency" value="INR"/>
                // <input type="hidden" name="orderCurrency" value="$orderCurrency"/>
                <input type="hidden" name="orderNote" value="$order->id"/>
                <input type="hidden" name="customerName" value="$customerName"/>
                <input type="hidden" name="customerEmail" value="$customerEmail"/>
                <input type="hidden" name="customerPhone" value="$customerPhone"/>
                <input type="hidden" name="returnUrl" value="$returnUrl"/>
                <input type="hidden" name="notifyUrl" value="$notifyUrl"/>
                <input type="hidden" name="signature" value="$signature"/>
                <button type="button" id="paymentbutton" class="btn btn-block btn-lg bg-ore continue-payment">Continue to Payment</button>
    
            </form>
    
        HERE;
    return response($form);
    }
}

