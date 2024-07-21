<?php

namespace App\Http\Controllers\Agent\Booking\Mix;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Amadeus\Client;
use App\Models\Booking;
use App\Models\Agent\AgentBooking;
use Amadeus\Client\RequestOptions\DocIssuanceIssueTicketOptions;
use Amadeus\Client\RequestOptions\FarePricePnrWithBookingClassOptions;
use Amadeus\Client\RequestOptions\PnrAddMultiElementsOptions;
use Amadeus\Client\RequestOptions\PnrCreatePnrOptions;
use Amadeus\Client\RequestOptions\PnrRetrieveOptions;
use Amadeus\Client\RequestOptions\Pnr\Element\Contact;
use Amadeus\Client\RequestOptions\Pnr\Element\FormOfPayment;
use Amadeus\Client\RequestOptions\Pnr\Element\Ticketing;
use Amadeus\Client\RequestOptions\Pnr\Itinerary;
use Amadeus\Client\RequestOptions\Pnr\Segment;
use Amadeus\Client\RequestOptions\Pnr\Segment\Miscellaneous;
use Amadeus\Client\RequestOptions\Pnr\Traveller;
use Amadeus\Client\RequestOptions\TicketCreateTstFromPricingOptions;
use Amadeus\Client\RequestOptions\Ticket\Pricing;
use Amadeus\Client\Result;
use App\Models\Cart;
use App\Http\Controllers\Airline\AirportiatacodesController;
use App\Models\User;
use App\Models\GalileoFlightLog;
use App\Http\Controllers\Airline\Galileo\AuthenticateController;
use App\Http\Controllers\Airline\Amadeus\AmadeusHeaderController;
use Illuminate\Support\Facades\Config;
use PDF;

class BookingController extends Controller
{
    
         
    //         return view('flight-pages/booking-confirm/Mix-Dom-Round',compact('both'));
    // }
    
    public function both_email_view(Request $request){
         $bookingData1 = AgentBooking::where('id', $request['id1'])->first();
         $bookingData2 = AgentBooking::where('id', $request['id2'])->first();
         $both = [
           'FristpnrRetrieve'=>$bookingData1 , 
            'book'=>$bookingData2 ,
        ];
        $bookings['both'] = $both;
        $bookings['email'] =  $email??$useremail[0]?? '';
        return view('flight-pages/booking-confirm/Mix-Dom-Round-pdf',$bookings);
        return view('booking-pdf.flight.Mix_eamil_content',compact('both'));
            // return view('booking-pdf.flight.edit-roundtrip-amd-flight-booking-confirm');
    }

