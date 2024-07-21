<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function seatMap(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "Key" => $request->input('Key'),
            "ReferenceNo" => $request->input('ReferenceNo'),
            "Provider" => $request->input('Provider'),
            "Destination" => $request->input('Destination'),
            "Origin" => $request->input('Origin'),
        ];
        // return $body;
        try {
            $response = AuthenticateController::callApiWithHeadersGal("SeatMap", $body);
            return response()->json($response) ;
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function emdSeatmap(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "Key" => $request->input('Key'),
            "ReferenceNo" => $request->input('ReferenceNo'),
            "Provider" => $request->input('Provider'),
            "PnrNo" => $request->input('PnrNo'),
            "TicketNumber" => $request->input('TicketNumber'),
        ];

        try {
            $response = AuthenticateController::callApiWithHeadersGal("EMDSeatMap", $body);
            return $response;
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function gdsSeatIssuance(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "AncillaryKey" => $request->input('AncillaryKey'),
            "Tittle" => $request->input('Tittle'),
            "FirstName" => $request->input('FirstName'),
            "LastName" => $request->input('LastName'),
            "MiddleName" => $request->input('MiddleName'),
            "Provider" => $request->input('Provider'),
            "PnrNo" => $request->input('PnrNo'),
            "TicketNumber" => $request->input('TicketNumber'),
            "SeatListDetails" => $request['SeatListDetails'],
        ];
        try {
            $response = AuthenticateController::callApiWithHeadersGal("GDSSeatIssuance", $body);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
