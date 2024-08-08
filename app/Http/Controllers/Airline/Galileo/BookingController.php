<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\GalileoFlightLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function ticketBooking(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request['SessionID'],
            "Key" => $request['Key'],
            "ReferenceNo" => $request['ReferenceNo'],
            "Provider" => $request['Provider'],
        ];
    
        try {
            $response = AuthenticateController::callApiWithHeadersGal("Booking", $body);
    
            // Log the request and response for debugging
            Log::info('Booking Request:', $body);
            Log::info('Booking Response:', $response);
    
            // if (isset($response['AirBookingResponse']) && !empty($response['AirBookingResponse'])) {
            //     $airBookingResponse = $response['AirBookingResponse'][0];
            
            //     $data["title"] = "From wagnistrip.com";
            //     $data["body"] = $airBookingResponse['PNR'] ?? 'N/A';
            //     $data["departure"] = $airBookingResponse['FlightDetails'][0]['DepartAirportCode'] ?? 'N/A';
            //     $data["arrival"] = $airBookingResponse['FlightDetails'][0]['ArrivalAirportCode'] ?? 'N/A';
            //     $data['name'] = $airBookingResponse['CustomerInfo']['PassengerDetails'][0]['FirstName'] ?? 'N/A';
            
            //     $pdf = PDF::loadView('emails.myTestMail', $data);
            
            //     $recipientEmail = $request->input('Email', 'sona.ansari786000@gmail.com');
            //     $recipients = ["customercare@wagnistrip.com", $recipientEmail];
            
            //     Mail::send('emails.myTestMail', $data, function ($message) use ($data, $pdf, $recipients) {
            //         $message->from('customercare@wagnistrip.com', 'Wagnistrip Customer Care');
            //         $message->to($recipients)
            //             ->subject($data["title"])
            //             ->attachData($pdf->output(), $data['name'] . ".pdf");
            //     });
            
            //     Log::info('Email sent to:', $recipients);
            // } else {
            //     Log::warning('AirBookingResponse not present or empty in response:', $response);
            // }
          
            return response()->json($response);
        } catch (\Exception $e) {
           
            Log::error('Booking Error:', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
    
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    public function getBookingDetails(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "Key" => $request->input('Key'),
            "ReferenceNo" => $request->input('ReferenceNo'),
            "Provider" => $request->input('Provider'),
            "PnrNo" =>  $request->input('PnrNo'),
            "FirstName" => $request->input('FirstName'),
            "LastName" => $request->input('LastName'),
            "From" => $request->input('From'),
            "To" => $request->input('To')
        ];
        try {
            $response = AuthenticateController::callApiWithHeadersGal("GetBookingDetails", $body);
            return $response;
        } catch (\Exception $e) {
           
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cancelBooking(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "ReferenceNo" => $request->input('ReferenceNo'),
            "CancellationRemarks" => $request->input('CancellationRemarks'),
        ];
        try {
            $response = AuthenticateController::callApiWithHeadersGal("CancelBooking", $body);
            return $response;
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function gdsRefund(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "Provider" => $request->input('Provider'),
            "Trip" => $request->input('Trip'),
            "TicketNo" => $request->input('TicketNo'),
            "AuthorityCode" => $request->input('AuthorityCode'),
            "DIRemarks" => $request->input('DIRemarks'),
            "Remarks" => $request->input('Remarks'),
            "TotalCancellationFee" => $request->input('TotalCancellationFee'),
        ];
        try {
            $response = AuthenticateController::callApiWithHeadersGal("GdsRefund", $body);
            return $response;
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getHistoricalData(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "AirlineCode" => $request->input('AirlineCode'),
            "Sector" => $request->input('Sector'),
            "TripType" => $request->input('TripType'),
            "ExcludeAirlineCode" => $request->input('ExcludeAirlineCode'),
            "FromDate" => $request->input('FromDate'),
            "ToDate" => $request->input('ToDate'),
        ];
        try {
            $response = AuthenticateController::callApiWithHeadersGal("HistoricalData", $body);
            return $response;
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public static function Booking($action, $body)
    {
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
        ])->send("POST", config('services.galileo.url') . $action, [
            "body" => json_encode($body, true),
        ])->json();

        if ($action == "Authenticate") {
            $response['SessionID'];
            $flightLogs = new GalileoFlightLog;
            $flightLogs->session_id = $response['SessionID'];
            $flightLogs->authenticate = json_encode($response, true);
            $flightLogs->availability = json_encode($response, true);
            $flightLogs->save();
        } else {
            $action = strtolower($action);
            if ($body['SessionID'] == '') {
                //
            }
            $flightLogs = GalileoFlightLog::where('session_id', '=', $body['SessionID'])->first();
            $flightLogs->$action = json_encode(['Request_Of_' . $action => $body, 'Response_Of_' . $action => $response], true);
            $flightLogs->save();
        }
        return $response;
    }
    
}
