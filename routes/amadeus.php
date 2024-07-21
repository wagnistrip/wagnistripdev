<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Airline\{ Amadeus\OrderFlightController , Amadeus\FlightReviewController};

Route::post('amadeus/search', [FlightReviewController::class, 'reviewFlight']);
// Amadeus Flight Offers Price
Route::post('amadeus/Pricing', [OrderFlightController::class, 'offerPrice']);
// Amadeus Flight Create Orders
Route::post('booking/flight-orders', [OrderFlightController::class, 'orderFlight']);
// Amadeus Flight Order Management
Route::get('booking/flight-orders/{id}', [OrderFlightController::class, 'getFlight']);
Route::delete('booking/flight-orders/{id}', [OrderFlightController::class, 'cancelFlight']);
// Amadeus FLight SeatMap Display
Route::get('/shopping/seatmaps', [OrderFlightController::class, 'getSeatmap']);
Route::post('/shopping/seatmaps', [OrderFlightController::class, 'storeSheatmap']);
// Amadeus FLight Branded Fares Upsell
Route::get('flight-offers/upselling', [OrderFlightController::class, 'upsellingOffer']);
// Amadeus FLight Flight Price Analysis
Route::get('flight-price/analysis', [OrderFlightController::class, 'priceAnalysis']);
// Amadeus FLight Flight Choice Prediction
Route::post('flight-offers/prediction', [OrderFlightController::class, 'getofferPrediction']);

// --------------- Flight inspiration --------------- //

// Amadeus FLight Flight Inspiration Search
// Amadeus FLight Flight Cheapest Date Search
// Amadeus FLight Flight Availabilities Search
// Amadeus FLight Travel Recommendations

// --------------- Flight schedule --------------- //

// Amadeus FLight On Demand Flight Status
// Amadeus FLight Flight Delay Prediction

// --------------- Flight Airport --------------- //

// Amadeus FLight Airport & City Search
// Amadeus FLight Airport Nearest Relevant
// Amadeus FLight Airport Routes API
// Amadeus FLight Airport On-Time Performance

// --------------- Flight Airlines     --------------- //

// Amadeus FLight Flight Check-in Links
// Amadeus FLight Airline Code Lookup
// Amadeus FLight Airline Routes
