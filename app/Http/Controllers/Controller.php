<?php

namespace App\Http\Controllers;

use Amadeus\ReferenceData\Airlines;
use App\Models\Airline;
use App\Models\Airline\Airportiatacode;
use App\Models\Airlinecode;
use App\Models\VisitorGeolocation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\{Session , Http , DB};
use RealRashid\SweetAlert\Facades\Alert;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function($request,$next){
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }

            return $next($request);
        });
    }

    public function getCountryCode(){
        $currencyconversion = VisitorGeolocation::geolocationInfo();
        if (is_array($currencyconversion) && array_key_exists('code', $currencyconversion)) {
            return $currencyconversion['code'][0];
        } else {
            return 'INR';
        }
    }
    public static function getvisitorcountrycurrency()
    {
        $session = !empty(Session::get('currency')) ? Session::get('currency') : '';
        $currency_symbol = !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';
        if (empty($session)) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $loc = Http::get('http://api.ipstack.com/' . $ip . '?access_key=528d7ed0b65ea7d1f694af15b0ced1a4')->json();
            $cncode = 'IN';
            if (!empty($loc)) {
                if (isset($loc['country_code'])) {
                    $cncode = $loc['country_code'];
                }
            }
            if ($cncode == 'US') {
                $currency = 'USD';
                $currency_symbol = '$';
            } else if ($cncode == 'IN') {
                $currency = 'INR';
                $currency_symbol = '₹';
            } else {
                $currency = DB::table('country_currency')
                    ->where('country', $cncode)
                    ->first();
                $currency = $currency->currency;
                $currency_symbol = $currency->symbol;
            }
            Session::forget('currency');
            Session::push('currency', $currency);
            Session::forget('currency_symbol');
            Session::push('currency_symbol', $currency_symbol);
            return ['currency'=>$currency , 'currency_symbol'=>$currency_symbol];
        } else {
            $currency = 'INR';
            if (!empty($session)) {
                $key_cn = $session;
                $key_cs = $currency_symbol;
                $currency_value = ($key_cn) ? $key_cn[0] : $key_cn;
                $currency_symbol = ($key_cs) ? $key_cs[0] : $key_cs;
                $currency = [
                    'currency' => $currency_value,
                    'currency_symbol' => $currency_symbol,
                ];
            } else {
                $currency = 'INR';
                $currency_symbol = '₹';
            }
            return $currency;
        }
    }

    public function getAirline() {
        $airline = Airlinecode::get();
        return $airline;

    }
    public function getCityName()
    {
        $airlineCity = Airportiatacode::get();
        return $airlineCity;
    }
}
