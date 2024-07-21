<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\GalileoFlightLog;

class GalileoService
{
    private $userName;
    private $galPassword;
    public function __construct(string $userName, string $galPassword)
    {
        $this->userName = $userName;
        $this->galPassword = $galPassword;
    }
    public function authenticate()
    {
        $body = [
            "UserName" => $this->userName,
            "Password" => $this->galPassword,
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
            $flightLogs = new GalileoFlightLog;
            $flightLogs->session_id = $response['SessionID'];
            $flightLogs->authenticate = json_encode($response, true);
            $flightLogs->availability = json_encode($response, true);
            $flightLogs->save();
        } else {
            $action = strtolower($action);
            if (empty($body['SessionID'])) {
                throw new \Exception('User not authenticated.');
            }

            $flightLogs = GalileoFlightLog::where('session_id', '=', $body['SessionID'])->first();
            $flightLogs->$action = json_encode(['Request_Of_' . $action => $body, 'Response_Of_' . $action => $response], true);
            $flightLogs->save();
        }
        return $response;
    }


}
