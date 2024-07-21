<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelOffer;
use App\Models\AirlinePackage;
use Session;

class OfferController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function hotelOffer(){
        $data = HotelOffer::orderBy('id','DESC')->get();
        return view('admin.hoteltable', compact('data'));
    }

    public function postHotelOffer(Request $request){
       
    $files = $request->file('image'); 
    foreach($files as $img)
        {
            $name = rand().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('/offerUpload/'), $name);  
            $sliderImages[] = $name;  
        }

        $hotelOffer = new HotelOffer;
        $hotelOffer->name = $request['name'];
        $hotelOffer->rating = $request['rate'];
        $hotelOffer->location = $request['location'];
        $hotelOffer->price = $request['price'];
        $hotelOffer->room_type = $request['room_type'];
        $hotelOffer->images = json_encode($sliderImages);
        $hotelOffer->save();
        Session::flash('msg','Offer hotel inserted');
        return redirect()->back();

    }

    public function editHotelData(Request $request){
        $datas = hotelOffer::find($request->id);
        return view('admin.edithotel', compact('datas'));
    }

    public function deleteHotelOffer(Request $request){
        $data = HotelOffer::where('id', $request['id'])->first();
        foreach(json_decode($data['images']) as $datas){
            unlink(public_path('/offerUpload/'.$datas));
        }
        $data->delete();
        Session::flash('danger','Hotel offer Deleted successfully');
        return redirect()->back();
    }

    public function updatePostHotelOffer(Request $request){
        $GetId = HotelOffer::where('id', $request['hid'])->first();
        $files = $request->file('image');
        if ($request->file('image')) {
            foreach(json_decode($GetId['images']) as $datas){
                unlink(public_path('/offerUpload/'.$datas));
            }
            foreach($files as $img)
            {
                $name = rand().'.'.$img->getClientOriginalExtension();
                $img->move(public_path('/offerUpload/'), $name);  
                $sliderImages[] = $name;  
            }
            $GetId->name = $request['name'];
            $GetId->rating = $request['rate'];
            $GetId->location = $request['location'];
            $GetId->price = $request['price'];
            $GetId->room_type = $request['room_type'];
            $GetId->images = json_encode($sliderImages);
            $GetId->save();
            Session::flash('msg','Offer hotel Updated');
            return redirect('/admin/hotel-offer');
        }else{
            $GetId->name = $request['name'];
            $GetId->rating = $request['rate'];
            $GetId->location = $request['location'];
            $GetId->price = $request['price'];
            $GetId->room_type = $request['room_type'];
            $GetId->save();
            Session::flash('msg','Offer hotel Updated');
            return redirect('/admin/hotel-offer');
        } 
    }

    public function airlineOffer(){
        $datas = AirlinePackage::orderBy('id','DESC')->get();
        return view('admin.flightoffer', compact('datas'));
    }

    public function postAirlineOffer(Request $request){
        $datas = new AirlinePackage;
        $datas->ttype = $request['ttype'];
        $datas->ticktype = $request['ticktype'];
        $datas->airline = $request['airline'];
        $datas->flight = $request['flight'];
        $datas->connection = $request['connection'];
        $datas->departure = $request['departure'];
        $datas->arrival = $request['arrival'];
        $datas->dates = $request['dates']; 
        $datas->times = $request['times']; 
        $datas->duration = $request['duration']; 
        $datas->roundairline = $request['roundairline']; 
        $datas->roundflight = $request['roundflight']; 
        $datas->roundconnection = $request['roundconnection']; 
        $datas->rounddeparture = $request['rounddeparture']; 
        $datas->roundarrival = $request['roundarrival']; 
        $datas->rounddates = $request['rounddates']; 
        $datas->roundtimes = $request['roundtimes']; 
        $datas->roundduration = $request['roundduration']; 
        $datas->save();
        Session::flash('msg','Airline package inserted');
        return redirect()->back();
    }

    public function airlineOfferDelete($id){
        AirlinePackage::find($id)->delete();
        Session::flash('danger','Airline package Deleted');
        return redirect()->back();
    }

    public function airlineOfferEdit($id){
        $data = AirlinePackage::find($id);    
        return view('admin.flightedit', compact('data'));
    }

    public function postAirlineofferUpdate(Request $request){
        $getData = AirlinePackage::find($request->hid);

        $getData->ttype = $request['ttype'];
        $getData->ticktype = $request['ticktype'];
        $getData->airline = $request['airline'];
        $getData->flight = $request['flight'];
        $getData->connection = $request['connection'];
        $getData->departure = $request['departure'];
        $getData->arrival = $request['arrival'];
        $getData->dates = $request['dates']; 
        $getData->times = $request['times']; 
        $getData->duration = $request['duration']; 
        $getData->roundairline = $request['roundairline']; 
        $getData->roundflight = $request['roundflight']; 
        $getData->roundconnection = $request['roundconnection']; 
        $getData->rounddeparture = $request['rounddeparture']; 
        $getData->roundarrival = $request['roundarrival']; 
        $getData->rounddates = $request['rounddates']; 
        $getData->roundtimes = $request['roundtimes']; 
        $getData->roundduration = $request['roundduration']; 
        $getData->save();
        Session::flash('msg','Airline package Updated');
        return redirect('admin/airline-offer');

    }




}
