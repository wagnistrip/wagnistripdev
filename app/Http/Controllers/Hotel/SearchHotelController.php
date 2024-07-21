<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AmadeusService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;

class SearchHotelController extends Controller
{
    private $amadeusAccessToken;
    public function __construct(AmadeusService $amadeusAccessToken)
    {
        $this->amadeusAccessToken = $amadeusAccessToken;
    }

    public function searchHotelByGeocode(Request $request)
    {
        try {

            $accessToken = $this->amadeusAccessToken->getAccessToken();

            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);

            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
            ];

            $latitude = $request->input('latitude');

            $longitude = $request->input('longitude');
            $radius = $request->input('radius', 5);
            $radiusUnit = $request->input('radiusUnit', 'KM');
            $chainCodes = $request->input('chainCodes');
            $amenities = $request->input('amenities');
            $ratings = $request->input('ratings');
            $hotelSource = $request->input('hotelSource', 'ALL');


            if (empty($latitude) || empty($longitude)) {
                return response()->json(['error' => 'Latitude and longitude are required'], 400);
            }


            $queryParams = [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'radius' => $radius,
                'radiusUnit' => $radiusUnit,
                'hotelSource' => $hotelSource,
            ];

            if (!empty($chainCodes)) {
                $queryParams['chainCodes'] = $chainCodes;
            }
            if (!empty($amenities)) {
                $queryParams['amenities'] = $amenities;
            }
            if (!empty($ratings)) {
                $queryParams['ratings'] = $ratings;
            }

