<?php

use App\Http\Controllers\Airline\AirPortIATACodesController;
use App\Http\Controllers\Airline\Both\SearchFlightController;
use App\Http\Controllers\Airline\Payment\PayPalController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\Hotel\{SearchHotelController, HotelBookingController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\{RazorpayPaymentController, CartController};
use App\Http\Controllers\EasebuzzController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
// --------------- Flight Location Search --------------- //

Route::get('/phonecode', [HelperController::class, 'phonecode']);
Route::get('/airlinecodes', [AirPortIATACodesController::class, 'searchAirIataCode']);
Route::get('/city-list', [AirPortIATACodesController::class, 'searchCityLeast']);
Route::get('/country-code', [AirPortIATACodesController::class, 'searchCountryCode']);
Route::get('/country-iso', [AirPortIATACodesController::class, 'searchCountryIso']);
Route::get('/Hotel-city', [AirPortIATACodesController::class, 'HotelCity']);
Route::get('geolocationinfo', [AirPortIATACodesController::class, 'get_geolocation_info']);

// --------------- Amadeus Flight --------------- //

// --------------- Flight booking --------------- //

// Amadeus Flight Offers Search
Route::get('flight/{slug}', [SearchFlightController::class, 'searchFlight']);


// --------------- Galileo FLight --------------- //


// --------------- Amadeus Destination experiences --------------- //
//  Amadeus Points Of Interest

//  Amadeus Tours and Activities

// --------------- Amadeus Car and Transfers --------------- //

// --------------- Amadeus Market insights --------------- //
// Safe Place
// Transfer Booking
// --------------- Amadeus Hotels --------------- //
// Transfer Management
//Transfer Search
// City Search
//Travel Recommendations
//Travel Restrictions
// --------------- Amadeus Hotels Booking --------------- //

// --------------- Amadeus Hotels Search --------------- //

// --------------- Amadeus Itinerary management --------------- //
// --------------- Amadeus Itinerary Trip Parser --------------- //
// --------------- Amadeus Itinerary Trip Purpose Prediction --------------- //


// Trip Parser

// ---------------- Payment --------------------- //
Route::controller(RazorpayPaymentController::class)->group(function () {
    // Route::post('/create-order', 'createPaymentLink');
    Route::group(['prefix' => 'razorpay'], function () {
        Route::post('/create-payment-link', 'createPaymentLink');
        Route::post('/create-order',  'createOrder');
        Route::get('/payment-callback', 'handlePaymentCallback')->name('payment.callback');
    });
});
Route::controller(PayPalController::class)->group(function () {
    Route::group(['prefix' => 'paypal'], function () {
        Route::post('create-payment',  'createPayment');
        Route::post('capture-payment',  'executePayment');
        Route::get('success',  'executePayment')->name('paypal.success');
        Route::get('cancel',  'cancelPayment')->name('paypal.cancel');
    });
});

Route::group(['prefix' => 'cart'], function () {
    Route::post('/galelio-traveller-details', [CartController::class, 'PaymentSaveGalelio'])->name('galelio-traveller-details');
    Route::post('/galelio-traveller-details-roundtrip', [CartController::class, 'PaymentSaveGalelioRoundTrip'])->name('galelio-traveller-details-roundtrip');
    Route::get('/galelio-traveller-details-roundtrip-internation', [CartController::class, 'PaymentSaveGaleliointerRoundTrip'])->name('galelio-traveller-details-roundtrip-internation');
    Route::post('/galelio-traveller-details-buzz', [CartController::class, 'BuzzSaveGalelioRoundTrip'])->name('cart.galelio-traveller-details-roundtrip-buzz');
});

//  for hotel List
Route::get('hotel/search', [SearchHotelController::class, 'searchHotelByGeocode']);
Route::get('hotel/search-bycityCode', [SearchHotelController::class, 'searchHotelByCityCode']);
Route::get('hotel/search-byhotel-ID', [SearchHotelController::class, 'searchHotelByHotelIds']);


//  For hotel Search Offers

Route::get('hotel/shopping-hotel-offers', [SearchHotelController::class, 'ShoppingHotelOffers']);
Route::get('/fetch-hotel-offer/{hotelOfferId}', [SearchHotelController::class, 'getHotelOfferPricing']);

// Hotel Rating

Route::get('hotel/get-hotel-rating', [SearchHotelController::class, 'getHotelSentiments']);
Route::get('search-hotel-by-keyword', [SearchHotelController::class, 'searchHotelsByKeyword']);

// Hotel Booking
Route::post('hotel-booking', [HotelBookingController::class, 'HotelBookingCode']);
Route::post('create-hotel-order', [HotelBookingController::class, 'CreateHotelOrder']);



//payment
Route::post('booking/process-payment', [EasebuzzController::class, 'processPayment']);
Route::get('payment/success', [EasebuzzController::class, 'paymentSuccess'])->name('payment.success');
Route::get('payment/failure', [EasebuzzController::class, 'paymentFailure'])->name('payment.failure');


require __DIR__ . '/galileo.php';
require __DIR__ . '/amadeus.php';
