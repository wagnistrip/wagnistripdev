<?php

namespace App\Http\Controllers\Airline\Both;


use App\Http\Controllers\Airline\AirPortIATACodesController;
use App\Http\Controllers\Airline\Amadeus\AmadeusSearchFlightController;
use App\Http\Controllers\Airline\Galileo\GalileoSearchFlightController;
use App\Http\Controllers\Controller;
use App\Services\AmadeusService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SearchFlightController extends Controller
{
    private $amadeusAccessToken;
    public function __construct(AmadeusService $amadeusAccessToken)
    {
        $this->amadeusAccessToken = $amadeusAccessToken;
    }

    public function getTripType($origin, $destination)
    {
        $airPortCodeController = new AirPortIATACodesController;
        $dep = strip_tags(trim($airPortCodeController->getCountry($origin)));
        $ari = strip_tags(trim($airPortCodeController->getCountry($destination)));
        if ($dep == "India" && $ari == "India") {
            return 1;
        } else {
            return 2;
        }
    }

    public function tripType($value)
    {
        if ($value == 'oneway') {
            return 1;
        } elseif ($value == 'roundtrip') {
            return 2;
        } elseif ($value == 'multicity') {
            return 3;
        }
    }

    public function searchFlight(Request $request)
    {

        $currency = $this->getvisitorcountrycurrency();
        try {
            $accessToken = $this->amadeusAccessToken->getAccessToken();
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);
            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
            ];
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $departureDate = $request->get('departDate');
        $returnDate = $request->get('returnDate');
        $origin = $request->get('departure');
        $destination = $request->get('arrival');
        $includedAirlineCodes = $request->get('includedAirlineCodes');
        $adults = $request->get('noOfAdults', 1);
        $children = $request->get('noOfChilds', 0);
        $infants = $request->get('noOfInfants', 0);
        $fareType = $request->get('fare', '');
        $travelClass = strtoupper($request->input('cabinClass'));
        $trip = $this->getTripType($origin, $destination); // Simplified logic for trip type
        // $tripType = $this->tripType($request['trip_type']); // Simplified logic for trip type
        $tripType = 1; // Simplified logic for trip type
        $travelClassMap = ['Y' => 'ECONOMY', 'W' => 'PREMIUM_ECONOMY', 'C' => 'BUSINESS', 'F' => 'FIRST'];
        $travelClass = isset($travelClassMap[$travelClass]) ? $travelClassMap[$travelClass] : null;
        if (!$travelClass) {
            return response()->json(['error' => 'Invalid cabin class provided. Please choose ECONOMY, BUSINESS, or FIRST_CLASS.'], 400);
        }

        $availability = [];
        $galileoflightController = new GalileoSearchFlightController;
        $amadeusflightController = new AmadeusSearchFlightController;
        $travellers = ['noOfAdults' => $adults, 'noOfChilds' => $children, 'noOfInfants' => $infants];

        $galileoAvailability = [];
        $amadeusAvailability = [];

        if ($request['trip_type'] === "oneway") {
            $amadeusAvailability = $amadeusflightController->onewayFlight(
                $trip,
                $departureDate,
                $origin,
                $destination,
                $adults,
                $includedAirlineCodes,
                $children,
                $infants,
                $travelClass,
                $client,
                $headers,
                $fareType
            );
            $galileoAvailability = $galileoflightController->Availability(
                $trip,
                $tripType,
                $departureDate,
                $adults,
                $children,
                $infants,
                $origin,
                $destination,
                ucfirst($travelClass)
            );
        } elseif ($request['trip_type'] === "roundtrip") {

            // $amadeusAvailability = $amadeusflightController->roundTripFlight(
            //     $trip, $departureDate, $returnDate, $origin, $destination, $adults, 
            //     $includedAirlineCodes, $children, $infants, $travelClass, $client, $headers, $this->amadeusAccessToken
            // );
            // $galileoAvailability = $galileoflightController->AvailabilityRound(
            //     $trip, $tripType, $departureDate, $returnDate, $adults, $children, 
            //     $infants, $origin, $destination, ucfirst($travelClass), $fareType
            // );
            $amadeusAvailabilitydeparture = $amadeusflightController->onewayFlight(
                $trip,
                $departureDate,
                $origin,
                $destination,
                $adults,
                $includedAirlineCodes,
                $children,
                $infants,
                $travelClass,
                $client,
                $headers,
                $fareType
            );
            $amadeusAvailabilityarival = $amadeusflightController->onewayFlight(
                $trip,
                $returnDate,
                $destination,
                $origin,
                $adults,
                $includedAirlineCodes,
                $children,
                $infants,
                $travelClass,
                $client,
                $headers,
                $fareType
            );
            $galileoAvailabilitydeparture = $galileoflightController->Availability(
                $trip,
                $tripType,
                $departureDate,
                $adults,
                $children,
                $infants,
                $origin,
                $destination,
                ucfirst($travelClass)
            );
            $galileoAvailabilityarival = $galileoflightController->Availability(
                $trip,
                $tripType,
                $returnDate,
                $adults,
                $children,
                $infants,
                $destination,
                $origin,
                ucfirst($travelClass)
            );

            $galileoAvailability = [
                'gal_departure' => $galileoAvailabilitydeparture,
                'gal_arrival' => $galileoAvailabilityarival,
            ];
            $amadeusAvailability = [
                'amadeus_departure' => $amadeusAvailabilitydeparture,
                'amadeus_arrival' => $amadeusAvailabilityarival,
            ];
        } elseif ($request['trip_type'] === "multicity") {
            $amadeusAvailability = $amadeusflightController->multyCityTripFlight(
                $trip,
                $departureDate,
                $returnDate,
                $origin,
                $destination,
                $adults,
                $includedAirlineCodes,
                $children,
                $infants,
                $travelClass,
                $client,
                $headers
            );
            $galileoAvailability = $galileoflightController->AvailabilityMultiCity(
                $trip,
                $tripType,
                $departureDate,
                $returnDate,
                $adults,
                $children,
                $infants,
                $origin,
                $destination,
                ucfirst($travelClass),
                $fareType
            );
        } else {
            return response()->json(['error' => 'Invalid trip type provided.'], 400);
        }

        $availabilityResults = [
            'galileo' => $galileoAvailability,
            'amadeus' => $amadeusAvailability,
            'airline' => $this->getAirline(),
            'currency' => $currency,
            'travellers' => $travellers,
            'trip_type' => $request['trip_type'],
            'city_name' => $this->getCityName()
        ];

        return response()->json($availabilityResults);
    }
}
