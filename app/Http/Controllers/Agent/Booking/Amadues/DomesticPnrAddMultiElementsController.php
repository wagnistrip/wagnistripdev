<?php

namespace App\Http\Controllers\Agent\Booking\Amadues;

use App\Http\Controllers\Controller;
use App\Models\Agent\AgentBooking;
use App\Http\Controllers\Airline\AirportiatacodesController;
use App\Http\Controllers\Airline\Amadeus\AmadeusHeaderController;
use App\Models\Booking\Bookingpnr;
use App\Models\Cart;
use App\Models\User;
use App\Services\AmadeusService;
use Exception;
use GuzzleHttp\Client;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;

class DomesticPnrAddMultiElementsController extends Controller
{
    private $amadeusAccessToken;
    public function __construct(AmadeusService $amadeusAccessToken)
    {
        $this->amadeusAccessToken = $amadeusAccessToken;
    }

    public function DomPnrAddMultiElements($tnxid, $showprice)
    {
        // dd($tnxid, $showprice);

        $bookingData = Cart::where('uniqueid',$tnxid)->first();

        $otherInformation = json_decode($bookingData['otherInformation'], true);
        $OutboundMarketingCompany = $otherInformation['otherInfoOutbound']['marketingCompany'] ?? $otherInformation['otherInfoOutbound']['marketingCompany_1'];
        $InboundMarketingCompany = $otherInformation['otherInfoInbound']['marketingCompany'] ?? $otherInformation['otherInfoInbound']['marketingCompany_1'];

        $activeTravellers = json_decode($bookingData['travllername'], true);

        $getsession = json_decode($bookingData['getsession'], true);

        $OutboundGetsession = $getsession['sessionOutbound'];
        $InboundGetsession = $getsession['sessionInbound'];

        $phonenumber = $bookingData['phonenumber'];
        $email = $bookingData['email'];
        $uniqueid = $bookingData['uniqueid'];

        for ($r = 1; $r <= 2; $r++) {
            $accessToken = $this->amadeusAccessToken->getAccessToken();
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);
            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
            ];
            $passengers = json_decode($bookingData['travellerquantity'], true);

            if ($r == 1) {
                $marketingCompany = $OutboundMarketingCompany;
                $client->setSessionData($OutboundGetsession);
            } elseif ($r == 2) {
                $marketingCompany = $InboundMarketingCompany;
                $client->setSessionData($InboundGetsession);
            }

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
                'value' => $phonenumber ?? '+919875489875',
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


                            /////////////////////////////////////////////////////////////
                            if ($pnrRetrieve->status === Result::STATUS_OK) {
                            // dd($pnrRetrieve);
                            /////////////////////////////////////////////////////////////////////////////////////////////////

                            if($showprice == "checked"){
                                $FareInformation[] = [
                                        "PaxType" => 'XXXXXXX' ,
                                        "PaxBaseFare" =>"XXXXXXX",
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>  "XXXXXXXXX" ,
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
                                        "PaxType" => $pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxBaseFare" => $pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>   $pnrRetrieve->response->tstData->fareData->monetaryInfo[0]->amount ?? '',
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
                                        "PaxType" => $pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '' ,
                                        "PaxBaseFare" =>$pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>  $pnrRetrieve->response->tstData->fareData->monetaryInfo[0]->amount ?? '' ,
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
                                        "PaxType" => $pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxBaseFare" => $pnrRetrieve->response->tstData->fareData->monetaryInfo[1]->amount ?? '',
                                        "PaxFuelSurcharge" => 0,
                                        "PaxOtherTax" => 0,
                                        "PaxTotalFare" =>   $pnrRetrieve->response->tstData->fareData->monetaryInfo[0]->amount ?? '',
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
                                                "BaggageDetails" => $pnrRetrieve->response->tstData->fareBasisInfo->fareElement->baggageAllowance ?? "",
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
                                                    "BaggageAllowance" => $pnrRetrieve->response->tstData->fareBasisInfo->fareElement->baggageAllowance?? '',
                                                    "ChangePenalty" => null,
                                                ];
                                                array_push($PassengerDetails, $Passenger);
                                            }
                                        }
                                        $book->passenger = json_encode($PassengerDetails, true);
                                        $book->email = $pnrRetrieve->response->dataElementsMaster->dataElementsIndiv[0]->otherDataFreetext->longFreetext ?? '';
                                        $book->mobile = $pnrRetrieve->response->dataElementsMaster->dataElementsIndiv[1]->otherDataFreetext->longFreetext ?? '';
                                        $CabIn  =  $booking->tstData->fareBasisInfo->fareElement->baggageAllowance ?? '15 kg .';
                                        $book->baggage = json_encode([[
                                            'CabIn' => $CabIn,
                                            'CheckIn' => '7KG'
                                        ]], true);
                                        $book->booking_from = "AMADEUS";
                                        $book->trip =  "Domestic";

