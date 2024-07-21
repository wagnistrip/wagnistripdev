<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Controller;
use App\Models\GalileoFlightLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GalileoSearchFlightController extends Controller
{
    public function Authenticate()
    {
        $body = [
            "UserName" => config('services.galileo.user_name'),
            "Password" => config('services.galileo.password'),
        ];
        $response = $this->callApiWithHeadersGal("Authenticate", $body);
        return $response['SessionID'];
    }

    public static function callApiWithHeadersGal($action, $body)
    {
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json",
        ])->send("POST", config('services.galileo.url') . $action, [
            "body" => json_encode($body, true),
        ])->json();

        if ($action == "Authenticate") {
            $response['SessionID'];
            $flightLogs = new GalileoFlightLog;
            $flightLogs->session_id = $response['SessionID'];
            $flightLogs->authenticate = json_encode($response, true);
            $flightLogs->availability = json_encode($response, true);
            // something go's there
            $flightLogs->save();
        } else {
            $action = strtolower($action);
            if (empty($body['SessionID'])) {
                throw new Exception('User not authenticated.');
            }

            // dd($body['SessionID']);
            $flightLogs = GalileoFlightLog::where('session_id', '=', $body['SessionID'])->first();
            $flightLogs->$action = json_encode(['Request_Of_' . $action => $body, 'Response_Of_' . $action => $response], true);
            $flightLogs->save();
        }
        return $response;
    }

    public function Availability($trip, $tripType, $date, $adult, $child, $infant, $origin, $destination, $class)
    {
        // dd([$trip, $tripType, $date, $adult, $child, $infant, $origin, $destination]);

        try {
            $SessionID = $this->Authenticate();
            // Validate inputs
            $date = \DateTime::createFromFormat("Y-m-d", $date);
            $date = $date->format("d/m/Y");
            $body = [
                "ClientCode" => config('services.galileo.user_name'),
                "Trip" => $trip,
                "TripType" => $tripType,
                "Adult" => $adult,
                "Child" => $child,
                "Infant" => $infant,
                "NonStop" => false,
                "ExcludeAirlines" => "",
                "ExcludeAirline" => [],
                "PreferredClass" => $class,
                "PreferredCarrier" => "",
                "RTF" => false,
                "SessionID" => $SessionID,
                "TravelerType" => '',
                "Segments" => [
                    [
                        "Origin" => $origin,
                        "Destination" => $destination,
                        "DepartDate" => $date,
                        "PreferredClass" => $class,
                    ],
                ],
            ];
            $response = $this->callApiWithHeadersGal("Availability", $body);
            // $logPath = storage_path('logs/galileo/' . 'one_way_flight' . date('Y-m-d') . '.xml');
            // config(['logging.channels.galileo.path' => $logPath]);
            // Log::channel('galileo')->info('Fetching Flight offers', ['response' => $response]);
            return $response;
        }catch (\GuzzleHttp\Exception\RequestException $e) {
            // Log::error('HTTP Request failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage().'Failed to fetch availability due to network error. Please try again later.'], 400);
         } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function AvailabilityRound($trip, $tripType, $date, $returnDate, $adult, $child, $infant, $origin, $destination, $class)
    {
        $SessionID = $this->Authenticate();

        $date = \DateTime::createFromFormat("Y-m-d", $date);
        $date = $date->format("d/m/Y");

        $returnDate = \DateTime::createFromFormat("Y-m-d", "$returnDate");
        $returnDate = $returnDate->format("d/m/Y");
        try {
            $body = [
                "ClientCode" => config('services.galileo.user_name'),
                "Trip" => $trip,
                "TripType" => $tripType,
                "Adult" => $adult,
                "Child" => $child,
                "Infant" => $infant,
                "NonStop" => false,
                "ExcludeAirlines" => "",
                "ExcludeAirline" => [],
                "PreferredClass" => $class,
                "PreferredCarrier" => "",
                "RTF" => true,
                "SessionID" => $SessionID,
                "TravelerType" => 'ADT',
                "Segments" => [
                    [
                        "Origin" => $origin,
                        "Destination" => $destination,
                        "DepartDate" => $date,
                        "PreferredClass" => $class,
                    ],
                    [
                        "Origin" => $destination,
                        "Destination" => $origin,
                        "DepartDate" => $returnDate,
                        "PreferredClass" => $class,
                    ],
                ],
            ];
            $response = $this->callApiWithHeadersGal("Availability", $body);
            // dd($response);
            return $response;
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }

    public function AvailabilityMultiCity($trip, $tripType, $date, $returnDate, $adult, $child, $infant, $origin, $destinations, $class)
    {
        try {
            $sessionID = $this->Authenticate();

            if (!$sessionID) {
                throw new \Exception('Failed to authenticate with Galileo API');
            }

            $body = [
                "ClientCode" => config('services.galileo.user_name'),
                "Trip" => $trip,
                "TripType" => $tripType,
                "Adult" => $adult,
                "Child" => $child,
                "Infant" => $infant,
                "NonStop" => false,
                "PreferredClass" => $class,
                "PreferredCarrier" => "",
                "RTF" => true,
                "SessionID" => $sessionID,
                "Segments" => [
                    [
                        "Origin" => "DEL",
                        "Destination" => "CCU",
                        "DepartDate" => "28/05/2024",
                        "PreferredClass" => $class,
                    ],
                    [
                        'Origin' => 'CCU',
                        'Destination' => 'BLR',
                        "DepartDate" => "30/05/2024",
                        "PreferredClass" => $class,
                    ],
                    [
                        'Origin' => 'BLR',
                        'Destination' => 'DEL',
                        "DepartDate" => "05/06/2024",
                        "PreferredClass" => $class,
                    ],
                ],
            ];
            $response = $this->callApiWithHeadersGal("Availability", $body);
            return $response;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function callAgencyBalanceApiWithHeadersGal($endpoint, $body)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint . '/AgencyBalance',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode(config('services.galileo.user_name') . ":" . config('services.galileo.password')),
                // Additional headers required by the API (if applicable)
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($body),
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'success' => false,
                'message' => 'Error calling API: ' . $err,
            ];
        } else {
            // Parse the JSON response and return relevant data (replace with actual parsing logic)
            $decodedResponse = json_decode($response, true);

            if (isset($decodedResponse['success']) && $decodedResponse['success']) {
                return [
                    'success' => true,
                    'data' => $decodedResponse['data'], // Replace with actual data structure
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'API error: ' . (isset($decodedResponse['message']) ? $decodedResponse['message'] : 'Unknown error'),
                    'response' => $decodedResponse, // Add this line to log the full response for debugging
                ];
            }
        }
    }

    public function agencyBalance()
    {

        // 1. Authentication (Replace with actual implementation)
        $SessionID = $this->Authenticate(); // Assuming you have an `Authenticate` function

        // 2. API Endpoint (Replace with actual endpoint for agency balance if available)
        $endpoint = config('services.galileo.url'); // Replace with actual endpoint URL

        // 3. Request Body (Replace with actual parameters if needed)
        $body = [
            "UserName" => config('services.galileo.user_name'),
            "Password" => config('services.galileo.password'),
            "SessionID" => $SessionID,
            // Include additional parameters required by the endpoint (if applicable)
        ];

        // 4. API Call (Replace with actual implementation)
        $response = $this->callAgencyBalanceApiWithHeadersGal($endpoint, $body);

        // 5. Error Handling and Response Parsing
        if ($response['success']) {
            // Parse the response to extract your agency value (replace placeholders)
            $agencyValue = $response['data']['agencyBalance'] ?? null; // Example structure
            if ($agencyValue) {
                return $agencyValue;
            } else {
                return 'Agency balance not found in response.';
            }
        } else {
            return 'Error retrieving agency balance: ' . $response['message'];
        }
    }

    public function sessionEnd(Request $request)
    {
        $body = [
            "UserName" => config('services.galileo.user_name'),
            "Password" => config('services.galileo.password'),
            "Session" => $request->input('SessionID'),
        ];
        try {
            $response = $this->callApiWithHeadersGal("EndSession", $body);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function searchCityLeast(Request $request)
    {
        $sessionID = $this->Authenticate();
        $city = $request->input('City'); // Get the city name from the request
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $sessionID,
            "City" => $city,
        ];
        // return $body;
        try {
            $response = $this->callApiWithHeadersGal("Citylist", $body);
            return $response;
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                throw new \Exception('Citylist request failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
