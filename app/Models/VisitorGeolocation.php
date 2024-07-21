<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CurrencyConverter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
// use App\Models\onlylocation;
use App\Models\OriginCurrencyConverter;
class VisitorGeolocation extends Model
{
    use HasFactory;
    
    public static function geolocationInfo(){
        $session = !empty(Session::get('currency')) ? Session::get('currency') : '';
        if(empty($session)){
        $ip = $_SERVER['REMOTE_ADDR'];    
        // $loc = Http::get('http://www.geoplugin.net/json.gp?ip='.$ip)->json();
            $ch = curl_init('http://www.geoplugin.net/json.gp?ip='.$ip);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000);
                $data = curl_exec($ch);
                $curl_errno = curl_errno($ch);
                $curl_error = curl_error($ch);
                curl_close($ch);      
        $loc = json_decode($data ,  true);
        $cncode = 'IN';
    
        if(!empty($loc)){
            if(is_array($loc)){
                if(isset($loc['geoplugin_countryCode'])){
                    $cncode = $loc['geoplugin_countryCode'];    
                }
            }
        }
        else{
            $cncode = 'IN';
        }
        if($cncode == 'US'){
            $currency = 'USD';
            $currency_symbol = '$';
        }
        else if($cncode == 'IN'){
            $currency = 'INR';  
            $currency_symbol = '₹';
        }
        else{

            $currency_symbol = !empty($loc['geoplugin_currencySymbol_UTF8']) ? $loc['geoplugin_currencySymbol_UTF8'] : '$';
            $currency = !empty($loc['geoplugin_currencyCode']) ? $loc['geoplugin_currencyCode'] : 'USD'; 
        }
        Session::forget('currency');
        Session::push('currency' ,$currency);
        Session::forget('currency_symbol');
        Session::push('currency_symbol' , $currency_symbol);
        }
        else{
            $currency = 'INR';
            if(!empty($session)){
                $key_cn = $session;
                $currency = ($key_cn) ? $key_cn[0] : $key_cn;  
            }   
            else{
                $currency = 'USD'; 
            }
        }    
        //getting currency conversion rates
        $params = array($currency , 'INR');
        $conversion = OriginCurrencyConverter::convert($params);
        if(empty($conversion)){
            $params = array('USD' , 'INR');
            $conversion = OriginCurrencyConverter::convert($params);
        }        
        return $conversion;
    }
    
}
