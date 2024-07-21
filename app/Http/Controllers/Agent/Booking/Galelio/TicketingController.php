<?php

namespace App\Http\Controllers\Agent\Booking\Galelio;
use App\Http\Controllers\Airline\Galileo\AuthenticateController;
use App\Http\Controllers\Airline\AirportiatacodesController;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Agent\AgentBooking;
use App\Models\Cart;
use App\Models\GalileoFlightLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller\SendMailController;
use Mail;
use PDF;


class TicketingController extends Controller {
    public function __construct() {
        $this->APP_ID = "1661862c982a09f6d5f1d93900681661";
        $this->SECRET_KEY = "781827d26290a6ea98559e65ec895029923b5fa7";
    }

    public function ReturnUrl($tnxid , $showprice) {
        // dd($tnxid, $showprice);
        
        $get_data = AgentBooking::where('booking_id', $tnxid)->first();
        
        if (!empty($get_data)) {
            return  $get_data;
        }
            if (true) {
                // success query
                $bookingData = Cart::where('uniqueid', $tnxid )->first();
                $getsession = json_decode($bookingData['getsession'], true);
                $AddPassengerDetailsBody = [
                    "ClientCode" => "MakeTrueTrip",
                    "SessionID" => $getsession['SessionID'],
                    "Key" => $getsession['Key'],
                    "ReferenceNo" => $getsession['ReferenceNo'],
                    "CustomerInfo" => [
                        "Email" => $bookingData['email'] ?? "customercare@wagnistrip.com",
                        "Mobile" => $bookingData['phonenumber'] ?? "+917669988012",
                        "Address" => "No. 5-b/13, Land Area Measuring 200Sq. YDS., Tilak Nagar, New Delhi (India) Pin: 110018",
                        "City" => "Delhi",
                        "State" => "Delhi",
                        "CountryCode" => "IN",
                        "CountryName" => "India",
                        "ZipCode" => "110018",
                        "PassengerDetails" => json_decode($bookingData['travllername'], true),
                        "PassengerTicketDetails" => [],
                        "Payment" => (object) [],
                    ],
                    "SSRInfo" => [],
                    "TotalAmount" => "0",
                    "SSRAmount" => 0,
                    "Discount" => 0,
                    "GrandTotalFare" => "0",
                    "IsGSTProvided" => false,
                ];
                $AddPassengerDetails = AuthenticateController::callApiWithHeadersGal("AddPassengerDetails", $AddPassengerDetailsBody);
                //var_dump($AddPassengerDetails);
                $BookingBody = [
                    "ClientCode" => "MakeTrueTrip",
                    "SessionID" => $getsession['SessionID'],
                    "Key" => $getsession['Key'],
                    "ReferenceNo" => $getsession['ReferenceNo'],
                    "Provider" => $getsession['Provider'],
                ];
                $Booking = AuthenticateController::callApiWithHeadersGal("Booking", $BookingBody);
                if (isset($Booking['Status'])) {
                    $TicketBody = [
                        "ClientCode" => "MakeTrueTrip",
                        "SessionID" => $getsession['SessionID'],
                        "Key" => $AddPassengerDetails['Key'],
                        "ReferenceNo" => $AddPassengerDetails['ReferenceNo'],
                        "Provider" => $getsession['Provider'],
                    ];
                    $Ticket = AuthenticateController::callApiWithHeadersGal("Ticket", $TicketBody);
                    if (isset($Ticket['Status'])) {
                        $getBookingBody = [
                            "ClientCode" => "MakeTrueTrip",
                            "SessionID" => $getsession['SessionID'],
                            "Key" => $AddPassengerDetails['Key'],
                            "ReferenceNo" => $AddPassengerDetails['ReferenceNo'],
                            "PnrNo" => "",
                            "Provider" => $getsession['Provider'],
                            "FirstName" => "",
                            "LastName" => "",
                            "From" => "",
                            "To" => "",
                        ];
                        $getBooking = AuthenticateController::callApiWithHeadersGal("GetBookingDetails", $getBookingBody);
                       
                        if(($getBooking['Status'] == "Hold") || ($getBooking['Status'] == 'Success')){
                            if($showprice == "checked"){
                                 $FareInformation[] = [
                                        "PaxType" =>  '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>"XXXXXX",
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                                    ];
                            $FareInformationA[] = [
                                        "PaxType" =>  '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>$getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare'] ?? '',
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                                    ];
                            }
                            
                            if($showprice == "unchecked"){
                                  $FareInformation[] = [
                                        "PaxType" =>  '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>$getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare'] ?? '',
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                                    ];
                            $FareInformationA[] = [
                                        "PaxType" =>  '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>$getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare'] ?? '',
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                                    ];
                            }
                           
                            $saveBooking = new AgentBooking;
                            $logs_id = GalileoFlightLog::where('session_id', '=', $getsession['SessionID'])->first('id');
                            $userId = User::where('phone', $bookingData['phonenumber'])->orWhere('email', $bookingData['email'])->first('id');

                            if (empty($userId->id)) {
                                $user = new User;
                                $user->name = json_encode($bookingData['name']);
                                $user->email = strtolower($bookingData['email']);
                                $user->phone = $bookingData['phonenumber'];
                                $user->password = Hash::make("WtUser@123");
                                $user->save();
                                $userId = $user->id;
                            } else {
                                $userId = $userId->id;
                            }
                            $saveBooking->booking_from = "GALILEO" . $getBooking['Status']??'Dev';
                            $saveBooking->booking_id =$tnxid;
                            $saveBooking->trip = $getBooking['AirBookingResponse'][0]['Trip'] ?? "0";
                            $saveBooking->trip_type = $getBooking['AirBookingResponse'][0]['TripType'] ?? "0";
                            $saveBooking->trip_stop = "0-Stop";
                            $saveBooking->gds_pnr = $getBooking['AirBookingResponse'][0]['PNR'] ??  " ";
                            $saveBooking->airline_pnr = $getBooking['AirBookingResponse'][0]['FlightDetails'][0]['AirLinePNR'] ?? ' ';
                            $saveBooking->email = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Email'] ?? strtolower($bookingData['email']) ;
                            $saveBooking->mobile = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Mobile'] ?? $bookingData['phonenumber'] ;
                            $saveBooking->itinerary = json_encode($getBooking['AirBookingResponse'][0]['FlightDetails'], true);
                                
                            
                            $saveBooking->baggage = json_encode([[
                                        'CabIn' =>  $getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'][0]['BaggageAllowance']?? '',
                                        'CheckIn' => '7KG'
                            ]], true);
                            $saveBooking->passenger = json_encode($getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'], true);
                            $saveBooking->fare = json_encode($FareInformation, true);
                            $saveBooking->A = json_encode($FareInformationA, true);
                            // $saveBooking->fare = json_encode($getBooking['AirBookingResponse'][0]['FareDetails'], true);
                            $saveBooking->status = $getBooking['AirBookingResponse'][0]['BookingStatus'];
                            $saveBooking->logs_id = $logs_id->id;
                            $saveBooking->user_id = $userId;
                            
                            $Agent = Session()->get("Agent");
                            $saveBooking->B = $Agent->email;
                            $saveBooking->C = "C";
                            
                            $saveBooking->save();
                            
                            $bookings['bookings'] = $saveBooking;
                                            
                            $bookings['email'] =  $saveBooking->email ??$bookingData['email'] ?? 'customercare@wagnistrip.com';
                            $bookings['title'] =   "Flight Ticket ".json_encode($bookingData['name'])??'';
                            
                            $files = PDF::loadView('flight-pages.booking-confirm.oneway-gal-flight-booking-confirm-pdf', $bookings);
                                            
                            \Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function($message)use( $bookings ,$files) {
                                                $message->to("customercare@wagnistrip.com")
                                                        ->subject( $bookings['title'])
                                                        ->attachData($files->output(), $bookings['title'].".pdf");
                            });  
                            \Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function($message)use( $bookings ,$files) {
                                                $message->to($bookings['email'])
                                                        ->subject( $bookings['title'])
                                                        ->attachData($files->output(), $bookings['title'].".pdf");
                            });  
                            $date  = $time = '';
                            foreach (json_decode($saveBooking->itinerary) as $key => $itinerary){
                                if($key == 0){
                                    $date =  NOgetDateFormat_db($itinerary->DepartDateTime)?? "" ;
                                    // $date2 =  getDate_fn($itinerary->DepartDate) ?? date('d-m-Y', strtotime($itinerary->DepartDate)) ;
                                    $time =  date('H:i', strtotime($itinerary->DepartDateTime)) ;
                                }
                            }
                            $from = json_decode($saveBooking->itinerary)[0]->DepartCityName ?? json_decode($saveBooking->itinerary)->DepartCityName ?? '';
                            $to = json_decode($saveBooking->itinerary)[count(json_decode($saveBooking->itinerary))-1]->ArrivalCityName ?? json_decode($saveBooking->itinerary)->ArrivalCityName ?? '';
                            foreach (json_decode($saveBooking->passenger) as $passenger){}
                            $name = $passenger->FirstName ?? "customer";
                            $name =  preg_replace('/\s+/', '%20', $name);
                            
                            $PhoneTo = $saveBooking->mobile;
                            $PhoneTo =  preg_replace('/\s+/', '%20', $PhoneTo);
                            
                            $from = AirportiatacodesController::getCity($from);
                            $from =  preg_replace('/\s+/', '%20', $from);
                            
                            $to = AirportiatacodesController::getCity($to);
                            $to =  preg_replace('/\s+/', '%20', $to);
                            
                            $pnr = $saveBooking->gds_pnr;
                            $pnr =  preg_replace('/\s+/', '%20', $pnr);
                            
                            // $date = "03-May-2023";
                            $Time = preg_replace('/\s+/', '%20', $time);
                            $date =  preg_replace('/\s+/', '%20', $date);
                            
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://app-vcapi.smscloud.in/fe/api/v1/send?username=wagnistrip.api&apiKey=eRXjt4GR3ekxHwYHTSRRC1uCgvjU2gbV&unicode=false&from=WAGNIS&to='.$PhoneTo.'&text=Dear%20'.$name.',%20We%27re%20Happy%20to%20Confirm%20your%20Booking.%20PNR-'.$pnr.'%20from%20'.$from.'%20to%20'.$to.'%20at%20'.$date.'%20'.$Time.'.%20For%20any%20query%20click%20https://wagnistrip.com',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'GET',
                            ));
                            $response = curl_exec($curl);
                            curl_close($curl);
                            
                            

                            return  $saveBooking;
                            
                            
                            
                        }else{
                            return redirect()->route('error')->with('msg', "Your Booking Has Been " . $getBooking['Status'] . "! , Kindly contact on this toll free number 08069145571 for further concern.");
                        }
                    } else {
                        return redirect()->route('error')->with('msg', "Your Booking Has Been " . $Ticket['Status'] . "! ,Kindly contact on this toll free number 08069145571 for further concern.");
                    }
                } else {
                    return redirect()->route('error')->with('msg', "Your Ticket Booking Faild.Kindly contact on this toll free number 08069145571 for further concern.");
                }
            } else {
                return redirect()->route('error')->with('msg', "Payment unsuccessful please click here to search agen. Kindly contact on this toll free number 08069145571 for further concern.");
            }
    }
    public function Ticketing(Request $request) {
        $input = $request->all();
        
        if($input['mode']== "DC"){
            $input['amount'] = $input['amount'] - (($input['amount']*0.99)/100)  ;
        }elseif($input['mode']== "CC"){
            $input['amount'] = $input['amount'] - (($input['amount']*1.96)/100)  ;
        }
        
        $txStatus = $input['status'];

        if ($txStatus == 'success') {

            
            $bookingData = Cart::where('uniqueid', $input['txnid'])->first();
            $getsession = json_decode($bookingData['getsession'], true);
            $secretKey =  $this->SECRET_KEY;

            $AddPassengerDetailsBody = [
                "ClientCode" => 'MakeTrueTrip',
                "SessionID" => $getsession['SessionID'],
                "Key" => $getsession['Key'],
                "ReferenceNo" => $getsession['ReferenceNo'],
                "CustomerInfo" => [
                    "Email" => $bookingData['email'] ?? "customercare@wagnistrip.com",
                    "Mobile" => $bookingData['phonenumber'] ?? "+917669988012",
                    "Address" => "No. 5-b/13, Tilak Nagar",
                    "City" => "Delhi",
                    "State" => "Delhi",
                    "CountryCode" => "IN",
                    "CountryName" => "India",
                    "ZipCode" => "110018",
                    "PassengerDetails" => json_decode($bookingData['travllername'], true),
                    "PassengerTicketDetails" => [],
                    "Payment" => (object) [],
                    
                ],
                "SSRInfo" => [],
                "TotalAmount" => "0",
                "SSRAmount" => 0,
                "Discount" => 0,
                "GrandTotalFare" => "0",
                "IsGSTProvided" => false,
            ];

            $AddPassengerDetails = AuthenticateController::callApiWithHeadersGal("AddPassengerDetails", $AddPassengerDetailsBody);
            //  if ($AddPassengerDetails['Status'] == "Success") {
                
                $BookingBody = [
                    "ClientCode" => 'MakeTrueTrip',
                    "Key" => $AddPassengerDetails['Key'],
                    "SessionID" => $getsession['SessionID'],
                    "ReferenceNo" => $AddPassengerDetails['ReferenceNo'],
                    "Provider" => $getsession['Provider'],
                ];
                
                $Booking = AuthenticateController::callApiWithHeadersGal("Booking", $BookingBody);
                // dd($Booking['Status']);
                // dd($bookingData ,$AddPassengerDetailsBody , $AddPassengerDetails, $BookingBody , $Booking );
                if (isset($Booking['Status'])) {
                    
                    $TicketBody = [
                        "ClientCode" => 'MakeTrueTrip',
                        "SessionID" => $getsession['SessionID'],
                        "Key" => $AddPassengerDetails['Key'],
                        "ReferenceNo" => $AddPassengerDetails['ReferenceNo'],
                        "Provider" => $getsession['Provider'],
                    ];
                    
                    $Ticket = AuthenticateController::callApiWithHeadersGal("Ticket", $TicketBody);
                    // dd($Ticket);
                    if (isset($Ticket['Status'])) {
                        
                        $getBookingBody = [
                            "ClientCode" => 'MakeTrueTrip',
                            "SessionID" => $getsession['SessionID'],
                            "Key" => $AddPassengerDetails['Key'],
                            "ReferenceNo" => $AddPassengerDetails['ReferenceNo'],
                            "PnrNo" => "",
                            "Provider" => $getsession['Provider'],
                            "FirstName" => "",
                            "LastName" => "",
                            "From" => "",
                            "To" => "",
                        ];
                        
                        $getBooking = AuthenticateController::callApiWithHeadersGal("GetBookingDetails", $getBookingBody);
                        
                        if (($getBooking['Status'] == "Success") || ($getBooking['Status'] == "Hold")) {
                            $FareInformation[] = [
                                        "PaxType" => '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => $input['amount']?? '',
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                            ];
                            $saveBooking = new Booking;
                            $logs_id = GalileoFlightLog::where('session_id', '=', $getsession['SessionID'])->first('id');
                            $userId = User::where('phone', $bookingData['phonenumber'])->orWhere('email', $bookingData['email'])->first('id');
                            
                            if (empty($userId->id)) {
                                $user = new User;
                                $user->name = json_encode($bookingData['name']);
                                $user->email = strtolower($bookingData['email']);
                                $user->phone = $bookingData['phonenumber'];
                                $user->password = Hash::make("User@WT");
                                $user->save();
                                $userId = $user->id;
                            } else {
                                $userId = $userId->id;
                            }
                            
                            $saveBooking->booking_from = "GALILEO";
                            $saveBooking->booking_id = $input['txnid'];
                            $saveBooking->trip = $getBooking['AirBookingResponse'][0]['Trip'];
                            $saveBooking->trip_type = $getBooking['AirBookingResponse'][0]['TripType'];
                            $saveBooking->trip_stop = "0-Stop";
                            $saveBooking->gds_pnr = $getBooking['AirBookingResponse'][0]['PNR'];
                            $saveBooking->airline_pnr = $getBooking['AirBookingResponse'][0]['FlightDetails'][0]['AirLinePNR'];
                            $saveBooking->email = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Email'];
                            $saveBooking->mobile = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Mobile'];
                            $saveBooking->itinerary = json_encode($getBooking['AirBookingResponse'][0]['FlightDetails'], true);
                            // $saveBooking->baggage = json_encode($getBooking['AirBookingResponse'][0]['PaxBaggageDetails'], true);
                            $saveBooking->baggage = json_encode([[
                                        'CabIn' =>  $getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'][0]['BaggageAllowance']??'',
                                        'CheckIn' => '7KG'
                            ]], true);
                            $saveBooking->passenger = json_encode($getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'], true);
                            $saveBooking->fare = json_encode($FareInformation, true);
                            // $saveBooking->fare = json_encode($getBooking['AirBookingResponse'][0]['FareDetails'], true);
                            $saveBooking->status = $getBooking['AirBookingResponse'][0]['BookingStatus'];
                            $saveBooking->logs_id = $logs_id->id;
                            $saveBooking->user_id = $userId;
                            $saveBooking->save();
                            
                            $bookings['bookings'] = $saveBooking;
                            
                            $bookings['email'] =  $saveBooking->email ??$bookingData['email'] ?? 'customercare@wagnistrip.com';
                            $bookings['title'] =   "Flight Ticket ".json_encode($bookingData['name'])??'';
                            
                            $files = PDF::loadView('flight-pages.booking-confirm.oneway-gal-flight-booking-confirm-pdf', $bookings);
                                            
                            \Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function($message)use( $bookings ,$files) {
                                                $message->to("customercare@wagnistrip.com")
                                                        ->subject( $bookings['title'])
                                                        ->attachData($files->output(), $bookings['title'].".pdf");
                                            });
                            \Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function($message)use( $bookings ,$files) {
                                                $message->to( $bookings['email'])
                                                        ->subject( $bookings['title'])
                                                        ->attachData($files->output(), $bookings['title'].".pdf");
                                            });

                            
                            $date  = $time = '';
                            foreach (json_decode($saveBooking->itinerary) as $key => $itinerary){
                                if($key == 0){
                                    $date = NOgetDateFormat_db($itinerary->DepartDateTime)?? '';
                                    // $date2 =  getDate_fn($itinerary->DepartDate) ?? date('d-m-Y', strtotime($itinerary->DepartDate)) ;
                                    $time =  date('H:i', strtotime($itinerary->DepartDateTime)) ;
                                }
                            }
                            $from = json_decode($saveBooking->itinerary)[0]->DepartCityName ?? json_decode($saveBooking->itinerary)->DepartCityName ?? '';
                            $to = json_decode($saveBooking->itinerary)[count(json_decode($saveBooking->itinerary))-1]->ArrivalCityName ?? json_decode($saveBooking->itinerary)->ArrivalCityName ?? '';
                            foreach (json_decode($saveBooking->passenger) as $passenger){}
                            $name = $passenger->FirstName ?? "customer";
                            $name =  preg_replace('/\s+/', '%20', $name);
                             
                            $PhoneTo = $saveBooking->mobile;
                            $PhoneTo =  preg_replace('/\s+/', '%20', $PhoneTo);
                            
                            $from = AirportiatacodesController::getCity($from);
                            $from =  preg_replace('/\s+/', '%20', $from);
                            
                            $to = AirportiatacodesController::getCity($to);
                            $to =  preg_replace('/\s+/', '%20', $to);
                            
                            $pnr = $saveBooking->gds_pnr;
                            $pnr =  preg_replace('/\s+/', '%20', $pnr);
                            
                            $Time = preg_replace('/\s+/', '%20', $time);
                            $date =  preg_replace('/\s+/', '%20', $date);
                            // $date = "03-May-2023";
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://app-vcapi.smscloud.in/fe/api/v1/send?username=wagnistrip.api&apiKey=eRXjt4GR3ekxHwYHTSRRC1uCgvjU2gbV&unicode=false&from=WAGNIS&to='.$PhoneTo.'&text=Dear%20'.$name.',%20We%27re%20Happy%20to%20Confirm%20your%20Booking.%20PNR-'.$pnr.'%20from%20'.$from.'%20to%20'.$to.'%20at%20'.$date.'%20'.$Time.'.%20For%20any%20query%20click%20https://wagnistrip.com',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'GET',
                            ));
                            $response = curl_exec($curl);
                            curl_close($curl);
                            
                            
                            return view('flight-pages.booking-confirm.oneway-gal-flight-booking-confirm')->with('bookings', $saveBooking);
                        } else {
                            
                            // return view('flight-pages.booking-confirm.oneway-gal-flight-booking-confirm')->with('bookings', $saveBooking);
                            // dd($getBooking , "trip_type Get Bookings");
                            return redirect()->route('error')->with('msg', "Your Booking Has Been " . $getBooking['Status'] . "!!!, Kindly contact on this toll free number 08069145571 for further concern.");
                        }
                    } else {
                        // dd($Ticket, " This is ticketing line 368");
                        return redirect()->route('error')->with('msg', "Your Booking Has Been " . $Ticket['Status'] . "!! ,  Kindly contact on this toll free number 08069145571 for further concern.");
                    }
                } else {
                    return redirect()->route('error')->with('msg', "Your Ticket Booking Faild, Kindly contact on this toll free number 08069145571 for further concern.");
                }
                // } else {
                    //       return redirect()->route('error')->with('msg', "Passenger Data Invalid. Kindly contact on this number 7669988012 for further concern.");
                    //  }
            }else{
                return redirect()->route('error')->with('msg', "Payment unsuccessful please click here to search agen. Kindly contact on this toll free number 08069145571 for further concern.");
            }

    }



    public function DomGalBooking($tnxid, $showprice)
    {
        // dd($showprice, $tnxid);
        
            if (true) {
                
                $bookingData = Cart::where('uniqueid', $tnxid )->first();
                $getsessions = json_decode($bookingData['getsession'], true);


                
                $bookingData2 = [];
                $fare1 = 0;
                $totalBooking = [];

                for ($i = 1; $i <= 2; $i++) {
                    if ($i == 1) {
                        $getsession = [
                            "ClientCode" => 'MakeTrueTrip',
                            "SessionID" => $getsessions['SessionID']['Outbound'],
                            "Key" => $getsessions['Key']['Outbound'],
                            "ReferenceNo" => $getsessions['ReferenceNo']['Outbound'],
                            "Provider" => $getsessions['Provider']['Outbound'],
                        ];
                    } elseif ($i == 2) {
                        $getsession = [
                            "ClientCode" => 'MakeTrueTrip',
                            "SessionID" => $getsessions['SessionID']['Inbound'],
                            "Key" => $getsessions['Key']['Inbound'],
                            "ReferenceNo" => $getsessions['ReferenceNo']['Inbound'],
                            "Provider" => $getsessions['Provider']['Inbound'],
                        ];
                    }

                    $AddPassengerDetailsBody = [
                        "ClientCode" => 'MakeTrueTrip',
                        "SessionID" => $getsession['SessionID'],
                        "Key" => $getsession['Key'],
                        "ReferenceNo" => $getsession['ReferenceNo'],
                        "CustomerInfo" => [
                            "Email" => $bookingData['email'] ??  "customercare@wagnistrip.com",
                            "Mobile" => $bookingData['phonenumber'] ?? "+917669988012",
                            "Address" => "Land Area Measuring 200Sq. YDS",
                            "City" => "Delhi",
                            "State" => "Delhi",
                            "CountryCode" => "IN",
                            "CountryName" => "India",
                            "ZipCode" => "110018",
                            "PassengerDetails" => json_decode($bookingData['travllername'], true),
                            "PassengerTicketDetails" => [],
                            "Payment" => (object) [],
                        ],
                        "SSRInfo" => [],
                        "TotalAmount" => "0",
                        "SSRAmount" => 0,
                        "Discount" => 0,
                        "GrandTotalFare" => "0",
                        "IsGSTProvided" => false,
                    ];
                    
                    $AddPassengerDetails = AuthenticateController::callApiWithHeadersGal("AddPassengerDetails", $AddPassengerDetailsBody);
                    
                    if ($AddPassengerDetails['Status'] == "Success") {
                    $BookingBody = [
                        "ClientCode" => 'MakeTrueTrip',
                        "SessionID" => $getsession['SessionID'],
                        "Key" => $AddPassengerDetails['Key'],
                        "ReferenceNo" => $AddPassengerDetails['ReferenceNo'],
                        "Provider" => $getsession['Provider'],
                    ];

                    $Booking = AuthenticateController::callApiWithHeadersGal("Booking", $BookingBody);

                    if (isset($Booking['Status'])) {

                        $TicketBody = [
                            "ClientCode" => 'MakeTrueTrip',
                            "SessionID" => $getsession['SessionID'],
                            "Key" => $AddPassengerDetails['Key'],
                            "ReferenceNo" => $AddPassengerDetails['ReferenceNo'],
                            "Provider" => $getsession['Provider'],
                        ];

                        $Ticket = AuthenticateController::callApiWithHeadersGal("Ticket", $TicketBody);

                        if (isset($Ticket['Status'])) {

                            $getBookingBody = [
                                "ClientCode" => 'MakeTrueTrip',
                                "SessionID" => $getsession['SessionID'],
                                "Key" => $AddPassengerDetails['Key'],
                                "ReferenceNo" => $AddPassengerDetails['ReferenceNo'],
                                "PnrNo" => "",
                                "Provider" => $getsession['Provider'],
                                "FirstName" => "",
                                "LastName" => "",
                                "From" => "",
                                "To" => "",
                            ];

                            $getBooking = AuthenticateController::callApiWithHeadersGal("GetBookingDetails", $getBookingBody);

                            $saveBooking = new AgentBooking;
                            
                            if  (($getBooking['Status'] == "Hold")|| ($getBooking['Status'] == "Success")) {
                                
                                $amount = session('totalAmount') ?? session('total_fare');
                                if($showprice == "checked"){
                                    $FareInformationA[] = [
                                        "PaxType" =>  '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => $amount ?? '',
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                                    ];
                                    
                                     $FareInformation[] = [
                                        "PaxType" =>  '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => "XXXXXX",
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                                    ];
                                }
                                
                                if($showprice == "unchecked"){
                                    $FareInformationA[] = [
                                        "PaxType" =>  '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => $amount ?? '',
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                                    ];
                                    
                                     $FareInformation[] = [
                                        "PaxType" =>  '',
                                        "PaxBaseFare" => '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => $amount ?? '',
                                        "PaxDiscount" => 0,
                                        "PaxCashBack" => 0,
                                        "PaxTDS" => 0,
                                        "PaxServiceTax" => 0,
                                        "PaxTransactionFee" => 0,
                                        "TravelFee" => 0,
                                        "Discount" => 0,
                                        "K3" => 265,
                                        "CGST" => 0,
                                        "SGST" => 0,
                                        "IGST" => 0,
                                        "UTGST" => 0,
                                    ];
                                }
                               
                                
                                $logs_id = GalileoFlightLog::where('session_id', '=', $getsession['SessionID'])->first('id');

                                $userId = User::where('phone', $bookingData['phonenumber'])->orWhere('email', $bookingData['email'])->first('id');

                                if (empty($userId->id)) {
                                    $user = new User;
                                    $user->name = json_encode($bookingData['name']);
                                    $user->email = strtolower($bookingData['email']);
                                    $user->phone = $bookingData['phonenumber'];
                                    $user->password = Hash::make("User@WT");
                                    $user->save();
                                    $userId = $user->id;
                                } else {
                                    $userId = $userId->id;
                                }
                                $saveBooking->booking_from = "GALILEO";
                                $saveBooking->booking_id =$tnxid;
                                $saveBooking->trip = $getBooking['AirBookingResponse'][0]['Trip'];
                                $saveBooking->trip_type = $getBooking['AirBookingResponse'][0]['TripType'];
                                $saveBooking->trip_stop = "0-Stop";
                                $saveBooking->gds_pnr = $getBooking['AirBookingResponse'][0]['PNR'];
                                $saveBooking->airline_pnr = $getBooking['AirBookingResponse'][0]['FlightDetails'][0]['AirLinePNR'];
                                $saveBooking->email = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Email'];
                                $saveBooking->mobile = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Mobile'];
                                $saveBooking->itinerary = json_encode($getBooking['AirBookingResponse'][0]['FlightDetails'], true);
                                // $saveBooking->baggage = json_encode($getBooking['AirBookingResponse'][0]['PaxBaggageDetails'], true);
                                $saveBooking->baggage = json_encode([[
                                        'CabIn' =>  $getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'][0]['BaggageAllowance']??'',
                                        'CheckIn' => '7KG'
                                ]], true);
                                $saveBooking->passenger = json_encode($getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'], true);
                                $saveBooking->fare = json_encode($FareInformation, true);
                                $saveBooking->A = json_encode($FareInformationA, true);
                                // $saveBooking->fare = json_encode($getBooking['AirBookingResponse'][0]['FareDetails'], true);
                                $saveBooking->status = $getBooking['AirBookingResponse'][0]['BookingStatus'];
                                $saveBooking->logs_id = $logs_id->id;
                                $saveBooking->user_id = $userId;
                                 $Agent = Session()->get("Agent");
                                $saveBooking->B = $Agent->email;
                                $saveBooking->C = "C";
                                $saveBooking->save();
                                
                                if ($i == 1) {
                                    $bookingData2 = $saveBooking;
                                    $fare1 = $getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare']??'';
                                }
                                if ($i == 2) {
                                    $bookings['bookings'] = $saveBooking;
                                    $bookings['email'] =  $saveBooking->email ?? $bookingData['email']?? 'customercare@wagnistrip.com';
                                    $bookings['title'] =   "Flight Ticket ".json_encode($bookingData['name'])??'';
                                    
                                    $files = PDF::loadView('flight-pages.booking-confirm.roundtrip-gal-flight-booking-confirm-pdf', $bookings);
                                            
                                    \Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function($message)use( $bookings ,$files) {
                                        $message->to("customercare@wagnistrip.com")
                                                ->subject( $bookings['title'])
                                                ->attachData($files->output(), $bookings['title'].".pdf");
                                    });
                                            
                                    \Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function($message)use( $bookings ,$files) {
                                        $message->to($bookings['email'])
                                            ->subject( $bookings['title'])
                                            ->attachData($files->output(), $bookings['title'].".pdf");
                                    });
                                    $date  = $time = '';
                                    foreach (json_decode($saveBooking->itinerary) as $key => $itinerary){
                                        if($key == 0){
                                            $date =  NOgetDateFormat_db($itinerary->DepartDateTime) ;
                                            
                                            $time =  date('H:i', strtotime($itinerary->DepartDateTime)) ;
                                        }
                                    }
                                    $from = json_decode($saveBooking->itinerary)[0]->DepartCityName ?? json_decode($saveBooking->itinerary)->DepartCityName ?? '';
                                    $to = json_decode($saveBooking->itinerary)[count(json_decode($saveBooking->itinerary))-1]->ArrivalCityName ?? json_decode($saveBooking->itinerary)->ArrivalCityName ?? '';
                                    foreach (json_decode($saveBooking->passenger) as $passenger){}
                                    
                                    $name = $passenger->FirstName ?? "customer";
                                    $name =  preg_replace('/\s+/', '%20', $name);
                                    
                                    $PhoneTo = $saveBooking->mobile;
                                    $PhoneTo =  preg_replace('/\s+/', '%20', $PhoneTo);
                                    
                                    $from = AirportiatacodesController::getCity($from);
                                    $from =  preg_replace('/\s+/', '%20', $from);
                                    
                                    $to = AirportiatacodesController::getCity($to);
                                    $to =  preg_replace('/\s+/', '%20', $to);
                                    
                                    $pnr = $saveBooking->gds_pnr;
                                    $pnr =  preg_replace('/\s+/', '%20', $pnr);
                                    
                                    
                                    $Time = preg_replace('/\s+/', '%20', $time);
                                    $date =  preg_replace('/\s+/', '%20', $date);
                                    
                                    $curl = curl_init();
                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => 'https://app-vcapi.smscloud.in/fe/api/v1/send?username=wagnistrip.api&apiKey=eRXjt4GR3ekxHwYHTSRRC1uCgvjU2gbV&unicode=false&from=WAGNIS&to='.$PhoneTo.'&text=Dear%20'.$name.',%20We%27re%20Happy%20to%20Confirm%20your%20Booking.%20PNR-'.$pnr.'%20from%20'.$from.'%20to%20'.$to.'%20at%20'.$date.'%20'.$Time.'.%20For%20any%20query%20click%20https://wagnistrip.com',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                    ));
                                    $response = curl_exec($curl);
                                    curl_close($curl);
                                    
                                    $both = [
                                        'FristpnrRetrieve'=>$saveBooking , 
                                        'book'=>$bookingData2 ,
                                    ];
                                    
                                    return  $both;
                                }
                                
                                }else{
                                    return redirect()->route('error')->with('msg', "Your Booking Has Been " . $Ticket['Status'] . "!! , Kindly contact on this toll free number 08069145571 for further concern.");
                                    
                                }
                            } else {
                                return redirect()->route('error')->with('msg', "Your Booking Has Been " . $Ticket['Status'] . "!, Kindly contact on this toll free number 08069145571 for further concern.");
                            }
                        } else {
                            return redirect()->route('error')->with('msg', "Your Ticket Booking Faild. Kindly contact on this toll free number 08069145571 for further concern.");
                        }
                    } else {
                    
                        return redirect()->route('error')->with('msg', "Passenger Data Invalid. Kindly contact on this toll free number 08069145571 for further concern.");
                    }
                }
            }else {
            return redirect()->route('error')->with('msg', "Payment unsuccessful please click here to search again. Kindly contact on this toll free number 08069145571 for further concern.");
        }
    }
}
