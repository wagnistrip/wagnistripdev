<?php

namespace App\Http\Controllers\Airline\Galileo;

use App\Http\Controllers\Airline\Galileo\AuthenticateController;
use App\Http\Controllers\Controller;
use App\Models\VisitorGeolocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PricingController extends Controller
{
    public function pricing(Request $request)
    {
        try {
            $data_currency = VisitorGeolocation::geolocationInfo();
            $code = 'INR'; // Default currency code
            $cvalue = '₹'; // Default currency value
            $currency = $this->getvisitorcountrycurrency();

            if (!empty($data_currency)) {
                $code = is_array($data_currency) ? $data_currency['code'][0] : $data_currency['code'];
                $cvalue = $data_currency['value'];
            }

            $travellers = json_decode($request['travellers'], true);
            $SessionID = $request['SessionID'];

            // return $SessionID;
            $body = [
                "ClientCode" => config('services.galileo.user_name'),
                "SessionID" => $request['SessionID'],
                "Key" => $request['Key'],
                "Pricingkey" => $request['Pricingkey'],
                "Provider" => $request['Provider'],
                "ResultIndex" => $request['ResultIndex'],
                "IsPriceChange" => true,
            ];

            // return $body;
            $response = AuthenticateController::callApiWithHeadersGal("Pricing", $body);

            if ($response['Status'] != "Success") {
                return response()->json([
                    'success' => false,
                    'message' => $response['Error']['Description'],
                ]);
            }
            // Assuming the response contains flight options and pricing details
            // $flightOptions = $this->parseFlightOptionsWithPricing($response); // Replace with actual parsing logic
            $logPath = storage_path('logs/galileo/' . 'get_pricing_details_' . date('Y-m-d') . '.xml');
            config(['logging.channels.galileo.path' => $logPath]);

            Log::channel('galileo')->info('Fetching Flight offers', ['response' => $response]);
            return response()->json([
                'flightOptions' => $response,
                'adult' => $request['adult'],
                'child' => $request['child'],
                'infant' => $request['infant'],
                'currencyCode' => $code,
                'currencyValue' => $cvalue,
                'currency' =>$currency,
                'airline' => $this->getAirline(),
                'city_name' => $this->getCityName(),
                'trip_type' => $request['trip_type'],
                'trip' => $request['trip'],
                // 'travellers' => $travellers,
            ])->withHeaders(["SessionID" => $SessionID,]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }

    public function getFlightFareRule(Request $request)
    {
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "SupplierCode" => $request->input('SupplierCode'),
            "AirCode" => $request->input('AirCode'),
            "PnrNO" => $request->input('PnrNO'),
            "DepartDate" => $request->input('DepartDate'),
            "DepartTime" => $request->input('DepartTime'),
            "IsPriceChange" => true,
        ];

        try {
            $response = AuthenticateController::callApiWithHeadersGal("FareRule", $body);
            return $response;
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getNonLccFlightFareRule(Request $request)
    {
        // return $request;
        $body = [
            "ClientCode" => config('services.galileo.user_name'),
            "SessionID" => $request->input('SessionID'),
            "Key" => $request->input('Key'),
            "ResultIndex" => $request->input('ResultIndex'),
            "PnrNO" => $request->input('PnrNO'),
            "Pricingkey" => $request->input('Pricingkey'),
            "UserID" => config('services.galileo.user_name'),
            "IsPriceChange" => true,
        ];

        try {
            $response = AuthenticateController::callApiWithHeadersGal("Non-LccFareRule", $body);
            // return response()->json($response);
            return $response;
        } catch (\Exception $e) {
            // Handle any exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
}
