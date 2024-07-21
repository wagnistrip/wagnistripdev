<?php

namespace App\Http\Controllers\Agent\Booking\Amadues;

use Amadeus\Client;
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
use App\Http\Controllers\Airline\AirportiatacodesController;
use Amadeus\Client\RequestOptions\Pnr\Reference;
// use Amadeus\Client\RequestOptions\Air\RetrieveSeatMap\FrequentFlyer;
use Amadeus\Client\RequestOptions\Pnr\Element\FrequentFlyer;
use App\Http\Controllers\Airline\Amadeus\AmadeusHeaderController;
use App\Http\Controllers\Controller;
use App\Models\Agent\AgentBooking;
use App\Models\amadeus_flight_log;
use App\Models\Cart;
use App\Models\PaymentHotels;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;
use PDF;
use Illuminate\Support\Facades\Session;
use Exception;

class PNR_AddMultiElementsController extends Controller
{
        
    
    public function PNR_AddMultiElements( $tnxid, $showprice)
    {
        // adding case free payment getway
        
        // dd($input , $request['amount'] , $request['mode']);
                
        $bookingData = AgentBooking::where('logs_id', $tnxid)->first();
        if(isset($bookingData['id'])){
            return  $bookingData;
        }
        
        
        $bookingData = Cart::where('uniqueid', $tnxid)->first();
        // dd($bookingData , $request['amount']);
        $otherInformation = json_decode($bookingData['otherInformation'], true);
        // dd($tnxid);

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

        $travellers = [];
        $pricing = [];

        // dd($bookingData);
        
        $travellerData =  [];
        if ((int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] === 0) {
            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {

                $trvlrs = new Traveller([
                    'number' => $i,
                    'firstName' => $activeTravellers['adults']['fistName'][$i],
                    'lastName' => $activeTravellers['adults']['lastName'][$i],
                    'type' => 'ADT',
                ]);
                array_push($travellers, $trvlrs);
                
                $TraData=[
                    'title' => $activeTravellers['adults']['title'][$i],
                    'firstName' => $activeTravellers['adults']['fistName'][$i],
                    'lastName' => $activeTravellers['adults']['lastName'][$i],
                    'type' => 'ADT',
                ];
                array_push($travellerData, $TraData);
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
                        $TraData=[
                            'title' => $activeTravellers['adults']['title'][$i],
                            'firstName' => $activeTravellers['adults']['fistName'][$i],
                            'lastName' => $activeTravellers['adults']['lastName'][$i]?? '',
                            'type' => 'ADT',
                        ];

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
                        $TraData=[
                            'title' => $activeTravellers['adults']['title'][$i],
                            'firstName' => $activeTravellers['adults']['fistName'][$i],
                            'lastName' => $activeTravellers['adults']['lastName'][$i],
                            'type' => 'ADT',
                        ];

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
                        $TraData=[
                            'title' => $activeTravellers['adults']['title'][$i],
                            'firstName' => $activeTravellers['adults']['fistName'][$i],
                            'lastName' => $activeTravellers['adults']['lastName'][$i],
                            'type' => 'ADT',
                        ];

                    }
                } else {
                    $trvlrs = new Traveller([
                        'number' => $i,
                        'firstName' => $activeTravellers['adults']['fistName'][$i],
                        'lastName' => $activeTravellers['adults']['lastName'][$i],
                        'type' => 'ADT',
                    ]);
                    $TraData=[
                        'title' => $activeTravellers['adults']['title'][$i],
                        'firstName' => $activeTravellers['adults']['fistName'][$i],
                        'lastName' => $activeTravellers['adults']['lastName'][$i],
                        'type' => 'ADT',
                    ];

                }
                array_push($travellers, $trvlrs); 
                
                array_push($travellerData, $TraData);

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
                
                $TraData9=[
                        'title' => $activeTravellers['adults']['title'][$i],
                        'firstName' => $activeTravellers['adults']['fistName'][$i],
                        'lastName' => $activeTravellers['adults']['lastName'][$i],
                        'type' => 'ADT',
                ];
                array_push($travellerData, $TraData9);
            }
            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {

                $trvlrs2 = new Traveller([
                    'number' => array_sum([$passengers['noOfAdults'], $i]),
                    'firstName' => $activeTravellers['childs']['fistName'][$i],
                    'lastName' => $activeTravellers['childs']['lastName'][$i],
                    'travellerType' => Traveller::TRAV_TYPE_CHILD,
                ]);

                array_push($travellers, $trvlrs2);
                 $TraData=[
                        'title' => $activeTravellers['childs']['title'][$i],
                        'firstName' => $activeTravellers['childs']['fistName'][$i],
                        'lastName' => $activeTravellers['childs']['lastName'][$i],
                        'type' => 'ADT',
                ];
                 array_push($travellerData, $TraData);

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
                         $TraData=[
                            'title' => $activeTravellers['adults']['title'][$i],
                            'firstName' => $activeTravellers['adults']['fistName'][$i],
                            'lastName' => $activeTravellers['adults']['lastName'][$i],
                            'type' => 'ADT',
                        ];

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
                         $TraData=[
                            'title' => $activeTravellers['adults']['title'][$i]?? '',
                            'firstName' => $activeTravellers['adults']['fistName'][$i],
                            'lastName' => $activeTravellers['adults']['lastName'][$i],
                            'type' => 'ADT',
                        ];

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
                         $TraData=[
                            'title' => $activeTravellers['adults']['title'][$i]??'',
                            'firstName' => $activeTravellers['adults']['fistName'][$i],
                            'lastName' => $activeTravellers['adults']['lastName'][$i],
                            'type' => 'ADT',
                        ];

                    }
                    array_push($travellers, $trvlrs1);
                    
