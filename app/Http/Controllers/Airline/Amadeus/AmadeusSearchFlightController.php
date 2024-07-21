<?php

namespace App\Http\Controllers\Airline\Amadeus;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class AmadeusSearchFlightController extends Controller
{

    public function onewayFlight(string $tripType, string $departureDate, string $origin, string $destination, int $adults, $includedAirlineCodes, int $children, int $infants, string $travelClass, Client $client, array $headers , $fareType): ?array
    {
        try {

            $response = $client->get('v2/shopping/flight-offers', [
                'headers' => $headers,
                'query' => [
                    "originLocationCode" => $origin,
                    "destinationLocationCode" => $destination,
                    "departureDate" => $departureDate,
                    "adults" => $adults,
                    "includedAirlineCodes" => $includedAirlineCodes,
                    "children" => $children,
                    "infants" => $infants,
                    "currencyCode" => $this->getCountryCode(),
                    "travelClass" => $travelClass,
                    // Optional parameters (comment out if not needed)
                    "max" => 20,
                    // "nonStop" => false,
                    // "excludedAirlineCodes" => ...,
                    // "maxPrice" => ...,
                    // "includeFares" => $fareType,
                ],
            ]);
            if (!empty($response)) {
                $responseData = json_decode($response->getBody(), true); // Decode response body as an array
                // Log::channel('xml')->info('Fetching hotel offers', ['response' => $responseData]);
                return $responseData;
            }
            return null;
        } catch (ClientException $e) {
            // Decode the response to get the error details
            $responseBody = json_decode($e->getResponse()->getBody(), true);
            return [
                'errors' => [
                    [
                        'status' => $e->getCode(),
                        'code' => $responseBody['errors'][0]['code'],
                        'title' => $responseBody['errors'][0]['title'],
                        'detail' => $responseBody['errors'][0]['detail'],
                        'source' => $responseBody['errors'][0]['source'] ?? []
                    ]
                ]
            ];
        } catch (\Exception $e) {
            // Catch any other exceptions and return a generic error message
            return response()->json([
                'errors' => [
                    [
                        'status' => 500,
                        'code' => 'INTERNAL_ERROR',
                        'title' => 'Internal Server Error',
                        'detail' => $e->getMessage(),
                        'source' => []
                    ]
                ]
            ], 500);
        }
    }

    public function roundTripFlight($tripType, $departureDate, $returnDate, $origin, $destination, $adults, $includedAirlineCodes, $children, $infants, $travelClass, Client $client, $headers ,$amadeusService)

    {
        try {
            $response = $client->get('v2/shopping/flight-offers', [
                'headers' => $headers,
                'query' => [
                    "originLocationCode" => $origin,
                    "destinationLocationCode" => $destination,
                    "departureDate" => $departureDate,
                    "adults" => $adults,
                    'returnDate' => $returnDate,
                    "max" => 5,
                    "children" => $children,
                    "includedAirlineCodes" => $includedAirlineCodes,
                    // "excludedAirlineCodes" =>
                    // "maxPrice" =>
                    // "nonStop" => false,
                    "infants" => $infants,
                    "currencyCode" => $this->getCountryCode(),
                    "travelClass" => $travelClass, // Amadeus uses travelClass Available values : ECONOMY, PREMIUM_ECONOMY, BUSINESS, FIRST
                    // Optional: Comment out if unsure about fare type
                    // "includeFares" => true,  // Include fares for sorting (optional)
                    // "maxNumberOfStops" => 2,  // Retrieve flights with up to 2 connections
                    // 'fare' => 'STD',
                ],
            ]);

            $amadeusService->logAmadeusRequest(
                'GET',
                'v2/shopping/flight-offers',
                [
                    'headers' => $headers,
                    'query' => [
                        "originLocationCode" => $origin,
                        "destinationLocationCode" => $destination,
                        "departureDate" => $departureDate,
                        "adults" => $adults,
                        "includedAirlineCodes" => $includedAirlineCodes,
                        "children" => $children,
                        "infants" => $infants,
                        "currencyCode" => $this->getCountryCode(),
                        "travelClass" => $travelClass,
                        "max" => 5,
                    ],
                ],
                $response,
                'request_success'
            );
            if (!empty($response)) {
                $responseData = json_decode($response->getBody(), true); // Decode response body as an array
                return $responseData;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No flight availabe',
                ]);
            }
        }catch (ClientException $e) {
            // Decode the response to get the error details
            $responseBody = json_decode($e->getResponse()->getBody(), true);
            return [
                'errors' => [
                    [
                        'status' => $e->getCode(),
                        'code' => $responseBody['errors'][0]['code'],
                        'title' => $responseBody['errors'][0]['title'],
                        'detail' => $responseBody['errors'][0]['detail'],
                        'source' => $responseBody['errors'][0]['source'] ?? []
                    ]
                ]
            ];
        } catch (\Exception $e) {
            // Catch any other exceptions and return a generic error message
            return response()->json([
                'errors' => [
                    [
                        'status' => 500,
                        'code' => 'INTERNAL_ERROR',
                        'title' => 'Internal Server Error',
                        'detail' => $e->getMessage(),
                        'source' => []
                    ]
                ]
            ], 500);
        }
    }

    public function multyCityTripFlight($tripType, $departureDate, $returnDate, $origin, $destination, $adults, $includedAirlineCodes, $children, $infants, $travelClass, Client $client, $headers)
    {
        try {
            $response = $client->get('v2/shopping/flight-offers', [
                'headers' => $headers,
                'query' => [
                    "originLocationCode" => $origin,
                    "destinationLocationCode" => $destination,
                    "departureDate" => $departureDate,
                    "adults" => $adults,
                    'returnDate' => $returnDate,
                    "max" => 10,
                    "children" => $children,
                    "includedAirlineCodes" => $includedAirlineCodes,

                    // "excludedAirlineCodes" =>
                    // "maxPrice" =>
                    "nonStop" => true,
                    "infants" => $infants,
                    "currencyCode" => $this->getCountryCode(),
                    "travelClass" => $travelClass, // Amadeus uses travelClass Available values : ECONOMY, PREMIUM_ECONOMY, BUSINESS, FIRST
                    // Optional: Comment out if unsure about fare type
                    // "includeFares" => true,  // Include fares for sorting (optional)
                    // "maxNumberOfStops" => 2,  // Retrieve flights with up to 2 connections
                    // 'fare' => 'STD',
                ],
            ]);
            if (!empty($response)) {
                return $response;

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No flight availabe',
                ]);
            }
        } catch (ClientException $e) {
            // Decode the response to get the error details
            $responseBody = json_decode($e->getResponse()->getBody(), true);
            return [
                'errors' => [
                    [
                        'status' => $e->getCode(),
                        'code' => $responseBody['errors'][0]['code'],
                        'title' => $responseBody['errors'][0]['title'],
                        'detail' => $responseBody['errors'][0]['detail'],
                        'source' => $responseBody['errors'][0]['source'] ?? []
                    ]
                ]
            ];
        } catch (\Exception $e) {
            // Catch any other exceptions and return a generic error message
            return response()->json([
                'errors' => [
                    [
                        'status' => 500,
                        'code' => 'INTERNAL_ERROR',
                        'title' => 'Internal Server Error',
                        'detail' => $e->getMessage(),
                        'source' => []
                    ]
                ]
            ], 500);
        }
    }


    
}
