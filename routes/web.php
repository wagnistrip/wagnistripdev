<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];


});


// Route::get('/success', function () {
//     return response()->json(['message' => 'Payment was successful!']);
// })->name('payment.success');

// Route::get('/failure', function () {
//     return response()->json(['message' => 'Payment failed!']);
// })->name('payment.failure');


// Route::get('flight/search' , [SearchFlightController::class , 'searchFlight']);

require __DIR__.'/auth.php';
