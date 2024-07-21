@extends('layouts.master')
@section('title', 'Wagnistrip')
@section('body')

<style>
.groupfareMainDiv .bookBtn{
    background: #0164a3;
    height: auto;
    width: fit-content;
    padding: 6px 15px;
    border-radius: 10px;
    color: #fff;
    font-weight: 500;
}

@media only screen and (min-device-width: 275px) and (max-device-width: 576px) {
    .groupfareMainDiv .rightsideBox form{
                margin-left:0;
    }   
    .groupfarerowmain{
        padding:18px;
    }
    .groupfareMainDiv .bookBtn{
        padding: 21px 40px;
        font-size: 47px;
        height: auto;
    }
    .groupfareMainDiv .rightsideBox{
        border-top: 1px solid #918e8e;
        margin-top: 19px;
    }
    .front_banenrsTopSearch{
        margin-top: 275px;
    }
    .groupfareMainDiv .indigodiv{
        border-bottom: 1px dashed #686868 !important;
        justify-content: center;
        margin-bottom: 38px !important;
        padding-bottom: 30px !important;
    }
}
</style>

<div class="front_banenrsTopSearch">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="imgfrontbanner_1">
                </div>
            </div>
            <div class="carousel-item">
                <div class="imgfrontbanner_2">
                </div>
            </div>
            <div class="carousel-item">
                <div class="imgfrontbanner_3">
                </div>
            </div>
            <div class="carousel-item">
                <div class="imgfrontbanner_4">
                </div>
            </div>
            <div class="carousel-item">
                <div class="imgfrontbanner_5">
                </div>
            </div>
            <div class="carousel-item">
                <div class="imgfrontbanner_6">
                </div>
            </div>
        </div>
    </div>
</div>

<main class="container groupfareMainDiv">
@foreach($data as $datas)

@php
$itinerary = json_decode($datas->itinerary, true);
@endphp


    
    <div class="boxunder grid-item takingoff my-5">
        <div class="row groupfarerowmain justify-content-between align-items-center">
            <div class="leftsideBox col-md-8 col-12  border-right">
                <div class="row ml-0 my-2 pb-1 align-items-center border-bottom indigodiv">
                    <div class="airlineLogo mr-5">
                        <img src="{{$itinerary['airlineImage']}}" width="40px" height="40px" alt="" class="imgonewayw">
                    </div>
                    <div class="airlineText">
                        <div class="owstitle1 searchtitle">{{$itinerary['airlineName']}}</div>
                        <div class="owstitle">{{$itinerary['FlightNumber']}}</div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-5 col-md-5 col-sm-5 text-center">
                        <div class="searchtitle cityflight" data-city1="{{$itinerary['departure']}}">{{$itinerary['departure']}}<span class=" takeoff"> {{$itinerary['departure_time']}}</span></div>
                        <div class="searchtitle colorgrey">{{$itinerary['departure_date']}}</div>
                    </div>
                    <div class="col-2 col-md-2 col-sm-2 text-center">
                        <div class="searchtitle text-center">{{$itinerary['TotalTrevelTime']}}</div>
                        <div class="borderbotum"></div>
                        <div class="searchtitle colorgrey  text-center">{{$itinerary['Stop']}}</div>
                    </div>
                    <div class="col-5 col-md-5 col-sm-5">
                        <div class="text-center">
                            <div class="searchtitle cityflight" data-city2="{{$itinerary['arriavel']}}">{{$itinerary['arriavel']}}<span class=" landing">{{$itinerary['arriavel_time']}}</span></div>
                            <div class="searchtitle colorgrey">{{$itinerary['arriavel_date']}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rightsideBox col-md-3 col-12">
                <form class="row align-items-center justify-content-between">
                    <div class="text">
                        <span class="TotalFare searchtitle product-card d-block" data-price1="{{$itinerary['price']}}"><i class="fa fa-rupee"></i> {{$itinerary['price']}}</span>
                        <span class="TotalFare searchtitle product-card d-block">{{$itinerary['leftSeat']}}</span>
                    </div>
                    <a class="bookBtn" href="{{url('/group-fares/')}}/{{$datas->id}}">Book Now</a>
                </form>
            </div>
        </div>
    </div>
    
    
@endforeach
</main>
<!--<main class="container groupfareMainDiv">-->
    
<!--    <div class="boxunder grid-item takingoff my-5">-->
<!--        <div class="row groupfarerowmain justify-content-between align-items-center">-->
<!--            <div class="leftsideBox col-md-8 col-12  border-right">-->
<!--                <div class="row ml-0 my-2 pb-1 align-items-center border-bottom indigodiv">-->
<!--                    <div class="airlineLogo mr-5">-->
<!--                        <img src="https://www.flights.wagnistrip.com/assets/images/flight/6E.png" width="40px" height="40px" alt="" class="imgonewayw">-->
<!--                    </div>-->
<!--                    <div class="airlineText">-->
<!--                        <div class="owstitle1 searchtitle">IndiGo</div>-->
<!--                        <div class="owstitle">6E-2042</div>-->
<!--                    </div>-->
<!--                </div>-->
                
<!--                <div class="row">-->
<!--                    <div class="col-5 col-md-5 col-sm-5 text-center">-->
<!--                        <div class="searchtitle cityflight" data-city1="Chandigarh (IXC)">Chandigarh (IXC)<span class=" takeoff">14:35</span></div>-->
<!--                        <div class="searchtitle colorgrey">Tue, 12 Sep 2023</div>-->
<!--                    </div>-->
<!--                    <div class="col-2 col-md-2 col-sm-2 text-center">-->
<!--                        <div class="searchtitle text-center">03:50</div>-->
<!--                        <div class="borderbotum"></div>-->
<!--                        <div class="searchtitle colorgrey  text-center">Non-Stop</div>-->
<!--                    </div>-->
<!--                    <div class="col-5 col-md-5 col-sm-5">-->
<!--                        <div class="text-center">-->
<!--                            <div class="searchtitle cityflight" data-city2="Goa (GOI)">Goa (GOI)<span class=" landing">13:25</span></div>-->
<!--                            <div class="searchtitle colorgrey">Tue, 12 Sep 2023</div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="rightsideBox col-md-3 col-12">-->
<!--                <form class="row align-items-center justify-content-between">-->
<!--                    <div class="text">-->
<!--                        <span class="TotalFare searchtitle product-card d-block" data-price1="6700"><i class="fa fa-rupee"></i> 6700</span>-->
<!--                        <span class="TotalFare searchtitle product-card d-block">15 Seat left</span>-->
<!--                    </div>-->
<!--                    <a class="bookBtn" href="{{url('/group-fares/2')}}">Book Now</a>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    
    
<!--</main>-->


@endsection