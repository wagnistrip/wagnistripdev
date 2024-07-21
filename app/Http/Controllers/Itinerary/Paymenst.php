<?php

namespace App\Http\Controllers\Itinerary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Paymenst extends Controller
{
    public function SaveItinerary(Request $request){
        dd($request->all());
    } 
}
