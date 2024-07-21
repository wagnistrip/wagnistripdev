<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PackageOffer;
use App\Models\HotelOffer;
use App\Models\AirlinePackage;

class OfferDetailsController extends Controller
{
    public function index(){
        $offerPack = PackageOffer::orderBy('id','DESC')->get();
        $offerArray = [];
        foreach($offerPack as $datas){
            $hotelPack = HotelOffer::find($datas->hotel_id);
            $airlinePack = AirlinePackage::find($datas->flight_id);
            $offerArray[] = [
                'hotelname' => $hotelPack['name'],
                'airline' => $airlinePack['airline'],
                'tickettype' => $airlinePack['ticktype'],
                'id' => $datas['id'],
                'packname' => $datas['pname'],
                'activities' => $datas['activities'],
                'imgs' => json_decode($datas['images']),
            ];
        }
        // dd($offerArray);
        return view('welcome', compact('offerArray'));
    }
    
    public function offerDetailss(){
        return view('pages.offerdetails'); 
    }

    public function festiveOffers(Request $request){
        $getData = PackageOffer::where('id', $request['id'])->get();
        $offerDetailArray = [];
        foreach($getData as $datas){
            $hotelPack = HotelOffer::find($datas->hotel_id);
            $airlinePack = AirlinePackage::find($datas->flight_id);
            $offerDetailArray[] = [
                'hotelname'     =>  $hotelPack['name'],
                'rating'        =>  $hotelPack['rating'],
                'location'      =>  $hotelPack['location'],
                'price'         =>  $hotelPack['price'],
                'hotelimages'   =>  json_decode($hotelPack['images']),
                'airline'       =>  $airlinePack['airline'],
                'tickettype'    =>  $airlinePack['ticktype'],
                'triptype'      =>  $airlinePack['ttype'],
                'flightn'       =>  $airlinePack['flight'],
                'connection'    =>  $airlinePack['connection'],
                'departure'     =>  $airlinePack['departure'],
                'arrivale'      =>  $airlinePack['arrival'],
                'arrivale'      =>  $airlinePack['arrival'],
                'id'            =>  $datas['id'],
                'packname'      =>  $datas['pname'],
                'duration'      =>  $datas['duration'],
                'package_type'  =>  $datas['package_type'],
                'location'      =>  $datas['location'],
                'passanger'     =>  $datas['passanger'],
                'meal'          =>  $datas['meal'], 
                'transfer'      =>  $datas['transfer'],
                'sumry'         =>  $datas['sumry'],
                'activities'    =>  $datas['activities'],
                'smalldesc'     =>  $datas['smdesc'],
                'packageimages' =>  json_decode($datas['images']),
            ];
        }
        // dd($offerDetailArray);
        return view('pages.festivle_offer', compact('offerDetailArray'));
    }



}
