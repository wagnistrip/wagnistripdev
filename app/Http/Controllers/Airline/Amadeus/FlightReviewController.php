<?php

namespace App\Http\Controllers\Airline\Amadeus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AmadeusService;
use Exception;
use GuzzleHttp\Client;
class FlightReviewController extends Controller
{
    private $amadeusAccessToken;
    public function __construct(AmadeusService $amadeusAccessToken)
    {
        $this->amadeusAccessToken = $amadeusAccessToken;
    }
    public function reviewFlight(Request $request)
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
    
            $response = $client->post('v2/shopping/flight-offers', [
                'headers' => $headers,
                'json' => $body,
            ]);
    
            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);
                return $responseData;
            }
    
            return response()->json(['error' => 'No response from Amadeus'], $response->getStatusCode());
    
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
