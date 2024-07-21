@extends('layouts.master')
@section('title', 'Wagnistrip ')
@section('body')
    <!-- DESKTOP VIEW START -->
    <x-search-bar />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
    {{-- <link rel="stylesheet" type="text/css" src="{{url('assets/css/jQuery.UI.css')}}"> --}}
    {{--<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css">--}}
    <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css">

    
    <style>
        .ui-slider {
            position: relative;
            text-align: left;
        }
        .ui-corner-all {
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
        }
        .ui-widget-content {
            border: 1px solid #dddddd;
            background: #eeeeee url(images/ui-bg_highlight-soft_100_eeeeee_1x100.png) 50% top repeat-x;
            color: #333333;
        }
        .ui-widget {
            font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif;
            font-size: 1.1em;
        }
        .ui-slider-horizontal {
            height: .6em;
        }
        .ui-slider-horizontal {
            margin-bottom: 2px; 
            width: 100%;
            border: 1px solid black;
            
        }
        .ui-widget-header {
            color: #f6931f;
            background: #0164a3;
        }
        .ui-slider-horizontal .ui-slider-range {
            top: 0;
            height: 100%;
        }
        .ui-slider .ui-slider-range {
            position: absolute;
            z-index: 1;
            font-size: .7em;
            display: block;
            border: 0;
        }
        .ui-slider .ui-slider-handle{
            top: -0.3em;
            margin-left: -0.6em;
        }
        .ui-slider .ui-slider-handle {
            position: absolute;
            z-index: 2;
            width: 1.2em;
            height: 1.2em;
            cursor: default;
        }
        .ui-state-default, .ui-widget-content .ui-state-default {
            border: 1px solid #cccccc;
            background: #f6f6f6 url(images/ui-bg_glass_100_f6f6f6_1x400.png) 50% 50% repeat-x;
            font-weight: bold;
            color: #1c94c4;
            outline: none;
        }
        .ui-widget-content a {
            color: #333333;
        }
        
        .ui-state-hover a, 
        .ui-state-hover a:hover { 
            color: #c77405; 
            text-decoration: none; 
            outline: none; 
        }
        /* timing btn css */
        .price-filter-container {
  			width: 1190px;
  			max-width: 100%;
  			margin: 0 auto;
		}
		
        .activetime{
            background:#004068;
            color:#fff;
        }
        .inputbox1 input{
            width: 62px
        }
        .timecard{
            width: 16rem;
        }
       
        .row.boxunder.p15 {
            display: flex;
            width: 100%;
            flex-wrap: wrap;
            font-size: 25px;
            flex-direction: row;
        }
    </style>
       <section>
    @php
        $segments = Session::get('segments');
        $Agent = Session()->get("Agent");
        
        if($Agent != null){
            $isAgent = true;
            $charge = 100;
        }else{
            $isAgent = false;
            $charge = 400;
        }
        $code = !empty($code) ? $code : 'INR';
        $cvalue = !empty($cvalue) ? $cvalue : 1;
        $cvalue = round($cvalue , 3);
        $code = is_array($code) ? $code[0] : $code; 
        $icon = !empty(__('common.'.$code)) ? __('common.'.$code) : '';
    @endphp
        <div class="container">

            <div class="pt-10 pb-10" style="">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2 text-center bor">
                                <span class="owstitle">Filter : </span>
                            </div>
                            <div class="col-sm-3 bor">
                                <div onclick="rotriprice()">
                                    <span class="owstitle"> {!! $icon !!} Price </span>
                                    <span class="float-right"><i class="fa fa-arrow-down"></i></span>
                                </div>
                                <div class="card price filterprice">
                                    <div class="ranjepp">
                                        <div class="owstitle pb-10" data-toggle="collapse" data-target="">
                                            Price Range
                                            {{--<span class="float-right"><i class="fa fa-arrow-down"
                                                    aria-hidden="true"></i></span>--}}
                                        </div>
                                        <select class="form-control1" name="" style="width: 100%; text-align: center; border-radius: 10px; border: 1px solid #0164a3;">
                                            <option value="0">Sort Price</option>
                                            <option value="l2h">Low - High Price</option>
                                            <option value="h2l">High - Low Price</option>
                                        </select><br>
                                        <div id="price" class="collapse show">
                                            <div class="inputbox1 text-center">
                                                <input type="number" min=0 max="999900" id="min_price" class="price-range-field" style="width:100px;border:none; text-align: center; background: #f2f2f2; " readonly/>
                                            </div>
                                            <div id="slider-range">
                                                <div class="ui-slider-range ui-widget-header" style="left: 0%; width: 100%;"></div>
                                                <a class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%; border: 2px solid;"></a>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="ranjepp">
                                        <div class="owstitle pb-10" data-toggle="collapse" data-target="#price">
                                            Return
                                            <span class="float-right"><i class="fa fa-arrow-down"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                        <div id="price" class="collapse show">
                                            <div class="slider-wrapper slider-primary slider-strips slider-ghost pb-10">
                                                <input class="input-range" type="text" data-slider-step="1"
                                                    data-slider-value="5, 90" data-slider-min="0" data-slider-max="100"
                                                    data-slider-range="true" data-slider-tooltip_split="true" />
                                            </div>
                                        </div>
                                    </div>--}}
                                </div>
                            </div>
                            <div class="col-sm-2 bor">
                                <div onclick="Airlines()">
                                    <span class="owstitle"> <i class="fa fa-plane"></i> Airlines </span>
                                    <span class="float-right"><i class="fa fa-arrow-down"></i></span>
                                </div>
                                <div id="Airline" class="card filterprice filter-btn AirlinesFilter Airlines dpn p-10">
                                    {{-- <div class="padding-10">
                                        <span><input type="checkbox" class="form-check-input" value="">DEL :
                                            Delhi</span>
                                        <span class="float-right">{!! $icon !!} 20029</span>
                                    </div>
                                    <div class="padding-10">
                                        <span><input type="checkbox" class="form-check-input" value="">DXB :
                                            Dubai</span>
                                        <span class="float-right">{!! $icon !!} 20029</span>
                                    </div>
                                    <div class="padding-10">
                                        <span><input type="checkbox" class="form-check-input" value="">XNB :
                                            XNB</span>
                                        <span class="float-right">{!! $icon !!} 20029</span>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-sm-3 bor">
                                <div onclick="Time()">
                                    <span class="owstitle"> <i class="fa fa-clock-o"></i> Time </span>
                                    <span class="float-right"><i class="fa fa-arrow-down"></i></span>
                                </div>
                                <div class="card filterprice timeInfo Time dpn timecard" >
                                    <div id="FLIGHT" class="collapse show">
                                        <i class="onwfnt-11">Departure <!--span id="city1"--></span></i>
                                        {{--<div class="slider-wrapper slider-primary slider-strips slider-ghost pb-10">--}}
                                            <div class="row filter-btn" style="margin: 0px -7px;">
                                                <div class="col-md-3 p-1">
                                                    <div class="card landing-timing">
                                                        <div class="text-center">
                                                            <i class="fa fa-sun-o"></i><br />
                                                            <small style="font-size:8px;">Before 6 AM </small><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 p-1">
                                                    <div class="card landing-timing">
                                                        <div class="text-center">
                                                            <i class="fa fa-sun-o"></i><br />
                                                            <small style="font-size:8px;">6 Am - 12 Pm</small><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 p-1">
                                                    <div class="card landing-timing">
                                                        <div class="text-center">
                                                            <i class="fa fa-moon-o"></i><br />
                                                            <small style="font-size:8px;">12 Pm - 6 Pm</small><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 p-1">
                                                    <div class="card landing-timing">
                                                        <div class="text-center">
                                                            <i class="fa fa-moon-o"></i><br />
                                                            <small style="font-size:8px;">After 6 Pm</small><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{--</div>--}}
                                        
                                        {{--<div class="slider-wrapper slider-primary slider-strips slider-ghost pb-20">
                                            <input class="input-range2" type="text" data-slider-step="1"
                                                data-slider-value="2, 22" data-slider-min="0" data-slider-max="24"
                                                data-slider-range="true" data-slider-tooltip_split="true" />
                                        </div>--}}

                                        <i class="onwfnt-11">Arrival <!--span id="city2"></span--></i>
                                        {{--<div class="slider-wrapper slider-primary slider-strips slider-ghost pb-20">--}}
                                            <div class="row filter-btn" style="margin: 0px -7px;">
                                                <div class="col-md-3 p-1">
                                                    <div class="card another-card take-off-timing">
                                                        <div class="text-center">
                                                            <i class="fa fa-sun-o"></i><br />
                                                            <small style="font-size:8px;">Before 6 AM </small><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 p-1">
                                                    <div class="card another-card take-off-timing ">
                                                        <div class="text-center">
                                                            <i class="fa fa-sun-o"></i><br />
                                                            <small style="font-size:8px;">6 Am - 12 Pm</small><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 p-1">
                                                    <div class="card another-card take-off-timing ">
                                                        <div class="text-center">
                                                            <i class="fa fa-moon-o"></i><br />
                                                            <small style="font-size:8px;">12 Pm - 6 Pm</small><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 p-1">
                                                    <div class="card another-card take-off-timing ">
                                                        <div class="text-center">
                                                            <i class="fa fa-moon-o"></i><br />
                                                            <small style="font-size:8px;">After 6 Pm</small><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{--</div>--}}
                                        
                                        {{--<div class="slider-wrapper slider-primary slider-strips slider-ghost pb-20">
                                            <input class="input-range2" type="text" data-slider-step="1"
                                                data-slider-value="2, 22" data-slider-min="0" data-slider-max="24"
                                                data-slider-range="true" data-slider-tooltip_split="true" />
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-sm-2 bor">
                                <div onclick="Duration()">
                                    <span class="owstitle"> <i class="fa fa-filter"></i> Duration </span>
                                    <span class="float-right"><i class="fa fa-arrow-down"></i></span>
                                </div>
                                <div class="card filterprice Duration dpn">
                                    <div id="FLIGHT" class="collapse show">
                                        <i class="onwfnt-11">Delhi to Mumbai</i>
                                        <div class="slider-wrapper slider-primary slider-strips slider-ghost pb-20">
                                            <input class="input-range2" type="text" data-slider-step="1"
                                                data-slider-value="2, 22" data-slider-min="0" data-slider-max="24"
                                                data-slider-range="true" data-slider-tooltip_split="true" />
                                        </div>

                                        <i class="onwfnt-11">Mumbai to Delhi</i>
                                        <div class="slider-wrapper slider-primary slider-strips slider-ghost pb-20">
                                            <input class="input-range2" type="text" data-slider-step="1"
                                                data-slider-value="2, 22" data-slider-min="0" data-slider-max="24"
                                                data-slider-range="true" data-slider-tooltip_split="true" />
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-sm-2">
                                <div onclick="Stops()">
                                    <span class="owstitle"> <i class="fa fa-map-marker"></i> Stops </span>
                                    <span class="float-right"><i class="fa fa-arrow-down"></i></span>
                                </div>
                                <div id="Stops"  class="card Stops filter-btn StopInfo filterprice dpn p-10">
                                    <div class="padding-10">
                                        {{-- <div><input type="checkbox" class="form-check-input" value=""> Nonstop
                                        </div>
                                        <div><input type="checkbox" class="form-check-input" value=""> 1 Stops
                                        </div>
                                        <div><input type="checkbox" class="form-check-input" value=""> 2 + Stops
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="isotope-grid" {{--style="overflow-x: hidden; height: 87vh;"--}}>
                <div class="too-many-filters" style="display: none; text-align:center; margin-top:10rem;">
                    <img src="{{url('assets/images/toomanyfilter.png')}}" alt="" srcset="">
                    <p>No Flight Found for this Time....Click to remove..<span class="close-btn2 btn btn-danger" style="cursor: pointer;">X</span></p>
                </div>
            @php
                $galkeylength = '';
                $airlineArr = [];
            @endphp
            @foreach ($availabilitys['Availibilities'][0]['Availibility'] as $rowGalkey => $availability)
                @php
                    $segmentItemOut = [];
                    $segmentItemIn = [];
                @endphp
                @foreach ($availability['Itineraries']['Itinerary'] as $galSagments)

                    @if ($galSagments['Flight'] == 1 && $galSagments['StopCount'] == '0-Stop')

                        @php
                            array_push($segmentItemOut, $galSagments);
                        @endphp

                    @elseif($galSagments['Flight'] == 1 && $galSagments['StopCount'] == '1-Stop')

                        @php
                            array_push($segmentItemOut, $galSagments);
                        @endphp

                    @elseif($galSagments['Flight'] == 1 && $galSagments['StopCount'] == '2-Stop')

                        @php
                            array_push($segmentItemOut, $galSagments);
                        @endphp

                    @elseif($galSagments['Flight'] == 2 && $galSagments['StopCount'] == '0-Stop')

                        @php
                            array_push($segmentItemIn, $galSagments);
                        @endphp

                    @elseif($galSagments['Flight'] == 2 && $galSagments['StopCount'] == '1-Stop')

                        @php
                            array_push($segmentItemIn, $galSagments);
                        @endphp

                    @elseif($galSagments['Flight'] == 2 && $galSagments['StopCount'] == '2-Stop')

                        @php
                            array_push($segmentItemIn, $galSagments);
                        @endphp

                    @endif

                @endforeach

                @php
                
                    if( $segmentItemOut[0]['AirLine']['Code'] == "SG"){
                        continue;
                    }
                array_push($airlineArr, ['code' => $segmentItemOut[0]['AirLine']['Code'], 'name' => $segmentItemOut[0]['AirLine']['Name'], 'stop' => $segmentItemOut[0]['StopCount'], 'layover' => '1-Stop']);
            @endphp

            <div class="card mb-3 airline_hide stops_hide {{ $segmentItemOut[0]['StopCount']. ' ' . $segmentItemIn[0]['StopCount']. ' ' . $segmentItemOut[0]['AirLine']['Code'] }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-6 col-sm-6">
                                <div class="row ranjepp">
                                    <div class="col-3 col-md-3 col-sm-2 ranjepp_123">
                                        <img src="{{ asset('assets/images/flight/' . $segmentItemOut[0]['AirLine']['Code']) }}.png"
                                            alt="flight" class="imgonewayw100">
                                    </div>
                                    <div class="col-3 col-md-3 col-sm-4">
                                        <div class="owstitle1">
                                             
                                             {{$segmentItemOut[0]['AirLine']['Name'] }}
                                           
                                        </div>
                                        <div class="owstitle">{{ $segmentItemOut[0]['AirLine']['Code'] }} </div>
                                    </div>

                                    <div class="col-3 col-md-3 col-sm-2">
                                        <img src="{{ asset('assets/images/flight/' . $segmentItemIn[0]['AirLine']['Code']) }}.png"
                                            alt="flight" class="imgonewayw100">
                                    </div>
                                    <div class="col-3 col-md-3 col-sm-4">
                                        <div class="owstitle1">
                                             {{ $segmentItemOut[0]['AirLine']['Name'] }}
                                            </div>
                                        <div class="owstitle">{{ $segmentItemIn[0]['AirLine']['Code'] }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-sm-6">
                                <div class="row ranjepp  ranjepp_012" style="  width: 60%;float: right;">
                                 
                                    <div class="col-6 col-md-6  col-sm-6">
                                        @if($isAgent)
                                        <span class="fontsize-22 fare dataprice margin-20 col_ok_ok " data-price1="{{ ceil(($availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $charge)*$cvalue) }}">{!! $icon !!}
                                            {{ ceil(($availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $charge)*$cvalue) }}
                                        </span>
                                        @else
                                        <span class="fontsize-22 fare dataprice margin-20 col_ok_ok " data-price1="{{ ceil(($availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'])*$cvalue) }}">{!! $icon !!}
                                            {{ ceil(($availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'])*$cvalue)  }}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-6 col-md-6 col-sm-6">
                                        <form name="gal{{ $rowGalkey }}" action="{{ route('galileo-pricing') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="trip" value="Roundtrip">
                                            <input type="hidden" name="travellers"
                                                value="{{ json_encode($travellers, true) }}">
                                            <input type="hidden" name="SessionID"
                                                value="{{ $availabilitys['SessionID'] }}">
                                            <input type="hidden" name="Key" value="{{ $availabilitys['Key'] }}">
                                            <input type="hidden" name="Pricingkey"
                                                value="{{ $availability['PricingInfos']['PricingInfo'][0]['Pricingkey'] }}">
                                            <input type="hidden" name="Provider"
                                                value="{{ $availability['Provider'] }}">
                                            <input type="hidden" name="ResultIndex"
                                                value="{{ $availability['ItemNo'] }}">

                                            <div class="outbound_form_datas_gal"></div>
                                            <div class="inbound_form_datas_gal"></div>
                                            <a type="submit" class="btn btn-sm btn-primary booknowbtn">Book
                                                Now</a>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6 pt-10">
                                <x-flight.galelio.searchflightsagment trip="DEPART" :segment="$segmentItemOut"
                                    segmentMarge="false" :rowkey="$rowGalkey" />
                            </div>
                            <div class="col-sm-6 pt-10">
                                <x-flight.galelio.searchflightsagment trip="RETURN" :segment="$segmentItemIn"
                                    segmentMarge="false" :rowkey="$rowGalkey" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                          {{--  <span class="onewflydetbtn text-left {{ $availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">{{ $availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}</span> --}}
                        </div>
                         <div class="col-sm-6">
                        <span data-toggle="collapse" data-target="#round-trip-details-gal{{ $rowGalkey }}"  class="onewflydetbtn" style="float:right;">Flight Details <i class="fa fa-regular fa-angle-down"></i></span>
                        </div>
                    </div>
                    
                    <div id="round-trip-details-gal{{ $rowGalkey }}" class="collapse">
                        <div class="container">
                            <ul class="nav nav-tabs w-100">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab"
                                        href="#round-trip-Information-gal{{ $rowGalkey }}"> Flight
                                        Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                        href="#round-trip-Details-gal{{ $rowGalkey }}">
                                        Fare
                                        Details </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                        href="#round-trip-Baggage-gal{{ $rowGalkey }}">
                                        Baggage Information </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                        href="#round-trip-Cancellation-gal{{ $rowGalkey }}">
                                        Cancellation Rules </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane container active"
                                    id="round-trip-Information-gal{{ $rowGalkey }}">

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <span class="smbtn">DEPART</span>
                                            <x-flight.galelio.searchflightsagment trip="DEPART"
                                                :segment="$segmentItemOut" segmentMarge="true" :rowkey="$rowGalkey" />
                                        </div>

                                        <div class="col-sm-6">
                                            <span class="smbtn">RETURN</span>
                                            <x-flight.galelio.searchflightsagment trip="RETURN"
                                                :segment="$segmentItemIn" segmentMarge="true" :rowkey="$rowGalkey" />
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane container fade" id="round-trip-Details-gal{{ $rowGalkey }}">

                                    <div class="onwfntrespons-11">
                                        <span class="text-left"> Fare Rules :</span>
                                        <span class="text-right onewflydetbtn text-left {{ $availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">{{ $availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                        </span>
                                    </div>
                                    <table class="table table-bordered">
                                        <tbody class="onwfntrespons-11">
                                            <tr>
                                                <td class="onwfnt-11">1 x Adult</td>
                                                <td class="text-right"> {!! $icon !!}
                                                    {{ ceil(($availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'])*$cvalue) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                <td class="text-right"> {!! $icon !!}
                                                    {{ ceil(($availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'])*$cvalue) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Total Tax +</td>
                                                <td class="text-right"> {!! $icon !!}
                                                    {{ ceil($availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalTax']*$cvalue) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                <td class="text-right"> {!! $icon !!}
                                                    {{ ceil($availability['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare']*$cvalue) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane container fade" id="round-trip-Baggage-gal{{ $rowGalkey }}">
                                    <table class="table table-bordered">
                                        <thead class="onwfntrespons-11">
                                            <tr>
                                                <th>Airline</th>
                                                <th>Check-in Baggage</th>
                                                <th>Cabin Baggage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">DEPART</td>
                                            </tr>
                                            @foreach ($segmentItemOut as $itemBagOut)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('assets/images/flight/' . $itemBagOut['AirLine']['Code']) }}.png"
                                                            alt="">
                                                        <span
                                                            class="onwfnt-11">{{ $itemBagOut['AirLine']['Name'] . '-' . $itemBagOut['AirLine']['Identification'] }}</span>
                                                    </td>

                                                    <td class="onwfnt-11">
                                                        {{ $itemBagOut['Baggage']['Allowance']['CheckInPiece'] == '0' ? $itemBagOut['Baggage']['Allowance']['CheckIn'] : $itemBagOut['Baggage']['Allowance']['CheckInPiece'] }} {{ $itemBagOut['Baggage']['Allowance']['CheckInPiece'] == '0' ? "KG" : "PC" }}
                                                    </td>
                                                    <td class="onwfnt-11">
                                                        {{ $itemBagOut['Baggage']['Allowance']['CabinPiece'] == '0' ? $itemBagOut['Baggage']['Allowance']['Cabin'] : $itemBagOut['Baggage']['Allowance']['CabinPiece'] }} {{ $itemBagOut['Baggage']['Allowance']['CheckInPiece'] == '0' ? "KG" : "PC" }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3">RETURN</td>
                                            </tr>
                                            @foreach ($segmentItemIn as $itemBagOut)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('assets/images/flight/' . $itemBagOut['AirLine']['Code']) }}.png"
                                                            alt="">
                                                        <span
                                                            class="onwfnt-11">{{ $itemBagOut['AirLine']['Name'] . '-' . $itemBagOut['AirLine']['Identification'] }}</span>
                                                    </td>

                                                    <td class="onwfnt-11">
                                                        {{ $itemBagOut['Baggage']['Allowance']['CheckInPiece'] == '0' ? $itemBagOut['Baggage']['Allowance']['CheckIn'] : $itemBagOut['Baggage']['Allowance']['CheckInPiece'] }} {{ $itemBagOut['Baggage']['Allowance']['CheckInPiece'] == '0' ? "KG" : "PC" }}
                                                    </td>
                                                    <td class="onwfnt-11">
                                                        {{ $itemBagOut['Baggage']['Allowance']['CabinPiece'] == '0' ? $itemBagOut['Baggage']['Allowance']['Cabin'] : $itemBagOut['Baggage']['Allowance']['CabinPiece'] }} {{ $itemBagOut['Baggage']['Allowance']['CheckInPiece'] == '0' ? "KG" : "PC" }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                    </table>

                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                    <ul class="onwfnt-11">
                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                            Difference if applicable + WT Fees.</li>
                                        <li>The airline cancel reschedule fees is indicative and can be
                                            changed without any prior notice by the airlines..</li>
                                        <li>Wagnistrip does not guarantee the accuracy of cancel reschedule
                                            fees..</li>
                                        <li>Partial cancellation is not allowed on the flight tickets which
                                            are book under special round trip discounted fares..</li>
                                        <li>Airlines doesnt allow any additional baggage allowance for any
                                            infant added in the booking</li>
                                        <li>In certain situations of restricted cases, no amendments and
                                            cancellation is allowed</li>
                                        <li>Airlines cancel reschedule should be reconfirmed before
                                            requesting for a cancellation or amendment</li>
                                    </ul>
                                </div>
                                <div class="tab-pane container fade"
                                    id="round-trip-Cancellation-gal{{ $rowGalkey }}">
                                    <table class="table table-bordered">
                                        <tbody class="onwfntrespons-11">
                                            <tr>
                                                <td> <b>Time Frame to Reissue</b>
                                                    <div class="onwfnt-11">(Before scheduled departure time)
                                                    </div>
                                                </td>
                                                <td> <b>Airline Fees</b>
                                                    <div class="onwfnt-11"> (per passenger) </div>
                                                </td>
                                                <td> <b>WT Fees</b>
                                                    <div class="onwfnt-11"> (per passenger) </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Cancel Before 4 hours of
                                                    departure time.</td>
                                                <td> As Per Airline Policy</td>
                                                <td> {!! $icon !!} {{$cvalue*500}}</td>
                                            </tr>

                                            <tr>
                                                <td> <b>Time Frame to cancel</b>
                                                    <div class="onwfnt-11">(Before scheduled departure time)
                                                    </div>
                                                </td>
                                                <td> <b>Airline Fees</b>
                                                    <div class="onwfnt-11"> (per passenger) </div>
                                                </td>
                                                <td> <b>WT Fees</b>
                                                    <div class="onwfnt-11"> (per passenger) </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Cancel Before 4 hours of
                                                    departure time.</td>
                                                <td> As Per Airline Policy</td>
                                                <td> {!! $icon !!} {{500*$cvalue}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                    <ul class="onwfnt-11">
                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                            Difference if applicable + WT Fees.</li>
                                        <li>The airline cancel reschedule fees is indicative and can be
                                            changed without any prior notice by the airlines..</li>
                                        <li>Wagnistrip does not guarantee the accuracy of cancel reschedule
                                            fees..</li>
                                        <li>Partial cancellation is not allowed on the flight tickets which
                                            are book under special round trip discounted fares..</li>
                                        <li>Airlines doesnt allow any additional baggage allowance for any
                                            infant added in the booking</li>
                                        <li>In certain situations of restricted cases, no amendments and
                                            cancellation is allowed</li>
                                        <li>Airlines cancel reschedule should be reconfirmed before
                                            requesting for a cancellation or amendment</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $galkeylength = $rowGalkey;
                @endphp
            @endforeach

            @php
                use App\Http\Controllers\Airline\AirportiatacodesController;
                is_array($roundtrips->recommendation) == true ? ($recommendations = $roundtrips->recommendation) : ($recommendations = [$roundtrips->recommendation]);
                $resultLenght = '';
            @endphp


            @foreach ($recommendations as $rowkey => $recommendation)

                @php
                    is_array($recommendation->paxFareProduct->fare) ? ($fareDetailsRule = $recommendation->paxFareProduct->fare) : ($fareDetailsRule = [$recommendation->paxFareProduct->fare]);
                    
                    is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                    
                    $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                    
                    if (is_array($recommendation->segmentFlightRef) == true) {
                        $segmentFlightRefs = $recommendation->segmentFlightRef;
                    } else {
                        $segmentFlightRefs = [$recommendation->segmentFlightRef];
                    }
                    if (is_array($recommendation->paxFareProduct) == true) {
                        $paxFareProduct = $recommendation->paxFareProduct[0];
                    } else {
                        $paxFareProduct = $recommendation->paxFareProduct;
                    }
                    
                    $segmentOutboundKeys = [];
                    $segmentInboundKeys = [];
                    
                    $baggRef = 1;
                    if (is_array($paxFareProduct->paxFareDetail->codeShareDetails) == true) {
                        $outbound_img = $paxFareProduct->paxFareDetail->codeShareDetails[0]->company;
                        $inbound_img = $paxFareProduct->paxFareDetail->codeShareDetails[1]->company;
                    } else {
                        $outbound_img = $paxFareProduct->paxFareDetail->codeShareDetails->company;
                        $inbound_img = $paxFareProduct->paxFareDetail->codeShareDetails->company;
                    }
                    $resultLenght = $rowkey;
                @endphp
                @php
                if( $outbound_img == "SG"){
                    continue;
                }
                array_push($airlineArr, ['code' => $outbound_img, 'name' => $outbound_img, ]);
            @endphp

                <div class="card airline_hide stops_hide mb-3 {{$inbound_img}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-6 col-sm-6">
                                <div class="row ranjepp">
                                    <div class="col-3 col-md-3 col-sm-2">
                                        <img src="{{ asset('assets/images/flight/' . $outbound_img) }}.png"
                                            alt="flight" class="imgonewayw100">
                                    </div>
                                    <div class="col-3 col-md-3 col-sm-4">
                                        <div class="owstitle1"> {{ $outbound_img }}</div>
                                        <div class="owstitle">{{ $outbound_img }}</div>
                                    </div>

                                    <div class="col-3 col-md-3 col-sm-2">
                                        <img src="{{ asset('assets/images/flight/' . $inbound_img) }}.png"
                                            alt="flight" class="imgonewayw100">
                                    </div>
                                    <div class="col-3 col-md-3 col-sm-4">
                                        <div class="owstitle1">{{ $inbound_img }}</div>
                                        <div class="owstitle">{{ $inbound_img }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-sm-6">
                                <div class="row ranjepp">
                                    <div class="col-5 col-md-5 col-md-5">
                                       {{-- <span class="onewflydetbtn margin-20 {{$farerule}}">{{ $farerule }} </span>--}}
                                    </div>
                                    <div class="col-4 col-md-4 col-md-4">
                                            @php
                                                $totalFareAmount = ceil($recommendation->paxFareProduct->paxFareDetail->totalFareAmount*$cvalue);
                                                $totalTaxAmount = ceil($recommendation->paxFareProduct->paxFareDetail->totalTaxAmount*$cvalue);
                                            @endphp
                                            @if($isAgent)
                                        <span class="fontsize-22 fare dataprice margin-20" data-price1="{{ ceil(($recommendation->paxFareProduct->paxFareDetail->totalFareAmount + $charge)*$cvalue) }}">{!! $icon !!}
                                            {{ ceil(($recommendation->paxFareProduct->paxFareDetail->totalFareAmount + $charge)*$cvalue) }}</span>
                                            @else
                                        <span class="fontsize-22 fare dataprice margin-20" data-price1="{{ ceil(($recommendation->paxFareProduct->paxFareDetail->totalFareAmount)*$cvalue) }}">{!! $icon !!}
                                            {{ ceil(($recommendation->paxFareProduct->paxFareDetail->totalFareAmount)*$cvalue) }}</span>
                                            
                                            @endif
                                    </div>
                                    <div class="col-3 col-md-3 col-md-3 ok_col">
                                        <form name="{{ $rowkey }}" action="{{ route('flight-review') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="noOfAdults"
                                                value="{{ $travellers['noOfAdults'] }}">

                                            <input type="hidden" name="noOfChilds"
                                                value="{{ $travellers['noOfChilds'] }}">

                                            <input type="hidden" name="noOfInfants"
                                                value="{{ $travellers['noOfInfants'] }}">

                                            <div class="outbound_form_datas"></div>
                                            <div class="inbound_form_datas"></div>
                                            <a type="submit" class="btn btn-sm btn-primary booknowbtn button_012">Book
                                                Now</a>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            @foreach ($segmentFlightRefs as $segkey => $segmentFlightRef)
                                @php
                                    array_push($segmentOutboundKeys, $segmentFlightRef->referencingDetail[0]->refNumber);
                                    array_push($segmentInboundKeys, $segmentFlightRef->referencingDetail[1]->refNumber);
                                @endphp
                            @endforeach

                            @php
                                $baggRefArray = array_reverse($segmentFlightRefs[0]->referencingDetail);
                                $baggRef = $baggRefArray[0]->refNumber;
                                
                                if (is_array($roundtrips->flightIndex[0]->groupOfFlights) == true) {
                                    $groupOfFlightsOfOut = $roundtrips->flightIndex[0]->groupOfFlights;
                                } else {
                                    $groupOfFlightsOfOut[] = (object) array_merge(['propFlightGrDetail' => $roundtrips->flightIndex[0]->groupOfFlights->propFlightGrDetail], ['flightDetails' => $roundtrips->flightIndex[0]->groupOfFlights->flightDetails]);
                                }
                                if (is_array($roundtrips->flightIndex[1]->groupOfFlights) == true) {
                                    $groupOfFlightsOfIn = $roundtrips->flightIndex[1]->groupOfFlights;
                                } else {
                                    $groupOfFlightsOfIn[] = (object) array_merge(['propFlightGrDetail' => $roundtrips->flightIndex[1]->groupOfFlights->propFlightGrDetail], ['flightDetails' => $roundtrips->flightIndex[1]->groupOfFlights->flightDetails]);
                                }
                            @endphp

                            @php
                                    (is_array($roundtrips->serviceFeesGrp->serviceCoverageInfoGrp) == true) ? $roundtripsServiceFeesCoverageInfoGrp
                            = $roundtrips->serviceFeesGrp->serviceCoverageInfoGrp :
                            $roundtripsServiceFeesCoverageInfoGrp =
                            [$roundtrips->serviceFeesGrp->serviceCoverageInfoGrp];
                            @endphp
                            @foreach ($roundtripsServiceFeesCoverageInfoGrp as $serviceCoverage)

                                @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                    @php
                                    (is_array($roundtrips->serviceFeesGrp->freeBagAllowanceGrp) == true) ? $roundtripBagAllowanceGrp =
                                    $roundtrips->serviceFeesGrp->freeBagAllowanceGrp :
                                    $roundtripBagAllowanceGrp =
                                    [$roundtrips->serviceFeesGrp->freeBagAllowanceGrp];

                                    is_array($serviceCoverage->serviceCovInfoGrp) ? $serviceCoverageRefInfo =
                                    $serviceCoverage->serviceCovInfoGrp : $serviceCoverageRefInfo =
                                    [$serviceCoverage->serviceCovInfoGrp];


                                    @endphp

                                    @foreach ($roundtripBagAllowanceGrp as $freeBagAllowance)

                                        @if (isset($serviceCoverageRefInfo[0]) && isset($serviceCoverageRefInfo[1]))
                                            @if ($serviceCoverageRefInfo[0]->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
                                                @if ($freeBagAllowance->freeBagAllownceInfo->baggageDetails->quantityCode == 'N')
                                                    @php $outFreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'PC baggage'; @endphp
                                                @else
                                                    @php $outFreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'Kg baggage'; @endphp
                                                @endif
                                            @endif

                                            @if ($serviceCoverageRefInfo[1]->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
                                                @if ($freeBagAllowance->freeBagAllownceInfo->baggageDetails->quantityCode == 'N')
                                                    @php $inFreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'PC baggage'; @endphp
                                                @else
                                                    @php $inFreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'Kg baggage'; @endphp
                                                @endif
                                            @endif
                                        @else
                                            @if ($serviceCoverageRefInfo[0]->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
                                                @if ($freeBagAllowance->freeBagAllownceInfo->baggageDetails->quantityCode == 'N')
                                                    @php $outFreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'PC baggage'; @endphp
                                                    @php $inFreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'PC baggage'; @endphp
                                                @else
                                                    @php $outFreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'Kg baggage'; @endphp
                                                    @php $inFreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'Kg baggage'; @endphp
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <div class="col-sm-6 pt-10">
                                <div class="container">
                                    {{-- <div class="row">
                                            <div class="col-md-12">
                                                {{ $outFreeBag }}
                                            </div>
                                        </div> --}}
                                    {{-- <span class="smbtn float-right margintop-30">DEPART</span> --}}
                                    @foreach ($groupOfFlightsOfOut as $outkey => $flightResultsOfOut)
                                        @foreach (array_unique($segmentOutboundKeys) as $segmentOutboundKey)
                                            @if ($segmentOutboundKey == $flightResultsOfOut->propFlightGrDetail->flightProposal[0]->ref)
                                                @if (is_array($flightResultsOfOut->flightDetails) == true && isset($flightResultsOfOut->flightDetails[7]) && !isset($flightResultsOfOut->flightDetails[8]))
                                                @elseif (is_array($flightResultsOfOut->flightDetails) == true &&
                                                    isset($flightResultsOfOut->flightDetails[6]) &&
                                                    !isset($flightResultsOfOut->flightDetails[7]))
                                                @elseif (is_array($flightResultsOfOut->flightDetails) == true &&
                                                    isset($flightResultsOfOut->flightDetails[5]) &&
                                                    !isset($flightResultsOfOut->flightDetails[6]))
                                                @elseif (is_array($flightResultsOfOut->flightDetails) == true &&
                                                    isset($flightResultsOfOut->flightDetails[4]) &&
                                                    !isset($flightResultsOfOut->flightDetails[5]))
                                                @elseif (is_array($flightResultsOfOut->flightDetails) == true &&
                                                    isset($flightResultsOfOut->flightDetails[3]) &&
                                                    !isset($flightResultsOfOut->flightDetails[4]))
                                                @elseif (is_array($flightResultsOfOut->flightDetails) == true &&
                                                    isset($flightResultsOfOut->flightDetails[2]) &&
                                                    !isset($flightResultsOfOut->flightDetails[3]))
                                                    @php
                                                        $outbound_img = $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->operatingCarrier;
                                                    @endphp
                                                    <div class="row boxunder p15  trip_box" id="{{ $rowkey }}">
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <input type="radio" name="outbound-btn{{ $rowkey }}"
                                                                class="radio-btn-outbound"
                                                                value="{{ $segmentOutboundKey }}">

                                                            <span class="searchtitle">
                                                                {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                            </span>
                                                                <span class="searchtitle landing">{{ substr_replace($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                            <div class="searchtitle colorgrey">
                                                                {{ getDate_fn($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="searchtitle text-center">
                                                                {{ substr_replace(substr_replace($flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                | 2-Stop
                                                            </div>
                                                            <div class="borderbotum"></div>
                                                            <small class="searchtitle colorgrey text-center">
                                                                {{ $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId . '-' . $flightResultsOfOut->flightDetails[0]->flightInformation->location[1]->locationId . '-' . $flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId . '-' . $flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId }}
                                                            </small>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">

                                                            <div class="float-right">
                                                                <div class="searchtitle cityflight" data-city1="{{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}">
                                                                    <span class="takeoff">{{ substr_replace($flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                                    {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="searchtitle colorgrey">
                                                                    {{ getDate_fn($flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="display: none;" class="outbound-bagg-data">
                                                            <table class="table table-bordered">

                                                                <tbody>

                                                                    <tr>
                                                                        <td> 
                                                                            <img src="{{ asset('assets/images/flight/' . $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span class="onwfnt-11">{{ $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfOut->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">{{ $outFreeBag }}
                                                                        </td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfOut->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfOut->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfOut->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">{{ $outFreeBag }}
                                                                        </td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfOut->flightDetails[2]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfOut->flightDetails[2]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfOut->flightDetails[2]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">{{ $outFreeBag }}
                                                                        </td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <div style="display: none;" class="outbound-segment-data">
                                                            <div class="row">

                                                                <div class="col-2 col-md-2 col-sm-2">
                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId . '->' . $flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId }}
                                                                    </small>
                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                    </span>
                                                                        <span class="landing">{{ substr_replace($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2 text-center">

                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ substr_replace(substr_replace($flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </small>
                                                                    <div class="borderbotum"></div>

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            <span class="takeoff">{{ substr_replace($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[0]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-2 col-md-2 col-sm-2">

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle ">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[1]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                    </span>
                                                                        <span class="searchtitle landing">{{ substr_replace($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2">


                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            <span class="landing">{{ substr_replace($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-2 col-md-2 col-sm-2">

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[2]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails[2]->flightInformation->location[0]->locationId . ')' }}
                                                                    </span>
                                                                        <span class="searchtitle takeoff">{{ substr_replace($flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2">

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            <span class="landing">{{ substr_replace($flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="outbound-form-data-display">

                                                            <input type="hidden" name="roundtrip_outbound_twostop"
                                                                value="roundtrip_outbound_twostop">

                                                            <input type="hidden" name="outbound_twostop_arrivalingTime"
                                                                value="{{ $flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref }}">

                                                            <input type="hidden" name="outbound_twostop_bookingClass_1"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[0]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[0]->groupOfFares[0]->productInformation->cabinProduct[0]->rbd }}">
                                                            <input type="hidden" name="outbound_twostop_bookingClass_2"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[1]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[0]->groupOfFares[1]->productInformation->cabinProduct[0]->rbd }}">
                                                            <input type="hidden" name="outbound_twostop_bookingClass_3"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[2]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[0]->groupOfFares[2]->productInformation->cabinProduct[0]->rbd }}">

                                                            <input type="hidden" name="outbound_twostop_fareBasis_1"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[0]->productInformation->fareProductDetail->fareBasis }}">
                                                            <input type="hidden" name="outbound_twostop_fareBasis_2"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[1]->productInformation->fareProductDetail->fareBasis }}">
                                                            <input type="hidden" name="outbound_twostop_fareBasis_3"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[2]->productInformation->fareProductDetail->fareBasis }}">

                                                            <input type="hidden" name="outbound_twostop_arrivalTime_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">
                                                            <input type="hidden" name="outbound_twostop_arrivalTime_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">
                                                            <input type="hidden" name="outbound_twostop_arrivalTime_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->timeOfArrival }}">

                                                            <input type="hidden" name="outbound_twostop_arrivalDate_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfArrival }}">
                                                            <input type="hidden" name="outbound_twostop_arrivalDate_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfArrival }}">
                                                            <input type="hidden" name="outbound_twostop_arrivalDate_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->dateOfArrival }}">

                                                            <input type="hidden" name="outbound_twostop_departure_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId }}">
                                                            <input type="hidden" name="outbound_twostop_departure_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->location[0]->locationId }}">
                                                            <input type="hidden" name="outbound_twostop_departure_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->location[0]->locationId }}">

                                                            <input type="hidden" name="outbound_twostop_arrival_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->location[1]->locationId }}">
                                                            <input type="hidden" name="outbound_twostop_arrival_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId }}">
                                                            <input type="hidden" name="outbound_twostop_arrival_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->location[1]->locationId }}">

                                                            <input type="hidden" name="outbound_twostop_departureDate_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">
                                                            <input type="hidden" name="outbound_twostop_departureDate_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">
                                                            <input type="hidden" name="outbound_twostop_departureDate_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture }}">

                                                            <input type="hidden" name="outbound_twostop_departureTime_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">
                                                            <input type="hidden" name="outbound_twostop_departureTime_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">
                                                            <input type="hidden" name="outbound_twostop_departureTime_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture }}">

                                                            <input type="hidden"
                                                                name="outbound_twostop_marketingCompany_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden"
                                                                name="outbound_twostop_marketingCompany_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden"
                                                                name="outbound_twostop_marketingCompany_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->companyId->marketingCarrier }}">

                                                            <input type="hidden"
                                                                name="outbound_twostop_operatingCompany_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">
                                                            <input type="hidden"
                                                                name="outbound_twostop_operatingCompany_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">
                                                            <input type="hidden"
                                                                name="outbound_twostop_operatingCompany_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->companyId->operatingCarrier }}">

                                                            <input type="hidden" name="outbound_twostop_flightNumber_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->flightOrtrainNumber }}">
                                                            <input type="hidden" name="outbound_twostop_flightNumber_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->flightOrtrainNumber }}">
                                                            <input type="hidden" name="outbound_twostop_flightNumber_3"
                                                                value="{{ $flightResultsOfOut->flightDetails[2]->flightInformation->flightOrtrainNumber }}">

                                                        </div>
                                                    </div>
                                                   @elseif (is_array($flightResultsOfOut->flightDetails) == true &&
                                                    isset($flightResultsOfOut->flightDetails[1]) &&
                                                    !isset($flightResultsOfOut->flightDetails[2]))
                                                    @php
                                                        $outbound_img = $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->operatingCarrier;
                                                    @endphp
                                                    <div class="row boxunder p15 trip_box" id="{{ $rowkey }}">
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <input type="radio" name="outbound-btn{{ $rowkey }}"
                                                                class="radio-btn-outbound"
                                                                value="{{ $segmentOutboundKey }}">

                                                            <span class="searchtitle">
                                                                {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                            </span>
                                                                <span class="landing">{{ substr_replace($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                            <div class="searchtitle colorgrey">
                                                                {{ getDate_fn($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="searchtitle text-center">
                                                                {{ substr_replace(substr_replace($flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                | 1-Stop
                                                                
                                                            </div>
                                                            <div class="borderbotum"></div>
                                                            <div class="searchtitle colorgrey text-center">
                                                                {{ $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId . '-' . $flightResultsOfOut->flightDetails[0]->flightInformation->location[1]->locationId . '-' . $flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            {{-- <span class="smbtn float-right margintop-30">DEPART</span> --}}
                                                            <div class="float-right">
                                                                <div class="searchtitle">
                                                                    <span class="takeoff">{{ substr_replace($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                                    {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="searchtitle colorgrey">
                                                                    {{ getDate_fn($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="display: none;" class="outbound-bagg-data">
                                                            <table class="table table-bordered">

                                                                <tbody>

                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfOut->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfOut->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfOut->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfOut->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <div style="display: none;" class="outbound-segment-data">
                                                            <div class="row">

                                                                <div class="col-2 col-md-2 col-sm-2">
                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId . '->' . $flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                                    </small>
                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2 text-center">

                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ substr_replace(substr_replace($flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </small>
                                                                    <div class="borderbotum"></div>

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[0]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-2 col-md-2 col-sm-2">

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[1]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2">


                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="outbound-form-data-display">

                                                            <input type="hidden" name="roundtrip_outbound_onestop"
                                                                value="roundtrip_outbound_onestop">

                                                            <input type="hidden" name="outbound_onestop_arrivalingTime"
                                                                value="{{ $flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref }}">

                                                            <input type="hidden" name="outbound_onestop_bookingClass_1"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[0]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[0]->groupOfFares[0]->productInformation->cabinProduct[0]->rbd }}">

                                                            <input type="hidden" name="outbound_onestop_bookingClass_2"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[1]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[0]->groupOfFares[1]->productInformation->cabinProduct[0]->rbd }}">

                                                            <input type="hidden" name="outbound_onestop_fareBasis_1"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[0]->productInformation->fareProductDetail->fareBasis }}">

                                                            <input type="hidden" name="outbound_onestop_fareBasis_2"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares[1]->productInformation->fareProductDetail->fareBasis }}">

                                                            <input type="hidden" name="outbound_onestop_arrivalTime_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">

                                                            <input type="hidden" name="outbound_onestop_arrivalTime_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">

                                                            <input type="hidden" name="outbound_onestop_arrivalDate_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfArrival }}">

                                                            <input type="hidden" name="outbound_onestop_arrivalDate_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfArrival }}">

                                                            <input type="hidden" name="outbound_onestop_departure_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->location[0]->locationId }}">

                                                            <input type="hidden" name="outbound_onestop_arrival_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->location[1]->locationId }}">

                                                            <input type="hidden" name="outbound_onestop_departureDate_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">

                                                            <input type="hidden" name="outbound_onestop_departureTime_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">

                                                            <input type="hidden"
                                                                name="outbound_onestop_marketingCompany_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden"
                                                                name="outbound_onestop_operatingCompany_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">

                                                            <input type="hidden" name="outbound_onestop_flightNumber_1"
                                                                value="{{ $flightResultsOfOut->flightDetails[0]->flightInformation->flightOrtrainNumber }}">

                                                            <input type="hidden" name="outbound_onestop_departure_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->location[0]->locationId }}">

                                                            <input type="hidden" name="outbound_onestop_arrival_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->location[1]->locationId }}">

                                                            <input type="hidden" name="outbound_onestop_departureDate_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">

                                                            <input type="hidden" name="outbound_onestop_departureTime_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">

                                                            <input type="hidden"
                                                                name="outbound_onestop_marketingCompany_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">

                                                            <input type="hidden"
                                                                name="outbound_onestop_operatingCompany_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">

                                                            <input type="hidden" name="outbound_onestop_flightNumber_2"
                                                                value="{{ $flightResultsOfOut->flightDetails[1]->flightInformation->flightOrtrainNumber }}">

                                                        </div>
                                                    </div>
                                                @else
                                                    @php
                                                        $outbound_img = $flightResultsOfOut->flightDetails->flightInformation->companyId->operatingCarrier;
                                                    @endphp
                                                    <div class="row boxunder p15 trip_box" id="{{ $rowkey }}">
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <input type="radio" name="outbound-btn{{ $rowkey }}"
                                                                class="radio-btn-outbound"
                                                                value="{{ $segmentOutboundKey }}">

                                                            <span
                                                                class="searchtitle " >{{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails->flightInformation->location[0]->locationId . ')' }}
                                                            </span>
                                                                <span class="landing">{{ substr_replace($flightResultsOfOut->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                            <div class="searchtitle colorgrey">
                                                                {{ getDate_fn($flightResultsOfOut->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="searchtitle text-center">
                                                                {{ substr_replace(substr_replace($flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                            </div>
                                                            <div class="borderbotum"></div>
                                                            <div class="searchtitle colorgrey text-center">Non-Stop
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">

                                                            <div class="float-right">
                                                                <div class="searchtitle">
                                                                    <span class="takeoff">{{ substr_replace($flightResultsOfOut->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                                    {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="searchtitle colorgrey">
                                                                    {{ getDate_fn($flightResultsOfOut->flightDetails->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="display: none;" class="outbound-bagg-data">

                                                            <table class="table table-bordered">
                                                                <tbody>

                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfOut->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfOut->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfOut->flightDetails->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <div style="display: none;" class="outbound-segment-data">
                                                            <div class="row">

                                                                <div class="col-2 col-md-2 col-sm-2">
                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ $flightResultsOfOut->flightDetails->flightInformation->location[0]->locationId . '->' . $flightResultsOfOut->flightDetails->flightInformation->location[1]->locationId }}
                                                                    </small>
                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfOut->flightDetails->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfOut->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfOut->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2 text-center">

                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ substr_replace(substr_replace($flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </small>
                                                                    <div class="borderbotum"></div>

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfOut->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfOut->flightDetails->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfOut->flightDetails->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfOut->flightDetails->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="outbound-form-data-display">

                                                            <input type="hidden" name="roundtrip_outbound_nonstop"
                                                                value="roundtrip_outbound_nonstop">

                                                            <input type="hidden" name="outbound_nonstop_arrivalingTime"
                                                                value="{{ $flightResultsOfOut->propFlightGrDetail->flightProposal[1]->ref }}">

                                                            <input type="hidden" name="outbound_nonstop_bookingClass"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[0]->groupOfFares->productInformation->cabinProduct[0]->rbd }}">
                                                            <input type="hidden" name="outbound_nonstop_fareBasis"
                                                                value="{{ $paxFareProduct->fareDetails[0]->groupOfFares->productInformation->fareProductDetail->fareBasis }}">

                                                            <input type="hidden" name="outbound_nonstop_departure"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->location[0]->locationId }}">
                                                            <input type="hidden" name="outbound_nonstop_arrival"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->location[1]->locationId }}">
                                                            <input type="hidden" name="outbound_nonstop_departureDate"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->productDateTime->dateOfDeparture }}">
                                                            <input type="hidden" name="outbound_nonstop_arrivalDate"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->productDateTime->dateOfArrival }}">
                                                            <input type="hidden"
                                                                name="outbound_nonstop_marketingCompany"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden"
                                                                name="outbound_nonstop_operatingCompany"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->companyId->operatingCarrier }}">

                                                            <input type="hidden" name="outbound_nonstop_flightNumber"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->flightOrtrainNumber }}">

                                                            <input type="hidden" name="outbound_nonstop_departureTime"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->productDateTime->timeOfDeparture }}">
                                                            <input type="hidden" name="outbound_nonstop_arrivalTime"
                                                                value="{{ $flightResultsOfOut->flightDetails->flightInformation->productDateTime->timeOfArrival }}">

                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-6 pt-10">

                                <div class="container">
                                    {{-- <div class="row">
                    <div class="col-md-12">
                        {{ $inFreeBag }}
                    </div>
                </div> --}}
                                    @foreach ($groupOfFlightsOfIn as $inkey => $flightResultsOfIn)
                                        @foreach (array_unique($segmentInboundKeys) as $segmentInboundKey)
                                            @if ($segmentInboundKey == $flightResultsOfIn->propFlightGrDetail->flightProposal[0]->ref)
                                                @if (is_array($flightResultsOfIn->flightDetails) && isset($flightResultsOfIn->flightDetails[7]) && !isset($flightResultsOfIn->flightDetails[8]))
                                                @elseif (is_array($flightResultsOfIn->flightDetails) &&
                                                    isset($flightResultsOfIn->flightDetails[6]) &&
                                                    !isset($flightResultsOfIn->flightDetails[7]))
                                                @elseif (is_array($flightResultsOfIn->flightDetails) &&
                                                    isset($flightResultsOfIn->flightDetails[5]) &&
                                                    !isset($flightResultsOfIn->flightDetails[6]))
                                                @elseif (is_array($flightResultsOfIn->flightDetails) &&
                                                    isset($flightResultsOfIn->flightDetails[4]) &&
                                                    !isset($flightResultsOfIn->flightDetails[5]))
                                                @elseif (is_array($flightResultsOfIn->flightDetails) &&
                                                    isset($flightResultsOfIn->flightDetails[3]) &&
                                                    !isset($flightResultsOfIn->flightDetails[4]))
                                                @elseif (is_array($flightResultsOfIn->flightDetails) &&
                                                    isset($flightResultsOfIn->flightDetails[2]) &&
                                                    !isset($flightResultsOfIn->flightDetails[3]))
                                                    @php
                                                        $inbound_img = $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->operatingCarrier;
                                                    @endphp
                                                    <div class="row boxunder p15 trip_box" id="{{ $rowkey }}">
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            {{-- <span
                                class="smbtn float-left margintop-30">RETURN</span> --}}
                                                            <input type="radio" name="inbound-btn{{ $rowkey }}"
                                                                class="radio-btn-inbound"
                                                                value="{{ $segmentInboundKey }}">
                                                            <span
                                                                class="searchtitle">{{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                {{ substr_replace($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                            <div class="searchtitle colorgrey">
                                                                {{ getDate_fn($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="searchtitle text-center">
                                                                {{ substr_replace(substr_replace($flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                | 2-Stop
                                                            </div>
                                                            <div class="borderbotum"></div>
                                                            <small class="searchtitle colorgrey text-center">
                                                                {{ $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId . '-' . $flightResultsOfIn->flightDetails[0]->flightInformation->location[1]->locationId . '-' . $flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId . '-' . $flightResultsOfIn->flightDetails[2]->flightInformation->location[1]->locationId }}
                                                            </small>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[2]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="searchtitle colorgrey">
                                                                    {{ getDate_fn($flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="display: none;" class="inbound-bagg-data">
                                                            <table class="table table-bordered">

                                                                <tbody>
                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfIn->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfIn->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfIn->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfIn->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfIn->flightDetails[2]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfIn->flightDetails[2]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfIn->flightDetails[2]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <div style="display: none;" class="inbound-segment-data">
                                                            <div class="row">

                                                                <div class="col-2 col-md-2 col-sm-2">
                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId . '->' . $flightResultsOfIn->flightDetails[2]->flightInformation->location[1]->locationId }}
                                                                    </small>
                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2 text-center">

                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ substr_replace(substr_replace($flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </small>
                                                                    <div class="borderbotum"></div>

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[0]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-2 col-md-2 col-sm-2">

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[1]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2">


                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-2 col-md-2 col-sm-2">

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[2]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails[2]->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2">


                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[2]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="inbound-form-data-display">

                                                            <input type="hidden" name="roundtrip_inbound_twostop"
                                                                value="roundtrip_inbound_twostop">

                                                            <input type="hidden" name="inbound_twostop_arrivalingTime"
                                                                value="{{ $flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref }}">

                                                            <input type="hidden" name="inbound_twostop_bookingClass_1"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[0]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[1]->groupOfFares[0]->productInformation->cabinProduct[0]->rbd }}">
                                                            <input type="hidden" name="inbound_twostop_bookingClass_2"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[1]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[1]->groupOfFares[1]->productInformation->cabinProduct[0]->rbd }}">
                                                            <input type="hidden" name="inbound_twostop_bookingClass_3"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[2]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[1]->groupOfFares[2]->productInformation->cabinProduct[0]->rbd }}">

                                                            <input type="hidden" name="inbound_twostop_fareBasis_1"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[0]->productInformation->fareProductDetail->fareBasis }}">
                                                            <input type="hidden" name="inbound_twostop_fareBasis_2"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[1]->productInformation->fareProductDetail->fareBasis }}">
                                                            <input type="hidden" name="inbound_twostop_fareBasis_3"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[2]->productInformation->fareProductDetail->fareBasis }}">

                                                            <input type="hidden" name="inbound_twostop_departure_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId }}">
                                                            <input type="hidden" name="inbound_twostop_departure_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->location[0]->locationId }}">
                                                            <input type="hidden" name="inbound_twostop_departure_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->location[0]->locationId }}">

                                                            <input type="hidden" name="inbound_twostop_departureTime_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">
                                                            <input type="hidden" name="inbound_twostop_departureTime_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">
                                                            <input type="hidden" name="inbound_twostop_departureTime_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture }}">

                                                            <input type="hidden" name="inbound_twostop_departureDate_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">
                                                            <input type="hidden" name="inbound_twostop_departureDate_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">
                                                            <input type="hidden" name="inbound_twostop_departureDate_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture }}">


                                                            <input type="hidden" name="inbound_twostop_arrival_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->location[1]->locationId }}">
                                                            <input type="hidden" name="inbound_twostop_arrival_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId }}">
                                                            <input type="hidden" name="inbound_twostop_arrival_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->location[1]->locationId }}">

                                                            <input type="hidden" name="inbound_twostop_arrivalTime_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">
                                                            <input type="hidden" name="inbound_twostop_arrivalTime_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">
                                                            <input type="hidden" name="inbound_twostop_arrivalTime_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->timeOfArrival }}">

                                                            <input type="hidden" name="inbound_twostop_arrivalDate_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfArrival }}">
                                                            <input type="hidden" name="inbound_twostop_arrivalDate_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfArrival }}">
                                                            <input type="hidden" name="inbound_twostop_arrivalDate_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->productDateTime->dateOfArrival }}">

                                                            <input type="hidden"
                                                                name="inbound_twostop_marketingCompany_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden"
                                                                name="inbound_twostop_marketingCompany_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden"
                                                                name="inbound_twostop_marketingCompany_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->companyId->marketingCarrier }}">

                                                            <input type="hidden"
                                                                name="inbound_twostop_operatingCompany_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">
                                                            <input type="hidden"
                                                                name="inbound_twostop_operatingCompany_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">
                                                            <input type="hidden"
                                                                name="inbound_twostop_operatingCompany_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->companyId->operatingCarrier }}">

                                                            <input type="hidden" name="inbound_twostop_flightNumber_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->flightOrtrainNumber }}">
                                                            <input type="hidden" name="inbound_twostop_flightNumber_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->flightOrtrainNumber }}">
                                                            <input type="hidden" name="inbound_twostop_flightNumber_3"
                                                                value="{{ $flightResultsOfIn->flightDetails[2]->flightInformation->flightOrtrainNumber }}">

                                                        </div>
                                                    </div>
                                                @elseif (is_array($flightResultsOfIn->flightDetails) &&
                                                    isset($flightResultsOfIn->flightDetails[1]) &&
                                                    !isset($flightResultsOfIn->flightDetails[2]))
                                                    @php
                                                        $inbound_img = $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->operatingCarrier;
                                                    @endphp
                                                    <div class="row boxunder p15 trip_box" id="{{ $rowkey }}">
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            {{-- <span class="smbtn float-left margintop-30">RETURN</span> --}}
                                                            <input type="radio" name="inbound-btn{{ $rowkey }}"
                                                                class="radio-btn-inbound"
                                                                value="{{ $segmentInboundKey }}"">
                                                        <span class="searchtitle">{{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                            {{ substr_replace($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                            <div class="searchtitle colorgrey">
                                                                {{ getDate_fn($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="searchtitle text-center">
                                                                {{ substr_replace(substr_replace($flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                | 1-Stop
                                                            </div>
                                                            <div class="borderbotum"></div>
                                                            <div class="searchtitle colorgrey text-center">
                                                                {{ $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId . '-' . $flightResultsOfIn->flightDetails[0]->flightInformation->location[1]->locationId . '-' . $flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="searchtitle colorgrey">
                                                                    {{ getDate_fn($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="display: none;" class="inbound-bagg-data">
                                                            <table class="table table-bordered">

                                                                <tbody>

                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfIn->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfIn->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfIn->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfIn->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <div style="display: none;" class="inbound-segment-data">
                                                            <div class="row">

                                                                <div class="col-2 col-md-2 col-sm-2">
                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId . '->' . $flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                                    </small>
                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2 text-center">

                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ substr_replace(substr_replace($flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </small>
                                                                    <div class="borderbotum"></div>

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[0]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-2 col-md-2 col-sm-2">

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[1]->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2">


                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="inbound-form-data-display">

                                                            <input type="hidden" name="roundtrip_inbound_onestop"
                                                                value="roundtrip_inbound_onestop">

                                                            <input type="hidden" name="inbound_onestop_arrivalingTime"
                                                                value="{{ $flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref }}">

                                                            <input type="hidden" name="inbound_onestop_bookingClass_1"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[0]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[1]->groupOfFares[0]->productInformation->cabinProduct[0]->rbd }}">

                                                            <input type="hidden" name="inbound_onestop_bookingClass_2"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[1]->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[1]->groupOfFares[1]->productInformation->cabinProduct[0]->rbd }}">

                                                            <input type="hidden" name="inbound_onestop_fareBasis_1"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[0]->productInformation->fareProductDetail->fareBasis }}">

                                                            <input type="hidden" name="inbound_onestop_fareBasis_2"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares[1]->productInformation->fareProductDetail->fareBasis }}">

                                                            <input type="hidden" name="inbound_onestop_arrivalTime_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">

                                                            <input type="hidden" name="inbound_onestop_arrivalTime_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">

                                                            <input type="hidden" name="inbound_onestop_arrivalDate_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfArrival }}">

                                                            <input type="hidden" name="inbound_onestop_arrivalDate_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfArrival }}">

                                                            <input type="hidden" name="inbound_onestop_departure_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->location[0]->locationId }}">

                                                            <input type="hidden" name="inbound_onestop_arrival_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->location[1]->locationId }}">

                                                            <input type="hidden" name="inbound_onestop_departureDate_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">

                                                            <input type="hidden" name="inbound_onestop_departureTime_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">

                                                            <input type="hidden"
                                                                name="inbound_onestop_marketingCompany_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden"
                                                                name="inbound_onestop_operatingCompany_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">

                                                            <input type="hidden" name="inbound_onestop_flightNumber_1"
                                                                value="{{ $flightResultsOfIn->flightDetails[0]->flightInformation->flightOrtrainNumber }}">

                                                            <input type="hidden" name="inbound_onestop_departure_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->location[0]->locationId }}">

                                                            <input type="hidden" name="inbound_onestop_arrival_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->location[1]->locationId }}">

                                                            <input type="hidden" name="inbound_onestop_departureDate_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">

                                                            <input type="hidden" name="inbound_onestop_departureTime_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">

                                                            <input type="hidden"
                                                                name="inbound_onestop_marketingCompany_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden"
                                                                name="inbound_onestop_operatingCompany_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">

                                                            <input type="hidden" name="inbound_onestop_flightNumber_2"
                                                                value="{{ $flightResultsOfIn->flightDetails[1]->flightInformation->flightOrtrainNumber }}">

                                                        </div>
                                                    </div>
                                                @else
                                                    @php
                                                        $inbound_img = $flightResultsOfIn->flightDetails->flightInformation->companyId->operatingCarrier;
                                                    @endphp
                                                    <div class="row boxunder p15 trip_box" id="{{ $rowkey }}">
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            {{-- <span
                                        class="smbtn float-left margintop-30">RETURN</span> --}}
                                                            <input type="radio" name="inbound-btn{{ $rowkey }}"
                                                                class="radio-btn-inbound"
                                                                value="{{ $segmentInboundKey }}">
                                                            <span
                                                                class="
                                            
                                            
                                            searchtitle">{{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails->flightInformation->location[0]->locationId . ')' }}
                                                                {{ substr_replace($flightResultsOfIn->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                            <div class="searchtitle colorgrey">
                                                                {{ getDate_fn($flightResultsOfIn->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="searchtitle text-center">
                                                                {{ substr_replace(substr_replace($flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                            </div>
                                                            <div class="borderbotum"></div>
                                                            <div class="searchtitle colorgrey text-center"> Non-Stop
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <div class="float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($flightResultsOfIn->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="searchtitle colorgrey">
                                                                    {{ getDate_fn($flightResultsOfIn->flightDetails->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="display: none;" class="inbound-bagg-data">
                                                            <table class="table table-bordered">

                                                                <tbody>

                                                                    <tr>
                                                                        <td> <img
                                                                                src="{{ asset('assets/images/flight/' . $flightResultsOfIn->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                                                alt="">
                                                                            <span
                                                                                class="onwfnt-11">{{ $flightResultsOfIn->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $flightResultsOfIn->flightDetails->flightInformation->flightOrtrainNumber }}</span>
                                                                        </td>

                                                                        <td class="onwfnt-11">
                                                                            {{ $outFreeBag }}</td>
                                                                        <td class="onwfnt-11">7KG</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <div style="display: none;" class="inbound-segment-data">
                                                            <div class="row">
                                                                <div class="col-2 col-md-2 col-sm-2">
                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ $flightResultsOfIn->flightDetails->flightInformation->location[0]->locationId . '->' . $flightResultsOfIn->flightDetails->flightInformation->location[1]->locationId }}
                                                                    </small>
                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <span class="searchtitle">
                                                                        {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails->flightInformation->location[0]->locationId) . ' (' . $flightResultsOfIn->flightDetails->flightInformation->location[0]->locationId . ')' }}
                                                                        {{ substr_replace($flightResultsOfIn->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </span>
                                                                    <div class="searchtitle colorgrey">
                                                                        {{ getDate_fn($flightResultsOfIn->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 col-md-2 col-sm-2 text-center">

                                                                    <small class="searchtitle colorgrey text-center">
                                                                        {{ substr_replace(substr_replace($flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </small>
                                                                    <div class="borderbotum"></div>

                                                                </div>
                                                                <div class="col-4 col-md-4 col-sm-4">
                                                                    <div class="float-right">
                                                                        <div class="searchtitle">
                                                                            {{ substr_replace($flightResultsOfIn->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                            {{ AirportiatacodesController::getCity($flightResultsOfIn->flightDetails->flightInformation->location[1]->locationId) . ' (' . $flightResultsOfIn->flightDetails->flightInformation->location[1]->locationId . ')' }}
                                                                        </div>
                                                                        <div class="searchtitle colorgrey">
                                                                            {{ getDate_fn($flightResultsOfIn->flightDetails->flightInformation->productDateTime->dateOfArrival) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="inbound-form-data-display">

                                                            <input type="hidden" name="roundtrip_inbound_nonstop"
                                                                value="roundtrip_inbound_nonstop">

                                                            <input type="hidden" name="inbound_nonstop_arrivalingTime"
                                                                value="{{ $flightResultsOfIn->propFlightGrDetail->flightProposal[1]->ref }}">

                                                            <input type="hidden" name="inbound_nonstop_bookingClass"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares->productInformation->cabinProduct->rbd ?? $paxFareProduct->fareDetails[1]->groupOfFares->productInformation->cabinProduct[0]->rbd }}">
                                                            <input type="hidden" name="inbound_nonstop_fareBasis"
                                                                value="{{ $paxFareProduct->fareDetails[1]->groupOfFares->productInformation->fareProductDetail->fareBasis }}">

                                                            <input type="hidden" name="inbound_nonstop_departure"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->location[0]->locationId }}">
                                                            <input type="hidden" name="inbound_nonstop_arrival"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->location[1]->locationId }}">
                                                            <input type="hidden" name="inbound_nonstop_departureDate"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->productDateTime->dateOfDeparture }}">
                                                            <input type="hidden" name="inbound_nonstop_arrivalDate"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->productDateTime->dateOfArrival }}">
                                                            <input type="hidden" name="inbound_nonstop_marketingCompany"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->companyId->marketingCarrier }}">
                                                            <input type="hidden" name="inbound_nonstop_operatingCompany"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->companyId->operatingCarrier }}">

                                                            <input type="hidden" name="inbound_nonstop_flightNumber"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->flightOrtrainNumber }}">

                                                            <input type="hidden" name="inbound_nonstop_departureTime"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->productDateTime->timeOfDeparture }}">
                                                            <input type="hidden" name="inbound_nonstop_arrivalTime"
                                                                value="{{ $flightResultsOfIn->flightDetails->flightInformation->productDateTime->timeOfArrival }}">

                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <span data-toggle="collapse" data-target="#round-trip-details{{ $rowkey }}"
                        class="onewflydetbtn">Flight
                        Details</span>
                    <div id="round-trip-details{{ $rowkey }}" class="collapse">
                        <div class="container">
                            <ul class="nav nav-tabs w-100">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab"
                                        href="#round-trip-Information{{ $rowkey }}"> Flight
                                        Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                        href="#round-trip-Details{{ $rowkey }}"> Fare
                                        Details </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                        href="#round-trip-Baggage{{ $rowkey }}">
                                        Baggage Information </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                        href="#round-trip-Cancellation{{ $rowkey }}">
                                        Cancellation Rules </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane container active"
                                    id="round-trip-Information{{ $rowkey }}">
                                    <div class="segment-outbound"></div>
                                    <div class="segment-inbound"></div>
                                </div>
                                <div class="tab-pane container fade" id="round-trip-Details{{ $rowkey }}">

                                    <div class="onwfntrespons-11">
                                        <span class="text-left"> Fare Rules :</span>
                                        <span class="text-right onewflydetbtn {{ $farerule }}"> {{ $farerule }}</span>
                                    </div>
                                    <table class="table table-bordered">
                                        <tbody class="onwfntrespons-11">
                                            <tr>
                                                <td class="onwfnt-11">1 x Adult</td>
                                                <td class="text-right"> {!! $icon !!}
                                                    {{ ($totalFareAmount - $totalTaxAmount) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                <td class="text-right"> {!! $icon !!}
                                                    {{ ($totalFareAmount - $totalTaxAmount) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Total Tax +</td>
                                                <td class="text-right"> {!! $icon !!}
                                                    {{ $totalTaxAmount }}</td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                <td class="text-right"> {!! $icon !!}
                                                    {{ $totalFareAmount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane container fade" id="round-trip-Baggage{{ $rowkey }}">
                                    <table class="table table-bordered">
                                        <thead class="onwfntrespons-11">
                                            <tr>
                                                <th>Airline</th>
                                                <th>Check-in Baggage</th>
                                                <th>Cabin Baggage</th>
                                            </tr>
                                        </thead>

                                    </table>
                                    <div class="segment-bagg-outbound"></div>

                                    <div class="segment-bagg-inbound"></div>
                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                    <ul class="onwfnt-11">
                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                            Difference if applicable + WT Fees.</li>
                                        <li>The airline cancel reschedule fees is indicative and can be
                                            changed without any prior notice by the airlines..</li>
                                        <li>Wagnistrip does not guarantee the accuracy of cancel reschedule
                                            fees..</li>
                                        <li>Partial cancellation is not allowed on the flight tickets which
                                            are book under special round trip discounted fares..</li>
                                        <li>Airlines doesnt allow any additional baggage allowance for any
                                            infant added in the booking</li>
                                        <li>In certain situations of restricted cases, no amendments and
                                            cancellation is allowed</li>
                                        <li>Airlines cancel reschedule should be reconfirmed before
                                            requesting for a cancellation or amendment</li>
                                    </ul>
                                </div>
                                <div class="tab-pane container fade" id="round-trip-Cancellation{{ $rowkey }}">
                                    <table class="table table-bordered">
                                        <tbody class="onwfntrespons-11">
                                            <tr>
                                                <td> <b>Time Frame to Reissue</b>
                                                    <div class="onwfnt-11">(Before scheduled departure time)
                                                    </div>
                                                </td>
                                                <td> <b>Airline Fees</b>
                                                    <div class="onwfnt-11"> (per passenger) </div>
                                                </td>
                                                <td> <b>WT Fees</b>
                                                    <div class="onwfnt-11"> (per passenger) </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Cancel Before 4 hours of
                                                    departure time.</td>
                                                <td> As Per Airline Policy</td>
                                                <td> {!! $icon !!} {{500*$cvalue}}</td>
                                            </tr>

                                            <tr>
                                                <td> <b>Time Frame to cancel</b>
                                                    <div class="onwfnt-11">(Before scheduled departure time)
                                                    </div>
                                                </td>
                                                <td> <b>Airline Fees</b>
                                                    <div class="onwfnt-11"> (per passenger) </div>
                                                </td>
                                                <td> <b>WT Fees</b>
                                                    <div class="onwfnt-11"> (per passenger) </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="onwfnt-11">Cancel Before 4 hours of
                                                    departure time.</td>
                                                <td> As Per Airline Policy</td>
                                                <td> {!! $icon !!} {{500*$cvalue}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                    <ul class="onwfnt-11">
                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                            Difference if applicable + WT Fees.</li>
                                        <li>The airline cancel reschedule fees is indicative and can be
                                            changed without any prior notice by the airlines..</li>
                                        <li>Wagnistrip does not guarantee the accuracy of cancel reschedule
                                            fees..</li>
                                        <li>Partial cancellation is not allowed on the flight tickets which
                                            are book under special round trip discounted fares..</li>
                                        <li>Airlines doesnt allow any additional baggage allowance for any
                                            infant added in the booking</li>
                                        <li>In certain situations of restricted cases, no amendments and
                                            cancellation is allowed</li>
                                        <li>Airlines cancel reschedule should be reconfirmed before
                                            requesting for a cancellation or amendment</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </section>

    </div>
    <!-- DESKTOP VIEW END -->
    <div class="pt-6p"></div>
    <!-- MOBILE VIEW START -->
    <div id="flightofmobileview">
        <header class="stickyheader">
            <nav class="navbar navbar-expand-sm bg-light navbar-light">
                <div class="container">
                    <span class="menubar" onclick="openNav()"><i class="fa fa-bars"
                            aria-hidden="true"></i></span>
                    <a href="" class="float-left img-fluid">

                        <img src="{{ asset('assets/images/logo.png') }}" class="img-responsive">
                    </a>
                    <span class="usericon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                </div>
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="#"> <i class="fa fa-user-circle-o"></i> <span class="spaceicon"> Login | Sign up
                            Now</span>
                    </a>
                    <a href="#"> <i class="fa fa-plane"></i> <span class="spaceicon">Flights</span> </a>
                    <a href="#"> <i class="fa fa-building-o"></i> <span class="spaceicon"> Hotels </span> </a>
                    <a href="#"> <i class="fa fa-yelp"></i> <span class="spaceicon"> Holidays </span></a>
                    <a href="#"> <i class="fa fa-bus"></i> <span class="spaceicon"> Bus </span></a>
                    <a href="#"> <i class="fa fa-cab"></i> <span class="spaceicon"> Cabs </span></a>
                    <a href="#"> <i class="fa fa-ship"></i> <span class="spaceicon"> Cruise </span></a>
                    <a href="#"> <i class="fa fa-book"></i> <span class="spaceicon"> Visa </span></a>
                </div>
            </nav>
        </header>
    </div>
    <!-- MOBILE VIEW END -->
@section('css')
    <link rel="stylesheet" href="assets/css/range.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
@stop
<script src="{{ asset('assets/js/internation-roundtrip.js') }}"></script>
<script>
    $(document).ready(function() {
        
        
         {{-- /////// API Data code By Neelesh ////// --}}
   
var divs = document.getElementsByClassName('owstitle1');
var uniqueValues = [];

for (let i = 0; i < divs.length; i++) {
  let iddata = divs[i].innerHTML;
  
  if (!uniqueValues.includes(iddata)) {
    uniqueValues.push(iddata);
    fetchAirlineCode(iddata, divs);
  }
}

function fetchAirlineCode(iddata, divs) {
  fetch("https://www.flights.wagnistrip.com/api/airlinecode?search=" + iddata)
    .then(response => response.text())
    .then(data => {
      for (let i = 0; i < divs.length; i++) {
        if (divs[i].innerHTML === iddata) {
          divs[i].innerHTML = data;
        }
      }
    })
    .catch(error => console.error(error));
}

  {{--///////  End  Code By Neelesh //////--}}

        
        for (i = 0; i <= {{ $resultLenght }}; i++) {
            // setTimeout(function(){
            $('INPUT:radio[name=outbound-btn' + i + ']:first').trigger('click');
            // }, 200+i);

            // setTimeout(function(){
            $('INPUT:radio[name=inbound-btn' + i + ']:first').trigger('click');
            // }, 200+i);
        }
        for (i = 0; i <= {{ $galkeylength }}; i++) {
            // setTimeout(function(){
            $('INPUT:radio[name=outbound-btn-gal' + i + ']:first').trigger('click');
            // }, 200+i);

            // setTimeout(function(){
            $('INPUT:radio[name=inbound-btn-gal' + i + ']:first').trigger('click');
            // }, 200+i);
        }

    });
</script>
@section('script')
    {{--<script src="assets/js/range.js"></script>--}}
    <script>
       $(document).ready(function () {

        $('.booknowbtn').on('click', function () {
           var formData = $(this).closest('form');
           $(formData).submit();
        });
        let airlineDataArr = {!! json_encode($airlineArr, true)!!};

            let airlineKey = 'code';
        
            let airlineStopKey = 'stop';
        
            airlineFileterArr = [...new Map(airlineDataArr.map(item => [item[airlineKey], item])).values()];
        
            airlineStopArr = [...new Map(airlineDataArr.map(item => [item[airlineStopKey], item])).values()];
        
         
            
                //////////////////////////////////Code BY Neelesh Start for showing airline and filter it///////////////////
                const deskiata = {
                    "AI":"Air India","VJ":"Viejet AIR","6E":"IndiGo","SG":"SpiceJet","UK":"Vistara","B3":"Bhutan Airlines","G8":"GoAir","I5":"AirAsia India","IX":"Air India Express","9I":"Alliance","2T":"TruJet","OG":"Star Air","EI":"Aer Lingus","SU":"Aeroflot","AR":"Argentinas","AM":"AeroMexico","G9":"Air Arabia","KC":"Air Astana","UU":"Air Austral","BT":"Air Baltic","HY":"Uzbekistan","AC":"Air Canada","CA":"Air China","XK":"Air Corsica","UX":"Air Europa","AF":"Air France","AI":"Air India","NX":"Air Macau","KM":"Air Malta","MK":"Air Mauritius","9U":"Air Moldova","SW":"Air Namibia","NZ":"Air New Zealand","PX":"Air Niugini","JU":"Air Serbia","TN":"Air Tahiti Nui","TS":"Air Transat","NF":"Air Vanuatu","AS":"Alaska Airlines","AZ":"Alitalia","NH":"All Nippon","AA":"American Airlines","OZ":"Asiana Airlines","OS":"Austrian Airlines","AV":"Avianca","J2":"Azerbaijan Airlines","AD":"Azul Brazilian Airlines","PG":"Bangkok Airways","B2":"Belavia Belarusian Airlines","BG":"Biman Bangladesh Airlines","BA":"British Airways","SN":"Brussels Airlines","FB":"Bulgaria Air","CX":"Cathay Pacific","5J":"Cebu Pacific","CI":"China Airlines", "MU":"China Eastern Airlines","CZ":"China Southern Airlines","DE":"Condor","CM":"Copa Airlines","OU":"Croatia Airlines","OK":"Czech Airlines","DL":"Delta Air Lines","U2":"easyJet","MS":"Egypt Air","LY":"El Al Israel Airlines","EK":"Emirates Airline","ET":"Ethiopian Airlines","EY":"Etihad Airways","EW":"Eurowings","BR":"EVA Airline","FJ":"Fiji Airways","AY":"Finnair","FZ":"Flydubai","F9":"Frontier Airlines","GA":"Garuda Indonesia","ST":"Germania Fluggesellschaft","G3":"Gol Transportes Aéreos","GF":"Gulf Air","HU":"Hainan Airlines","HA":"Hawaiian Airlines","HX":"Hong Kong Airlines","IB":"Iberia","FI":"Icelandair","6E":"IndiGo","4O":"Interjet","IR":"Iran Air","JL":"Japan Airlines","9W":"Jet Airways","B6":"JetBlue Airways","KQ":"Kenya Airways","KL":"KLM Royal Dutch Airlines","KE":"Korean Air","KU":"Kuwait Airways","LA":"LATAM Airlines","LO":"LOT Polish","LH":"Lufthansa","MH":"Malaysia Airlines","OD":"Batik Air","JE":"Mango","ME":"Middle East Airlines","YM":"Montenegro Airlines","8M":"Myanmar Airways International","RA":"Nepal Airlines","DY":"Norwegian Air Shuttle","WY":"Oman Air","MM":"Peach Aviation","PR":"Philippine Airlines","DP":"Pobeda Airlines","QF":"Qantas","QR":"Qatar Airways","AT":"Royal Air Maroc","BI":"Royal Brunei Airlines","RJ":"Royal Jordanian","ES":"DHL International E.C.","MS":"Egyptair","LY":"EL AL","EK":"Emirates","OV":"Estonian Air","ET":"Ethiopian Airlines","EY":"Etihad Airways","EA":"EEuropean Air Express","QY":"European Air Transport","EW":"Eurowings","BR":"EVA Air","EF":"Far Eastern Air Transport","FX":"Federal Express","AY":"Finnair","BE":"flybe.British European","TE":"FlyLAL - Lithuanian Airlines","GA":"Garuda","GT":"GB Airways","GF":"Gulf Air","HR":"Hahn Air","HU":"Hainan Airlines","HF":"Hapag Lloyd","HJ":"Hellas Jet","DU":"Hemus Air","IB":"IBERIA Air","FI":"Icelandair","IC":"Indian Airlines","D6":"Interair","IR":"Iran Air","EP":"Iran Aseman Airlines","IA":"Iraqi Airways","6H":"Israir","JO":"JALways Co. Ltd","JL":"Japan Airlines","JU":"Jat Airways","9W":"Jet Airways","R5":"Jordan Aviation","KQ":"Kenya Airways","Y9":"Kish Air","KR":"Kitty Hawk","KL":"KLM Airline","KE":"Korean Air","KU":"Kuwait Airways","LB":"LAB","LR":"LACSA","TM":"LAM Airline","LA":"Lan Airline","4M":"Lan Argentina","UC":"Lan Chile Cargo","LP":"Lan Peru","XL":"Lan Ecuador","NG":"Lauda Air","LN":"Libyan Arab Airlines","ZE":"Lineas Aereas Azteca S.A. de C.V.","LT":"LTU Airline","LH":"Lufthansa","LH":"Lufthansa Cargo","CL":"Lufthansa CityLine","LG":"Lux airline","W5":"Mahan Air","MH":"Malaysia Airlines","MA":"MALEV","TF":"Malm Aviation","IN":"MAT -Macedonian Airlines","ME":"MEA Airline","IG":"Meridiana","MX":"Mexicana","OM":"MIAT Airline","YM":"Montenegro Airlines","CE":"Nationwide Airlines","KZ":"Nippon Cargo Airlines (NCA)","NW":"Northwest Airlines","OA":"Olympic Airlines S.A.","WY":"Oman Air","8Q":"Onur Air","PR":"PAL Airline","PF":"Palestinian Airlines","H9":"Pegasus Airlines","NI":"PGA-Portug?lia Airlines","PK":"PIA Airline","PU":"PLUNA","PW":"Precision Air","QF":"Qantas","QR":"Qatar Airways","FV":"Rossiya - Russian Airlines","AT":"Royal Air Maroc","BI":"Royal Brunei","WB":"Rwandair Express","4Z":"SA Airlink","SA":"SAA Airline","FA":"Safair","SK":"SAS Airline","BU":"SAS Braathens","XY":"Flynas ","SP":"SATA Air A?ores","SV":"Saudi Arabian","SC":"Shandong Airlines Co., Ltd.","FM":"Shanghai Airlines","ZH":"Shenzhen Airlines Co. Ltd.","SQ":"SIA Cargo","S7":"Siberia Airlines","3U":"Sichuan Airlines Co. Ltd.","MI":"Silkair","JZ":"Skyways","SN":" Brussels Airlines","IE":"Solomon Airlines","JK":"Spanair","UL":"SriLankan","SD":"Sudan Airways","PY":"Surinam Airways","LX":"SWISS","RB":"Syrianair","TA":"TACA","PZ":"Transportes airline","JJ":"Linhas Airline","TP":"Air Portugal","RO":"TAROM S.A.","SF":"Tassili ","TG":"Thai Airways","TK":"THY Airline","3V":"TNT Airways","UN":"Transaero","GE":"TransAsia Airways","TU":"Tunis Air","PS":"Ukraine International","UA":"United Airlines","5X":"UPS Airlines","US":"US Airways","LC":"Varig Log","VN":"Vietnam Airlines","VS":"Virgin Atlantic","VK":"Virgin Nigeria","XF":"Vladivostok Air","VI":"Volga-Dnepr","WF":"Wideroe","GP":"APG Airlines","MF":"Xiamen","IY":"Yemenia"
                 };
                
                airlineFileterArr.forEach(element => {
               airlineLoop = '<div class="padding-10 input_row12">' +
                    '<span class="span_input"><input type="checkbox" class="form-check-input" value="'+ element.code+ '">'+'<img src="{{ asset('assets/images/flight/') }}/'+element.code+'.png" width="20px" height="20px" alt="">' +' '+ deskiata[element.code] + ' </span>' +
  
                    '</div>';
                    $('#Airline').append(airlineLoop);
                });
    


    {{--  ENd of code Neelesh --}}
        
            airlineStopArr.forEach(element => {
                airlineStopLoop = '<div class="input_row"><input type="checkbox" class="filter-btn form-check-input" value="' + element.stop + '">' + element.stop + '</div>';
                $('#Stops .padding-10').append(airlineStopLoop);
            });

var airlineArr = [];
var stopsArr = [];

$("#Airline :checkbox, #Airline2 :checkbox, #Stops :checkbox, #Stops2 :checkbox").click(function () {
    // reset the filters
    $(".airline_hide").show();
    $(".stops_hide").show();
    $(".too-many-filters").hide();
    
    showMatchingCardLists();
    let cardAirLine = $('.airline_hide');
    if(cardAirLine.length === 0){
        $(".too-many-filters").show();
    } else {
        $(".too-many-filters").hide();
    }
});

    // /\.../\/\.../\Time Range Code By Vikas/\.../\/\../\/\
    const buttons = $('.take-off-timing');
    const cardLists = $('.isotope-grid .airline_hide');
    const buttons2 = $('.landing-timing');
    const cardLists2 = $('.isotope-grid .airline_hide');

    buttons.on('click', function() {
        const button = $(this);
        button.toggleClass('activetime');
        showMatchingCardLists();
    });

    buttons2.on('click', function() {
        const button = $(this);
        button.toggleClass('activetime');
        showMatchingCardLists();
    });

    function isTimeInRange(time, timeRange) {
        const hour = parseInt(time.split(':')[0]);
        if (timeRange === 'before 6 am') {
        return hour < 6;
        } else if (timeRange === '6 am - 12 pm') {
        return hour >= 6 && hour < 12;
        } else if (timeRange === '12 pm - 6 pm') {
        return hour >= 12 && hour < 18;
        } else if (timeRange === 'after 6 pm') {
        return hour >= 18;
        } else {
        return false;
        }
    }

    function showMatchingCardLists() {
        const allCards = $('.isotope-grid .airline_hide');
        allCards.css('display', 'none');

        const activeButtons = $('.take-off-timing.activetime');
        const activeButtons2 = $('.landing-timing.activetime');
        let timeRanges = [];
        let timeRanges2 = [];
        activeButtons.each(function() {
            timeRanges.push($(this).text().toLowerCase().trim());
        });
        activeButtons2.each(function() {
            timeRanges2.push($(this).text().toLowerCase().trim());
        });


        let displayedCardCount = 0;
        cardLists.each(function() {
        const time = $(this).find('.takeoff').text().trim();
        const time2 = $(this).find('.landing').text().trim();
        let isTakeOffInRange = false;
        let isLandingInRange = false;
        if (activeButtons.length === 0) {
            isTakeOffInRange = true;
        } else {
            activeButtons.each(function() {
                if (isTimeInRange(time, $(this).text().toLowerCase().trim())) {
                    isTakeOffInRange = true;
                    return false;
                }
            });
        }
        if (activeButtons2.length === 0) {
            isLandingInRange = true;
        } else {
            activeButtons2.each(function() {
                if (isTimeInRange(time2, $(this).text().toLowerCase().trim())) {
                    isLandingInRange = true;
                    return false;
                }
            });
        }
        if (isTakeOffInRange && isLandingInRange) {
            $(this).css('display', 'block');
            displayedCardCount++;
        } else {
            $(this).css('display', 'none');
        }
        });

        const allCardsDisplayed = displayedCardCount === 0;
        const container = $('.too-many-filters');
        if (allCardsDisplayed) {
        container.css('display', 'block');
        } else {
        container.css('display', 'none');
        }

        // update the airline and stops value arrays with all checked checkboxes
        airlineArr = $("#Airline :checkbox:checked, #Airline2 :checkbox:checked").map(function() {
            return "." + $(this).val();
        }).get();
        stopsArr = $("#Stops :checkbox:checked, #Stops2 :checkbox:checked").map(function() {
            return "." + $(this).val();
        }).get();

        // hide the elements that don't match the filters
        if (airlineArr.length > 0) {
            $(".airline_hide").not(airlineArr.join(", ")).hide();
        }
        if (stopsArr.length > 0) {
            $(".stops_hide").not(stopsArr.join(", ")).hide();
        }
        
        // close btn for reset filters
        const closeBtn = container.find('.close-btn2');
        closeBtn.on('click', function() {
        const activeButtons = $('.take-off-timing.activetime, .landing-timing.activetime');
        $("#Airline :checkbox:checked, #Airline2 :checkbox:checked, #Stops :checkbox:checked, #Stops2 :checkbox:checked").prop('checked', false);
        activeButtons.removeClass('activetime');
        $(".airline_hide").show();
        $(".stops_hide").show();
        $(".too-many-filters").hide();
        showMatchingCardLists();
        });
        
    if (airlineArr.length > 0 && stopsArr.length > 0 && activeButton.length > 0 && activeButton2.length > 0) {
        var filteredCards = $(".airline_hide" + airlineArr.join(", .airline_hide") + stopsArr.join(", .stops_hide") + activeButton.join(", .airline_hide") + activeButton2.join(", .airline_hide"));
        if (filteredCards.length === 0) {
            // if no cards match the filters, add the "too-many-filters" div
            // $("<div id='too-many-filters'>No Flight Found </div>").insertAfter("#filters");
            $(".too-many-filters").show();
        } 
    }    

    }

             $('.js-example-basic-single').select2();
         
             function togglePopup() {
                 $(".content").toggle();
             }
         
           

        // price range slider 1 

            <!--var minPrice = parseInt($('.fare').first().text());-->
            <!--var maxPrice = parseInt($('.fare').first().text());-->
            var minPrice_text  = $('.fare').first().text();
            minPrice_text = minPrice_text.replace('$' , '');
            minPrice_text.trim();
            var minPrice = parseInt(minPrice_text);
            var maxPrice = parseInt(minPrice_text);
            
                $('.fare').each(function() {
                    <!--var price = parseInt($(this).text());-->
                    var price_text = $(this).text();
                    price_text = price_text.replace('$' , '');
                    price_text.trim();
                    var price = parseInt(price_text);
                    
                    if (price < minPrice) minPrice = price;
                    if (price > maxPrice) maxPrice = price;
                });
                $('#min_price').val(minPrice);
                $("#slider-range").slider({
                    range: false,
                    min: minPrice,
                    max: maxPrice,
                    value: minPrice,
                    slide: function(event, ui) {
                        $("#min_price").val(ui.value);
                        filterAirlineHide(ui.value, maxPrice);
                    }
                });
                $('#min_price').on('input', function() {
                    var minPrice = parseInt($('#min_price').val());
                    if (minPrice > maxPrice) {
                        var temp = minPrice;
                        minPrice = maxPrice;
                        maxPrice = temp;
                        $('#min_price').val(minPrice);
                    }
                    $("#slider-range").slider("value", minPrice);
                    filterAirlineHide(minPrice, maxPrice);
                });
                    filterAirlineHide(parseInt($('#min_price').val()), parseInt($('#max_price').val()));
                function filterAirlineHide(minPrice, maxPrice) {
                return false;
                    $('.airline_hide').each(function() {
                        <!--var fare = parseInt($(this).find('.fare').text());-->
                        var fare_text  = $(this).find('.fare').text();
                         fare_text = fare_text.replace('$' , '');
                        fare_text = fare_text.trim();
                        var fare = parseInt(fare_text);
                        
                        if (fare >= minPrice) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }


// \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
           // sort by low to high 
            $(".form-control1").on("change", function () {
                var sortingMethod = $(this).val();
            
                if (sortingMethod == 'l2h') {
                    sortProductsPriceAscending();
                    
                } else if (sortingMethod == 'h2l') {
                    sortProductsPriceDescending();
                } else if (sortingMethod == '0') {
                    sortBynormal();
                }
            });
            setTimeout(() => {
              sortProductsPriceAscending();
            }, 500);
            
            
            function sortProductsPriceAscending() {
                var gridItems = $('.airline_hide');
            
                gridItems.sort(function (a, b) {
                    return $('.dataprice', a).data("price1") - $('.dataprice', b).data("price1");
                    // return sortPrice =  $('.product-card', a).data("price1") - $('.product-card', b).data("price1");
                });
            
                $(".isotope-grid").append(gridItems);
            }
            
            function sortProductsPriceDescending() {
                var gridItems = $('.airline_hide');
            
              // Sort the products by price
                gridItems.sort(function (a, b) {
                    return $('.dataprice', b).data("price1") - $('.dataprice', a).data("price1");
                    
                });
            
                $(".isotope-grid").append(gridItems);
            }
            
            function sortBynormal() {
                var gridItems = $('.airline_hide');
            
                gridItems.sort(function (a, b) {
                    return $(a).index() - $(b).index();
                });
            
                $(".isotope-grid").append(gridItems);
            }
    
});





// \\\\\\\\\\\\\\\\\store dynimic city name//////////////////////
        // Get the div elements with class "city"
        const cityElements = document.querySelectorAll('.cityflight');

        // Get the span elements by their IDs
        const city1Span = document.getElementById('city1');
        const city2Span = document.getElementById('city2');

        // Loop through the city elements
        cityElements.forEach(cityElement => {
            // If the element has a "data-city1" attribute, set the text of city1Span to its value
            if (cityElement.hasAttribute('data-city1')) {
                const city1Value = cityElement.getAttribute('data-city1');
                city1Span.textContent = city1Value;
            }

            // If the element has a "data-city2" attribute, set the text of city2Span to its value
            if (cityElement.hasAttribute('data-city2')) {
                const city2Value = cityElement.getAttribute('data-city2');
                city2Span.textContent = city2Value;
            }
        });




// Get all filter buttons
const filterButtons = document.querySelectorAll('.filter-btn');

// Set initial active filter as null
let activeFilter = null;
// Add click event listener to each filter button
filterButtons.forEach(button => {
  button.addEventListener('click', () => {
    // Remove active class from previous active filter, if it exists
    if (activeFilter) {
      activeFilter.classList.remove('activetime');
    }

    // Add active class to current filter
    button.classList.add('activetime');

    // Set current filter as active filter
    activeFilter = button;
  });
});

</script>
@stop
{{-- <x-footer />--}}
@endsection