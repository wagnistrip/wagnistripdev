<?php


namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AmadeusService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use GuzzleHttp\Exception\RequestException;

class HotelBookingController extends Controller
{
    private $amadeusAccessToken;
    public function __construct(AmadeusService $amadeusAccessToken)
    {
        $this->amadeusAccessToken = $amadeusAccessToken;
    }

    public function HotelBookingCode(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'data.offerId' => 'required|string',
                'data.guests' => 'required|array',
                'data.guests.*.name.title' => 'required|string',
                'data.guests.*.name.firstName' => 'required|string',
                'data.guests.*.name.lastName' => 'required|string',
                'data.guests.*.contact.phone' => 'required|string',
                'data.guests.*.contact.email' => 'required|email',
                'data.payments' => 'required|array',
                'data.payments.*.method' => 'required|string',
                'data.payments.*.card.vendorCode' => 'required|string',
                'data.payments.*.card.cardNumber' => 'required|string',
                'data.payments.*.card.expiryDate' => 'required|string|date_format:Y-m',
            ]);


            $bookingData = [
                'offerId' => $validatedData['data']['offerId'],
                'guests' => $validatedData['data']['guests'],
                'payments' => $validatedData['data']['payments'],
            ];


            Log::info('Booking Data:', ['data' => $bookingData]);


            $accessToken = $this->amadeusAccessToken->getAccessToken();


            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);


            $response = $client->post('v1/booking/hotel-bookings', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/vnd.amadeus+json',
                    'Accept-Encoding' => 'gzip, identity',
                    'Ama-Client-Ref' => Str::uuid()->toString(),
                ],
                'json' => ['data' => $bookingData],
            ]);

            $responseBody = json_decode($response->getBody(), true);
            // Log the exact response for debugging
            Log::info('Amadeus API Response', [
                'status_code' => $response->getStatusCode(),
                'body' => $responseBody,
            ]);
            // Check the response status code
            if ($response->getStatusCode() === 201) {

                return response()->json([
                    'success' => true,
                    'data' => $responseBody,
                ]);
            } else {

                return response()->json([
                    'success' => false,
                    'message' => 'Booking failed',
                    'details' => $responseBody,
                ], $response->getStatusCode());
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errorResponse = $e->getResponse() ? json_decode($e->getResponse()->getBody(), true) : null;
            Log::error('Amadeus Booking Error', [
                'message' => $e->getMessage(),
                'response' => $errorResponse,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Booking failed',
                'details' => $errorResponse ?: ['error' => 'An error occurred'],
            ], $e->getResponse() ? $e->getResponse()->getStatusCode() : 500);
        } catch (\Exception $e) {

            Log::error('General Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function CreateHotelOrder(Request $request){
        try {

            $validatedData = $request->validate([
                'data.type' => 'required|string',
                'data.guests' => 'required|array',
                'data.guests.*.tid' => 'required|integer',
                'data.guests.*.title' => 'required|string',
                'data.guests.*.firstName' => 'required|string',
                'data.guests.*.lastName' => 'required|string',
                'data.guests.*.phone' => 'required|string',
                'data.guests.*.email' => 'required|email',
                'data.travelAgent.contact.email' => 'required|email',
                'data.roomAssociations' => 'required|array',
                'data.roomAssociations.*.guestReferences' => 'required|array',
                'data.roomAssociations.*.guestReferences.*.guestReference' => 'required|string',
                'data.payment' => 'required|array',
                'data.payment.method' => 'required|string',
                'data.payment.paymentCard.paymentCardInfo.vendorCode' => 'required|string',
                'data.payment.paymentCard.paymentCardInfo.holderName' => 'required|string',
                'data.payment.paymentCard.paymentCardInfo.cardNumber' => 'required|string',
                'data.payment.paymentCard.paymentCardInfo.expiryDate' => 'required|string',
            ]);

            // Prepare the booking data from the request input
            $bookingData = $validatedData['data'];

            // Log the booking data for debugging
            Log::info('Booking Data:', ['data' => $bookingData]);

            $accessToken = $this->amadeusAccessToken->getAccessToken();

            // Initialize the Guzzle HTTP client
            $client = new Client([
                'base_uri' => config('services.amadeus.url'),
            ]);

            // Make the API call to Amadeus
            $response = $client->post('v2/booking/hotel-orders', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/vnd.amadeus+json',
                    'Accept-Encoding' => 'gzip, identity',
                    'Ama-Client-Ref' => Str::uuid()->toString(),
                ],
                'json' => ['data' => $bookingData],
            ]);

            $responseBody = json_decode($response->getBody(), true);

            // Log the exact response for debugging
            Log::info('Amadeus API Response', [
                'status_code' => $response->getStatusCode(),
                'body' => $responseBody,
            ]);

            // Check the response status code
            if ($response->getStatusCode() === 201) {

                return response()->json([
                    'success' => true,
                    'data' => $responseBody,
                ]);
            } else {

                return response()->json([
                    'success' => false,
                    'message' => 'Booking failed',
                    'details' => $responseBody,
                ], $response->getStatusCode());
            }
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse() ? json_decode($e->getResponse()->getBody(), true) : null;
            Log::error('Amadeus Booking Error', [
                'message' => $e->getMessage(),
                'response' => $errorResponse,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Booking failed',
                'details' => $errorResponse ?: ['error' => 'An error occurred'],
            ], $e->getResponse() ? $e->getResponse()->getStatusCode() : 500);
        } catch (\Exception $e) {

            Log::error('General Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
