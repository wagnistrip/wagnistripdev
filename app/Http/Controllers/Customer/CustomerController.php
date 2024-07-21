<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;
use Auth;
use PDF;

class CustomerController extends Controller
{
    
    public function userProfile(){
        return view('userpages.profile');
    }

    public function userGenderUpdate(Request $request){
        $findId = user::find($request->id);
        $findId->gender = $request->gen;
        $findId->save();
    }

    public function userAllUpdate(Request $request){
        $findId = user::find($request->id);
        $image = $request->file('fileInput');
        if(empty($image)){
            $findId->name = $request->name;
            $findId->phone = $request->phone;
            $findId->gender = $request->gender;
            $findId->save();
            Session::flash('msg','Profile Updated Successfully');
            return redirect()->back();
        }
        else{
            $fnn = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/'), $fnn);
            $findId->name = $request->name;
            $findId->phone = $request->phone;
            $findId->image = $fnn;
            $findId->gender = $request->gender;
            $findId->save();
            Session::flash('msg','Profile Updated Successfully');
            return redirect()->back();
        }
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
           
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        Session::flash('msg','Password changed successfully');
        return redirect()->back();
    }

    public function userBooking(){

        $userId  = Auth::user()->id;

        $bookings = Booking::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('userpages.flightboked', compact('bookings'));
    }

    public function userBookingDetails($id){
        $id  = $id / 2021;
        $bookings = Booking::where('id', $id)->first();
        return view('userpages.boking-details', compact('bookings'));
    }

    public function FlightTicketPdf($id){
        $id  = $id / 2021;
        $bookings = Booking::where('id', $id)->first();

        view()->share('bookings', $bookings);

        $pdf = PDF::loadView('booking-pdf.flight.booking-pdf', compact('bookings'));
   
        return $pdf->download($bookings->booking_id.'.pdf');

        // return view('booking-pdf.flight.booking-pdf', compact('bookings'));
    }
    

}