            $response = $client->get('v1/reference-data/locations/hotels/by-geocode', [
                'headers' => $headers,
                'query' => $queryParams
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (isset($responseData['errors'])) {
                return response()->json(['error' => $responseData['errors']], 404);
            }

            return response()->json($responseData);
        } catch (\Amadeus\Exceptions\ResponseException $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    // For City code hotel searching 

    public function searchHotelByCityCode(Request $request)
{
    try {
        $accessToken = $this->amadeusAccessToken->getAccessToken();

        $client = new Client([
            'base_uri' => config('services.amadeus.url'),
        ]);

        $headers = [
            'Authorization' => sprintf('Bearer %s', $accessToken),
        ];

        $cityCode = $request->input('cityCode');
        $radius = $request->input('radius', 5);
        $radiusUnit = $request->input('radiusUnit', 'KM');
        $chainCodes = $request->input('chainCodes');
        $amenities = $request->input('amenities');
        $ratings = $request->input('ratings');
        $hotelSource = $request->input('hotelSource', 'ALL');

        if (empty($cityCode)) {
            return response()->json(['error' => 'City code is required'], 400);
        }

      
        $allAmenities = [
            'SWIMMING_POOL', 'SPA', 'FITNESS_CENTER', 'AIR_CONDITIONING', 'RESTAURANT', 'PARKING',
            'PETS_ALLOWED', 'AIRPORT_SHUTTLE', 'BUSINESS_CENTER', 'DISABLED_FACILITIES', 'WIFI',
            'MEETING_ROOMS', 'NO_KID_ALLOWED', 'TENNIS', 'GOLF', 'KITCHEN', 'ANIMAL_WATCHING',
            'BABY_SITTING', 'BEACH', 'CASINO', 'JACUZZI', 'SAUNA', 'SOLARIUM', 'MASSAGE',
            'VALET_PARKING', 'BAR_OR_LOUNGE', 'KIDS_WELCOME', 'NO_PORN_FILMS', 'MINIBAR',
            'TELEVISION', 'WI_FI_IN_ROOM', 'ROOM_SERVICE', 'GUARDED_PARKING', 'SERV_SPEC_MENU'
        ];

        $queryParams = [
            'cityCode' => $cityCode,
            'radius' => $radius,
            'radiusUnit' => $radiusUnit,
            'hotelSource' => $hotelSource,
        ];

        if (!empty($chainCodes)) {
            $queryParams['chainCodes'] = $chainCodes;
        }
        if (!empty($amenities)) {
            if (strtoupper($amenities) === 'ALL') {
                $queryParams['amenities'] = implode(',', $allAmenities);
            } else {
                $queryParams['amenities'] = implode(',', (array)$amenities);
            }
        }
        if (!empty($ratings)) {
            $queryParams['ratings'] = $ratings;
        }

        $response = $client->get('/v1/reference-data/locations/hotels/by-city', [
            'headers' => $headers,
            'query' => $queryParams
        ]);

        $responseData = json_decode($response->getBody(), true);

        if (isset($responseData['errors'])) {
            return response()->json(['error' => $responseData['errors']], 404);
        }

        return response()->json($responseData);
    } catch (\Amadeus\Exceptions\ResponseException $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}

   // for hotel id

    public function searchHotelByHotelIds(Request $request)
    {
        try {

            $accessToken = $this->amadeusAccessToken->getAccessToken();

           
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);


            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
            ];

            $hotelIds = $request->input('hotelIds');

            if (empty($hotelIds)) {
                return response()->json(['error' => 'Hotel IDs are required'], 400);
            }

            $queryParams = [
                'hotelIds' => $hotelIds,
            ];

            Log::info('Requesting hotel data with parameters:', $queryParams);

            $response = $client->get('v1/reference-data/locations/hotels/by-hotels', [
                'headers' => $headers,
                'query' => $queryParams
            ]);


            $responseData = json_decode($response->getBody(), true);

            if (isset($responseData['errors'])) {
                return response()->json(['error' => $responseData['errors']], 404);
            }

            return response()->json($responseData);
        } catch (\Amadeus\Exceptions\ResponseException $e) {

            Log::error('Amadeus API Response Exception:', ['message' => $e->getMessage()]);

            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {

            Log::error('General Exception:', ['message' => $e->getMessage()]);

            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function ShoppingHotelOffers(Request $request)
    {
        try {
            $accessToken = $this->amadeusAccessToken->getAccessToken();

            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);

            $queryParams = [
                'hotelIds' => $request->input('hotelIds'),
                'adults' => $request->input('adults', 1),
                'checkInDate' => $request->input('checkInDate'),
                'checkOutDate' => $request->input('checkOutDate'),
                'countryOfResidence' => $request->input('countryOfResidence'),
                'roomQuantity' => $request->input('roomQuantity', 1),
                'priceRange' => $request->input('priceRange'),
                'currency' => $request->input('currency', $this->getCountryCode()),
                'paymentPolicy' => $request->input('paymentPolicy', 'NONE'),
                'boardType' => $request->input('boardType'),
                'includeClosed' => $request->input('includeClosed', false),
                'bestRateOnly' => $request->input('bestRateOnly', true),
                'lang' => $request->input('lang'),
            ];


            $queryParams = array_filter($queryParams, function ($value) {
                return !is_null($value) && $value !== '';
            });

            Log::channel('xml')->info('Fetching hotel offers', ['queryParams' => $queryParams]);
            Log::info('Fetching hotel offers', ['queryParams' => $queryParams]);

            $response = $client->get('v3/shopping/hotel-offers', [
                'query' => $queryParams,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            if ($response->getStatusCode() === 200 && isset($responseData['data'])) {
                foreach ($responseData['data'] as &$hotel) {
                    if (isset($hotel['hotel']['media']) && is_array($hotel['hotel']['media'])) {
                        $hotel['images'] = array_map(function ($media) {
                            return $media['uri'];
                        }, $hotel['hotel']['media']);
                    } else {

                        Log::channel('xml')->warning('No media found for hotel', ['hotelId' => $hotel['hotel']['hotelId']]);
                        Log::warning('No media found for hotel', ['hotelId' => $hotel['hotel']['hotelId']]);
                        $hotel['images'] = [];
                    }
                }

                return response()->json($responseData);
            } else {
                Log::channel('xml')->error('Failed to fetch hotel offers');
                Log::error('Failed to fetch hotel offers', ['status_code' => $response->getStatusCode(), 'response' => $response->getBody()]);
                return response()->json([
                    'success' => false,
                    'message' => 'No hotel offers available',
                ], $response->getStatusCode());
            }
        } catch (ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody(), true);
            Log::channel('xml')->error('ClientException', ['error' => $responseBody, 'status' => $e->getCode()]);
            Log::error('ClientException', ['error' => $responseBody, 'status' => $e->getCode()]);
            return response()->json(['error' => $responseBody['errors']], $e->getCode());
        } catch (\Exception $e) {
            Log::channel('xml')->error('Exception', ['message' => $e->getMessage()]);
            Log::error('Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getHotelOfferPricing($hotelOfferId)
    {
        try {

            $accessToken = $this->amadeusAccessToken->getAccessToken();


            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);


            $url = "v3/shopping/hotel-offers/{$hotelOfferId}";


            Log::info('Fetching hotel offer', [
                'url' => $url,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
            ]);


            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
            ]);


            if ($response->getStatusCode() === 200) {

                $responseData = json_decode($response->getBody(), true);
                return response()->json($responseData);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No hotel offer available',
                ], 404);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $responseBody = json_decode($e->getResponse()->getBody(), true);
            Log::error('ClientException', ['response' => $responseBody]);
            return response()->json(['error' => $responseBody['errors']], $e->getCode());
        } catch (\Exception $e) {

            Log::error('Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getHotelSentiments(Request $request)
    {
        try {

            $accessToken = $this->amadeusAccessToken->getAccessToken();


            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);


            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
                'Accept' => 'application/json',
            ];

            $hotelIds = $request->input('hotelIds');


            if (empty($hotelIds)) {
                return response()->json(['error' => 'hotelIds is required'], 400);
            }


            $queryParams = [
                'hotelIds' => $hotelIds,
            ];


            Log::info('Fetching hotel sentiments', [
                'url' => 'v2/e-reputation/hotel-sentiments',
                'queryParams' => $queryParams,
                'headers' => $headers,
            ]);


            $response = $client->get('v2/e-reputation/hotel-sentiments', [
                'headers' => $headers,
                'query' => $queryParams,
            ]);


            if ($response->getStatusCode() === 200) {

                $responseData = json_decode($response->getBody(), true);
                return response()->json($responseData);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to fetch hotel sentiments',
                ], 404);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $responseBody = json_decode($e->getResponse()->getBody(), true);
            Log::error('ClientException', ['response' => $responseBody]);
            return response()->json(['error' => $responseBody['errors']], $e->getCode());
        } catch (\Exception $e) {

            Log::error('Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function searchHotelsByKeyword(Request $request)
    {
        try {
            $accessToken = $this->amadeusAccessToken->getAccessToken();
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);

            $headers = [
                'Authorization' => sprintf('Bearer %s', $accessToken),
                'Accept' => 'application/json',
            ];

            $keyword = $request->input('keyword');
            $subTypes = $request->input('subType');
            $countryCode = $request->input('countryCode');
            $lang = $request->input('lang', 'EN');
            $max = $request->input('max', 20);

            $request->validate([
                'keyword' => 'required|string',
                'subType' => 'required|string',
                'countryCode' => 'nullable|string|size:2',
                'lang' => 'nullable|string|size:2',
                'max' => 'nullable|integer|min:1|max:20',
            ]);

            $queryParams = [
                'keyword' => $keyword,
                'subType' => $subTypes,
                'countryCode' => $countryCode,
                'lang' => $lang,
                'max' => $max,
            ];

            $queryParams = array_filter($queryParams, function ($value) {
                return !is_null($value) && $value !== '';
            });

            Log::channel('xml')->info('Fetching hotel locations', [
                'url' => 'v1/reference-data/locations/hotel',
                'queryParams' => $queryParams,
                'headers' => $headers,
            ]);

            Log::info('Fetching hotel locations', [
                'url' => 'v1/reference-data/locations/hotel',
                'queryParams' => $queryParams,
                'headers' => $headers,
            ]);

            $response = $client->get('v1/reference-data/locations/hotel', [
                'headers' => $headers,
                'query' => $queryParams,
            ]);

            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);
                return response()->json($responseData);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to fetch hotel locations',
                ], $response->getStatusCode());
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody(), true);
            Log::channel('xml')->error('ClientException', ['response' => $responseBody]);
            Log::error('ClientException', ['response' => $responseBody]);
            return response()->json(['error' => $responseBody['errors']], $e->getCode());
        } catch (\Exception $e) {
            Log::channel('xml')->error('Exception', ['message' => $e->getMessage()]);
            Log::error('Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    

}