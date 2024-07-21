<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlightDetailsController extends Controller
{


    public function getCityDetails(Request $request)
    {
        try {
            $body = [
                "ClientCode" => config('services.galileo.user_name'),
                "SessionID" => $request->input('SessionID'),
                "City" => $request->input('City'),
            ];

            $response = AuthenticateController::callApiWithHeadersGal("Citylist", $body);
            return $response;
            $responseData = json_decode($response->getBody(), true); // Assuming JSON response

            // Check for successful response and extract airport code(s)
            if ($response->isSuccess() && isset($responseData['data']['Airports'])) {
                $airportCodes = [];
                foreach ($responseData['data']['Airports'] as $airport) {
                    $airportCodes[] = $airport['Code'];
                }

                return response()->json(['airport_codes' => $airportCodes]);
            } else {
                $errorMessage = $response->getErrorMessage() ?: 'City not found'; // Handle specific errors
                return response()->json(['error' => $errorMessage], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function gdsAncillaryServices(Request $request)
    {
        try {
            $body = [
                "ClientCode" => config('services.galileo.user_name'),
                "SessionID" => $request->input('SessionID'),
                "PnrNo" => $request->input('PnrNo'),
                "Provider" => $request->input('Provider'),
                "ReferenceNo" => $request->input('ReferenceNo'),
                "Key" => $request->input('Key'),
                "TicketNumber" => $request->input('TicketNumber'),
            ];

            $response = AuthenticateController::callApiWithHeadersGal("GDSAncillaryServices", $body);
            return $response;
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function gdsAncillaryFulfillment(Request $request)
    {
        try {
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
                "OptServices" => $request['OptServices'],
                "MiddleName" => $request->input('MiddleName'),
            ];

            return $body;
            $response = AuthenticateController::callApiWithHeadersGal("GDSAncillaryFulfillment", $body);
            return $response;
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getGDSTerminal(Request $request)
    {
        try {
            $body = [
                "ClientCode" => config('services.galileo.user_name'),
                "SessionID" => $request->input('SessionID'),
                "Key" => $request->input('Key'),
                "UserName" => $request->input('UserName'),
                "Password" => $request->input('Password'),
                "BranchCode" => $request->input('BranchCode'),
                "PCC" => $request->input('PCC'),
                "TransactionType" => $request->input('TransactionType'),
                "HostTokenValue" => $request->input('HostTokenValue'),
                "TerminalCommand" => $request->input('TerminalCommand'),
                "TCmdPostionNo" => $request->input('TCmdPostionNo'),
                "Provider" => $request->input('Provider'),
            ];
            $response = AuthenticateController::callApiWithHeadersGal("GetGdsTerminal", $body);
            return $response;
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
