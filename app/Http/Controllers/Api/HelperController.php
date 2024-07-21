<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class HelperController extends Controller
{
    public function phonecode(Request $request)
    {
        $search = $request['search'];
        if ($search == '') {
            $countries = Country::orderby('updated_at', 'DESC')->select('id', 'country', 'code', 'iso_two')->limit(5)->get();
        } else {
            $countries = Country::where('country', 'like','%'. $search.'%')
                 ->orWhere('code', 'like', $search .'%')
                 ->orWhere('iso_two', 'like','%'. $search .'%')
                 ->limit(5)->get();
        }
        $response = array();
        foreach ($countries as $employee) {
            $response[] = array(
                "id" => $employee['code'],
                "country" => $employee['country'],
                "code" =>$employee['code'] ,
                "phoneCode" => $employee['iso_two'],
            );
        }
        echo json_encode($response);
        exit;
    }
}
