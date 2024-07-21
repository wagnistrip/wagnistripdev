<?php

namespace App\Http\Controllers\Itinerary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaveUser extends Controller
{
    public function GetItinerary(Request $request){
        $LUrl = url()->previous();
        dd('hello' , $LUrl );
    }
}
