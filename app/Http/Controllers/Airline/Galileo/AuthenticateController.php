<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\GalileoFlightLog;

class AuthenticateController extends Controller
{
    public function Authenticate()
    {
        $body = [
            "UserName" => config('services.galileo.user_name'),
            "Password" => config('services.galileo.password'),
        ];
        $response = $this->callApiWithHeadersGal("Authenticate", $body);
        return $response['SessionID'];
    }

    public static function callApiWithHeadersGal($action, $body)
    {
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
        ])->send("POST", config('services.galileo.url') . $action, [
            "body" => json_encode($body, true),
        ])->json();

        if ($action == "Authenticate") {
            if (!isset($response['SessionID'])) {
                throw new \Exception('Authentication failed: SessionID not received.');
            }
            $response['SessionID'];
            $flightLogs = new GalileoFlightLog;
            $flightLogs->session_id = $response['SessionID'];
            $flightLogs->authenticate = json_encode($response, true);
            $flightLogs->availability = json_encode($response, true);
            $flightLogs->save();
        } else {
            $action = strtolower($action);
            if (empty($body['SessionID'])) {
                throw new \Exception('User not authenticated: SessionID is empty.');
            }
            $flightLogs = GalileoFlightLog::where('session_id', '=', $body['SessionID'])->first();
            if (!$flightLogs) {
                throw new \Exception('Session not found: Invalid SessionID.');
            }
            $flightLogs->$action = json_encode(['Request_Of_' . $action => $body, 'Response_Of_' . $action => $response], true);
            $flightLogs->save();
        }
        return $response;
    }

    
}
