<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogAuthenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class CronController extends Controller
{
    public function currency_exchnages(){
        $apikey = 'cur_live_lQBFoyiR1CVNoyO9t3WJ3IRxhEBBlYLPW5WYcLUM';
        $req_url = 'https://api.currencyapi.com/v3/latest';  
        $update = DB::table('latest_currency_exchanges')
                    ->update(['temp_mark' => 0]);
        $api_resp = Http::get($req_url.'?apikey='.$apikey.'&base_currency=INR')->json();
                
        $out = [];
            if(!empty($api_resp)){
                if(!empty($api_resp['data'])){
                    $data = $api_resp['data'];
                    foreach($data as $key => $value){
                        if(!empty($value['code']) && !empty($value['value'])){
                            $code = $value['code'];
                            $cvalue = $value['value'];
                            $out[] = [
                                    'code'             => $code,
                                    'value'            => $cvalue,
                                    'server_date_time' => date('Y-m-d H:i:s'),
                                    'temp_mark'        => 1,
                                ];
                        }
                    }
                    if(!empty($out)){
                        $insert = DB::table('latest_currency_exchanges')
                                    ->insert($out); 
                    }
                }
            }
            if(!empty($insert)){
                  $check = DB::table('latest_currency_exchanges')
                             ->where('temp_mark' , 1)
                             ->count();
                if($check > 0){
                    $delete = DB::table('latest_currency_exchanges')    
                                ->where('temp_mark' , 0)
                                ->delete();
                }
            }
    }   
}