        public function Bookings($tnxid , $tnxid1, $showprice)
        {
            
            
        $FristpnrRetrieve =[];
        
        $Fare1 = 0;
            $bookingData = Cart::where('uniqueid', $tnxid )->first();
            
            
            $getsession = json_decode($bookingData['getsession'], true);
        
            $totalBooking = [];
                
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
                        
                        $saveBooking = new AgentBooking;
                        if ($getBooking['Status'] == "Success") {

                                $logs_id = GalileoFlightLog::where('session_id', '=', $getsession['SessionID'])->first('id');

                                $userId = User::where('phone', $bookingData['phonenumber'])->orWhere('email', $bookingData['email'])->first('id');

                                if (empty($userId->id)) {
                                    $user = new User;
                                    $user->name = json_encode($bookingData['name']);
                                    $user->email = strtolower($bookingData['email']);
                                    $user->phone = $bookingData['phonenumber'];
                                    $user->password = Hash::make("User@WT123");
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
                                            'CheckIn' => '7KG',
                                ]], true);
                                $saveBooking->passenger = json_encode($getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'], true);
                                $saveBooking->fare = "XXXXXX" ?? json_encode($getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare'], true);
                                $saveBooking->A =  json_encode($getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare'], true);
                                $saveBooking->status = $getBooking['AirBookingResponse'][0]['BookingStatus'];
                                $saveBooking->logs_id = $logs_id->id;
                                $saveBooking->user_id = $userId;
                                 $Agent = Session()->get("Agent");
                                $saveBooking->B = $Agent->email;
                                $saveBooking->C = "C";
                                $saveBooking->save();

                                
                            } elseif  ($getBooking['Status'] == "Hold") {
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
                                $saveBooking->booking_id = $tnxid;
                                $saveBooking->trip = $getBooking['AirBookingResponse'][0]['Trip'];
                                $saveBooking->trip_type = $getBooking['AirBookingResponse'][0]['TripType'];
                                $saveBooking->trip_stop = "0-Stop";
                                $saveBooking->gds_pnr = $getBooking['AirBookingResponse'][0]['PNR'];
                                $saveBooking->airline_pnr = $getBooking['AirBookingResponse'][0]['FlightDetails'][0]['AirLinePNR'];
                                $saveBooking->email = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Email'];
                                $saveBooking->mobile = $getBooking['AirBookingResponse'][0]['CustomerInfo']['Mobile'];
                                $saveBooking->itinerary = json_encode($getBooking['AirBookingResponse'][0]['FlightDetails'], true);
                                $saveBooking->baggage = json_encode($getBooking['AirBookingResponse'][0]['PaxBaggageDetails'], true);
                                $saveBooking->passenger = json_encode($getBooking['AirBookingResponse'][0]['CustomerInfo']['PassengerTicketDetails'], true);
                                $saveBooking->fare = "XXXXXX" ?? json_encode($getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare'], true);
                                $saveBooking->A = json_encode($getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare'], true);
                                $saveBooking->status = $getBooking['AirBookingResponse'][0]['BookingStatus'];
                                $saveBooking->logs_id = $logs_id->id;
                                $saveBooking->user_id = $userId;
                                 $Agent = Session()->get("Agent");
                                $saveBooking->B = $Agent->email;
                                $saveBooking->C = "C";
                                
                                $saveBooking->save();
                                $Fare1 = $getBooking['AirBookingResponse'][0]['FareDetails']['TotalFare'];
                                
                                $FristpnrRetrieve = $saveBooking ;
                               
                                
                                }else{
                                    
                                    // dd($getBooking);
                                    
                                }
                     } else {
                        // dd($Ticket, " This is ticketing line 368");
                        return redirect()->route('error')->with('msg', "Your Booking Has Been " . $Ticket['Status'] . "!!, Kindly contact on this toll free number 08069145571 for further concern.");
                    }
                } else {
                    return redirect()->route('error')->with('msg', "Your Ticket Booking Faild, Kindly contact on this toll free number 08069145571 for further concern.");
                }
            
            
            //////// G A L   B O O K I N G   E N D  ///////////////////////////
            
            
            //////// A M A D E U S   B O O K I N G   S T A R T  ///////////////////////////

            
            $bookingData = Cart::where('uniqueid', $tnxid1)->first();
            $otherInformation = json_decode($bookingData['otherInformation'], true);
           
              $marketingCompany = $otherInformation['marketingCompany'] ?? $otherInformation['marketingCompany_1'] ?? $otherInformation['outbound_marketingCompany'] ?? $otherInformation['outbound_marketingCompany_1'];
              $activeTravellers = json_decode($bookingData['travllername'], true);
              $phonenumber = $bookingData['phonenumber'];
              $email = $bookingData['email'];
              $uniqueid = $bookingData['uniqueid'];
           
              $HeaderController = new AmadeusHeaderController;
              $params = $HeaderController->State(true);
              $client = new Client($params);
              $client->setSessionData(json_decode($bookingData['getsession'], true));
              $passengers = json_decode($bookingData['travellerquantity'], true);
              $phonenumber = $bookingData['phonenumber'];
              $email = $bookingData['email'];
                
                
              $travellers = [];
              $pricing = [];
           
              if ((int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] === 0) {
                  for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
           
                      $trvlrs = new Traveller([
                          'number' => $i,
                          'firstName' => $activeTravellers['adults']['fistName'][$i],
                          'lastName' => $activeTravellers['adults']['lastName'][$i],
                          'type' => 'ADT',
                      ]);
                      array_push($travellers, $trvlrs);
                 }
           
                  $pricing = new TicketCreateTstFromPricingOptions([
                    'pricings' => [
                          new Pricing([
                              'tstNumber' => 1,
                          ]),
                     ],
                  ]);
              } elseif ((int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] > 0) {
                  for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
           
                      if ($passengers['noOfInfants'] != 0 && $i < $passengers['noOfInfants']) {
                          if ($activeTravellers['adults']['fistName'][$i] == $activeTravellers['infants']['fistName'][$i] && $activeTravellers['adults']['lastName'][$i] == $activeTravellers['infants']['lastName'][$i]) {
                             $trvlrs = new Traveller([
                                  'number' => $i,
                                  'firstName' => $activeTravellers['adults']['fistName'][$i],
                                  'lastName' => $activeTravellers['adults']['lastName'][$i],
                                  'travellerType' => null,
                                 'infant' => new Traveller([
                                      'firstName' => 'Junior',
                                    'dateOfBirth' => \DateTime::createFromFormat('Y-m-d', $activeTravellers['infants']['infantDOB'][$i], new \DateTimeZone('UTC')),
                                 ]),
                              ]);
           
                       } elseif ($activeTravellers['adults']['fistName'][$i] == $activeTravellers['infants']['fistName'][$i] && $activeTravellers['adults']['lastName'][$i] != $activeTravellers['infants']['lastName'][$i]) {
                              $trvlrs = new Traveller([
                                  'number' => $i,
                                  'firstName' => $activeTravellers['adults']['fistName'][$i],
                                  'lastName' => $activeTravellers['adults']['lastName'][$i],
                                'infant' => new Traveller([
                                      'firstName' => $activeTravellers['infants']['fistName'][$i],
                                      'dateOfBirth' => \DateTime::createFromFormat('Y-m-d', $activeTravellers['infants']['infantDOB'][$i], new \DateTimeZone('UTC')),
                                  ]),
                              ]);
           
                          } else {
                              $trvlrs = new Traveller([
                                  'number' => $i,
                                  'firstName' => $activeTravellers['adults']['fistName'][$i],
                                  'lastName' => $activeTravellers['adults']['lastName'][$i],
                                  'infant' => new Traveller([
                                     'firstName' => $activeTravellers['infants']['fistName'][$i],
                                    'lastName' => $activeTravellers['infants']['lastName'][$i],
                                     'dateOfBirth' => \DateTime::createFromFormat('Y-m-d', $activeTravellers['infants']['infantDOB'][$i], new \DateTimeZone('UTC')),
                                ]),
                              ]);
           
                         }
                      } else {
                          $trvlrs = new Traveller([
                              'number' => $i,
                              'firstName' => $activeTravellers['adults']['fistName'][$i],
                              'lastName' => $activeTravellers['adults']['lastName'][$i],
                              'type' => 'ADT',
                          ]);
           
                      }
                      array_push($travellers, $trvlrs);
           
                  }
           
                  $pricing = new TicketCreateTstFromPricingOptions([
                      'pricings' => [
                         new Pricing([
                            'tstNumber' => 1,
                         ]),
                        new Pricing([
                          'tstNumber' => 2,
                          ]),
                      ],
                ]);
              } elseif ((int) $passengers['noOfChilds'] > 0 && (int) $passengers['noOfInfants'] === 0) {
           
                 for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
           
                     $trvlrs1 = new Traveller([
                        'number' => $i,
                         'firstName' => $activeTravellers['adults']['fistName'][$i],
                          'lastName' => $activeTravellers['adults']['lastName'][$i],
                         'type' => 'ADT',
                      ]);
                     array_push($travellers, $trvlrs1);
               }
                  for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
           
