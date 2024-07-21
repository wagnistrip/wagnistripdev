<?php

namespace App\Http\Controllers\Airline;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Country, HotelCity, VisitorGeolocation, Airline\Airportiatacode};

class AirPortIATACodesController extends Controller
{
    public function searchAirIataCode(Request $request)
    {
        $search = $request['search'];

        if ($search == '') {
            $airlinecodes = Airportiatacode::orderby('iata', 'ASC')->select('id', 'iata', 'city', 'country', 'airport', 'CityCode', 'CountryCode', 'state')->limit(10)->get();
        } else {
            $airlinecodes = Airportiatacode::where('CountryCode', 'like', $search)
                ->orWhere('city', 'like', $search . '%')
                ->orWhere('state', 'LIKE', '%' . $search . '%')
                ->orWhere('country', 'like', '%' . $search . '%')
                ->orWhere('airport', 'like', '%' . $search . '%')
                ->orWhere('CityCode', 'like', '%' . $search . '%')
                ->orWhere('iata', 'like', $search . '%')
                ->limit(20)->orderby('iata', 'ASC')->get();
        }
        $final_arr_obj = [];
        $suggestions  = [];
        foreach ($airlinecodes as $key => $value) {
            $iata = $value->iata;
            // dd($search);
            // if(substr($search , $iata) || $iata == $search || $iata == strtoupper($search) ||  $iata == strtolower($search)){
            if ($iata == $search || strtoupper($search) == $iata || strtolower($search) == $iata) {
                $final_arr_obj[] = $value;
            } else {
                $suggestions[] = $value;
            }
        }
        $response = array();
        $response2 = array();
        // dd($final_arr_obj , $suggestions);
        foreach ($final_arr_obj as $airlinecode) {
            $response2[] = [
                'id' => $airlinecode['iata'],
                'text' => '',
                'head' => $airlinecode['city'] . "\n " . $airlinecode['country'] . "",
            ];
            $response[] = array(
                "id" => $airlinecode['iata'],
                "text" => $airlinecode['city'] . "\n (" . $airlinecode['iata'] . ") " . "\n " . $airlinecode['state'] . " " . $airlinecode['country'] . "\n" . $airlinecode['airport'],
                "head" => $airlinecode['city'] . "\n " . $airlinecode['country'] . "",
                'airport' => $airlinecode['airport'],
                'city' => $airlinecode['city'],
                'state' => !empty($airlinecode['state']) ? $airlinecode['state'] : '',
                'country' => $airlinecode['country']
            );
        }
        foreach ($suggestions as $airlinecode) {
            $response2[] = [
                'id' => $airlinecode['iata'],
                'text' => '',
                'head' => $airlinecode['city'] . "\n " . $airlinecode['country'] . "",
            ];
            $response[] = array(
                "id" => $airlinecode['iata'],
                "text" => $airlinecode['city'] . "\n (" . $airlinecode['iata'] . ") " . "\n " . $airlinecode['state'] . " " . $airlinecode['country'] . "\n" . $airlinecode['airport'],
                "head" => $airlinecode['city'] . "\n " . $airlinecode['country'] . "",
                'airport' => $airlinecode['airport'],
                'city' => $airlinecode['city'],
                'state' => !empty($airlinecode['state']) ? $airlinecode['state'] : '',
                'country' => $airlinecode['country']
            );
        }
        return response()->json($response);
    }

    public function searchCountryCode(Request $request)
    {
        $search = $request['search'];
        if ($search == '') {
            $countries = Country::orderby('updated_at', 'DESC')->select('id', 'country', 'code')->limit(10)->get();
        } else {
            $countries = Country::where('country', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', $search . '%')
                ->limit(10)->get();
        }
        $response = array();
        foreach ($countries as $employee) {
            $response[] = array(
                "id" => $employee['code'],
                "text" => $employee['country'] . " (" . $employee['code'] . ") ",
            );
        }
        return response()->json($response);
    }

    public function searchCountryIso(Request $request)
    {
        $search = $request['search'];
        if ($search == '') {
            $countries = Country::orderby('updated_at', 'DESC')->select('id', 'country', 'iso_two')->limit(10)->get();
        } else {
            $countries = Country::where('country', 'like', '%' . $search . '%')
                ->orWhere('iso_two', 'like', $search . '%')
                ->limit(10)->get();
        }
        $response = array();
        foreach ($countries as $employee) {
            $response[] = array(
                "id" => $employee['iso_two'],
                "text" => $employee['country'] . " (" . $employee['iso_two'] . ") ",
            );
        }
        return response()->json($response);
    }

    public static function getCity($d)
    {
        $res = '';
        $datas = Airportiatacode::where('iata', $d)->get('city');
        foreach ($datas as $data) {
            $res = $data['city'];
        }
        if ($res != '') {
            return $res;
        }
        return $d;
    }
    
    public static function getCountry($d)
    {
        $datas = Airportiatacode::where('iata', $d)->first('country');
        $res = '';
        $res = $datas['country'] ?? '';
        if (!isset($res) && empty($res)) {
            return $d;
        }
        return $res;
    }

    public static function getAirport($d)
    {
        $res = '';
        $datas = Airportiatacode::where('iata', $d)->get('airport');
        foreach ($datas as $data) {
            $res = $data['airport'];
        }
        if ($res != '') {
            return $res;
        }
        return $d;
    }

    public static function HotelCity(Request $request)
    {
        $search = $request['search'];
        // dd($request->all());
        if ($search == '') {
            $airlinecodes = HotelCity::orderby('city', 'ASC')->select('id', 'city', 'state', 'country')->limit(10)->get();
        } else {
            $airlinecodes = HotelCity::orderby('city', 'ASC')->where('city', 'like', $search)
                //  ->orWhere('city', 'like', $search.'%')
                ->orWhere('state', 'like', $search . '%')
                ->orWhere('country', 'like', $search . '%')
                //  ->orWhere('CityCode', 'like', $search.'%')
                ->orWhere('city', 'like', $search . '%')
                ->limit(20)->get();
        }
        $response = array();
        foreach ($airlinecodes as $employee) {
            $response[] = array(
                "id" => $employee['city'],
                "text" => $employee['city'] . "\n (" . $employee['city'] . ") " . $employee['country'] . "\n",
                "head" => $employee['city'] . "\n " . $employee['country'] . "",
            );
        }
        return response()->json($response);
    }
    public function get_geolocation_info()
    {
        $pricing = VisitorGeolocation::geolocationInfo();
        $cvalue = !empty($pricing['value']) ? $pricing['value'] : 1;    // conversion rate
        $code = !empty($pricing['code'][0]) ? $pricing['code'][0] : 'INR';
        $icon = __('common.' . $code);
        $icon_inr = __('common.INR');
        $arr = [
            'code' => 200,
            'icon' => $icon,
            'icon_inr' => $icon_inr,
            'cvalue' => $cvalue,
        ];
        return response()->json($arr);
    }
}