                                        $book->trip_type =  "Dow Roun One";
                                        $book->trip_stop = "No stop";
                                        $book->airline_pnr =  $pnrRetrieve->response->pnrHeader->reservationInfo->reservation->controlNumber ?? '';

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

                                        $client->securitySignOut();

                                        if ($r == 1) {
                                             $FristpnrRetrieve = $book;
                                        }
                                        if ($r == 2) {


                                            $date  = $time = '';
                                            foreach (json_decode($book->itinerary) as $key => $itinerary){
                                                if($key == 0){
                                                    $date =  NOgetDate_fn($itinerary->DepartDate) ;
                                                    $date2 =  getDate_fn($itinerary->DepartDate) ?? date('d-m-Y', strtotime($itinerary->DepartDate)) ;
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
                                            $date = preg_replace('/\s+/', '%20', $date);;
                                            $Time = preg_replace('/\s+/', '%20', $time);;

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



                                            $both['both'] = [
                                                'FristpnrRetrieve'=>$FristpnrRetrieve ,
                                                'book'=>$book ,
                                            ];

                                            $both['bookings'] =  $FristpnrRetrieve;
                                            $both['email'] =  $email??$useremail[0]?? 'customercare@wagnistrip.com';
                                            $both['title'] =   "Flight Ticket ".$activeTravellers['adults']['fistName'][0]??'';

                                            $files = PDF::loadView('flight-pages/booking-confirm/edit-roundtrip-amd-flight-booking-confirm-pdf', $both);

                                            \Mail::send('flight-pages.booking-confirm.amd-email_content', $both, function($message)use($both ,$files) {
                                                $message->to($both['email'])
                                                        ->subject( $both['title'])
                                                        ->attachData($files->output(), $both['title'].".pdf");

                                            });
                                            \Mail::send('flight-pages.booking-confirm.amd-email_content', $both, function($message)use( $both ,$files) {
                                                $message->to("customercare@wagnistrip.com")
                                                        ->subject( $both['title'])
                                                        ->attachData($files->output(), $both['title'].".pdf");

                                            });

                                            ///////////////////////////////////////////////////////////////////////////////////
                                            ///////////////////////////////////////////////////////////////////////////////////
                                            $both = [
                                                'FristpnrRetrieve'=>$FristpnrRetrieve ,
                                                'book'=>$book ,
                                            ];
                                            return $both;


                                        }


                            } else {
                                return redirect()->route('error')->with('message', 'pnrRetrieve  ---- Your booking could not be completed as we did not receive successful authorisation of the payment from your bank, Kindly contact on this toll free number 08069145571 for further concern.');

                            }
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
                return redirect()->route('error')->with('message', 'createdPnr   -----   Your booking could not be completed as we did not receive successful authorisation of the payment from your bank, Kindly contact on this toll free number 08069145571 for further concern.');

            }

        }
    }

}
