<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OriginCurrencyConverter extends Model
{
    use HasFactory;
    public static function convert($args){
        if(!empty($args[0]) && !empty($args[1])){
            $args['from'] = $args[1];
            $args['to'] = $args[0];
            $currency = [];
            $currency[] = $args['from'];
            $currency[] = $args['to'];
            $get = DB::table('latest_currency_exchanges')
                     ->whereIn('code' , $currency)
                     ->get()
                     ->toArray();
        if(count($get) == 2)
        {
            $arr_out = [];
            foreach($get as $key => $value){
                $arr_out[$value->code] = [
                    'code' => $value->code,
                    'value' =>$value->value,
                    ];
            }
            if($args['from'] == 'INR'){
                $cvalue_obj = $arr_out[$args['to']];
                $symbol = __('common.'.$args['to']);
                return  ['code' => [0 => $cvalue_obj['code']] , 'value' => $cvalue_obj['value'] , 'symbol' => $symbol];
            }
            else{
                $cvalue_obj =$arr_out[$args['to']];
                $cvalue_origin = $arr_out[$args['from']];
                $cval_obj_val  = $cvalue_obj['value'];     //  1 rs = $cval_obj_val 
                $cval_obj_origin = $cvalue_origin['value'];  // 1 rs = $cval_obj_origin
                $symbol = __('common.'.$args['to']);

                return  ['code' => [0 => $cvalue_obj['code']] , 'value' => $cval_obj_origin , 'symbol' => $symbol];
            }
        }
        else{
            $symbol = __('common.INR');
            return ['code' => [0 => 'INR']  , 'value' => 1 , 'symbol' => $symbol]; 
        }                     
        }        
    }
}
