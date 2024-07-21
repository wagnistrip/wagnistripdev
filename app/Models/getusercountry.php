<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CurrencyConverter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
class getusercountry extends Model
{
    use HasFactory;
    
    public static function geolocation(){
        //Session::forget('currency');
        $session = !empty(Session::get('country_code')) ? Session::get('country_code') : '';
        
        if(empty($session)){
        $ip = $_SERVER['REMOTE_ADDR'];    
        $loc = Http::get('http://www.geoplugin.net/json.gp?ip='.$ip)->json();
        $cncode = 'IN';
    
        if(!empty($loc)){
            if(isset($loc['geoplugin_countryCode'])){
                $cncode = $loc['geoplugin_countryCode'];    
            }
        }
        else{
            $cncode = 'US';
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
        Session::forget('country_code');
        Session::push('country_code' ,$cncode);
        return true;
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
            return true;
        }    

    }
    
}
