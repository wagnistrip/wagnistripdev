<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Airline\{AirPortIATACodesController ,Galileo\AuthenticateController};
use App\Http\Controllers\Controller;
use App\Models\{Booking, Cart, GalileoFlightLog, User};
use Illuminate\Support\Facades\{Hash ,Mail};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
class TicketingController extends Controller
{
    public $APP_ID;
    public $SECRET_KEY;
    public function __construct()
    {
        $this->APP_ID = config('services.cashfree.key');
        $this->SECRET_KEY = config('services.cashfree.secret');
    }

    public function getTicketDetails(Request $request)
    {
        $TicketBody = [
            "ClientCode" => "MakeTrueTrip",
            "SessionID" => $request['SessionID'],
            "Key" => $request['Key'],
            "ReferenceNo" => $request['ReferenceNo'],
            "Provider" => $request['Provider'],
        ];
        $Ticket = AuthenticateController::callApiWithHeadersGal("Ticket", $TicketBody);

        return response()->json($Ticket);
    }

    public function ReturnUrl(Request $request)
    {
        $buzz = $request->all();
        if ($buzz['mode'] == "DC") {
            $buzz['amount'] = $buzz['amount'] - (($buzz['amount'] * 0.99) / 100);
        } elseif ($buzz['mode'] == "CC") {
            $buzz['amount'] = $buzz['amount'] - (($buzz['amount'] * 1.96) / 100);
        }
        // dd($request , $buzz, $buzz['mode']);
        $orderId = $request['txnid'];
        $get_data = Booking::where('booking_id', $orderId)->first();

        if (!empty($get_data)) {
            return view('flight-pages.booking-confirm.oneway-gal-flight-booking-confirm')->with('bookings', $get_data);
        }
        // dd($buzz['amount']);
        $orderAmount = $request->orderAmount;
        $referenceId = $request->referenceId;
        $txStatus = $request->txStatus;
        $paymentMode = $request->paymentMode;
        $txMsg = $request->txMsg;
        $txTime = $request->txTime;
        $signature = $request->signature;
        $secretkey = $this->SECRET_KEY;
        $data = $orderId . $orderAmount . $referenceId . $txStatus . $paymentMode . $txMsg . $txTime;
        $hash_hmac = hash_hmac('sha256', $data, $secretkey, true);
        $computedSignature = base64_encode($hash_hmac);
        // if ($signature == $computedSignature) {
        if ($buzz['status'] == 'success') {
            // success query
            $input = $request->all();
            $bookingData = Cart::where('uniqueid', $input['txnid'])->first();
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

                    // dd($getBooking);
                    if (($getBooking['Status'] == "Hold") || ($getBooking['Status'] == 'Success')) {

                        $FareInformation[] = [
                            "PaxType" =>  '',
                            "PaxBaseFare" => '',
                            "PaxFuelSurcharge" => 0,
                            "PaxOtherTax" => 0,
                            "PaxTotalFare" => $buzz['amount'] ?? '',
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
                            $user->password = Hash::make("WtUser@123");
                            $user->save();
                            $userId = $user->id;
                        } else {
                            $userId = $userId->id;
                        }
                        $saveBooking->booking_from = "GALILEO" . $getBooking['Status'] ?? 'Dev';
                        $saveBooking->booking_id = $input['txnid'];
                        $saveBooking->trip = $getBooking['AirBookingResponse'][0]['Trip'] ?? "0";
                        $saveBooking->trip_type = $getBooking['AirBookingResponse'][0]['TripType'] ?? "0";
                        $saveBooking->trip_stop = "0-Stop";
                        $saveBooking->gds_pnr = $getBooking['AirBookingResponse'][0]['PNR'] ??  " ";
                        $saveBooking->airline_pnr = $getBooking['AirBookingResponse'][0]['FlightDetails'][0]['AirLinePNR'] ?? ' ';
                        $saveBooking->email = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Email'] ?? strtolower($bookingData['email']);
                        $saveBooking->mobile = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Mobile'] ?? $bookingData['phonenumber'];
                        $saveBooking->itinerary = json_encode($getBooking['AirBookingResponse'][0]['FlightDetails'], true);


                        $saveBooking->baggage = json_encode([[
                            'CabIn' =>  $getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'][0]['BaggageAllowance'] ?? '',
                            'CheckIn' => '7KG'
                        ]], true);
                        $saveBooking->passenger = json_encode($getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'], true);
                        $saveBooking->fare = json_encode($FareInformation, true);
                        // $saveBooking->fare = json_encode($getBooking['AirBookingResponse'][0]['FareDetails'], true);
                        $saveBooking->status = $getBooking['AirBookingResponse'][0]['BookingStatus'];
                        $saveBooking->logs_id = $logs_id->id;
                        $saveBooking->user_id = $userId;
                        $saveBooking->save();
                        // dd($saveBooking);
                        // dd($saveBooking , $getBooking['AirBookingResponse'][0]);
                        $bookings['bookings'] = $saveBooking;

                        $bookings['email'] =  $saveBooking->email ?? $bookingData['email'] ?? 'customercare@wagnistrip.com';
                        $bookings['title'] =   "Flight Ticket " . json_encode($bookingData['name']) ?? '';

                        $files = PDF::loadView('flight-pages.booking-confirm.oneway-gal-flight-booking-confirm-pdf', $bookings);

                        Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function ($message) use ($bookings, $files) {
                            $message->to("customercare@wagnistrip.com")
                                ->subject($bookings['title'])
                                ->attachData($files->output(), $bookings['title'] . ".pdf");
                        });
                        Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function ($message) use ($bookings, $files) {
                            $message->to($bookings['email'])
                                ->subject($bookings['title'])
                                ->attachData($files->output(), $bookings['title'] . ".pdf");
                        });

                        $date  = $time = '';
                        foreach (json_decode($saveBooking->itinerary) as $key => $itinerary) {
                            if ($key == 0) {
                                $date =  NOgetDateFormat_db($itinerary->DepartDateTime) ?? "";
                                // $date2 =  getDate_fn($itinerary->DepartDate) ?? date('d-m-Y', strtotime($itinerary->DepartDate)) ;
                                $time =  date('H:i', strtotime($itinerary->DepartDateTime));
                            }
                        }
                        $from = json_decode($saveBooking->itinerary)[0]->DepartCityName ?? json_decode($saveBooking->itinerary)->DepartCityName ?? '';
                        $to = json_decode($saveBooking->itinerary)[count(json_decode($saveBooking->itinerary)) - 1]->ArrivalCityName ?? json_decode($saveBooking->itinerary)->ArrivalCityName ?? '';
                        foreach (json_decode($saveBooking->passenger) as $passenger) {
                        }
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
                            CURLOPT_URL => 'https://app-vcapi.smscloud.in/fe/api/v1/send?username=wagnistrip.api&apiKey=eRXjt4GR3ekxHwYHTSRRC1uCgvjU2gbV&unicode=false&from=WAGNIS&to=' . $PhoneTo . '&text=Dear%20' . $name . ',%20We%27re%20Happy%20to%20Confirm%20your%20Booking.%20PNR-' . $pnr . '%20from%20' . $from . '%20to%20' . $to . '%20at%20' . $date . '%20' . $Time . '.%20For%20any%20query%20click%20https://wagnistrip.com',
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
                        // dd($getBooking , $Booking, $AddPassengerDetails, "get Booking line 168 ");
                        return redirect()->route('error')->with('msg', "Your Booking Has Been " . $getBooking['Status'] . "! , Kindly contact on this toll free number 08069145571 for further concern.");
                    }
                } else {
                    // dd($Ticket ,  'Ticketing line 172 ticketingController');
                    return redirect()->route('error')->with('msg', "Your Booking Has Been " . $Ticket['Status'] . "! ,Kindly contact on this toll free number 08069145571 for further concern.");
                }
            } else {
                return redirect()->route('error')->with('msg', "Your Ticket Booking Faild.Kindly contact on this toll free number 08069145571 for further concern.");
            }
        } else {
            // rejected query
            //Cart::where('id', $uniqueid)->update(['uniqueid' => 2]);
            return redirect()->route('error')->with('msg', "Payment unsuccessful please click here to search agen. Kindly contact on this toll free number 08069145571 for further concern.");
        }
        // } else {
        //     return redirect()->route('error')->with('msg', "Signature not match");
        // }
    }
    public function Ticketing(Request $request)
     {
        $input = $request->all();

        if ($input['mode'] == "DC") {
            $input['amount'] = $input['amount'] - (($input['amount'] * 0.99) / 100);
        } elseif ($input['mode'] == "CC") {
            $input['amount'] = $input['amount'] - (($input['amount'] * 1.96) / 100);
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
                            "PaxTotalFare" => $input['amount'] ?? '',
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
                            'CabIn' =>  $getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'][0]['BaggageAllowance'] ?? '',
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

                        $bookings['email'] =  $saveBooking->email ?? $bookingData['email'] ?? 'customercare@wagnistrip.com';
                        $bookings['title'] =   "Flight Ticket " . json_encode($bookingData['name']) ?? '';

                        $files = PDF::loadView('flight-pages.booking-confirm.oneway-gal-flight-booking-confirm-pdf', $bookings);

                        Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function ($message) use ($bookings, $files) {
                            $message->to("customercare@wagnistrip.com")
                                ->subject($bookings['title'])
                                ->attachData($files->output(), $bookings['title'] . ".pdf");
                        });
                        Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function ($message) use ($bookings, $files) {
                            $message->to($bookings['email'])
                                ->subject($bookings['title'])
                                ->attachData($files->output(), $bookings['title'] . ".pdf");
                        });


                        $date  = $time = '';
                        foreach (json_decode($saveBooking->itinerary) as $key => $itinerary) {
                            if ($key == 0) {
                                $date = NOgetDateFormat_db($itinerary->DepartDateTime) ?? '';
                                // $date2 =  getDate_fn($itinerary->DepartDate) ?? date('d-m-Y', strtotime($itinerary->DepartDate)) ;
                                $time =  date('H:i', strtotime($itinerary->DepartDateTime));
                            }
                        }
                        $from = json_decode($saveBooking->itinerary)[0]->DepartCityName ?? json_decode($saveBooking->itinerary)->DepartCityName ?? '';
                        $to = json_decode($saveBooking->itinerary)[count(json_decode($saveBooking->itinerary)) - 1]->ArrivalCityName ?? json_decode($saveBooking->itinerary)->ArrivalCityName ?? '';
                        foreach (json_decode($saveBooking->passenger) as $passenger) {
                        }
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
                            CURLOPT_URL => 'https://app-vcapi.smscloud.in/fe/api/v1/send?username=wagnistrip.api&apiKey=eRXjt4GR3ekxHwYHTSRRC1uCgvjU2gbV&unicode=false&from=WAGNIS&to=' . $PhoneTo . '&text=Dear%20' . $name . ',%20We%27re%20Happy%20to%20Confirm%20your%20Booking.%20PNR-' . $pnr . '%20from%20' . $from . '%20to%20' . $to . '%20at%20' . $date . '%20' . $Time . '.%20For%20any%20query%20click%20https://wagnistrip.com',
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
        } else {
            return redirect()->route('error')->with('msg', "Payment unsuccessful please click here to search agen. Kindly contact on this toll free number 08069145571 for further concern.");
        }
    }

   public function DomGalBooking(Request $request)
    {
        ////////////////////////////// udd.
        $paymentData = $request->all();

        if ($paymentData['mode'] == "DC") {
            $paymentData['amount'] = $paymentData['amount'] - (($paymentData['amount'] * 0.99) / 100);
        } elseif ($paymentData['mode'] == "CC") {
            $paymentData['amount'] = $paymentData['amount'] - (($paymentData['amount'] * 1.96) / 100);
        }
        // dd($paymentData);
        $txStatus = $paymentData['status'];
        // if ($signature == $computedSignature) {
        if ($txStatus == 'success') {
            // success query
            $input = $request->all();
            $bookingData = Cart::where('uniqueid', $input['txnid'])->first();
            $getsessions = json_decode($bookingData['getsession'], true);
            // dd($input,$bookingData,$getsessions);
            $bookingData2 = [];
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
                // dd();
                $AddPassengerDetails = AuthenticateController::callApiWithHeadersGal("AddPassengerDetails", $AddPassengerDetailsBody);
                // dd($AddPassengerDetails ,$AddPassengerDetailsBody);
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
                            $saveBooking = new Booking;
                            if (($getBooking['Status'] == "Hold") || ($getBooking['Status'] == "Success")) {
                                $FareInformation[] = [
                                    "PaxType" =>  '',
                                    "PaxBaseFare" => '',
                                    "PaxFuelSurcharge" => 0,
                                    "PaxOtherTax" => 0,
                                    "PaxTotalFare" => $paymentData['amount'] ?? '',
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
                                    'CabIn' =>  $getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'][0]['BaggageAllowance'] ?? '',
                                    'CheckIn' => '7KG'
                                ]], true);
                                $saveBooking->passenger = json_encode($getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'], true);
                                $saveBooking->fare = json_encode($FareInformation, true);
                                // $saveBooking->fare = json_encode($getBooking['AirBookingResponse'][0]['FareDetails'], true);
                                $saveBooking->status = $getBooking['AirBookingResponse'][0]['BookingStatus'];
                                $saveBooking->logs_id = $logs_id->id;
                                $saveBooking->user_id = $userId;
                                $saveBooking->save();
                                if ($i == 1) {
                                    $bookingData2 = $saveBooking;
                                }
                                if ($i == 2) {
                                    $bookings['bookings'] = $saveBooking;
                                    $bookings['email'] =  $saveBooking->email ?? $bookingData['email'] ?? 'customercare@wagnistrip.com';
                                    $bookings['title'] =   "Flight Ticket " . json_encode($bookingData['name']) ?? '';
                                    $files = PDF::loadView('flight-pages.booking-confirm.roundtrip-gal-flight-booking-confirm-pdf', $bookings);
                                    Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function ($message) use ($bookings, $files) {
                                        $message->to("customercare@wagnistrip.com")
                                            ->subject($bookings['title'])
                                            ->attachData($files->output(), $bookings['title'] . ".pdf");
                                    });
                                    Mail::send('booking-pdf.flight.Gal-Tic-Mail', $bookings, function ($message) use ($bookings, $files) {
                                        $message->to($bookings['email'])
                                            ->subject($bookings['title'])
                                            ->attachData($files->output(), $bookings['title'] . ".pdf");
                                    });
                                    $date  = $time = '';
                                    foreach (json_decode($saveBooking->itinerary) as $key => $itinerary) {
                                        if ($key == 0) {
                                            $date =  NOgetDateFormat_db($itinerary->DepartDateTime);
                                            // $date2 =  getDate_fn($itinerary->DepartDate) ?? date('d-m-Y', strtotime($itinerary->DepartDate)) ;
                                            $time =  date('H:i', strtotime($itinerary->DepartDateTime));
                                        }
                                    }
                                    $from = json_decode($saveBooking->itinerary)[0]->DepartCityName ?? json_decode($saveBooking->itinerary)->DepartCityName ?? '';
                                    $to = json_decode($saveBooking->itinerary)[count(json_decode($saveBooking->itinerary)) - 1]->ArrivalCityName ?? json_decode($saveBooking->itinerary)->ArrivalCityName ?? '';
                                    foreach (json_decode($saveBooking->passenger) as $passenger) {
                                    }
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
                                        CURLOPT_URL => 'https://app-vcapi.smscloud.in/fe/api/v1/send?username=wagnistrip.api&apiKey=eRXjt4GR3ekxHwYHTSRRC1uCgvjU2gbV&unicode=false&from=WAGNIS&to=' . $PhoneTo . '&text=Dear%20' . $name . ',%20We%27re%20Happy%20to%20Confirm%20your%20Booking.%20PNR-' . $pnr . '%20from%20' . $from . '%20to%20' . $to . '%20at%20' . $date . '%20' . $Time . '.%20For%20any%20query%20click%20https://wagnistrip.com',
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
                                        'FristpnrRetrieve' => $saveBooking,
                                        'book' => $bookingData2,
                                    ];

                                    return view('flight-pages.booking-confirm.Round-Gal-Dom')->with('bookings', $both);
                                }
                            } else {
                                // dd($getBooking);
                                return redirect()->route('error')->with('msg', "Your Booking Has Been " . $Ticket['Status'] . "!! , Kindly contact on this toll free number 08069145571 for further concern.");
                            }
                        } else {
                            // dd($Ticket);
                            return redirect()->route('error')->with('msg', "Your Booking Has Been " . $Ticket['Status'] . "!, Kindly contact on this toll free number 08069145571 for further concern.");
                        }
                    } else {
                        // dd($Booking);
                        return redirect()->route('error')->with('msg', "Your Ticket Booking Faild. Kindly contact on this toll free number 08069145571 for further concern.");
                    }
                } else {

                    return redirect()->route('error')->with('msg', "Passenger Data Invalid. Kindly contact on this toll free number 08069145571 for further concern.");
                }
            }
        } else {
            return redirect()->route('error')->with('msg', "Payment unsuccessful please click here to search again. Kindly contact on this toll free number 08069145571 for further concern.");
        }
    }
}
