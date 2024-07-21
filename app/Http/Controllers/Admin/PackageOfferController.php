<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AirlinePackage;
use App\Models\HotelOffer;
use App\Models\PackageOffer;
use Illuminate\Http\Request;
use Session;

class PackageOfferController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function offerPackage()
    {
        $getAllOffers = PackageOffer::orderBy('id', 'DESC')->get();
        $offferArray = [];
        foreach ($getAllOffers as $datas) {
            $hoteldata = HotelOffer::find($datas->hotel_id);
            $airlinedata = AirlinePackage::find($datas->flight_id);
            $offferArray[] = [
                'id' => $datas['id'],
                'package_name' => $datas['pname'],
                'hotelname' => $hoteldata['name'],
                'rating' => $hoteldata['rating'],
                'location' => $hoteldata['location'],
                'price' => $hoteldata['price'],
                'room_type' => $hoteldata['room_type'],
                'flightname' => $airlinedata['airline'],
                'ttype' => $airlinedata['ttype'],
                'ticktype' => $airlinedata['ticktype'],
                'departure' => $airlinedata['departure'],
                'arrival' => $airlinedata['arrival'],
                'dates' => $airlinedata['dates'],
                'times' => $airlinedata['times'],
                'duration' => $airlinedata['duration'],
                'roundairline' => $airlinedata['roundairline'],
                'rounddeparture' => $airlinedata['rounddeparture'],
                'roundarrival' => $airlinedata['roundarrival'],
                'rounddates' => $airlinedata['rounddates'],
                'duration' => $datas['duration'],
                'package_type' => $datas['package_type'],
                'location' => $datas['location'],
                'passanger' => $datas['passanger'],
                'meal' => $datas['meal'],
                'transfer' => $datas['transfer'],
                'sumry' => $datas['sumry'],
                'activities' => $datas['activities'],
                'images' => $datas['images'],
                'smdesc' => $datas['smdesc'],
            ];
        }
        return view('admin.offerpackagelist', compact('offferArray'));
    }

    public function addOfferPackage(Request $request)
    {
        $hotelData = HotelOffer::orderBy('id', 'DESC')->get();
        $airlineData = AirlinePackage::orderBy('id', 'DESC')->get();
        return view('admin.addofferpackage', compact('hotelData', 'airlineData'));
    }

    public function postOfferPackages(Request $request)
    {
        // dd($request->all());
        $files = $request->file('image');
        foreach ($files as $img) {
            $name = "OFFERPACKAGE" . rand() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('/offerUpload/'), $name);
            $sliderImages[] = $name;
        }
        $sData = new PackageOffer;
        $sData->pname = $request['pname'];
        $sData->duration = $request['duration'];
        $sData->package_type = $request['ptype'];
        $sData->location = $request['location'];
        $sData->passanger = $request['passanger'];
        $sData->flight_id = $request['airline_id'];
        $sData->hotel_id = $request['hotel_id'];
        $sData->meal = $request['meal'];
        $sData->transfer = $request['transfer'];
        $sData->sumry = $request['summry'];
        $sData->activities = $request['activities'];
        $sData->images = json_encode($sliderImages);
        $sData->save();
        Session::flash('msg', 'Package Offer inserted');
        return redirect('admin/offer-package');
    }

    public function deleteOfferPackage(Request $request)
    {
        $datas = PackageOffer::where('id', $request['id'])->first();
        foreach (json_decode($datas['images']) as $images) {
            unlink(public_path('/offerUpload/' . $images));
        }
        $datas->delete();
        Session::flash('danger', 'Deleted successfully');
        return redirect()->back();
    }

    public function editOfferPackage($id)
    {
        $hotelData = HotelOffer::orderBy('id', 'DESC')->get();
        $airlineData = AirlinePackage::orderBy('id', 'DESC')->get();
        $datas = PackageOffer::find($id);
        return view('admin.editofferpackage', compact('datas', 'hotelData', 'airlineData'));
    }

    public function postOfferPackagesUpdate(Request $request)
    {
        $getHID = PackageOffer::where('id', $request['hid'])->first();
        $files = $request->file('image');
        if ($request->file('image')) {
            foreach (json_decode($getHID['images']) as $datas) {
                unlink(public_path('/offerUpload/' . $datas));
            }
            foreach ($files as $img) {
                $name = "OFFERPACKAGE" . rand() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('/offerUpload/'), $name);
                $sliderImages[] = $name;
            }
            $getHID->pname = $request['pname'];
            $getHID->duration = $request['duration'];
            $getHID->package_type = $request['ptype'];
            $getHID->location = $request['location'];
            $getHID->passanger = $request['passanger'];
            $getHID->flight_id = $request['airline_id'];
            $getHID->hotel_id = $request['hotel_id'];
            $getHID->meal = $request['meal'];
            $getHID->transfer = $request['transfer'];
            $getHID->sumry = $request['summry'];
            $getHID->activities = $request['activities'];
            $getHID->images = json_encode($sliderImages);
            $getHID->save();
            Session::flash('msg', 'Package Offer Updated');
            return redirect('admin/offer-package');
        } else {
            $getHID->pname = $request['pname'];
            $getHID->duration = $request['duration'];
            $getHID->package_type = $request['ptype'];
            $getHID->location = $request['location'];
            $getHID->passanger = $request['passanger'];
            $getHID->flight_id = $request['airline_id'];
            $getHID->hotel_id = $request['hotel_id'];
            $getHID->meal = $request['meal'];
            $getHID->transfer = $request['transfer'];
            $getHID->sumry = $request['summry'];
            $getHID->activities = $request['activities'];
            $getHID->save();
            Session::flash('msg', 'Package Offer Updated');
            return redirect('admin/offer-package');
        }
    }

}
