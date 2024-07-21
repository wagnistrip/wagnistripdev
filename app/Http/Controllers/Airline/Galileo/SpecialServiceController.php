<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SpecialServiceController extends Controller
{
    public function SpecialService(Request $request){
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request['SessionID'],
            "Key" => $request['Key'],
            "ReferenceNo" => $request['ReferenceNo'],
        ];

        $response = AuthenticateController::callApiWithHeadersGal("SpecialService", $body);

        return $response;
    }
}
