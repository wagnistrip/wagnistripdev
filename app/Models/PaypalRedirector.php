<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VisitorGeolocation;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Session;

class PaypalRedirector extends Model
{
    use HasFactory;
    public static function getredirection($amount , $uniqueid , $type = '' , $uniqueidgal = ''){ // uniqueid gal is used for mix roundtrip booking for handing gal and amd unique id 
        $conversion = VisitorGeolocation::geolocationInfo();
        if(!empty($conversion['code'])){
            $cvalue = $conversion['value']; //conversion value in ruppe
            // $cvalue = 0.012;
            $code = $conversion['code'][0];
        }
        else{
            $code = 'INR';
            $cvalue = 1;
        }
        $currency = Session::get('currency');
        $currency = is_array($currency) ? $currency[0] : $currency;
        if($currency == 'INR'){
            return '';
        }
        $fare_final = ceil($amount*$cvalue);
        $provider = new PayPalClient();  
        $provider->getAccessToken();
        $concat = '?uniqueid='.$uniqueid;
        if(!empty($type)){
            $concat .= '&type='.$type;
        }
        if(!empty($uniqueidgal)){
            $concat .= '&uniqueidgal='.$uniqueidgal;
        }
        if(!empty($amount)){
            $concat .= '&fare='.$amount;
        }
        $code = 'USD';
        $req_arr = [
            "intent"              => "CAPTURE",
            'PayPal-Request-Id'   => $uniqueid,
            "invoice_id"          => $uniqueid,
            "purchase_units"      => [
                [
                'name' => 'WAGNISTRIP OPC PVT. LTD',
                'desc'  => 'Flight Ticket',  
                    "reference_id" => $uniqueid,
                    "amount" => [
                        "value"         => $fare_final,
                        "currency_code" => $code,
                    ],
                ],
            ],
            "application_context" => [
                "cancel_url" => route("cancelTransaction").$concat,
                "return_url" => route("successTransaction").$concat,
            ],
        ];

        $order = $provider->createOrder($req_arr);
        $payment_url = $order['links'][1]['href']."&disable-funding=paylater";
        return $payment_url;        
    }
}
