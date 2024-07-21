<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Payment extends Controller
{
    function process (Request $request){
        $input = $request->all();
        $customerEmail = $customerName = $customerPhone = "";
       
        $postData = array(
            "appId" => "1661862c982a09f6d5f1d93900681661",
            "orderId" => $input['uniqueid'],
            "orderAmount" => $input['data-amount'] ,
            "orderCurrency" => 'INR',
            "orderNote" => 'Wallet',
            "customerName" => $input['customerName'],
            "customerPhone" => $input['customerPhone'],
            "customerEmail" => $input['customerEmail'],
            "returnUrl" =>  route('galileo-returnurl'),
            "notifyUrl" => route('galileo-returnurl'),
            'secretKey' => "781827d26290a6ea98559e65ec895029923b5fa7",
        );
           return view('flight-pages.oneway-flight-pages.confirm')->with($postData);
        
    }
    function processround (Request $request){
       
        $input = $request->all();
        
        $customerEmail = $customerName = $customerPhone = "";
        
        $postData = array(
            "appId" => "1661862c982a09f6d5f1d93900681661",
            "orderId" => $input['uniqueid'],
            "orderAmount" => $input['data-amount'] ,
            "orderCurrency" => 'INR',
            "orderNote" => 'Wallet',
            "customerName" => $input['customerName'],
            "customerPhone" => $input['customerPhone'],
            "customerEmail" => $input['customerEmail'],
            "returnUrl" =>  route('bookingsroundtrip'),
            "notifyUrl" => route('bookingsroundtrip'),
            'secretKey' => "781827d26290a6ea98559e65ec895029923b5fa7",
        );
       
    return view('flight-pages.oneway-flight-pages.confirm')->with($postData);
        
    }
}