                    array_push($travellerData, $TraData);
                } else {
                    $trvlrs2 = new Traveller([
                        'number' => $i,
                        'firstName' => $activeTravellers['adults']['fistName'][$i],
                        'lastName' => $activeTravellers['adults']['lastName'][$i],
                        'type' => 'ADT',
                    ]);
                    $TraData5=[
                            'title' => $activeTravellers['adults']['title'][$i],
                            'firstName' => $activeTravellers['adults']['fistName'][$i],
                            'lastName' => $activeTravellers['adults']['lastName'][$i],
                            'type' => 'ADT',
                    ];
                    array_push($travellers, $trvlrs2);
                    array_push($travellerData, $TraData5);
                }
            }

            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {

                $trvlrs3 = new Traveller([
                    'number' => array_sum([$passengers['noOfAdults'], $i]),
                    'firstName' => $activeTravellers['childs']['fistName'][$i],
                    'lastName' => $activeTravellers['childs']['lastName'][$i],
                    'travellerType' => Traveller::TRAV_TYPE_CHILD,
                ]);
                    $TraData4=[
                            'title' => $activeTravellers['childs']['title'][$i],
                            'firstName' => $activeTravellers['childs']['fistName'][$i],
                            'lastName' => $activeTravellers['childs']['lastName'][$i],
                            'type' => 'CHD',
                    ];

                array_push($travellers, $trvlrs3);
                    array_push($travellerData, $TraData4);

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
        // dd($activeTravellers);
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
                    'freeText' => 'WAGNISTRIP (OPC) PRIVATE LIMITED',
                    'quantity' => array_sum([$passengers['noOfAdults'], $passengers['noOfChilds']]),
                ]),
            ],
        ]);
        $opt->elements[] = new Contact([
            'type' => Contact::TYPE_PHONE_MOBILE,
            'value' => $phonenumber ?? '7669988012',

        ]);
        $opt->elements[] = new Contact([
            'type' => Contact::TYPE_EMAIL,
            'value' => $email ?? "customercare@wagnistrip.com",
        ]);
        
        $opt->elements[] = new FormOfPayment([
            'type' => FormOfPayment::TYPE_CASH,
        ]);
        
        // https://github.com/amabnl/amadeus-ws-client/blob/master/docs/samples/pnr-create-modify.rst#form-of-payment-fp use this link for deatiles
        // $opt->elements[] = new FormOfPayment([
        //     'type' => FormOfPayment::TYPE_CREDITCARD,
        //     'creditCardType' => 'VI',
        //     'creditCardNumber' => '5598670000002763',
        //     'creditCardExpiry' => '0323',
        //     'creditCardCvcCode' => '',
        //     'creditCardHolder' => 'MAKE TRUE TRIP'
        // ]);
        
        $createdPnr = $client->pnrCreatePnr($opt);

        // dd($opt , $createdPnr);
        if ($createdPnr->status === Result::STATUS_OK) {
            $getsession = $client->getSessionData();
            $client->setSessionData($getsession);



            $pricingResponse = $client->farePricePnrWithBookingClass(
                new FarePricePnrWithBookingClassOptions([
                    'validatingCarrier' => $marketingCompany,
                ])
            );
            if ($pricingResponse->status === Result::STATUS_OK) {
                $getsession = $client->getSessionData();
                $client->setSessionData($getsession);
                $createTstResponse = $client->ticketCreateTSTFromPricing(
                    $pricing
                );

                if ($createTstResponse->status === Result::STATUS_OK) {
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
                        
                        // dd($pnrRetrieve);
                        
                        if ($pnrRetrieve->status === Result::STATUS_OK) {
                            $getsession = $client->getSessionData();
                            $client->setSessionData($getsession);
                            
                            $issueTicketResponse = $client->docIssuanceIssueTicket(
                                new DocIssuanceIssueTicketOptions([
                                    'options' => [
                                        DocIssuanceIssueTicketOptions::OPTION_ETICKET,
                                    ],
                                ])
                            );
                            
                            // if ($issueTicketResponse->status === Result::STATUS_OK) {
                                $getsession = $client->getSessionData();
                                $client->setSessionData($getsession);
                                
                                $createdPnrForRetriever2 = $pnrRetrieve->response->pnrHeader->reservationInfo->reservation->controlNumber;
                                $pnrRetrieveAndDisplay = $client->pnrRetrieve(
                                    new PnrRetrieveOptions(['recordLocator' => $createdPnrForRetriever2])
                                );
                                // dd($issueTicketResponse);
                                
                                // if ($pnrRetrieveAndDisplay->status === Result::STATUS_OK) {
                                    $booking = $pnrRetrieveAndDisplay->response;
                                    $longFreetext = $str = (isset($booking->dataElementsMaster->dataElementsIndiv[3]->otherDataFreetext->longFreetext) ? ($booking->dataElementsMaster->dataElementsIndiv[3]->otherDataFreetext->longFreetext) : '');
                                    $longFreetext = substr($str, (strpos($str, "-")) + 1, 10);
                                    
                                    // echo $longtextnumber;die;
                                    // print "<pre>";print_r($booking);die();
                                    // dd($booking);
                                    
                                    $getsession = $client->getSessionData();
                                    $client->setSessionData($getsession);

                                    // -------------------- Start Save Data From Pnr Informition For Amadeus --------------------

                                    $FlightDetails = [];
                                    // dd($booking);

                                    foreach ($booking->originDestinationDetails->itineraryInfo as $segkey => $segment) {
                                        if ($segkey > 0) {
                                            $segdata = [
                                                "Leg" => 1,
                                                "FlightCount" => $segkey,
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
                                    
                                    // is_array($booking->travellerInfo) ? $travellerInfo = $booking->travellerInfo : $travellerInfo = [$booking->travellerInfo];
                                    $PassengerDetails = [];
                                    
                                    // foreach ($travellerInfo as $travellers) {
                                    //     $ticketNo = $travellers->elementManagementPassenger->reference->number;


                                    //     is_array($travellers->passengerData) ? $travellerDataByApi = $travellers->passengerData : $travellerDataByApi = [$travellers->passengerData];

                                    //     foreach ($travellerDataByApi as $person) {
                                            
                                    //     $Title = '';
                                    // $activeTravellers
                                    if(isset($activeTravellers['adults']['title'])){
                                        foreach($activeTravellers['adults']['title'] as $key => $value){
                                           $Passenger = [
                                                "ReferenceNo" => "",
                                                "TrackID" => "",
                                                "Title" => $value ?? "MR",
                                                "FirstName" => $activeTravellers['adults']['fistName'][$key] ?? '',
                                                "MiddleName" => null,
                                                "LastName" => $activeTravellers['adults']['lastName'][$key] ?? '',
                                                "PaxTypeCode" =>  'ADT',
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
                                    if(isset($activeTravellers['childs']['title'])){
                                        foreach($activeTravellers['childs']['title'] as $key => $value){
                                           $Passenger = [
                                                "ReferenceNo" => "",
                                                "TrackID" => "",
                                                "Title" => $value ?? "MR",
                                                "FirstName" => $activeTravellers['childs']['fistName'][$key] ?? '',
                                                "MiddleName" => null,
                                                "LastName" => $activeTravellers['childs']['lastName'][$key] ?? '',
                                                "PaxTypeCode" =>  'CHD',
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
                                    if(isset($activeTravellers['infants']['title'])){
                                        foreach($activeTravellers['infants']['title'] as $key => $value){
                                           $Passenger = [
                                                "ReferenceNo" => "",
                                                "TrackID" => "",
                                                "Title" => $value ?? "MISS",
                                                "FirstName" => $activeTravellers['infants']['fistName'][$key] ?? '',
                                                "MiddleName" => null,
                                                "LastName" => $activeTravellers['infants']['lastName'][$key] ?? '',
                                                "PaxTypeCode" =>  'INF',
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
                                        // foreach($travellerData as $traveller){
                                            
                                        //     if( strtoupper($traveller['firstName']) == ($person->travellerInformation->passenger->firstName??'')) {
                                        //         $Title = $traveller['title']; 
                                        //     }
                                        // }
                                            // dd( $booking ,$traveller, $Title , strtoupper($traveller['firstName']),$person->travellerInformation->passenger->firstName ?? ''  );
                                            
                                            
                                            
                                            // $Passenger = [
                                            //     "ReferenceNo" => "",
                                            //     "TrackID" => "",
                                            //     "Title" => $Title ?? "MR",
                                            //     "FirstName" => $person->travellerInformation->passenger->firstName ?? '',
                                            //     "MiddleName" => null,
                                            //     "LastName" => $person->travellerInformation->traveller->surname ?? '',
                                            //     "PaxTypeCode" => $person->travellerInformation->passenger->type ?? '',
                                            //     "Gender" => "",
                                            //     "DOB" => null,
                                            //     "TicketID" => $ticketNo ?? '',
                                            //     "TicketNumber" => $longFreetext ?? '',
                                            //     "IssueDate" => "",
                                            //     "Status" => "Ticketed",
                                            //     "ModifyStatus" => "",
                                            //     "ValidatingAirline" => " ",
                                            //     "FareBasis" => null,
                                            //     "Baggage" => null,
                                            //     "BaggageAllowance" => null,
                                            //     "ChangePenalty" => null,
                                            // ];
                                            // array_push($PassengerDetails, $Passenger);
                                            
                                            
                                    //     }
                                    // }
                                    if($showprice == "checked"){
                                        $FareInformation[] = [
                                        "PaxType" =>"XXXXX",
                                        "PaxBaseFare" => "XXXXXX",
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => 'XXXXXXX',
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
                                        "PaxType" => $booking->tstData->fareData->monetaryInfo[1]->amount ??$booking->tstData[0]->fareData->monetaryInfo[1]->amount?? '',
                                        "PaxBaseFare" => $request['amount']??$booking->tstData->fareData->monetaryInfo[1]->amount ??$booking->tstData[0]->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => $booking->tstData->fareData->monetaryInfo[0]->amount ??  $booking->tstData[0]->fareData->monetaryInfo[0]->amount ?? '',
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
                                    }else{
                                       $FareInformation[] = [
                                        "PaxType" =>$booking->tstData->fareData->monetaryInfo[1]->amount ??$booking->tstData[0]->fareData->monetaryInfo[1]->amount?? '',
                                        "PaxBaseFare" => $request['amount']??$booking->tstData->fareData->monetaryInfo[1]->amount ??$booking->tstData[0]->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => $booking->tstData->fareData->monetaryInfo[0]->amount ??  $booking->tstData[0]->fareData->monetaryInfo[0]->amount ?? '',
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
                                        "PaxType" => $booking->tstData->fareData->monetaryInfo[1]->amount ??$booking->tstData[0]->fareData->monetaryInfo[1]->amount?? '',
                                        "PaxBaseFare" => $request['amount']??$booking->tstData->fareData->monetaryInfo[1]->amount ??$booking->tstData[0]->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" => $booking->tstData->fareData->monetaryInfo[0]->amount ??  $booking->tstData[0]->fareData->monetaryInfo[0]->amount ?? '',
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
                                    

                                    $usermobile = User::where('phone', $phonenumber)->pluck('id') ?? '';
                                    $useremail = User::where('email', $email)->pluck('id') ?? '';
                                    $saveBooking = new AgentBooking;
                                    // dd([$usermobile,$useremail]);
                                    if (isset($usermobile[0])) {
                                        $saveBooking->user_id = $usermobile[0];
                                    } elseif (isset($useremail[0]) ) {
                                        $saveBooking->user_id = $useremail[0];

                                    } else {
                                        $user = new User;
                                        $user->name = $activeTravellers['adults']['fistName'][0] . " " . $activeTravellers['adults']['lastName'][0] ?? '';
                                        $user->email = strtolower($email);
                                        $user->phone = $phonenumber;
                                        $user->password = Hash::make("WTUser@1234");
                                        $user->save();
                                        $saveBooking->user_id = $user->id;
                                    };
                                    $saveBooking->booking_from = "AMADEUS";
                                    $saveBooking->booking_id = "WT0000" . $booking->pnrHeader->reservationInfo->reservation->controlNumber ?? '';
                                    $saveBooking->trip = $Ticket['AirBookingResponse'][0]['Trip'] ?? "Domestic";
                                    $saveBooking->trip_type = $Ticket['AirBookingResponse'][0]['TripType'] ?? "Oneway";
                                    $saveBooking->trip_stop = $segment->flightDetail->productDetails->numOfStops;
                                    $saveBooking->gds_pnr = $booking->pnrHeader->reservationInfo->reservation->controlNumber ?? '';
                                    $saveBooking->airline_pnr = $booking->originDestinationDetails->itineraryInfo[1]->itineraryReservationInfo->reservation->controlNumber ?? '';
                                    $saveBooking->email = $email;
                                    $saveBooking->mobile = $phonenumber;
                                    $saveBooking->itinerary = json_encode($FlightDetails, true);
                                    
                                    is_array($booking->tstData) ? $tstData = $booking->tstData : $tstData = [$booking->tstData];
                                    is_array($tstData[0]->fareBasisInfo->fareElement) ? $fareElement = $tstData[0]->fareBasisInfo->fareElement : $fareElement = [$tstData[0]->fareBasisInfo->fareElement];

                                    $CabIn  = $fareElement[0]->baggageAllowance ?? '';
                                    $saveBooking->baggage = json_encode([[
                                        'CabIn' =>  $CabIn ,
                                        'CheckIn' => '7KG'
                                    ]], true);
                                    $saveBooking->passenger = json_encode($PassengerDetails, true);
                                    $saveBooking->fare = json_encode($FareInformation, true);
                                    $saveBooking->A = json_encode($FareInformationA, true);
                                    $saveBooking->status = "Ticketed";
                                    $saveBooking->logs_id = $tnxid;
                                    
                                     $Agent = Session()->get("Agent");
                                    $saveBooking->B =$Agent->email;
                                    $saveBooking->C = "C";
                                    $saveBooking->save();

                                    $client->securitySignOut();
                                    // dd($saveBooking,  $tstData , $booking);
                                    // return redirect()->route('error')->with('message', 'State Not correctly!');

                                    ///////////////////////////////////////////////////////////////////////////////////
                                    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    ///////////////////////////////////////////////////////////////////////////////////
                                    $date  = $date2= $time = '';
                                    foreach (json_decode($saveBooking->itinerary) as $key => $itinerary){
                                        if($key == 0){
                                            $date =  NOgetDate_fn($itinerary->DepartDate) ;
                                            $date2 =  getDate_fn($itinerary->DepartDate) ?? date('d-m-Y', strtotime($itinerary->DepartDate)) ;
                                            $time =  date('H:i', strtotime($itinerary->DepartDateTime));
                                        }
                                    }
                                    
                                    $from = json_decode($saveBooking->itinerary)[0]->DepartCityName ?? json_decode($saveBooking->itinerary)->DepartCityName ?? '';
                                    $to = json_decode($saveBooking->itinerary)[count(json_decode($saveBooking->itinerary))-1]->ArrivalCityName ?? json_decode($saveBooking->itinerary)->ArrivalCityName ?? '';
                                   foreach (json_decode($saveBooking->passenger) as $passenger){}
                                   
                                    $name = $passenger->FirstName ?? "customer";
                                    $name =  preg_replace('/\s+/', '%20', $name);
                                    $PhoneTo = $saveBooking->mobile;
                                    $from = AirportiatacodesController::getCity($from);
                                    $from = preg_replace('/\s+/', '%20', $from);
                                    $to = AirportiatacodesController::getCity($to);
                                    $to =  preg_replace('/\s+/', '%20', $to);
                                    $pnr = $saveBooking->gds_pnr;
                                    $Time = preg_replace('/\s+/', '%20', $time);
                                    
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
                                    
                                    // dd($response , $name , $PhoneTo , $from , $to , $pnr , $Time , $date , $date2);
                                    
                                    $bookings['bookings'] = $saveBooking;
                                    
                                    $bookings['email'] =  $email??$useremail[0]?? '';
                                    $bookings['title'] =   "Flight Ticket ".$activeTravellers['adults']['fistName'][0]??'';
                                    
                                    $files = PDF::loadView('flight-pages.booking-confirm.oneway-amd-flight-booking-confirm-pdf', $bookings);

                                    \Mail::send('flight-pages.booking-confirm.amd-email_content', $bookings, function($message)use($bookings ,$files) {
                                        $message->to($bookings['email'])
                                                ->subject( $bookings['title'])
                                                ->attachData($files->output(), $bookings['title'].".pdf");
                                    });
                                    \Mail::send('flight-pages.booking-confirm.amd-email_content', $bookings, function($message)use( $bookings ,$files) {
                                        $message->to("customercare@wagnistrip.com")
                                                ->subject( $bookings['title'])
                                                ->attachData($files->output(), $bookings['title'].".pdf");
                                    });
                                                                       
                                    ///////////////////////////////////////////////////////////////////////////////////
                                    ///////////////////////////////////////////////////////////////////////////////////
                                    
                                    
                                    //   return redirect()->route('user-booking')->with('message', 'State saved correctly!');
                                    return  $saveBooking;
                                // }
                            // } else {
            
                                    // return view('flight-pages.booking-confirm.oneway-amd-flight-booking-confirm')->with('bookings', $saveBooking);
                               // return redirect()->route('error')->with('message', 'issueTicketResponse ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank.');
                            // }
                        } else {
                            return redirect()->route('error')->with('message', 'pnrRetrieve  ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank, Kindly contact on this toll free number 08069145571 for further concern.');
                        }
                    } else {
                        return redirect()->route('error')->with('message', 'pnrReply  ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank, Kindly contact on this toll free number 08069145571 for further concern.');
                    }
                } else {
                    return redirect()->route('error')->with('message', 'createTstResponse  ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank, Kindly contact on this toll free number 08069145571 for further concern.');
                }
            } else {
                return redirect()->route('error')->with('message', 'pricingResponse -----  Your booking could not be completed as we did not receive successful authorisation of the payment from your bank, Kindly contact on this toll free number 08069145571 for further concern.');
            }
        } else {
            return redirect()->route('error')->with('message', 'createdPnr   -----   Your booking could not be completed as we did not receive successful authorisation of the payment from your bank, Kindly contact on this toll free number 08069145571 for further concern.');
        }
    }
}