                      $trvlrs2 = new Traveller([
                         'number' => array_sum([$passengers['noOfAdults'], $i]),
                          'firstName' => $activeTravellers['childs']['fistName'][$i],
                         'lastName' => $activeTravellers['childs']['lastName'][$i],
                        'travellerType' => Traveller::TRAV_TYPE_CHILD,
                    ]);
           
                     array_push($travellers, $trvlrs2);
           
                 }
                 $pricing = new TicketCreateTstFromPricingOptions([
                     'pricings' => [
                          new Pricing([
                              'tstNumber' => 1,
                         ]),
                         new Pricing([
                             'tstNumber' => 2,
                        ]),
                     ],
                 ]);
              } elseif ((int) $passengers['noOfChilds'] > 0 && (int) $passengers['noOfInfants'] > 0) {
                 for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
           
                     if ($passengers['noOfInfants'] != 0 && $i < $passengers['noOfInfants']) {
                         if ($activeTravellers['adults']['fistName'][$i] == $activeTravellers['infants']['fistName'][$i] && $activeTravellers['adults']['lastName'][$i] == $activeTravellers['infants']['lastName'][$i]) {
                           $trvlrs1 = new Traveller([
                                'number' => $i,
                             'firstName' => $activeTravellers['adults']['fistName'][$i],
                                 'lastName' => $activeTravellers['adults']['lastName'][$i],
                                 'infant' => new Traveller([
                                    'firstName' => 'Junior',
                                      'dateOfBirth' => \DateTime::createFromFormat('Y-m-d', $activeTravellers['infants']['infantDOB'][$i], new \DateTimeZone('UTC')),
                                 ]),
                             ]);
           
                        } elseif ($activeTravellers['adults']['fistName'][$i] == $activeTravellers['infants']['fistName'][$i] && $activeTravellers['adults']['lastName'][$i] != $activeTravellers['infants']['lastName'][$i]) {
                             $trvlrs1 = new Traveller([
                                 'number' => $i,
                                 'firstName' => $activeTravellers['adults']['fistName'][$i],
                                'lastName' => $activeTravellers['adults']['lastName'][$i],
                                  'infant' => new Traveller([
                                     'firstName' => $activeTravellers['infants']['fistName'][$i],
                                      'dateOfBirth' => \DateTime::createFromFormat('Y-m-d', $activeTravellers['infants']['infantDOB'][$i], new \DateTimeZone('UTC')),
                                 ]),
                            ]);
           
                        } else {
                            $trvlrs1 = new Traveller([
                                'number' => $i,
                                'firstName' => $activeTravellers['adults']['fistName'][$i],
                                'lastName' => $activeTravellers['adults']['lastName'][$i],
                                'infant' => new Traveller([
                                    'firstName' => $activeTravellers['infants']['fistName'][$i],
                                    'lastName' => $activeTravellers['infants']['lastName'][$i],
                                    'dateOfBirth' => \DateTime::createFromFormat('Y-m-d', $activeTravellers['infants']['infantDOB'][$i], new \DateTimeZone('UTC')),
                                ]),
                            ]);

                        }
                        array_push($travellers, $trvlrs1);
                    } else {
                        $trvlrs2 = new Traveller([
                            'number' => $i,
                            'firstName' => $activeTravellers['adults']['fistName'][$i],
                            'lastName' => $activeTravellers['adults']['lastName'][$i],
                            'type' => 'ADT',
                        ]);
                        array_push($travellers, $trvlrs2);
                    }
                }

                for ($i = 0; $i < $passengers['noOfChilds']; $i++) {

                    $trvlrs3 = new Traveller([
                        'number' => array_sum([$passengers['noOfAdults'], $i]),
                        'firstName' => $activeTravellers['childs']['fistName'][$i],
                        'lastName' => $activeTravellers['childs']['lastName'][$i],
                        'travellerType' => Traveller::TRAV_TYPE_CHILD,
                    ]);

                    array_push($travellers, $trvlrs3);

                }
                $pricing = new TicketCreateTstFromPricingOptions([
                    'pricings' => [
                        new Pricing([
                            'tstNumber' => 1,
                        ]),
                        new Pricing([
                            'tstNumber' => 2,
                        ]),
                        new Pricing([
                            'tstNumber' => 3,
                        ]),

                    ],
                ]);
            }

            $opt = new PnrCreatePnrOptions();
            $opt->actionCode = PnrCreatePnrOptions::ACTION_NO_PROCESSING; //0 Do not yet save the PNR and keep in context.

            $opt->travellers = $travellers;

            $opt->elements[] = new Ticketing([
                'ticketMode' => Ticketing::TICKETMODE_OK,
            ]);
            $opt->itineraries[] = new Itinerary([
                'segments' => [
                    new Miscellaneous([
                        'status ' => Segment::STATUS_CONFIRMED,
                        'company' => '1A',
                        'date' => \DateTime::createFromFormat('Ymd', date('Ymd'), new \DateTimeZone('UTC')),
                        'cityCode' => 'DEL',
                        'freeText' => 'MAKE TRUE TRIP (OPC ) PRIVATE LIMITED.',
                        'quantity' => array_sum([$passengers['noOfAdults'], $passengers['noOfChilds']]),
                    ]),
                ],
            ]);

            $opt->elements[] = new Contact([
                'type' => Contact::TYPE_PHONE_MOBILE,
                'value' => '+919875489875',
            ]);
            $opt->elements[] = new Contact([
                'type' => Contact::TYPE_EMAIL,
                'value' => $email,
            ]);
            $opt->elements[] = new FormOfPayment([
                'type' => FormOfPayment::TYPE_CASH,
            ]);

            $createdPnr = $client->pnrCreatePnr($opt);

            if ($createdPnr->status === Result::STATUS_OK) {
                $getsession = $client->getSessionData();
                $client->setSessionData($getsession);

                $pricingResponse = $client->farePricePnrWithBookingClass(
                    new FarePricePnrWithBookingClassOptions([
                        'validatingCarrier' => $marketingCompany,
                    ]),
                );
                
                if ($pricingResponse->status === Result::STATUS_OK) {
                    // dd($pricingResponse);
                    $getsession = $client->getSessionData();
                    $client->setSessionData($getsession);

                    $createTstResponse = $client->ticketCreateTSTFromPricing(
                        $pricing
                    );

                    if ($createTstResponse->status === Result::STATUS_OK) {
                        
                        // dd($createTstResponse);
                        $getsession = $client->getSessionData();
                        $client->setSessionData($getsession);
                        $pnrReply = $client->pnrAddMultiElements(
                            new PnrAddMultiElementsOptions([
                                'actionCode' => PnrAddMultiElementsOptions::ACTION_END_TRANSACT, //ET: END AND RETRIEVE
                            ])
                        );

                        if ($pnrReply->status === Result::STATUS_OK) {
                            $getsession = $client->getSessionData();
                            $client->setSessionData($getsession);
                            sleep(10);
                            $createdPnrForRetriever1 = $pnrReply->response->pnrHeader->reservationInfo->reservation->controlNumber;

                            $pnrRetrieve = $client->pnrRetrieve(new PnrRetrieveOptions(['recordLocator' => $createdPnrForRetriever1]));

                            if ($pnrRetrieve->status === Result::STATUS_OK) {
                                if($showprice == "checked"){
                                     $FareInformation[] = [
                                        "PaxType" =>  "XXXXXXX",
                                        "PaxBaseFare" => "XXXXXXX",
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => "XXXXXXXX",
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
                                        "PaxType" =>  $pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxBaseFare" => $pnrRetrieve->response->tstData->fareData->monetaryInfo[0]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>  ($pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount) + $Fare1 ?? '',
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
                                        "PaxType" =>  $pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxBaseFare" => $pnrRetrieve->response->tstData->fareData->monetaryInfo[0]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => ($pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount) + $Fare1 ?? '',
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
                                        "PaxType" =>  $pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxBaseFare" => $pnrRetrieve->response->tstData->fareData->monetaryInfo[0]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>  ($pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount) + $Fare1 ?? '',
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
                                
                                
                                   
                            
                                       
                                    $booking = $pnrRetrieve->response;
                                    $longFreetext = $str = (isset($booking->dataElementsMaster->dataElementsIndiv[3]->otherDataFreetext->longFreetext) ? ($booking->dataElementsMaster->dataElementsIndiv[3]->otherDataFreetext->longFreetext) : '');
                                    $longFreetext = substr($str, (strpos($str, "-")) + 1, 10);
                                        
                                    $FlightDetails = [];

                                    foreach ($pnrRetrieve->response->originDestinationDetails->itineraryInfo as $segkey => $segment) {
                                        if ($segkey > 0) {
                                            $segdata = [
                                               "Leg" => 1,
                                                "FlightCount" => 1,
                                                "DepartAirportCode" => $segment->travelProduct->boardpointDetail->cityCode ?? '',
                                                "DepartAirportName" => $segment->travelProduct->boardpointDetail->cityCode ?? '',
                                                "DepartCityName" => $segment->travelProduct->boardpointDetail->cityCode ?? '',
                                                "DepartTerminal" => $segment->flightDetail->departureInformation->departTerminal ?? '',
                                                "DepartDateTime" => $segment->travelProduct->product->depTime ??''.$segment->travelProduct->product->depDate ??'',
                                                "DepartDate" => $segment->travelProduct->product->depDate ??'',
                                                "ArrivalAirportCode" => $segment->travelProduct->offpointDetail->cityCode ?? '',
                                                "ArrivalAirportName" => $segment->travelProduct->offpointDetail->cityCode ?? '',
                                                "ArrivalCityName" => $segment->travelProduct->offpointDetail->cityCode ?? '',
                                                "ArrivalTerminal" => $segment->flightDetail->arrivalStationInfo->terminal ?? '',
                                                "ArrivalDateTime" => $segment->travelProduct->product->arrTime??''.$segment->travelProduct->product->arrDate??'' ,
                                                "ArrivalDate" => $segment->travelProduct->product->arrDate??'' ,
                                                "FlightNumber" => $segment->travelProduct->productDetails->identification ?? '',
                                                "AirLineCode" => $segment->travelProduct->companyDetail->identification ?? '',
                                                "AirLineName" => $segment->travelProduct->companyDetail->identification ?? '',
                                                "Duration" => $segment->flightDetail->productDetails->duration,
                                                "AvailableSeats" => $segment->flightDetail->productDetails->duration,
                                                "EquipmentType" =>  $segment->flightDetail->productDetails->equipment,
                                                "MarketingCarrier" => $segment->travelProduct->companyDetail->identification,
                                                "OperatingCarrier" => $segment->travelProduct->companyDetail->identification,
                                                "OperatingCarrierName" => $segment->travelProduct->companyDetail->identification,
                                                "OperatingFlightNumber" => $segment->travelProduct->companyDetail->identification,
                                                "AirLinePNR" => $segment->itineraryReservationInfo->reservation->controlNumber?? '',
                                                "TravelClass" => $segment->travelProduct->productDetails->classOfService ?? '',
                                                "TrackID" =>$segment->itineraryReservationInfo->reservation->controlNumber?? '',
                                                "BookingCode" => null,
                                                "BaggageDetails" => null,
                                                "NumberOfStops" => $segment->flightDetail->productDetails->numOfStops,
                                                "ViaSector" => null,
                                                "TicketNumber" => $longFreetext,
                                            ];

                                            array_push($FlightDetails, $segdata);
                                        }
                                    }

                                    is_array($booking->travellerInfo) ? $travellerInfo = $booking->travellerInfo : $travellerInfo = [$booking->travellerInfo];
                                    $PassengerDetails = [];
                                    
                                    
                                        $book = new AgentBooking;
                                        
                                        $book->gds_pnr = $pnrRetrieve->response->pnrHeader->reservationInfo->reservation->controlNumber ?? '';
                                        $seg = [];
                                        foreach ($pnrRetrieve->response->originDestinationDetails->itineraryInfo as $segkey => $segment) {
                                            if ($segkey > 0) {
                                                $segdata = [
                                                    'operatingcompany' => $segment->travelProduct->companyDetail->identification ?? '',
                                                    'marketingcompany' => $segment->travelProduct->companyDetail->identification ?? '',
                                                    'flightnumber' => $segment->travelProduct->productDetails->identification ?? '',
                                                    'departurelocation' => $segment->travelProduct->boardpointDetail->cityCode ?? '',
                                                    'departureterminal' => $segment->flightDetail->departureInformation->departTerminal ?? '',
                                                    'departuredate' => $segment->travelProduct->product->depDate ?? '',
                                                    'departuretime' => $segment->travelProduct->product->depTime ?? '',
                                                    'arrivallocation' => $segment->travelProduct->offpointDetail->cityCode ?? '',
                                                    'arrivalterminal' => $segment->flightDetail->arrivalStationInfo->terminal ?? '',
                                                    'arrivaldate' => $segment->travelProduct->product->arrDate ?? '',
                                                    'arrivaltime' => $segment->travelProduct->product->arrTime ?? '',
                                                    'journeytime' => $segment->flightDetail->productDetails->duration ?? '',
                                                    'serviceclass' => $segment->travelProduct->productDetails->classOfService ?? '',
                                                    'seat' => '',
                                                    'meal' => '',

                                                ];
                                                array_push($seg, $segdata);
                                            }
                                        }
                                        $book->itinerary =  json_encode($FlightDetails, true);
                                        is_array($booking->travellerInfo) ? $travellerInfo = $booking->travellerInfo : $travellerInfo = [$booking->travellerInfo];
                                        $PassengerDetails = [];
                                        foreach ($travellerInfo as $travellers) {
                                            $ticketNo = $travellers->elementManagementPassenger->reference->number;
    
                                            // dd($ticketNo);
    
                                            is_array($travellers->passengerData) ? $travellerData = $travellers->passengerData : $travellerData = [$travellers->passengerData];
    
                                            foreach ($travellerData as $person) {
    
                                                $Passenger = [
                                                    "ReferenceNo" => "",
                                                    "TrackID" => "",
                                                    "Title" => "MR",
                                                    "FirstName" => $person->travellerInformation->passenger->firstName ?? '',
                                                    "MiddleName" => null,
                                                    "LastName" => $person->travellerInformation->traveller->surname ?? '',
                                                    "PaxTypeCode" => $person->travellerInformation->passenger->type ?? '',
                                                    "Gender" => "",
                                                    "DOB" => null,
                                                    "TicketID" => $ticketNo ?? '',
                                                    "TicketNumber" => $longFreetext ?? '',
                                                    "IssueDate" => "",
                                                    "Status" => "Ticketed",
                                                    "ModifyStatus" => "",
                                                    "ValidatingAirline" => " ",
                                                    "FareBasis" => null,
                                                    "Baggage" => null,
                                                    "BaggageAllowance" => null,
                                                    "ChangePenalty" => null,
                                                ];
                                                array_push($PassengerDetails, $Passenger);
                                            }
                                        }
                                        $book->passenger = json_encode($PassengerDetails, true);
                                        $book->email = $pnrRetrieve->response->dataElementsMaster->dataElementsIndiv[0]->otherDataFreetext->longFreetext ?? '';
                                        $book->mobile = $pnrRetrieve->response->dataElementsMaster->dataElementsIndiv[1]->otherDataFreetext->longFreetext ?? '';
                                        $book->booking_from = "AMADEUS";
                                        $book->trip =  "Domestic";
                                        
                                        $book->trip_type =  "Dow Roun One";
                                        $book->trip_stop = "No stop";
                                        $book->airline_pnr =  $pnrRetrieve->response->pnrHeader->reservationInfo->reservation->controlNumber ?? '';
                                        
                                        $CabIn  = $booking->tstData->fareBasisInfo->fareElement->baggageAllowance ??  $booking->tstData->fareBasisInfo->fareElement->baggageAllowance ?? '15 kg.';
                                        $book->baggage = json_encode([[
                                            'CabIn' => $CabIn, 
                                            'CheckIn' => '7KG'
                                        ]], true);
                                        $book->booking_id = "WT0000" .$pnrRetrieve->response->pnrHeader->reservationInfo->reservation->controlNumber ?? '' ;
                                        $book->fare = json_encode($FareInformation, true);
                                        $book->A = json_encode($FareInformationA, true);
                                        $book->logs_id = $pnrRetrieveAndDisplay->responseXml ?? "";
                                        $book->status = "Ticketed";
                                        
                                        $usermobile = User::where('phone', $phonenumber)->pluck('id') ?? '';
                                        $useremail = User::where('email', $email)->pluck('id') ?? '';
                                        if (isset($usermobile[0])) {
                                            $book->user_id = $usermobile[0] ?? '';
                                        } elseif (isset($useremail[0])) {
                                            $book->user_id = $useremail[0] ?? '';
                                        
                                        } else {
                                            $user = new User;
                                            $user->name = $activeTravellers['adults']['fistName'][0] . " " . $activeTravellers['adults']['lastName'][0] ?? '';
                                            $user->email = strtolower($email) ?? '';
                                            $user->phone = $phonenumber ?? '';
                                            $user->password = Hash::make("New@1234") ?? '';
                                            $user->save();

                                            $book->user_id = $user->id;
                                        }
                                        $Agent = Session()->get("Agent");
                                        $book->B = $Agent->email;
                                        $book->C = "C";
                                        $book->save();
                                        
                                        
                                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        
                                        $client->securitySignOut();
                                        
                                        $date  = $time = '';
                                            foreach (json_decode($book->itinerary) as $key => $itinerary){
                                                if($key == 0){
                                                    $date =  NOgetDate_fn($itinerary->DepartDate) ;
                                                    
                                                    $time =  date('H:i', strtotime($itinerary->DepartDateTime)) ;
                                                }
                                            }
                                           
                                            $from = json_decode($book->itinerary)[0]->DepartCityName ?? json_decode($book->itinerary)->DepartCityName ?? '';
                                            $to = json_decode($book->itinerary)[count(json_decode($book->itinerary))-1]->ArrivalCityName ?? json_decode($book->itinerary)->ArrivalCityName ?? '';
                                            
                                            foreach (json_decode($book->passenger) as $passenger){}
                                            $name = $passenger->FirstName ?? "customer";
                                            $name =  preg_replace('/\s+/', '%20', $name);
                                            
                                            $PhoneTo = $book->mobile;
                                            $PhoneTo =  preg_replace('/\s+/', '%20', $PhoneTo);
                                            
                                            $from = AirportiatacodesController::getCity($from);
                                            $from =  preg_replace('/\s+/', '%20', $from);
                                            
                                            $to = AirportiatacodesController::getCity($to);
                                            $to =  preg_replace('/\s+/', '%20', $to);
                                            
                                            $pnr = $book->gds_pnr;
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
                                        
                                            $both = [
                                                    'FristpnrRetrieve'=>$FristpnrRetrieve , 
                                                    'book'=>$book ,
                                            ];
                                            
                                            $bookings['both'] = $both;
                                            $bookings['email'] =  $email??$useremail[0]?? '';
                                            $bookings['title'] =   "Flight Ticket ".$activeTravellers['adults']['fistName'][0]??'';
                                            
                                            $files = PDF::loadView('flight-pages/booking-confirm/Mix-Dom-Round-pdf', $bookings);
                                        
                                            \Mail::send('booking-pdf.flight.Mix_eamil_content', $bookings, function($message)use($bookings ,$files) {
                                                $message->to("customercare@wagnistrip.com")
                                                        ->subject( $bookings['title'])
                                                        ->attachData($files->output(), $bookings['title'].".pdf");
                                            });
                                            \Mail::send('booking-pdf.flight.Mix_eamil_content', $bookings, function($message)use($bookings ,$files) {
                                                $message->to($bookings['email'])
                                                        ->subject( $bookings['title'])
                                                        ->attachData($files->output(), $bookings['title'].".pdf");
                                            });
                                        
                                        $both = [
                                            'FristpnrRetrieve'=>$FristpnrRetrieve , 
                                            'book'=>$book ,
                                        ];
                                        return $both;
                                   }
                            //   } else {
             
                            //          return redirect()->route('error')->with('message', 'issueTicketResponse  ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank.');
             
                            //  }
             
                            // } else {
                            //     return redirect()->route('error')->with('message', 'pnrRetrieve  ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank.');
             
                            //   }
                        } else {
                           return redirect()->route('error')->with('message', 'pnrReply  ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank,  Kindly contact on this toll free number 08069145571 for further concern.');
             
                       }
             
                   } else {
                       return redirect()->route('error')->with('message', 'createTstResponse  ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank,  Kindly contact on this toll free number 08069145571 for further concern.');
             
                     }
             
                 } else {
                    return redirect()->route('error')->with('message', 'pricingResponse -----  Your booking could not be completed as we did not receive successful authorisation of the payment from your bank,  Kindly contact on this toll free number 08069145571 for further concern.');
             
                 }
             
              } else {
                 return redirect()->route('error')->with('message', 'createdPnr   -----   Your booking could not be completed as we did not receive successful authorisation of the payment from your bank,  Kindly contact on this toll free number 08069145571 for further concern.');
             
              }



        }
}
