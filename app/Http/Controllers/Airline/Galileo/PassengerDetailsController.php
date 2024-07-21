<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Airline\Galileo\AuthenticateController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PassengerDetailsController extends Controller
{
    public function addPassengerDetails(Request $request)
    {

        // return $request['SessionID'];
        try {
      
            $passengerDetails = [];
            foreach ($request['CustomerInfo']['PassengerDetails']as $passenger) {
                $seatDetails = [];
                // if (isset($passenger['ConfirmSeat'])) {
                //     foreach ($passenger['ConfirmSeat'] as $seat) {
                //         $seatDetails[] = [
                //             'SeatDesignator' => $seat['SeatDesignator'],
                //             'Amount' => $seat['Amount'],
                //             'Origin' => $seat['Origin'],
                //             'Destination' => $seat['Destination'],
                //             'FlightNumber' => $seat['FlightNumber'],
                //             'FlightTime' => $seat['FlightTime'],
                //             'SeatAlignment' => $seat['SeatAlignment'],
                //             'Group' => $seat['Group'],
                //             'ClassOfService' => $seat['ClassOfService'],
                //             'Equipment' => $seat['Equipment'],
                //             'Carrier' => $seat['Carrier'],
                //             'Paid' => $seat['Paid'],
                //             'SeatStatus' => $seat['SeatStatus'],
                //         ];
                //     }
                // }
                $passengerDetails[] = [
                    'Title' => $passenger['Title'],
                    'FirstName' => $passenger['FirstName'],
                    'Gender' => $passenger['Gender'] ?? null,
                    'MiddleName' => $passenger['MiddleName'] ?? null, // Optional
                    'LastName' => $passenger['LastName'],
                    'DateOfBirth' => $passenger['DateOfBirth'] ?? null, // Optional
                    'PassengerType' => $passenger['PaxType'] ?? 'ADT', // Adjust passenger type (ADT - Adult, CHD - Child)
                    'PassportNumber' => $passenger['PassportNumber'] ?? null, // Optional
                    'IssuingCountry' => $passenger['IssuingCountry'] ?? null,
                    'ExpiryDate' => $passenger['ExpiryDate'] ?? null,
                    'FrequentFlyerAirline' => $passenger['FrequentFlyerAirline'] ?? null,
                    'PaxType' => $passenger['PaxType'] ?? null,
                    'ConfirmSeat' => $seatDetails,
                ];
            }
            $SSRInfo = [];
            // if (isset($request['SSRInfo'])) {
            //     foreach ($request['SSRInfo'] as $ssr) {
            //         $SSRInfo[] = [
            //             'TrackID' => $ssr['TrackID'],
            //             'WayType' => $ssr['WayType'],
            //             'Description' => $ssr['Description'],
            //             'AirlineDescription' => $ssr['AirlineDescription'],
            //             'PaxNumber' => $ssr['PaxNumber'],
            //             'TripType' => $ssr['TripType'],
            //             'SSRCode' => $ssr['SSRCode'],
            //             'SSRPrice' => $ssr['SSRPrice'],
            //             'DepartureStation' => $ssr['DepartureStation'],
            //             'ArrivalStation' => $ssr['ArrivalStation'],
            //             'SSRType' => $ssr['SSRType'],
            //             'Weight' => $ssr['Weight'],
            //             'PaxType' => $ssr['PaxType'],
            //         ];
            //     }
            // }
            $AddPassengerDetailsBody = [
                "ClientCode" => config('services.galileo.user_name'),
                "SessionID" => $request['SessionID'],
                "Key" => $request['Key'],
                "ReferenceNo" => $request['ReferenceNo'],
                "CustomerInfo" => [
                    "Email" => $request['CustomerInfo']['Email'] ?? "customercare@wagnistrip.com",
                    "Mobile" => $request['CustomerInfo']['Mobile'] ??  "+917669988012",
                    "Address" => $request['CustomerInfo']['Address'] ??  "No. 5-b/13, Land Area Measuring 200Sq. YDS., Tilak Nagar, New Delhi (India) Pin: 110018",
                    "City" => $request['CustomerInfo']['City'] ??  "Delhi",
                    "State" => $request['CustomerInfo']['State'] ??  "Delhi",
                    "CountryCode" => $request['CustomerInfo']['CountryCode'] ??  "IN",
                    "CountryName" => $request['CustomerInfo']['CountryName'] ??  "India",
                    "ZipCode" => $request['CustomerInfo']['ZipCode'] ??  "110018",
                    "PassengerDetails" => $passengerDetails,
                    "PassengerTicketDetails" => [],
                    "Payment" => (object) [],
                ],
                "SSRInfo" => $SSRInfo,
                "TotalAmount" => $request['TotalAmount'],
                "SSRAmount" => $request['SSRAmount'],
                "Discount" => $request['Discount'],
                "GrandTotalFare" => $request['GrandTotalFare'],
                "IsGSTProvided" => $request['IsGSTProvided'] ? true : false,
            ];
            // return $passengerDetails;
            $getsession = [
                'SessionID' => $request['SessionID'],
                'ReferenceNo' => $request['ReferenceNo'],
                'Provider' =>  $request['Provider'],
                'Key'      => $request['Key'],
            ];
            // return $request['travellers'];
            $uniqueid = "WT" . $request['ReferenceNo'] . rand(9, 99) . $this->getCartData();
            $AddPassengerDetails = AuthenticateController::callApiWithHeadersGal("AddPassengerDetails", $AddPassengerDetailsBody);
            if ($AddPassengerDetails['Status'] == 'Success') {
                $validator = Validator::make($request->all(), [
                    'otherInformation' => 'required',
                    'GrandTotalFare' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                                'error' => $validator->errors()->all()
                            ]);
                }
                $savePassenger = Cart::create([
                    'uniqueid' => $uniqueid,
                    'otherInformation' => $request['otherInformation'],
                    'getsession' => json_encode($getsession, true),
                    'travllername' => json_encode($passengerDetails, true),
                    'email' => $request['CustomerInfo']['Email'],
                    'phonenumber' => $request['CustomerInfo']['Mobile'],
                    'fare' => $request['GrandTotalFare'],
                    'travellerquantity' => json_encode($request['travellers']),
                ]);
                //     $bookingController = new BookingController;
                //     $bookingDetails = $bookingController->ticketBooking($request , $sessionID , $key , $referenceNo , $provider);
                //     return $bookingDetails;


                // $logPath = storage_path('logs/galileo/' . 'Add_passanger_details' . date('Y-m-d') . '.xml');
                // $logresultPath = storage_path('logs/galileo/' . 'Add_passanger_result' . date('Y-m-d') . '.xml');
                // config(['logging.channels.galileo.path' => $logPath]);
                // config(['logging.channels.galileo.path' => $logresultPath]);

                // Log::channel('galileo')->info('Add Passenger Details', ['response' => $AddPassengerDetails]);
                // Log::channel('galileo')->info('Add Passenger Details', ['response' => $AddPassengerDetails]);
                return response()->json($AddPassengerDetails);
            }
        } catch (Exception $e) {
            // Log::error('Error in addPassengerDetails: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCartData()
    {
        $cart = Cart::latest()->first();
        if (empty($cart)) {
            return  1;
        } else {
            return $cart->id;
        }
    }
    
    
}
