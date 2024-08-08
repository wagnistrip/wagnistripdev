<?php

namespace App\Http\Controllers\Airline\Amadeus;

use App\Http\Controllers\Controller;
use App\Services\AmadeusService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OrderFlightController extends Controller
{
    private $amadeusAccessToken;
    public function __construct(AmadeusService $amadeusAccessToken)
    {
        $this->amadeusAccessToken = $amadeusAccessToken;
    }
    public function offerPrice(Request $request)
    {
        
        // return $request;
        try {
            $currency = $this->getvisitorcountrycurrency();
            $accessToken = $this->amadeusAccessToken->getAccessToken();
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);
            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
                'Content-Type' => 'application/json', 
            ];
            $body = $request->json()->all();
            // $body = json_encode($jsonData); // Encode data as JSON
            $response = $client->post('v1/shopping/flight-offers/pricing', [
                'headers' => $headers,
                'json' => $body, 
            ]);
            if (!empty($response)) {
                $responseData['currency'] = $currency;
                $responseData['response']  = json_decode($response->getBody(), true); 
                return $responseData;
            }
            return null;
        } catch (\Amadeus\Exceptions\ResponseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function orderFlight(Request $request)
    {
        try {
            $accessToken = $this->amadeusAccessToken->getAccessToken();
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);
            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
                'Content-Type' => 'application/json',
            ];
            $body = $request->json()->all();
            $response = $client->post('v1/booking/flight-orders', [
                'headers' => $headers,
                'json' => $body,
            ]);
            if (!empty($response)) {
                return response()->json([
                    'status' => 'success',
                    'response' => json_decode($response->getBody(), true),
                ]);
            }
            return response()->json(['status' => 'failed', 'message' => 'No response from Amadeus API'], 500);
        } catch (\Amadeus\Exceptions\ResponseException $e) {
            return response()->json(['status' => 'failed', 'error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function getFlight($id) 
    {
        try {
            $currency = $this->getvisitorcountrycurrency();

            $accessToken = $this->amadeusAccessToken->getAccessToken();
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);
            $headers = [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ];
            $response = $client->get('v1/booking/flight-orders/' . $id, [
                'headers' => $headers,
            ]);
            if ($response->getStatusCode() === 200) {
                $responseData['currency'] = $currency;
                $responseData['response'] = json_decode($response->getBody(), true);
                return $responseData;
            }
            return null;
        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $error = json_decode($response->getBody(), true)['errors'][0] ?? 'An error occurred.';
            return response()->json([
                'error' => $error,
            ], $statusCode);
        }
    }

    public function cancelFlight($id) 
    {
        try {
            $accessToken = $this->amadeusAccessToken->getAccessToken();

            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);
            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
            ];
            $response = $client->delete('v1/booking/flight-orders/' . $id, [
                'headers' => $headers,
            ]);
            if ($response->getStatusCode() === 204) {
                return response()->json(['message' => 'Flight order successfully cancelled.']);
            } else {
                // Handle unexpected status codes (optional)
                return response()->json(['error' => 'An error occurred during cancellation.'], 500);
            }
        } catch (\Amadeus\Exceptions\ResponseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function getSeatmap(Request $request)
    {
        try {
            $accessToken = $this->amadeusAccessToken->getAccessToken();

            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);
            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
                'Content-Type' => 'application/json',
            ];
            $flightOrderId = $request->get('flight-orderId');

            $response = $client->get('v1/shopping/seatmaps', [
                'headers' => $headers,
                'query' => [
                    'flightOrderId' => $flightOrderId,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);
                return $responseData; // Return seatmap data
            } else {
                // Handle unsuccessful response (e.g., 400 Bad Request, 404 Not Found)
                $error = json_decode($response->getBody(), true)['error'];
                // return response()->json(['error' => $error['message'] ?? 'An error occurred.'], $response->getStatusCode());
            }
        } catch (\Amadeus\Exceptions\ResponseException $e) {
            // return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function storeSheatmap(Request $request)
    {
        try {
            $accessToken = $this->amadeusAccessToken->getAccessToken();

            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);
            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
                'Content-Type' => 'application/json',
            ];
            $jsonData = $request->json()->all();
            $body = json_encode($jsonData); // Encode data as JSON

            $response = $client->post('v1/shopping/seatmaps', [
                'headers' => $headers,
                'body' => $body,
            ]);

            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);
                return response()->json($responseData); // Return seatmap data
            } else {
                $responseBody = json_decode($response->getBody(), true);
                $error = $responseBody['errors'][0]['detail'] ?? 'An error occurred.';
                return response()->json(['error' => $error], $response->getStatusCode());
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody(), true);
            $error = $responseBody['errors'][0]['detail'] ?? 'An error occurred.';
            return response()->json(['error' => $error], $e->getResponse()->getStatusCode());
        } catch (\Amadeus\Exceptions\ResponseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function upsellingOffer(Request $request)
    {
        try {
            // Get Amadeus access token
            $accessToken = $this->amadeusAccessToken->getAccessToken();

            // Create Amadeus API client with base URL
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);

            // Build headers with authorization and content type
            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
                'Content-Type' => 'application/json', // Add Content-Type header
            ];

            // Extract JSON data from request (assuming valid format)
            $jsonData = $request->json()->all();

            // Encode request body as JSON
            $body = json_encode($jsonData);

            // Make POST request to Amadeus upselling endpoint
            $response = $client->post('v1/shopping/flight-offers/upselling', [
                'headers' => $headers,
                'body' => $body,
            ]);

            // Handle successful response (200 status code)
            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);
                return $responseData; // Return upselling offer details
            }

            // Handle unsuccessful response (generic error handling for now)
            $error = json_decode($response->getBody(), true)['error'] ?? 'An error occurred.';
            return response()->json([
                'error' => $error,
                'error_code' => null, // Assuming no error code in unsuccessful responses yet
            ], $response->getStatusCode());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle client exceptions
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $error = json_decode($response->getBody(), true)['errors'][0] ?? 'An error occurred.';
            return response()->json([
                'error' => $error,
            ], $statusCode);
        } catch (\Exception $e) {
            // Handle unexpected exceptions
            return response()->json([
                'error' => [
                    "message" => "We couldn't find any upsell offers for your flight at this time. Please try again later.",
                    "code" => 400,
                    "detail" => "UNABLE TO RETRIEVE UPSELL OFFER (code: 39397)",
                ],
                'error_code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function priceAnalysis(Request $request)
    { 
        {
            try {
                $accessToken = $this->amadeusAccessToken->getAccessToken();
                $client = new Client([
                    'base_uri' => config('services.amadeus.url'),
                ]);
                $headers = [
                    'Authorization' => sprintf('Bearer %s', $accessToken),
                    'Content-Type' => 'application/json', // Add Content-Type header
                ];
                $response = $client->get('v1/analytics/itinerary-price-metrics', [
                    'headers' => $headers,
                    'query' => [
                        "originIataCode" => $request->originIataCode,
                        "destinationIataCode" => $request->destinationIataCode,
                        "departureDate" => $request->departureDate,
                        "currencyCode" => $this->getCountryCode(),
                        "oneWay" => $request->oneWay,
                    ],
                ]);
                if (!empty($response)) {
                    $responseData = json_decode($response->getBody(), true); // Decode response body as an array
                    return $responseData;
                }
                return null;
            } catch (\Amadeus\Exceptions\ResponseException $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function getofferPrediction(Request $request)
    { 
        {
            try {
                $accessToken = $this->amadeusAccessToken->getAccessToken();
                $client = new Client([
                    'base_uri' => config('services.amadeus.url'),
                ]);
                $headers = [
                    'Authorization' => sprintf('Bearer %s', $accessToken),
                    'Content-Type' => 'application/json',
                ];
                $jsonData = $request->json()->all();
                $body = json_encode($jsonData);
                $response = $client->post('v2/shopping/flight-offers/prediction', [
                    'headers' => $headers,
                    'body' => $body,
                ]);
                return $response;
                if (!empty($response)) {
                    $responseData = json_decode($response->getBody(), true); // Decode response body as an array
                    return $responseData;
                }
            } catch (\Amadeus\Exceptions\ResponseException $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
    
    
}
