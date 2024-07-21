<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CurrencyConverter extends Model
{
    use HasFactory;
    public static function convert($args){
        if(!empty($args[0]) && !empty($args[1])){
            //call api 
            $status = 0;   // change this status to 1 for getting apikeys and url form DB
            if($status == 1){
                $get_key = DB::table('exchange_api_settings')
                             ->orderBy('id' , 'DESC')
                             ->first();
                $apikey = !empty($get_key->apikey) ? $get_key->apikey : 'cur_live_3rAIiB45QtX8vwBeLRh2xpErMw1v17ZSTawfwHSG';
                $req_url = !empty($get_key->request_url) ? $get_key->request_url : 'https://api.currencyapi.com/v3/latest'; 
            }
            else{
                $apikey = 'cur_live_lQBFoyiR1CVNoyO9t3WJ3IRxhEBBlYLPW5WYcLUM';
                $req_url = 'https://api.currencyapi.com/v3/latest';                
            }
            // running Http
            $api_resp = Http::get($req_url.'?apikey='.$apikey.'&currencies[]='.$args[0].'&base_currency='.$args[1])->json();
            // $ip = $_SERVER['REMOTE_ADDR'];
            // $get_currency = Session::get('currency');
            // $api_resp = Http::get('http://www.geoplugin.net/json.gp?ip='.$ip.'?base_currency=USD')->json();

            if(!empty($api_resp)){
                if(!empty($api_resp['data'])){
                    $data = $api_resp['data'];
                    if(!empty($data[$args[0]])){
                        $get = $data[$args[0]];
                        $send = [
                            "code"  => [$get["code"]],
                            "value" => $get["value"],
                            "symbol" => __('common.'.$args[0])
                            ];
                            return $send;
                    }
                    else{
                        return [];
                    }
                }
                if(!empty($api_resp['geoplugin_currencyConverter'])){
                    $rate = round(1/$api_resp['geoplugin_currencyConverter'] , 3);
                    $code = !empty(Session::get('currency')) ? Session::get('currency') : ['USD']; 
                    $symbol = !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ['$']; 
                    // $code = $api_resp['geoplugin_currencyCode'];
                    // $symbol = $api_resp['geoplugin_currencySymbol_UTF8'];
                    if($get_currency[0] == 'INR'){
                        $data = [
                            "code" => $code,
                            "value" => 1,
                            "symbol" => $symbol
                            ];    
                    }
                    else{
                    $data = [
                        "code" => $code,
                        "value" => $rate,
                        "symbol" => $symbol
                        ];
                    }
                    // $data = $api_resp['data'];
                    // if(!empty($data[$args[0]])){
                    //     return $data[$args[0]];
                    // }
                    if(!empty($data)){
                        return $data;

                    }
                    else{
                        return [];
                    }
                }                
                else{
                        return [];                    
                }
            }
            else{
                        return [];                
            }
        }
    }
}
