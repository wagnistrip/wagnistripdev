<?php

use App\Http\Controllers\Airline\Galileo\AuthenticateController;
use App\Http\Controllers\Airline\Galileo\BookingController;
use App\Http\Controllers\Airline\Galileo\FlightDetailsController;
use App\Http\Controllers\Airline\Galileo\PassengerDetailsController;
use App\Http\Controllers\Airline\Galileo\PricingController;
use App\Http\Controllers\Airline\Galileo\SeatController;
use App\Http\Controllers\Airline\Galileo\SpecialServiceController;
use App\Http\Controllers\Airline\Galileo\TicketingController;
use App\Http\Controllers\Payment\PayPalController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'Galileo'], function () {

    Route::controller(AuthenticateController::class)->group(function () {
        // Flight Availability
        Route::get('/galileo', 'Authenticate');
        //Agency balance
        Route::get('/AgencyBalance', 'agencyBalance');
        //Flight EndSession
        Route::get('session-end', 'sessionEnd');
        Route::post('session-end', 'sessionEnd');
    });
    Route::controller(PricingController::class)->group(function () {
        //Flight FareRule
        Route::get('/FareRule', 'getFlightFareRule');
        Route::post('/FareRule', 'getFlightFareRule');
        // Flight Non-LccFareRule
        Route::get('/non-lcc-FareRule', 'getNonLccFlightFareRule');
        Route::post('/non-lcc-FareRule', 'getNonLccFlightFareRule');
        // Flight Price
        Route::get('/pricing', 'pricing');
        Route::post('/pricing', 'pricing');
    });
    Route::controller(SpecialServiceController::class)->group(function () {
        // Flight SpacialService
        Route::get('/SpecialService', 'SpecialService');
        Route::post('/SpecialService', 'SpecialService');
    });
    // Flight Add Passenger Details
    Route::post('add-passenger-details', [PassengerDetailsController::class, 'addPassengerDetails']);

    Route::controller(BookingController::class)->group(function () {
        // Flight Booking
        Route::get('/booking', 'ticketBooking');
        Route::post('/booking', 'ticketBooking');
        // Flight Get Booking Details
        Route::get('get-booking-details', 'getBookingDetails');
        Route::post('get-booking-details', 'getBookingDetails');
        // Flight Cancel Booking
        Route::get('/booking-cancel', 'cancelBooking');
        Route::post('/booking-cancel', 'cancelBooking');
        // Flight GdsRefund
        Route::get('/gds-refund', 'gdsRefund');
        Route::post('/gds-refund', 'gdsRefund');
        // Flight HistoricalData
        Route::get('/get-historical-data', 'getHistoricalData');
        Route::post('/get-historical-data', 'getHistoricalData');
    });
    Route::controller(TicketingController::class)->group(function () {
        Route::post('/bookings-round-trip', 'DomGalBooking');
        Route::post('/bookingsroundtrip', 'DomGalBooking');
        // Flight Ticket
        Route::get('/ticket', 'getTicketDetails');
        Route::post('/ticket', 'getTicketDetails');
        // Flight Reschedule
        Route::get('/reschedule-ticket', 'rescheduleTicket');
        Route::post('/reschedule-ticket', 'rescheduleTicket');
        // Flight TicketingStatus
        Route::get('/get-ticketing-status', 'getTicketingStatus');
        Route::post('/get-ticketing-status', 'getTicketingStatus');

        Route::post('/returnurl', 'ReturnUrl');
    });
    Route::controller(SeatController::class)->group(function () {
        // Flight SeatMap
        Route::get('/seatMap', 'seatMap');
        Route::post('/seatMap', 'seatMap');
        // Flight EMDSeatMap
        Route::get('/emd-seatmap', 'emdSeatmap');
        Route::post('/emd-seatmap', 'emdSeatmap');
        // Flight GDSSeatIssuance
        Route::get('/gds-seat-issuance', 'gdsSeatIssuance');
        Route::post('/gds-seat-issuance', 'gdsSeatIssuance');
    });
    Route::controller(FlightDetailsController::class)->group(function () {
        // Flight Citylist
        Route::get('/citylist', 'getCityDetails');
        // Flight GDSAncillaryServices
        Route::get('/gds-ancillary-services', 'gdsAncillaryServices');
        Route::post('/gds-ancillary-services', 'gdsAncillaryServices');
        // Flight GDSAncillaryFulfillment
        Route::get('/gds-ancillary-fulfillment', 'gdsAncillaryFulfillment');
        Route::post('/gds-ancillary-fulfillment', 'gdsAncillaryFulfillment');
        // Flight GetGdsTerminal
        Route::get('/get-gds-terminal', 'getGDSTerminal');
        Route::post('/get-gds-terminal', 'getGDSTerminal');
    });
    Route::controller(PayPalController::class)->group(function () {
        Route::post('create-payment',  'createPayment');
        Route::post('capture-payment',  'capturePayment');
        Route::get('paypal-success',  'success');
        Route::get('paypal-cancel',  'cancel');
    });
});
