@extends('layouts.master')
@section('title', 'Wagnistrip')
@section('body')

<x-search-bar />


    <script defer src="{{url('assets/js/sorting.js')}}"></script>
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
     {{--<link rel="stylesheet" type="text/css" src="{{url('assets/css/jQuery.UI.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css">
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
        .owstitle1 {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    font-family: system-ui;
}
.input_row-12 {
    margin-right: 24%;
}


.tab-pane {
    padding-top:10px;
}

@media only screen and (min-device-width: 275px) and (max-device-width: 576px) {
    .scrollfix{
        height:auto;
    }   
}



    </style>
@php
    $Agent = Session()->get("Agent");
    if($Agent != null){
        $isAgent = true;
        $charge = 2;
    }else{
        $isAgent = false;
        $charge = 100;
    }
        // 15 AUG 2023 ONLY OUTSIDE INDIA
    if($Agent != null){
        $isAgent = true;
        $charge = 2;
    }else{
        $isAgent = false;
        $charge = 100;
    }    
    
@endphp
    <section >
        <div class="container">
            <div class="row">
                <div class="col-sm-3 pt-20">
                    <div class="boxunder " >
                            <div>
                                <div class="card-header owstitle" data-toggle="collapse" data-target="#FILTER">FILTER
                                <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div id="FILTER">
                                
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#Stops2,#Airline2">Popular Filters
                                    <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                                </div>
                                <div id="Stops2" class="collapse show">
                                    <div class="padding-10">
                                    </div>
                                </div>
                        
                                <div id="Airline2" class="collapse show">
                                </div>
                            </div>
                        <div class="ranjepp">
                            <div class="owstitle pb-10" data-toggle="collapse" data-target="#price">Pricing
                                <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                            </div>
                            <div id="price" class="collapse show">
                                <div class="wrapper text-center">
                                    
                                    <div class="input_row-12 text-center" style=" margin-top: 1rem; width:100%; ">
                                        <input type="number" min=0 max="9900" oninput="validity.valid||(value='3400');" id="min_price" class="price-range-field text-center" style="border:none; " readonly/>
                                    </div>
                                    <div id="slider-range">
                                        <div class="ui-slider-range ui-widget-header" style="left: 0%; width: 100%;"></div>
                                        <a class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%; border: 2px solid;"></a>
                                    </div>
		                            {{--<div style="margin:13px 22px">
		                                <input type="number" min=0 max="9900" oninput="validity.valid||(value='3400');" id="min_price" class="price-range-field" style="border:none; text-align: center;" readonly/>
		                                <input type="number" min=0 max="10000" oninput="validity.valid||(value='10000');" id="max_price" class="price-range-field" style="border:none; text-align: center;" readonly/>
		                            </div>
                                    <div id="slider-range">
                                        <div class="ui-slider-range ui-widget-header" style="left: 0%; width: 100%;"></div>
                                        <a class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%; border: 2px solid;"></a>
                                        <a class="ui-slider-handle ui-state-default ui-corner-all" style="left: 100%; border: 2px solid;"></a>
                                    </div>--}}

                                    {{-- <button class="price-range-search" id="price-range-submit">Search</button> --}}
                                    <br><br>
                                    <select class="form-control1" name="price-sorting" style="width: 100%; text-align: center; border-radius: 10px; border: 1px solid #0164a3;">
                                        <option value="0">Sort Price</option>
                                        <option value="l2h">Low - High Price</option>
                                        <option value="h2l">High - Low Price</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                        <div class="borderbotum"></div>
                        <div class="ranjepp">
                            <div class="owstitle pb-10" data-toggle="collapse" data-target="#FLIGHT">FLIGHT TIMING
                                <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                            </div>
                            <div id="FLIGHT" class="collapse show price-filter-container">
                                
                                <i class="onwfnt-11">Departure <span id="city1"></span></i>
                                <div class="slider-wrapper slider-primary slider-strips slider-ghost pb-20">
                                    <div class="row">
                                        <div class="col-md-3 p-1 timeBTN">
                                            <div class="card another-card take-off-timing">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-sunrise-fill" viewBox="0 0 16 16">
                                                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1-.708.708L8.5 2.707V4.5a.5.5 0 0 1-1 0V2.707l-.646.647a.5.5 0 1 1-.708-.708l1.5-1.5zM2.343 4.343a.5.5 0 0 1 .707 0l1.414 1.414a.5.5 0 0 1-.707.707L2.343 5.05a.5.5 0 0 1 0-.707zm11.314 0a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zM11.709 11.5a4 4 0 1 0-7.418 0H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                                      </svg><br/>
                                                    <small class="beforesixam" style="font-size:8px;">Before 6 AM </small><br>
                                                    {{-- <small style="font-size:10px;">$ 65225</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 p-1 timeBTN">
                                            <div class="card another-card take-off-timing ">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 0 16 16">
                                                        <path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                                                      </svg><br/>
                                                    <small class="beforesixam" style="font-size:8px;">6 Am - 12 Pm</small><br>
                                                    {{-- <small style="font-size:10px;">$ 65225</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 p-1 timeBTN">
                                            <div class="card another-card take-off-timing ">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-sunset-fill" viewBox="0 0 16 16">
                                                        <path d="M7.646 4.854a.5.5 0 0 0 .708 0l1.5-1.5a.5.5 0 0 0-.708-.708l-.646.647V1.5a.5.5 0 0 0-1 0v1.793l-.646-.647a.5.5 0 1 0-.708.708l1.5 1.5zm-5.303-.51a.5.5 0 0 1 .707 0l1.414 1.413a.5.5 0 0 1-.707.707L2.343 5.05a.5.5 0 0 1 0-.707zm11.314 0a.5.5 0 0 1 0 .706l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zM11.709 11.5a4 4 0 1 0-7.418 0H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                                      </svg><br/>
                                                    <small class="beforesixam" style="font-size:8px;">12 Pm - 6 Pm</small><br>
                                                    {{-- <small style="font-size:10px;">$ 65225</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 p-1 timeBTN">
                                            <div class="card another-card take-off-timing ">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-moon-fill" viewBox="0 0 16 16">
                                                        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                                                      </svg><br/>
                                                    <small class="beforesixam" style="font-size:8px;">After 6 Pm</small><br>
                                                    {{-- <small style="font-size:10px;">$ 65225</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <i class="onwfnt-11">Arrival <span id="city2"></span></i>
                                <div class="slider-wrapper slider-primary slider-strips slider-ghost pb-10">
                                    <div class="row">
                                        <div class="col-md-3 p-1 timeBTN">
                                            <div class="card landing-timing">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-sunrise-fill" viewBox="0 0 16 16">
                                                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1-.708.708L8.5 2.707V4.5a.5.5 0 0 1-1 0V2.707l-.646.647a.5.5 0 1 1-.708-.708l1.5-1.5zM2.343 4.343a.5.5 0 0 1 .707 0l1.414 1.414a.5.5 0 0 1-.707.707L2.343 5.05a.5.5 0 0 1 0-.707zm11.314 0a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zM11.709 11.5a4 4 0 1 0-7.418 0H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                                      </svg><br/>
                                                    <small class="beforesixam" style="font-size:8px;">Before 6 AM </small><br>
                                                    {{-- <small style="font-size:10px;">$ 65225</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 p-1 timeBTN">
                                            <div class="card landing-timing">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 0 16 16">
                                                        <path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                                                      </svg><br/>
                                                    <small class="beforesixam" style="font-size:8px;">6 Am - 12 Pm</small><br>
                                                    {{-- <small style="font-size:10px;">$ 65225</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 p-1 timeBTN">
                                            <div class="card landing-timing">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-sunset-fill" viewBox="0 0 16 16">
                                                        <path d="M7.646 4.854a.5.5 0 0 0 .708 0l1.5-1.5a.5.5 0 0 0-.708-.708l-.646.647V1.5a.5.5 0 0 0-1 0v1.793l-.646-.647a.5.5 0 1 0-.708.708l1.5 1.5zm-5.303-.51a.5.5 0 0 1 .707 0l1.414 1.413a.5.5 0 0 1-.707.707L2.343 5.05a.5.5 0 0 1 0-.707zm11.314 0a.5.5 0 0 1 0 .706l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zM11.709 11.5a4 4 0 1 0-7.418 0H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                                      </svg><br/>
                                                    <small class="beforesixam" style="font-size:8px;">12 Pm - 6 Pm</small><br>
                                                    {{-- <small style="font-size:10px;">$ 65225</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 p-1 timeBTN">
                                            <div class="card landing-timing">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-moon-fill" viewBox="0 0 16 16">
                                                        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                                                      </svg><br/>
                                                    <small class="beforesixam" style="font-size:8px;">After 6 Pm</small><br>
                                                    {{-- <small style="font-size:10px;">$ 65225</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="borderbotum"></div>

                        <div class="ranjepp">
                            <div class="owstitle pb-10" data-toggle="collapse" data-target="#Stops">STOPS
                                <span class="float-right"><i class="fa fa-arrow-down"></i></span>
                            </div>
                            <div id="Stops" class="collapse show">
                                <i class="onwfnt-11">Stops </i>
                                <div class="padding-10">
                                    {{-- <div><input type="checkbox" class="form-check-input" value=""> 2 + Stops</div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="borderbotum"></div>

                        <div class="ranjepp">
                            <div class="owstitle pb-10" data-toggle="collapse" data-target="#Airline">AIRLINES
                                <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                            </div>
                            <div id="Airline" class="collapse show">

                                {{-- <div class="padding-10">
                                    <span><input type="checkbox" class="form-check-input" value=""> Air India (21)
                                    </span>
                                    <span class="float-right"><i class="fa fa-inr"></i> 20029</span>
                                </div> --}}
                               
                            </div>
                        </div>
                          {{--  <div class="borderbotum"></div>

                      <div class="ranjepp">
                            <div class="owstitle pb-10" data-toggle="collapse" data-target="#Layover">LAYOVER
                                AIRPORTS
                                <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                            </div>
                            <div id="Layover" class="collapse show">
                               <div class="padding-10">
                                    <span><input type="checkbox" class="form-check-input" value=""> Banglore (6)
                                    </span>
                                    <span class="float-right"><i class="fa fa-inr"></i> 20029</span>
                                </div> 
                            </div>
                        </div>--}}

                    </div>
                    </div>
                </div>

                <div class="col-sm-9 pt-20" id="flightMainCard">
                    {{-- <div class="pb-10">
                        <span class="owstitle">Sort By : </span>
                        <option type="button" class="btn btn-sm btn-outline-info shortbtn" value="l2h"><i class="fa fa-money"></i>
                            CHEAPEST</option>
                        <button type="button" class="btn btn-sm btn-outline-info shortbtn" value="h2l"><i class="fa fa-clock-o"></i>
                            FASTEST</button>

                        
                    </div> --}}
                    

                    @php
                        $period = new DatePeriod(new DateTime(date('Y-m-d', strtotime('tomorrow'))), new DateInterval('P1D'), new DateTime('2022-10-05'));
                        $currentDate = new DateTime(date('Y-m-d'));
                    @endphp

                    <div id="exampleSlider" class="dpnr">
                        <div class="MS-content">
                            <div class="item">
                                <div class="actived">
                                    <a href="#">
                                       {{-- <div class="dateone"> {{ $currentDate->format('D') }},
                                            {{ $currentDate->format('M d') }} </div>
                                        <div class="prr" id="todayMinp"> ₹ 2,456 </div>--}}
                                        <div class="dateone" id="dateone">  </div>
                                        <div class="prr" id="todayMinp"> ₹ 2,456 </div>
                                    </a>
                                </div>
                            </div>
                            @foreach ($period as $data)
                                <div class="item">
                                    <a href="#">
                                        <div class="dateone"> {{ $data->format('D') }},
                                            {{ $data->format('M d') }} </div>
                                        <div class="prr"> ₹ 2,456 </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                        <div class="MS-controls">
                            <button class="MS-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                            <button class="MS-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    
                    {{-- <div class="" > --}}
                        <div id="scrollfix " class="scrollfix isotope-grid" >
                            <div class="too-many-filters" style="display: none; text-align:center; margin-top:10rem;">
                            <img src="{{url('assets/images/toomanyfilter.png')}}" alt="" srcset="">
                            <p>No Flight Found for this Time....Click to remove..<span class="close-btn2 btn btn-danger" style="cursor: pointer;">X</span></p>
                        </div>
                        
                        @php
                            use App\Http\Controllers\Airline\AirportiatacodesController;
                        @endphp
                        @if (!empty($availability))
                        @php
                            $SessionID = $availability['SessionID'];
                            $availabilityKey = $availability['Key'];
                            $airlineArr = [];
                        @endphp
                        @foreach ($availability['Availibilities'][0]['Availibility'] as $AvailKey => $itineraries)
                            @if (isset($itineraries['Itineraries']['Itinerary'][0]) && isset($itineraries['Itineraries']['Itinerary'][1]) && !isset($itineraries['Itineraries']['Itinerary'][2]))
                               
                                @php
                                    if($itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']== "SG"){
                                        continue;
                                    }
                                    array_push($airlineArr, ['code' => $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'name' => $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Name'], 'stop' => '1-Stop', 'layover' => $itineraries['Itineraries']['Itinerary'][0]['Destination']['AirportCode'],'airFare' =>$itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare']]);
                                @endphp
                                
                                <div class="cardlist take airline_hide stops_hide 1-Stop {{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']. ' ' . $itineraries['Itineraries']['Itinerary'][0]['Destination']['AirportCode']}} " data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">
                                    {{-- <div class="" > --}}
                                        <div class="boxunder grid-item takingoff">
                                            <div class="row">
                                                <div class="col-6 col-md-6 col-sm-6">
                                                <div class="row ranjepp">

                                                    <div class="col-3 col-md-3 col-sm-2">
                                                        <img src="{{ asset('assets/images/flight/' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png" width="40px" height="40px" alt="" class="imgonewayw">

                                                    </div>
                                                    <div class="col-8 col-md-8 col-sm-6">
                                                        <div class="owstitle1" >
                                                          {{ ($itineraries['Itineraries']['Itinerary'][0]['AirLine']['Name'])??($itineraries['Itineraries']['Itinerary'][0]['AirLine']['Name']) }}
                                                        </div>
                                                        <div class="owstitle">
                                                            {{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-6 col-md-6 col-sm-6">
                                                <div class="float-right ranjepp">
                                                    <form action="{{ route('galileo-pricing') }}" method="POST">
                                                        @csrf

                                                        <input type="hidden" name="trip" value="Oneway">
                                                        <input type="hidden" name="travellers"
                                                            value="{{ json_encode($travellers, true) }}">

                                                        <input type="hidden" name="SessionID" value="{{ $SessionID }}">
                                                        <input type="hidden" name="Key" value="{{ $availabilityKey }}">
                                                        <input type="hidden" name="Pricingkey"
                                                            value="{{ $itineraries['PricingInfos']['PricingInfo'][0]['Pricingkey'] }}">
                                                        <input type="hidden" name="Provider"
                                                            value="{{ $itineraries['Provider'] }}">
                                                        <input type="hidden" name="ResultIndex"
                                                            value="{{ $itineraries['ItemNo'] }}">
                                                        <span class="fontsize-22"><i class="fa fa-rupee"></i>
                                                        @if($isAgent)
                                                        <span class="TotalFare product-card" data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $charge }}">
                                                            {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $charge }}
                                                        </span>
                                                        @else
                                                        <span class="TotalFare product-card" data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}">
                                                            {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                        </span>
                                                        @endif
                                                        </span>

                                                        <a class="btn btn-primary btn-sm submit-btn">Book Now</a>

                                                        </td>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="boxunder">
                                                <div class="row">
                                                <div class="col-5 col-md-5 col-sm-5 text-center">

                                                    <div class="searchtitle cityflight" data-city1="{{ $itineraries['Itineraries']['Itinerary'][0]['Origin']['CityName'] . ' (' . $itineraries['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}">
                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Origin']['CityName'] . ' (' . $itineraries['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}
                                                        <span class=" takeoff"> {{ getTimeFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                                    </div>
                                                    <div class="searchtitle colorgrey">
                                                        {{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                    </div>
                                                </div>
                                                <div class="col-2 col-md-2 col-sm-2 text-center">
                                                    <div class="searchtitle text-center">
                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Duration'] }}
                                                        {{-- {{ substr_replace(substr_replace($flightResults->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }} --}}
                                                    </div>
                                                    <div class="borderbotum"></div>
                                                    <div class="searchtitle colorgrey  text-center">
                                                        1-Stop
                                                    </div>
                                                </div>
                                                <div class="col-5 col-md-5 col-sm-5">
                                                    <div class="text-center">
                                                        <div class="searchtitle cityflight" data-city2="{{ $itineraries['Itineraries']['Itinerary'][1]['Destination']['CityName'] . ' (' . $itineraries['Itineraries']['Itinerary'][1]['Destination']['AirportCode'] . ')' }}">
                                                            {{ $itineraries['Itineraries']['Itinerary'][1]['Destination']['CityName'] . ' (' . $itineraries['Itineraries']['Itinerary'][1]['Destination']['AirportCode'] . ')' }}
                                                            <span class=" landing">{{ getTimeFormat($itineraries['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}</span>
                                                        </div>
                                                        <div class="searchtitle colorgrey">
                                                           {{ getDateFormat($itineraries['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                                        </div>

                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="container pt-10 pb-10">
                                            {{--<span class="onewflydetbtn {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}</span>--}}
                                            <span data-toggle="collapse" data-target="#flight-details1{{ $AvailKey }}"
                                                class="onewflydetbtn float-right">Flight Details <i class="fa fa-regular fa-angle-down"></i></span>
                                            {{-- <span class="badge badge-info float-right">Flight Details</span> --}}
                                            </div>
                                            <div id="flight-details1{{ $AvailKey }}" class="collapse">
                                            <div class="container">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab"
                                                            href="#Information1{{ $AvailKey }}"> Flight
                                                            Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Details1{{ $AvailKey }}"> Fare
                                                            Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Baggage1{{ $AvailKey }}">
                                                            Baggage Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Cancellation1{{ $AvailKey }}">
                                                            Cancellation Rules </a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane container active"
                                                        id="Information1{{ $AvailKey }}">
                                                        <div class="row">
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $itineraries['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . '->' . $itineraries['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png" width="40px" height="40px" alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Origin']['CityName'] . '(' . $itineraries['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itineraries['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Destination']['CityName'] . '(' . $itineraries['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                       {{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-12 col-sm-12">
                                                                <div class="pt-10 text-center">
                                                                    <div class="owstitle">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Duration'] }}
                                                                    </div>
                                                                    <div class="flh"></div>
                                                                    <div class="owstitle">By: Air</div>
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $itineraries['Itineraries']['Itinerary'][1]['Origin']['AirportCode'] . '->' . $itineraries['Itineraries']['Itinerary'][1]['Destination']['AirportCode'] }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDateFormat($itineraries['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $itineraries['Itineraries']['Itinerary'][1]['AirLine']['Code']) }}.png"
                                                                        width="40px" height="40px"  alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itineraries['Itineraries']['Itinerary'][1]['AirLine']['Code'] . '-' . $itineraries['Itineraries']['Itinerary'][1]['AirLine']['Identification'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itineraries['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][1]['Origin']['CityName'] . '(' . $itineraries['Itineraries']['Itinerary'][1]['Origin']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDateFormat($itineraries['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                       {{ getTimeFormat($itineraries['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][1]['Destination']['CityName'] . '(' . $itineraries['Itineraries']['Itinerary'][1]['Destination']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                       {{ getDateFormat($itineraries['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane container fade" id="Details1{{ $AvailKey }}">

                                                        <div class="onwfntrespons-11">
                                                            <span class="text-left"> Fare Rules :</span>
                                                            <span class="text-right {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">
                                                                {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                                            </span>

                                                        </div>
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11"> 
                                                                <tr>
                                                                    <td class="onwfnt-11">1 Adult</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Base Fare)</td>
                                                                    <td class="text-right"> <i class="fa fa-inr"></i>
                                                                        {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total Tax +</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalTax'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>

                                                    <div class="tab-pane container fade" id="Baggage1{{ $AvailKey }}">
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
                                                                    <td> <img class="images_flig"
                                                                            src="{{ asset('assets/images/flight/' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                            width="40px" height="40px"  alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                                    </td>

                                                                    <td class="onwfnt-11">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <img class="images_flig"
                                                                            src="{{ asset('assets/images/flight/' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                            width="40px" height="40px"  alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                                    </td>

                                                                    <td class="onwfnt-11">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
                                                                infant added in the booking</li>
                                                            <li>In certain situations of restricted cases, no amendments and
                                                                cancellation is allowed</li>
                                                            <li>Airlines cancel reschedule should be reconfirmed before
                                                                requesting for a cancellation or amendment</li>
                                                        </ul>
                                                    </div>

                                                    <div class="tab-pane container fade"
                                                        id="Cancellation1{{ $AvailKey }}">
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11">
                                                                <tr>
                                                                    <td> <b>Time Frame to Reissue</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> <b>Time Frame to cancel</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
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
                                    {{-- </div> --}}
                                </div>
                            

                            @elseif (isset($itineraries['Itineraries']['Itinerary'][0]) &&
                                !isset($itineraries['Itineraries']['Itinerary'][1]))
                                 @php
                                 
                                if($itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']== "SG"){
                                        continue;
                                }
                                    array_push($airlineArr, ['code' => $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'name' => $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Name'], 'stop' => 'Non-Stop', 'layover' => 'Non-Stop','airFare' =>$itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare']]);
                                @endphp
                                <div class="cardlist take airline_hide stops_hide Non-Stop {{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'] }}" data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">
                                    {{-- <div class="grid-item" > --}}
                                    <div class="boxunder grid-item takingoff">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-sm-6">
                                                <div class="row ranjepp">
                                                    <div class="col-3 col-md-3 col-sm-2">
                                                        <img src="{{ asset('assets/images/flight/' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                        width="40px" height="40px"  alt="" class="imgonewayw">
                                                    </div>
                                                    <div class="col-8 col-md-8 col-sm-6">
                                                        <div class="owstitle1" >
                                                            {{ ($itineraries['Itineraries']['Itinerary'][0]['AirLine']['Name'])??($itineraries['Itineraries']['Itinerary'][0]['AirLine']['Name']) }}
                                                        </div>
                                                        <div class="owstitle">
                                                            {{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-sm-6">
                                                <div class="float-right ranjepp">
                                                    <form action="{{ route('galileo-pricing') }}" method="POST">
                                                        @csrf

                                                        <input type="hidden" name="travellers"
                                                            value="{{ json_encode($travellers, true) }}">
                                                        <input type="hidden" name="trip" value="Oneway">
                                                        <input type="hidden" name="SessionID" value="{{ $SessionID }}">
                                                        <input type="hidden" name="Key" value="{{ $availabilityKey }}">
                                                        <input type="hidden" name="Pricingkey"
                                                            value="{{ $itineraries['PricingInfos']['PricingInfo'][0]['Pricingkey'] }}">
                                                        <input type="hidden" name="Provider"
                                                            value="{{ $itineraries['Provider'] }}">
                                                        <input type="hidden" name="ResultIndex"
                                                            value="{{ $itineraries['ItemNo'] }}">
                                                        <span class="fontsize-22"><i class="fa fa-rupee"></i>
                                                        @if($isAgent)
                                                        <span class="TotalFare product-card" data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $charge }}">
                                                            {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $charge }}
                                                        </span>
                                                        @else
                                                        <span class="TotalFare product-card" data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}">
                                                            {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                        </span>
                                                        @endif
                                                        </span>

                                                        <a class="btn btn-primary btn-sm submit-btn">Book Now</a>

                                                        </td>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxunder">
                                            <div class="row">

                                                <div class="col-4 col-md-4 col-sm-4 marginleft-20">

                                                    <div class="searchtitle">
                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Origin']['CityName'] . ' (' . $itineraries['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}
                                                        <span class=" takeoff">{{ getTimeFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                                    </div>
                                                    <div class="searchtitle colorgrey">
                                                        {{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                    </div>
                                                </div>
                                                <div class="col-2 col-md-2 col-sm-2 text-center">
                                                    <div class="searchtitle text-center">
                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Duration'] }}
                                                    </div>
                                                    <div class="borderbotum"></div>
                                                    <div class="searchtitle colorgrey text-center">
                                                        Non-Stop
                                                    </div>
                                                </div>
                                                <div class="col-5 col-md-5 col-sm-5">
                                                    <div class="text-center">
                                                        <div class="searchtitle">
                                                            {{ $itineraries['Itineraries']['Itinerary'][0]['Destination']['CityName'] . ' (' . $itineraries['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] . ')' }}
                                                            <span class=" landing">{{ getTimeFormat($itineraries['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}</span>
                                                        </div>
                                                        <div class="searchtitle colorgrey">
                                                            {{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container pt-10 pb-10">
                                            {{--<span class="onewflydetbtn {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}</span>--}}
                                            <span data-toggle="collapse" data-target="#flight-details1{{ $AvailKey }}"
                                                class="onewflydetbtn float-right">Flight Details <i class="fa fa-regular fa-angle-down"></i></span>
                                            {{-- <span class="badge badge-info float-right">Flight Details</span> --}}
                                        </div>
                                        <div id="flight-details1{{ $AvailKey }}" class="collapse">
                                            <div class="container">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab"
                                                            href="#Information1{{ $AvailKey }}"> Flight
                                                            Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Details1{{ $AvailKey }}"> Fare
                                                            Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Baggage1{{ $AvailKey }}">
                                                            Baggage Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Cancellation1{{ $AvailKey }}">
                                                            Cancellation Rules </a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane container active"
                                                        id="Information1{{ $AvailKey }}">
                                                        <div class="row">
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $itineraries['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . '->' . $itineraries['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                        width="40px" height="40px"  alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Origin']['CityName'] . '(' . $itineraries['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itineraries['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Destination']['CityName'] . '(' . $itineraries['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDateFormat($itineraries['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-sm-12">
                                                                <div class="pt-10 text-center">
                                                                    <div class="owstitle">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Duration'] }}
                                                                    </div>
                                                                    <div class="flh"></div>
                                                                    <div class="owstitle">By: Air</div>
                                                                </div>
                                                            </div> --}}

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane container fade"
                                                        id="Details1{{ $AvailKey }}">

                                                        <div class="onwfntrespons-11">
                                                            <span class="text-left"> Fare Rules :</span>
                                                            <span class="text-right {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">
                                                                {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                                            </span>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11">
                                                                <tr>
                                                                    <td class="onwfnt-11">1 Adult</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Base Fare)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total Tax +</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalTax'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="tab-pane container fade"
                                                        id="Baggage1{{ $AvailKey }}">
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
                                                                    <td> <img
                                                                            src="{{ asset('assets/images/flight/' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                            width="40px" height="40px"  alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itineraries['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                                    </td>

                                                                    <td class="onwfnt-11">
                                                                        {{ $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itineraries['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
                                                                    </td>

                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11 onwnt123">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
                                                                infant added in the booking</li>
                                                            <li>In certain situations of restricted cases, no amendments and
                                                                cancellation is allowed</li>
                                                            <li>Airlines cancel reschedule should be reconfirmed before
                                                                requesting for a cancellation or amendment</li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane container fade"
                                                        id="Cancellation1{{ $AvailKey }}">
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11">
                                                                <tr>
                                                                    <td> <b>Time Frame to Reissue</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> <b>Time Frame to cancel</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
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
                                {{-- </div> --}}
                            </div>
                        @endif
                            
                        @endforeach
                        @endif

                        @if (!empty($oneways))
                        @php
                        is_array($oneways->recommendation) == true ? ($onewaysRecommendation = $oneways->recommendation) : ($onewaysRecommendation = [$oneways->recommendation]);
                        is_array($oneways->flightIndex->groupOfFlights) == true ? ($onewaysGroupOfFlights = $oneways->flightIndex->groupOfFlights) : ($onewaysGroupOfFlights = [$oneways->flightIndex->groupOfFlights]);
                        @endphp
                        @foreach ($onewaysGroupOfFlights as $rowkey => $flightResults)
                                {{-- {{dd($flightResults)}} --}}
                            @if (is_array($flightResults->flightDetails) == true && isset($flightResults->flightDetails[2]) && !isset($flightResults->flightDetails[3]))
                                @php
                                if($flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier == "SG"){
                                    continue;
                                }
                                @endphp
                                <div class="cardlist take airline_hide stops_hide 2-Stop {{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier. ' ' .$flightResults->flightDetails[1]->flightInformation->location[0]->locationId}}" data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">
                                    {{-- <div class="grid-item" > --}}
                                    <div class="boxunder grid-item takingoff">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-sm-6">
                                                <div class="row ranjepp">
                                                    <div class="col-3 col-md-3 col-sm-2">
                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                        width="40px" height="40px"  alt="" class="imgonewayw">
                                                    </div>
                                                    <div class="col-8 col-md-8 col-sm-6">
                                                         <div class="owstitle1" >
                                                            {{ ($flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier)?? ($flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier)}}
                                                        </div>
                                                        <div class="owstitle">
                                                            {{ ($flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier??'').'-'.$flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber }}
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-6 col-sm-6">
                                                <div class="float-right ranjepp">
                                                    <form action="{{ route('flight-review') }}" method="POST">
                                                        @csrf

                                                        @foreach ($onewaysRecommendation as $recommendation)
                                                            @php
                                                            (is_array($recommendation->segmentFlightRef) == true) ? $newSegmentFlightRef =
                                                            $recommendation->segmentFlightRef : $newSegmentFlightRef =
                                                            [$recommendation->segmentFlightRef];
                                                            @endphp

                                                            @foreach ($newSegmentFlightRef as $segmentFlightRef)
                                                                @if ($segmentFlightRef->referencingDetail[0]->refNumber == $flightResults->propFlightGrDetail->flightProposal[0]->ref)

                                                                    @php
                                                                        
                                                                        $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                                        $baggRef = $baggRefArray[0]->refNumber;
                                                                        
                                                                        is_array($recommendation->paxFareProduct) == true ? ($paxFareDetails = $recommendation->paxFareProduct[0]) : ($paxFareDetails = $recommendation->paxFareProduct);
                                                                        is_array($paxFareDetails->fare) ? ($fareDetailsRule = $paxFareDetails->fare) : ($fareDetailsRule = [$paxFareDetails->fare]);
                                                                        
                                                                        is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                                        
                                                                        $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                                        
                                                                    @endphp

                                                                    <input type="hidden" name="bookingClass_1"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[0]->productInformation->cabinProduct->rbd ?? $paxFareDetails->fareDetails->groupOfFares[0]->productInformation->cabinProduct[0]->rbd }}">

                                                                    <input type="hidden" name="bookingClass_2"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[1]->productInformation->cabinProduct->rbd ?? $paxFareDetails->fareDetails->groupOfFares[1]->productInformation->cabinProduct[0]->rbd }} ">

                                                                    <input type="hidden" name="bookingClass_3"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[2]->productInformation->cabinProduct->rbd ?? $paxFareDetails->fareDetails->groupOfFares[2]->productInformation->cabinProduct[0]->rbd }} ">


                                                                    <input type="hidden" name="fareBasis_1"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[0]->productInformation->fareProductDetail->fareBasis }}">

                                                                    <input type="hidden" name="fareBasis_2"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[1]->productInformation->fareProductDetail->fareBasis }}">

                                                                    <input type="hidden" name="fareBasis_3"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[2]->productInformation->fareProductDetail->fareBasis }}">

                                                                @endif
                                                            @endforeach

                                                        @endforeach

                                                        <input type="hidden" name="onewayTwostop">

                                                        <input type="hidden" name="arrivalingTime"
                                                            value="{{ $flightResults->propFlightGrDetail->flightProposal[1]->ref }}">

                                                        <input type="hidden" name="arrivalDate_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfArrival }}">

                                                        <input type="hidden" name="arrivalDate_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfArrival }}">

                                                        <input type="hidden" name="arrivalDate_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->productDateTime->dateOfArrival }}">

                                                        <input type="hidden" name="arrivalTime_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">

                                                        <input type="hidden" name="arrivalTime_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">

                                                        <input type="hidden" name="arrivalTime_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->productDateTime->timeOfArrival }}">

                                                        <input type="hidden" name="departure_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->location[0]->locationId }}">

                                                        <input type="hidden" name="departure_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->location[0]->locationId }}">

                                                        <input type="hidden" name="departure_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->location[0]->locationId }}">

                                                        <input type="hidden" name="arrival_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->location[1]->locationId }}">

                                                        <input type="hidden" name="arrival_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->location[1]->locationId }}">

                                                        <input type="hidden" name="arrival_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->location[1]->locationId }}">

                                                        <input type="hidden" name="departureDate_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">

                                                        <input type="hidden" name="departureDate_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">

                                                        <input type="hidden" name="departureDate_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture }}">

                                                        <input type="hidden" name="departureTime_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">

                                                        <input type="hidden" name="departureTime_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">

                                                        <input type="hidden" name="departureTime_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture }}">

                                                        <input type="hidden" name="flightNumber_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber }}">

                                                        <input type="hidden" name="flightNumber_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->flightOrtrainNumber }}">

                                                        <input type="hidden" name="flightNumber_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->flightOrtrainNumber }}">

                                                        <input type="hidden" name="marketingCompany_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">

                                                        <input type="hidden" name="marketingCompany_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">

                                                        <input type="hidden" name="marketingCompany_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->companyId->marketingCarrier }}">

                                                        <input type="hidden" name="operatingCompany_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">

                                                        <input type="hidden" name="operatingCompany_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">

                                                        <input type="hidden" name="operatingCompany_3"
                                                            value="{{ $flightResults->flightDetails[2]->flightInformation->companyId->operatingCarrier }}">


                                                        <input type="hidden" name="noOfAdults"
                                                            value="{{ $travellers['noOfAdults'] }}">

                                                        <input type="hidden" name="noOfChilds"
                                                            value="{{ $travellers['noOfChilds'] }}">

                                                        <input type="hidden" name="noOfInfants"
                                                            value="{{ $travellers['noOfInfants'] }}">

                                                        <span class="fontsize-22"><i class="fa fa-rupee"></i>
                                                        @if($isAgent)
                                                        <span class="TotalFare product-card" data-price1="{{ $paxFareDetails->paxFareDetail->totalFareAmount + $charge }}">
                                                            {{ $paxFareDetails->paxFareDetail->totalFareAmount + $charge  }}
                                                        </span>
                                                        @else
                                                        <span class="TotalFare product-card" data-price1="{{ $paxFareDetails->paxFareDetail->totalFareAmount }}">
                                                            {{ $paxFareDetails->paxFareDetail->totalFareAmount - $paxFareDetails->paxFareDetail->totalTaxAmount }}
                                                        </span>
                                                        @endif
                                                            
                                                            </span>
                                                            
                                                            <a class="btn btn-primary btn-sm submit-btn">Book Now</a>

                                                        @php
                                                            $totalFareAmount = $paxFareDetails->paxFareDetail->totalFareAmount;
                                                            $totalTaxAmount = $paxFareDetails->paxFareDetail->totalTaxAmount;
                                                        array_push($airlineArr, [
                                                        'code' => $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier, 
                                                        'name' => $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier,
                                                        'stop' => '2-Stop', 
                                                        'layover' => $flightResults->flightDetails[1]->flightInformation->location[0]->locationId,
                                                        'airFare' =>$totalFareAmount]);
                               
                                                        @endphp
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxunder margin-20">
                                            <div class="row">
                                                <div class="col-4 col-md-4 col-sm-4 marginleft-20">
                                                    <div class="searchtitle">
                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[0]->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                        <span class=" takeoff">{{ substr_replace($flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                    </div>
                                                    <div class="searchtitle colorgrey">
                                                        {{ getDate_fn($flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                    </div>
                                                </div>
                                                <div class="col-3 col-md-3 col-sm-3">
                                                    <div class="searchtitle text-center">
                                                        {{ substr_replace(substr_replace($flightResults->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                        | 2-Stop </div>
                                                    <div class="borderbotum"></div>
                                                    <div class="searchtitle colorgrey text-center">
                                                        {{ $flightResults->flightDetails[0]->flightInformation->location[1]->locationId . '-' . $flightResults->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-4 col-sm-4">
                                                    <div class="float-right">
                                                        <div class="searchtitle">
                                                            <span class=" landing">{{ substr_replace($flightResults->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                            {{ AirportiatacodesController::getCity($flightResults->flightDetails[2]->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}
                                                        </div>
                                                        <div class="searchtitle colorgrey">
                                                            {{ getDate_fn($flightResults->flightDetails[2]->flightInformation->productDateTime->dateOfArrival) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-bottom: 1px solid #ccc; padding-top:7px;"></div>
                                        <div class="container pt-10 pb-10">
                                            {{--<span class="onewflydetbtn {{ $farerule }}">{{ $farerule }}</span>--}}
                                            <span data-toggle="collapse" data-target="#details{{ $rowkey }}"
                                                class="onewflydetbtn float-right">Flight Details <i class="fa fa-regular fa-angle-down"></i></span>
                                            <!-- <span class="badge badge-info float-right">Flight Details</span> -->
                                        </div>
                                        <div id="details{{ $rowkey }}" class="collapse">
                                            <div class="container">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab"
                                                            href="#Information{{ $rowkey }}"> Flight
                                                            Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Details{{ $rowkey }}"> Fare
                                                            Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Baggage{{ $rowkey }}">
                                                            Baggage Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Cancellation{{ $rowkey }}">
                                                            Cancellation Rules </a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane container active"
                                                        id="Information{{ $rowkey }}">
                                                        <div class="row">
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $flightResults->flightDetails[0]->flightInformation->location[0]->locationId . '->' . $flightResults->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDate_fn($flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        width="40px" height="40px"  alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[0]->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[0]->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 col-sm-12">
                                                                <div class="pt-10 text-center">
                                                                    <div class="owstitle">
                                                                        {{ substr_replace(substr_replace($flightResults->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </div>
                                                                    <div class="flh"></div>
                                                                    {{-- <div class="owstitle">By: Air</div> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span class="searchtitle">{{ $flightResults->flightDetails[1]->flightInformation->location[0]->locationId }}
                                                                        ->
                                                                        {{ $flightResults->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDate_fn($flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        width="40px" height="40px"   alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[1]->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[1]->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 col-sm-12">
                                                                <div class="pt-10 text-center">
                                                                    <div class="owstitle">
                                                                        {{ substr_replace(substr_replace($flightResults->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </div>
                                                                    <div class="flh"></div>
                                                                    {{-- <div class="owstitle">By: Air</div> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $flightResults->flightDetails[2]->flightInformation->location[0]->locationId }}
                                                                        ->
                                                                        {{ $flightResults->flightDetails[2]->flightInformation->location[1]->locationId }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDate_fn($flightResults->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[2]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        width="40px" height="40px"  alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[2]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[2]->flightInformation->flightOrtrainNumber }}</span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[2]->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails[2]->flightInformation->location[0]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[2]->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[2]->flightInformation->productDateTime->dateOfArrival) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane container fade" id="Details{{ $rowkey }}">

                                                        <div class="onwfntrespons-11">
                                                            <span class="text-left"> Fare Rules :</span>
                                                            <span class="text-right {{ $farerule }}"> {{ $farerule }} </span>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11">
                                                                <tr>
                                                                    <td class="onwfnt-11">1 x Adult</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Base Fare)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total Tax +</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="tab-pane container fade" id="Baggage{{ $rowkey }}">
                                                        <table class="table table-bordered">
                                                            <thead class="onwfntrespons-11">
                                                                <tr>
                                                                    <th>Airline</th>
                                                                    <th>Check-in Baggage</th>
                                                                    <th>Cabin Baggage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                (is_array($oneways->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $oneways->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                [$oneways->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                        (is_array($oneways->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $onewaysServiceBagAllowanceGrp =
                                                                        $oneways->serviceFeesGrp->freeBagAllowanceGrp :
                                                                        $onewaysServiceBagAllowanceGrp =
                                                                        [$oneways->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($onewaysServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber??'' == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
                                                                                @if ($freeBagAllowance->freeBagAllownceInfo->baggageDetails->quantityCode == 'N')
                                                                                    @php $FreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'PC baggage'; @endphp
                                                                                @else
                                                                                    @php $FreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'KG baggage'; @endphp
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                                <tr>
                                                                    <td> <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                            width="40px" height="40px"  alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">{{ $FreeBag }}</td>

                                                                    <td class="onwfnt-11">7KG</td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <img
                                                                            src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                            width="40px" height="40px"  alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">{{ $FreeBag }}</td>

                                                                    <td class="onwfnt-11">7KG</td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <img
                                                                            src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[2]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                            width="40px" height="40px"  alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[2]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[2]->flightInformation->flightOrtrainNumber }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">{{ $FreeBag }}</td>

                                                                    <td class="onwfnt-11">7KG</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
                                                                infant added in the booking</li>
                                                            <li>In certain situations of restricted cases, no amendments and
                                                                cancellation is allowed</li>
                                                            <li>Airlines cancel reschedule should be reconfirmed before
                                                                requesting for a cancellation or amendment</li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane container fade"
                                                        id="Cancellation{{ $rowkey }}">
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11">
                                                                <tr>
                                                                    <td> <b>Time Frame to Reissue</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> <b>Time Frame to cancel</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
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
                                    {{-- </div> --}}
                                </div>
                            @elseif (is_array($flightResults->flightDetails) == true &&
                                isset($flightResults->flightDetails[1]) && !isset($flightResults->flightDetails[2]))
                                @php
                                if($flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier== "SG"){
                                        continue;
                                }
                                 @endphp
                                <div class="cardlist take airline_hide stops_hide 1-Stop {{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier. ' ' . $flightResults->flightDetails[1]->flightInformation->location[0]->locationId}}" data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">
                                    {{-- <div class="grid-item" > --}}
                                    <div class="boxunder grid-item takingoff">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-sm-6">
                                                <div class="row ranjepp">
                                                    <div class="col-3 col-md-3 col-sm-2">
                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                        width="40px" height="40px"  alt="" class="imgonewayw">
                                                    </div>
                                                    <div class="col-8 col-md-8 col-sm-6">
                                                        <div class="owstitle1" >
                                                            {{ ($flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier)??($flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}
                                                        </div>
                                                        <div class="owstitle">
                                                            {{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier.'-'.$flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber  }}
                                                            {{-- $flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-sm-6">
                                                <div class="float-right ranjepp">
                                                    <form action="{{ route('flight-review') }}" method="POST">
                                                        
                                                        @csrf

                                                        @foreach ($onewaysRecommendation as $recommendation)
                                                            @php
                                                            (is_array($recommendation->segmentFlightRef) == true) ? $newSegmentFlightRef =
                                                            $recommendation->segmentFlightRef : $newSegmentFlightRef =
                                                            [$recommendation->segmentFlightRef];
                                                            @endphp
                                                            @foreach ($newSegmentFlightRef as $segmentFlightRef)
                                                                @if ( ($segmentFlightRef->referencingDetail[0]->refNumber) == $flightResults->propFlightGrDetail->flightProposal[0]->ref )

                                                                    @php
                                                                        $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                                        $baggRef = $baggRefArray[0]->refNumber;
                                                                        
                                                                        is_array($recommendation->paxFareProduct) == true ? ($paxFareDetails = $recommendation->paxFareProduct[0]) : ($paxFareDetails = $recommendation->paxFareProduct);
                                                                        is_array($paxFareDetails->fare) ? ($fareDetailsRule = $paxFareDetails->fare) : ($fareDetailsRule = [$paxFareDetails->fare]);
                                                                        
                                                                        is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                                        
                                                                        $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                                    @endphp

                                                                    <input type="hidden" name="bookingClass_1"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[0]->productInformation->cabinProduct->rbd ?? $paxFareDetails->fareDetails->groupOfFares[0]->productInformation->cabinProduct[0]->rbd }}">

                                                                    <input type="hidden" name="bookingClass_2"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[1]->productInformation->cabinProduct->rbd ?? $paxFareDetails->fareDetails->groupOfFares[1]->productInformation->cabinProduct[0]->rbd }} ">

                                                                    <input type="hidden" name="fareBasis_1"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[0]->productInformation->fareProductDetail->fareBasis }}">

                                                                    <input type="hidden" name="fareBasis_2"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares[1]->productInformation->fareProductDetail->fareBasis }}">

                                                                @endif
                                                            @endforeach
                                                        @endforeach

                                                        <input type="hidden" name="onewayOnestop">

                                                        <input type="hidden" name="arrivalingTime"
                                                            value="{{ $flightResults->propFlightGrDetail->flightProposal[1]->ref }}">

                                                        <input type="hidden" name="arrivalDate_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfArrival }}">

                                                        <input type="hidden" name="arrivalDate_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfArrival }}">

                                                        <input type="hidden" name="arrivalTime_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">

                                                        <input type="hidden" name="arrivalTime_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">
                                                        <input type="hidden" name="departure_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->location[0]->locationId }}">

                                                        <input type="hidden" name="arrival_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->location[1]->locationId }}">

                                                        <input type="hidden" name="departureDate_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">

                                                        <input type="hidden" name="departureTime_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">

                                                        <input type="hidden" name="marketingCompany_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">

                                                        <input type="hidden" name="operatingCompany_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">

                                                        <input type="hidden" name="flightNumber_1"
                                                            value="{{ $flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber }}">

                                                        <input type="hidden" name="departure_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->location[0]->locationId }}">

                                                        <input type="hidden" name="arrival_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->location[1]->locationId }}">

                                                        <input type="hidden" name="departureDate_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">

                                                        <input type="hidden" name="departureTime_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">

                                                        <input type="hidden" name="noOfAdults"
                                                            value="{{ $travellers['noOfAdults'] }}">

                                                        <input type="hidden" name="noOfChilds"
                                                            value="{{ $travellers['noOfChilds'] }}">

                                                        <input type="hidden" name="noOfInfants"
                                                            value="{{ $travellers['noOfInfants'] }}">

                                                        <input type="hidden" name="marketingCompany_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">

                                                        <input type="hidden" name="operatingCompany_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">

                                                        <input type="hidden" name="flightNumber_2"
                                                            value="{{ $flightResults->flightDetails[1]->flightInformation->flightOrtrainNumber }}">

                                                        <span class="fontsize-22"><i class="fa fa-rupee"></i>
                                                            @php
                                                                $totalFareAmount = $paxFareDetails->paxFareDetail->totalFareAmount;
                                                                $totalTaxAmount = $paxFareDetails->paxFareDetail->totalTaxAmount;
                                                                array_push($airlineArr, ['code' => $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'name' => $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'stop' => '1-Stop', 'layover' => $flightResults->flightDetails[1]->flightInformation->location[0]->locationId,'airFare' =>$totalFareAmount]);
                               
                                                            @endphp
                                                            @if($isAgent)
                                                            <span class="TotalFare product-card" data-price1="{{ $paxFareDetails->paxFareDetail->totalFareAmount + $charge }}">
                                                                {{ $paxFareDetails->paxFareDetail->totalFareAmount + $charge}}
                                                            </span>
                                                            @else
                                                            <span class="TotalFare product-card" data-price1="{{ $paxFareDetails->paxFareDetail->totalFareAmount - $totalTaxAmount }}">
                                                                {{ $paxFareDetails->paxFareDetail->totalFareAmount - $totalTaxAmount }}
                                                            </span>
                                                            @endif
                                                            </span>

                                                            <a class="btn btn-primary btn-sm submit-btn">Book Now</a>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxunder margin-20">
                                            <div class="row">
                                                <div class="col-4 col-md-4 col-sm-4 marginleft-20">
                                                    <div class="searchtitle">
                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[0]->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                        <span class=" takeoff">{{ substr_replace($flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                    </div>
                                                    <div class="searchtitle colorgrey">
                                                        {{ getDate_fn($flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                    </div>
                                                </div>
                                                <div class="col-3 col-md-3 col-sm-3">
                                                    <div class="searchtitle text-center">
                                                        {{ substr_replace(substr_replace($flightResults->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                        | 1 - Stop </div>
                                                    <div class="borderbotum"></div>
                                                    <div class="searchtitle colorgrey text-center">
                                                        {{ $flightResults->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-4 col-sm-4">
                                                    <div class="float-right">
                                                        <div class="searchtitle">
                                                            <span class=" landing">{{ substr_replace($flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                            {{ AirportiatacodesController::getCity($flightResults->flightDetails[1]->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                        </div>
                                                        <div class="searchtitle colorgrey">
                                                            {{ getDate_fn($flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-bottom: 1px solid #ccc; padding-top:7px;"></div>
                                        <div class="container pt-10 pb-10">
                                            {{--<span class="onewflydetbtn {{ $farerule }}">{{ $farerule }}</span>--}}
                                            <span data-toggle="collapse" data-target="#details{{ $rowkey }}"
                                                class="onewflydetbtn float-right">Flight Details <i class="fa fa-regular fa-angle-down"></i></span>

                                            <!-- <span class="badge badge-info float-right">Flight Details</span> -->
                                        </div>
                                        <div id="details{{ $rowkey }}" class="collapse">
                                            <div class="container">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab"
                                                            href="#Information{{ $rowkey }}"> Flight
                                                            Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Details{{ $rowkey }}"> Fare
                                                            Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Baggage{{ $rowkey }}">
                                                            Baggage Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Cancellation{{ $rowkey }}">
                                                            Cancellation Rules </a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane container active"
                                                        id="Information{{ $rowkey }}">
                                                        <div class="row">
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $flightResults->flightDetails[0]->flightInformation->location[0]->locationId }}
                                                                        ->
                                                                        {{ $flightResults->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDate_fn($flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        width="40px" height="40px"  alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[0]->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">

                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[0]->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 col-sm-12">
                                                                <div class="pt-10 text-center">
                                                                    <div class="owstitle">
                                                                        {{ substr_replace(substr_replace($flightResults->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                    </div>
                                                                    <div class="flh"></div>
                                                                    {{-- <div class="owstitle">By: Air</div> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $flightResults->flightDetails[1]->flightInformation->location[0]->locationId }}
                                                                        ->
                                                                        {{ $flightResults->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDate_fn($flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        width="40px" height="40px"   alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[1]->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">

                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails[1]->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane container fade" id="Details{{ $rowkey }}">

                                                        <div class="onwfntrespons-11">
                                                            <span class="text-left"> Fare Rules :</span>
                                                            <span class="text-right {{ $farerule }}"> {{ $farerule }} </span>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="onwfnt-11">1 x Adult</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Base Fare)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total Tax +</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>


                                                    </div>
                                                    <div class="tab-pane container fade" id="Baggage{{ $rowkey }}">
                                                        <table class="table table-bordered">
                                                            <thead class="onwfntrespons-11">
                                                                <tr>
                                                                    <th>Airline</th>
                                                                    <th>Check-in Baggage</th>
                                                                    <th>Cabin Baggage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                (is_array($oneways->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $oneways->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                [$oneways->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                        (is_array($oneways->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $onewaysServiceBagAllowanceGrp =
                                                                        $oneways->serviceFeesGrp->freeBagAllowanceGrp :
                                                                        $onewaysServiceBagAllowanceGrp =
                                                                        [$oneways->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($onewaysServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber??'' == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
                                                                                @if ($freeBagAllowance->freeBagAllownceInfo->baggageDetails->quantityCode == 'N')

                                                                                    @php $FreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'PC baggage'; @endphp
                                                                                @else
                                                                                    @php $FreeBag = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'KG baggage'; @endphp
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                                <tr>
                                                                    <td> <img
                                                                            src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                            width="40px" height="40px"  alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                    </td>

                                                                    <td class="onwfnt-11">{{ $FreeBag }}</td>

                                                                    <td class="onwfnt-11">7KG</td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <img
                                                                            src="{{ asset('assets/images/flight/' . $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                            width="40px" height="40px"   alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">{{ $FreeBag }}</td>
                                                                    <td class="onwfnt-11">7KG</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
                                                                infant added in the booking</li>
                                                            <li>In certain situations of restricted cases, no amendments and
                                                                cancellation is allowed</li>
                                                            <li>Airlines cancel reschedule should be reconfirmed before
                                                                requesting for a cancellation or amendment</li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane container fade"
                                                        id="Cancellation{{ $rowkey }}">
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11">
                                                                <tr>
                                                                    <td> <b>Time Frame to Reissue</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> <b>Time Frame to cancel</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
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
                                {{-- </div> --}}
                            </div>
                            @else
                                @php
                                if($flightResults->flightDetails->flightInformation->companyId->operatingCarrier== "SG"){
                                        continue;
                                }
                                @endphp
                                <div class="cardlist take airline_hide stops_hide Non-Stop {{ $flightResults->flightDetails->flightInformation->companyId->operatingCarrier }}" data-price1="{{ $itineraries['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">
                                    {{-- <div class="grid-item" > --}}
                                    <div class="boxunder grid-item takingoff">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-sm-6">
                                                <div class="row ranjepp">
                                                    <div class="col-3 col-md-3 col-sm-2">
                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                        width="40px" height="40px"   alt="" class="imgonewayw">

                                                    </div>
                                                    <div class="col-8 col-md-8 col-sm-6">
                                                        <div class="owstitle1">
                                                            {{ ($flightResults->flightDetails->flightInformation->companyId->operatingCarrier)??($flightResults->flightDetails->flightInformation->companyId->operatingCarrier) }}
                                                        </div>
                                                        <div class="owstitle">
                                                            {{ $flightResults->flightDetails->flightInformation->companyId->operatingCarrier.'-'.$flightResults->flightDetails->flightInformation->flightOrtrainNumber  }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-sm-6">
                                                <div class="float-right ranjepp">
                                                    <form action="{{ route('flight-review') }}" method="POST">
                                                        @csrf

                                                        @foreach ($onewaysRecommendation as $recommendation)
                                                            @php
                                                            (is_array($recommendation->segmentFlightRef) == true) ? $newSegmentFlightRef =
                                                            $recommendation->segmentFlightRef : $newSegmentFlightRef =
                                                            [$recommendation->segmentFlightRef];
                                                            @endphp
                                                            @foreach ($newSegmentFlightRef as $segmentFlightRef)
                                                                @if ($segmentFlightRef->referencingDetail[0]->refNumber == $flightResults->propFlightGrDetail->flightProposal[0]->ref)
                                                                    @php
                                                                        $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                                        $baggRef = $baggRefArray[0]->refNumber;
                                                                        
                                                                        is_array($recommendation->paxFareProduct) == true ? ($paxFareDetails = $recommendation->paxFareProduct[0]) : ($paxFareDetails = $recommendation->paxFareProduct);
                                                                        is_array($paxFareDetails->fare) ? ($fareDetailsRule = $paxFareDetails->fare) : ($fareDetailsRule = [$paxFareDetails->fare]);
                                                                        
                                                                        is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                                        
                                                                        $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                                    @endphp

                                                                    <input type="hidden" name="bookingClass"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares->productInformation->cabinProduct->rbd ?? $paxFareDetails->fareDetails->groupOfFares->productInformation->cabinProduct[0]->rbd }}">

                                                                    <input type="hidden" name="fareBasis"
                                                                        value="{{ $paxFareDetails->fareDetails->groupOfFares->productInformation->fareProductDetail->fareBasis }}">
                                                                @endif
                                                            @endforeach

                                                        @endforeach

                                                        <input type="hidden" name="onewayNonstop">

                                                        <input type="hidden" name="arrivalingTime"
                                                            value="{{ $flightResults->propFlightGrDetail->flightProposal[1]->ref }}">
                                                        <input type="hidden" name="departure"
                                                            value="{{ $flightResults->flightDetails->flightInformation->location[0]->locationId }}">
                                                        <input type="hidden" name="arrival"
                                                            value="{{ $flightResults->flightDetails->flightInformation->location[1]->locationId }}">
                                                        <input type="hidden" name="departureDate"
                                                            value="{{ $flightResults->flightDetails->flightInformation->productDateTime->dateOfDeparture }}">
                                                        <input type="hidden" name="arrivalDate"
                                                            value="{{ $flightResults->flightDetails->flightInformation->productDateTime->dateOfArrival }}">
                                                        <input type="hidden" name="marketingCompany"
                                                            value="{{ $flightResults->flightDetails->flightInformation->companyId->marketingCarrier }}">
                                                        <input type="hidden" name="operatingCompany"
                                                            value="{{ $flightResults->flightDetails->flightInformation->companyId->operatingCarrier }}">

                                                        <input type="hidden" name="noOfAdults"
                                                            value="{{ $travellers['noOfAdults'] }}">

                                                        <input type="hidden" name="noOfChilds"
                                                            value="{{ $travellers['noOfChilds'] }}">

                                                        <input type="hidden" name="noOfInfants"
                                                            value="{{ $travellers['noOfInfants'] }}">

                                                        <input type="hidden" name="flightNumber"
                                                            value="{{ $flightResults->flightDetails->flightInformation->flightOrtrainNumber }}">

                                                        <input type="hidden" name="departureTime"
                                                            value="{{ $flightResults->flightDetails->flightInformation->productDateTime->timeOfDeparture }}">
                                                        <input type="hidden" name="arrivalTime"
                                                            value="{{ $flightResults->flightDetails->flightInformation->productDateTime->timeOfArrival }}">

                                                        <span class="fontsize-22"><i class="fa fa-rupee"></i>
                                                            @if($isAgent)
                                                                <span class="TotalFare product-card" data-price1="{{ $paxFareDetails->paxFareDetail->totalFareAmount + $charge }}">
                                                                    {{ $paxFareDetails->paxFareDetail->totalFareAmount + $charge }}
                                                                </span>
                                                            @else
                                                                <span class="TotalFare product-card" data-price1="{{ $paxFareDetails->paxFareDetail->totalFareAmount - $paxFareDetails->paxFareDetail->totalTaxAmount}}">
                                                                    {{ $paxFareDetails->paxFareDetail->totalFareAmount - $paxFareDetails->paxFareDetail->totalTaxAmount }}
                                                                </span>
                                                            @endif
                                                        </span>
                                                        
                                                        <a class="btn btn-primary btn-sm submit-btn">Book Now</a>
                                                        @php
                                                            $totalFareAmount = $paxFareDetails->paxFareDetail->totalFareAmount;
                                                            $totalTaxAmount = $paxFareDetails->paxFareDetail->totalTaxAmount;
                                                            array_push($airlineArr, ['code' => $flightResults->flightDetails->flightInformation->companyId->operatingCarrier, 'name' => $flightResults->flightDetails->flightInformation->companyId->operatingCarrier, 'stop' => 'Non-Stop', 'layover' => 'Non-Stop','airFare' =>$totalFareAmount]);
                                                         @endphp
                                                        {{-- </td> --}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxunder">
                                            <div class="row">
                                                <div class="col-5 col-md-5 col-sm-5 text-center">
                                                    <div class="searchtitle">
                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails->flightInformation->location[0]->locationId . ')' }}
                                                        <span class=" takeoff">{{ substr_replace($flightResults->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                                    </div>
                                                    <div class="searchtitle colorgrey">
                                                        {{ getDate_fn($flightResults->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}
                                                    </div>
                                                </div>
                                                <div class="col-2 col-md-2 col-sm-2 text-center">
                                                    <div class="searchtitle text-center">
                                                        {{ substr_replace(substr_replace($flightResults->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                    </div>
                                                    <div class="borderbotum"></div>
                                                    <div class="searchtitle colorgrey text-center">
                                                        Non-Stop
                                                    </div>
                                                </div>
                                                <div class="col-5 col-md-5 col-sm-5">
                                                    <div class="text-center">
                                                        <div class="searchtitle">
                                                            <span class=" landing">{{ substr_replace($flightResults->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}</span>
                                                            {{ AirportiatacodesController::getCity($flightResults->flightDetails->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails->flightInformation->location[1]->locationId . ')' }}
                                                        </div>
                                                        <div class="searchtitle colorgrey">
                                                            {{ getDate_fn($flightResults->flightDetails->flightInformation->productDateTime->dateOfArrival) }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container pt-10 pb-10">
                                            {{--<span class="onewflydetbtn {{ $farerule }}">{{ $farerule}}</span>--}}
                                            <span data-toggle="collapse" data-target="#details{{ $rowkey }}" class="onewflydetbtn float-right">Flight Details <i class="fa fa-regular fa-angle-down"></i></span>
                                            <!-- <span class="badge badge-info float-right">Flight Details</span> -->
                                        </div>
                                        <div id="details{{ $rowkey }}" class="collapse">
                                            <div class="container">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab"
                                                            href="#Information{{ $rowkey }}"> Flight
                                                            Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Details{{ $rowkey }}"> Fare
                                                            Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Baggage{{ $rowkey }}">
                                                            Baggage Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#Cancellation{{ $rowkey }}">
                                                            Cancellation Rules </a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane container active"
                                                        id="Information{{ $rowkey }}">
                                                        <div class="row">
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $flightResults->flightDetails->flightInformation->location[0]->locationId }}
                                                                        ->
                                                                        {{ $flightResults->flightDetails->flightInformation->location[1]->locationId }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDate_fn($flightResults->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $flightResults->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        width="40px" height="40px" alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails->flightInformation->flightOrtrainNumber }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails->flightInformation->location[0]->locationId) . '(' . $flightResults->flightDetails->flightInformation->location[0]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-4 col-md-4 col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ substr_replace($flightResults->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ AirportiatacodesController::getCity($flightResults->flightDetails->flightInformation->location[1]->locationId) . '(' . $flightResults->flightDetails->flightInformation->location[1]->locationId . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDate_fn($flightResults->flightDetails->flightInformation->productDateTime->dateOfArrival) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="tab-pane container fade" id="Details{{ $rowkey }}">

                                                        <div class="onwfntrespons-11">
                                                            <span class="text-left"> Fare Rules :</span>
                                                            <span class="text-right {{ $farerule }}"> {{ $farerule }} </span>

                                                        </div>
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11">
                                                                <tr>
                                                                    <td class="onwfnt-11">1 x Adult</td>

                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Base Fare)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total Tax +</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalTaxAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                    <td class="text-right"> <i
                                                                            class="fa fa-inr"></i>
                                                                        {{ $totalFareAmount }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="tab-pane container fade" id="Baggage{{ $rowkey }}">
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
                                                                    <td> <img
                                                                            src="{{ asset('assets/images/flight/' . $flightResults->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                                            width="40px" height="40px" alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $flightResults->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $flightResults->flightDetails->flightInformation->flightOrtrainNumber }}</span>
                                                                    </td>
                                                                    @php
                                                                    (is_array($oneways->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                    $onewaysServiceFeesCoverageInfoGrp =
                                                                    $oneways->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                    $onewaysServiceFeesCoverageInfoGrp =
                                                                    [$oneways->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                    @endphp

                                                                    @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                        @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                            @php
                                                                            (is_array($oneways->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                            $onewaysServiceBagAllowanceGrp =
                                                                            $oneways->serviceFeesGrp->freeBagAllowanceGrp :
                                                                            $onewaysServiceBagAllowanceGrp =
                                                                            [$oneways->serviceFeesGrp->freeBagAllowanceGrp];
                                                                            @endphp
                                                                            @foreach ($onewaysServiceBagAllowanceGrp as $freeBagAllowance)
                                                                                @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber??'' == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
                                                                                    @if ($freeBagAllowance->freeBagAllownceInfo->baggageDetails->quantityCode == 'N')
                                                                                        <td class="onwfnt-11">
                                                                                            {{ $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance }}PC
                                                                                            baggage</td>
                                                                                    @else
                                                                                        <td class="onwfnt-11">
                                                                                            {{ $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance }}KG
                                                                                            baggage</td>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endforeach

                                                                    {{-- <td class="onwfnt-11">7KG</td> --}}
                                                                    <td class="onwfnt-11">7KG</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
                                                                infant added in the booking</li>
                                                            <li>In certain situations of restricted cases, no amendments and
                                                                cancellation is allowed</li>
                                                            <li>Airlines cancel reschedule should be reconfirmed before
                                                                requesting for a cancellation or amendment</li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane container fade"
                                                        id="Cancellation{{ $rowkey }}">
                                                        <table class="table table-bordered">
                                                            <tbody class="onwfntrespons-11">
                                                                <tr>
                                                                    <td> <b>Time Frame to Reissue</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> <b>Time Frame to cancel</b>
                                                                        <div class="onwfnt-11">(Before scheduled
                                                                            departure time)
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
                                                                    <td> <i class="fa fa-inr"></i> 500</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>WT does not guarantee the accuracy of cancel
                                                                reschedule
                                                                fees..</li>
                                                            <li>Partial cancellation is not allowed on the flight tickets
                                                                which
                                                                are book under special round trip discounted fares..</li>
                                                            <li>Airlines doesnt allow any additional baggage allowance for
                                                                any
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
                                {{-- </div> --}}
                            </div>
                            @endif
                        @endforeach
                        @endif
                        </div>
                        
                    {{-- </div> --}}
                </div>
            </div>
        </div>
          {{-- </div>
        </div> --}}
    </section>

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/range.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sliderstyle/custom.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/range.js') }}"></script>
    <script src="{{ asset('assets/sliderstyle/multislider.js') }}"></script>
    <script src="{{ asset('assets/sliderstyle/multislider.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#exampleSlider').multislider({
                interval: 0,
                slideAll: false,
                duration: 100
            });
        });
    </script>
@endsection
<script defer src="{{asset('assets/js/filterFlight.js')}}"></script>
<script>
{{--code by Neelesh--}}
   $(document).ready(function () {
    

    $('.submit-btn').on('click', function () {
        var formData = $(this).closest('form');
        $(formData).submit();
    });
   
    
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

 let airlineDataArr = {!! json_encode($airlineArr, true)!!};

// console.table(airlineDataArr)

let airData = airlineDataArr.sort(function(a, b) {
  return a.airFare - b.airFare;
}).filter(function(item, index, arr) {
  return index === 0 || item.airFare !== arr[index - 1].airFare;
});



let nameairLineKey='name';
let airlineKey = 'code';
let airlinePrice = 'airFare';
let airlineStopKey = 'stop';



airlineStopArr = [...new Map(airlineDataArr.map(item => [item[airlineStopKey], item])).values()];
airlinePriceArr= [...new Map(airlineDataArr.map(item => [item[airlinePrice], item])).values()];
airlineFileterArr = [...new Map(airlineDataArr.map(item => [item[airlineKey], item])).values()];
 airlineDtt = [...new Map(airData.map(item => [item[airlineKey], item])).values()];
{{-- let result = airlineDataArr.filter(e=> e.airFare === Math.min(...airlineDataArr.map(e=>e.airFare) ) ); --}}




let min=airlineDataArr.reduce(function(prev, curr) {
    return prev.Cost < curr.Cost ? prev : curr;
});

var arr=[];
airlineFileterArr.forEach(element => {
    arr.push(element.code) 
});


// ====================new code by neelesh=======================
var arrStop=[];
airlineStopArr.forEach(element => {
    arrStop.push(element.stop) 
});


let arrfilterStop=[];
console.log(airData[0].stop)
for(var i=0;i<arrStop.length;i++){
    for(var j=0;j<airData.length;j++)
    {
        // console.log(airData[j].code)
       if(airData[j].stop==arrStop[i]){
         arrfilterStop.push(airData[j])
         break;

       } 

    }   
}
// ==============================================================

let arrfilterline = [];
let codeSet = new Set(); // create a new Set to keep track of unique codes

for (let i = 0; i < arr.length; i++) {
  for (let j = 0; j < airlineDataArr.length; j++) {
    if (airlineDataArr[j].code == arr[i] && !codeSet.has(arr[i])) {
      arrfilterline.push(airlineDataArr[j]);
      codeSet.add(arr[i]); // add the code to the Set
      break;
    }
  }
}
//  console.table(arrfilterline);



// console.log(uniqueFlights);




// let arrfilterline=[];
// for(var i=0;i<arr.length;i++){
//     for(var j=0;j<airData.length;j++)
//     {
//       if(airData[j].code==arr[i]){
//          arrfilterline.push(airData[j])
//          break;


//       } 

//     }
    
// }


//////////////////////////////////Code BY Neelesh Start for showing airline and filter it///////////////////
    const deskiata = {
        "AI":"Air India","6E":"IndiGo","Indigo":"IndiGo","SG":"SpiceJet","UK":"Vistara","G8":"GoAir","I5":"AirAsia India","IX":"Air India Express","9I":"Alliance","2T":"TruJet","OG":"Star Air","EI":"Aer Lingus","SU":"Aeroflot","AR":"Argentinas","AM":"AeroMexico","G9":"Air Arabia","KC":"Air Astana","UU":"Air Austral","BT":"Air Baltic","HY":"Uzbekistan","AC":"Air Canada","CA":"Air China","XK":"Air Corsica","UX":"Air Europa","AF":"Air France","AI":"Air India","NX":"Air Macau","KM":"Air Malta","MK":"Air Mauritius","9U":"Air Moldova","SW":"Air Namibia","NZ":"Air New Zealand","PX":"Air Niugini","JU":"Air Serbia","TN":"Air Tahiti Nui","TS":"Air Transat","NF":"Air Vanuatu","AS":"Alaska Airlines","AZ":"Alitalia","NH":"All Nippon","AA":"American Airlines","OZ":"Asiana Airlines","OS":"Austrian Airlines","AV":"Avianca","J2":"Azerbaijan Airlines","AD":"Azul Brazilian","PG":"Bangkok Airways","B2":"Belavia Belarusian","BG":"Biman ","BA":"British Airways","SN":"Brussels Airlines","FB":"Bulgaria Air","CX":"Cathay Pacific","5J":"Cebu Pacific","CI":"China Airlines", "MU":"China Eastern Airlines","CZ":"China Southern Airlines","DE":"Condor","CM":"Copa Airlines","OU":"Croatia Airlines","OK":"Czech Airlines","DL":"Delta Air Lines","U2":"easyJet","MS":"Egypt Air","LY":"El Al Israel","EK":"Emirates Airline","ET":"Ethiopian Airlines","EY":"Etihad Airways","EW":"Eurowings","BR":"EVA Airline","FJ":"Fiji Airways","AY":"Finnair","FZ":"Flydubai","F9":"Frontier Airlines","GA":"Garuda Indonesia","ST":"Germania Fluggesellschaft","G3":"Gol Transportes Aéreos","GF":"Gulf Air","HU":"Hainan Airlines","HA":"Hawaiian Airlines","HX":"Hong Kong Airlines","IB":"Iberia","FI":"Icelandair","6E":"IndiGo ","4O":"Interjet","IR":"Iran Air","JL":"Japan Airlines","9W":"Jet Airways","B6":"JetBlue Airways","KQ":"Kenya Airways","KL":"KLM Royal Dutch Airlines","KE":"Korean Air","KU":"Kuwait Airways","LA":"LATAM Airlines","LO":"LOT Polish Airlines","LH":"Lufthansa","MH":"Malaysia Airlines","OD":"Batik Air","JE":"Mango","ME":"Middle East Airlines","YM":"Montenegro Airlines","8M":"Myanmar Airways","RA":"Nepal Airlines","DY":"Norwegian Air Shuttle","WY":"Oman Air","MM":"Peach Aviation","PR":"Philippine Airlines","DP":"Pobeda Airlines","QF":"Qantas","QR":"Qatar Airways","AT":"Royal Air Maroc","BI":"Royal Brunei Airlines","RJ":"Royal Jordanian","ES":"DHL International E.C.","MS":"Egyptair","LY":"EL AL","EK":"Emirates","OV":"Estonian Air","ET":"Ethiopian Airlines","EY":"Etihad Airways","EA":"EEuropean Air Express","QY":"European Air Transport","EW":"Eurowings","BR":"EVA Air","EF":"Far Eastern Air Transport","FX":"Federal Express","AY":"Finnair","BE":"flybe.British European","TE":"FlyLAL - Lithuanian Airlines","GA":"Garuda","GT":"GB Airways","GF":"Gulf Air","HR":"Hahn Air","HU":"Hainan Airlines","HF":"Hapag Lloyd","HJ":"Hellas Jet","VJ":"VIETJET AIR","DU":"Hemus Air","W2":"FLEXFLIGHT AIR","GP":"APG AIRLINES","IB":"IBERIA Air","FI":"Icelandair","IC":"Indian Airlines","D6":"Interair","IR":"Iran Air","EP":"Iran Aseman Airlines","IA":"Iraqi Airways","6H":"Israir","JO":"JALways Co. Ltd","JL":"Japan Airlines","JU":"Jat Airways","9W":"Jet Airways","R5":"Jordan Aviation","KQ":"Kenya Airways","Y9":"Kish Air","KR":"Kitty Hawk","KL":"KLM Airline","KE":"Korean Air","KU":"Kuwait Airways","LB":"LAB","LR":"LACSA","TM":"LAM Airline","LA":"Lan Airline","4M":"Lan Argentina","UC":"Lan Chile Cargo","LP":"Lan Peru","XL":"Lan Ecuador","NG":"Lauda Air","LN":"Libyan Arab Airlines","ZE":"Lineas Aereas Azteca S.A. de C.V.","LO":"LOT Polish Airlines","LT":"LTU Airline","LH":"Lufthansa","LH":"Lufthansa Cargo","CL":"Lufthansa CityLine","LG":"Lux airline","W5":"Mahan Air","MH":"Malaysia Airlines","MA":"MALEV","TF":"Malm Aviation","IN":"MAT -Macedonian Airlines","ME":"MEA Airline","IG":"Meridiana","MX":"Mexicana","OM":"MIAT Airline","YM":"Montenegro Airlines","CE":"Nationwide Airlines","KZ":"Nippon Cargo Airlines (NCA)","NW":"Northwest Airlines","OA":"Olympic Airlines S.A.","WY":"Oman Air","8Q":"Onur Air","PR":"PAL Airline","PF":"Palestinian Airlines","H9":"Pegasus Airlines","NI":"PGA-Portug?lia Airlines","PK":"PIA Airline","PU":"PLUNA","PW":"Precision Air","QF":"Qantas","QR":"Qatar Airways","FV":"Rossiya - Russian Airlines","AT":"Royal Air Maroc","BI":"Royal Brunei","WB":"Rwandair Express","4Z":"SA Airlink","SA":"SAA Airline","FA":"Safair","SK":"SAS Airline","BU":"SAS Braathens","XY":"Flynas ","SP":"SATA Air A?ores","SV":"Saudi Arabian","SC":"Shandong Airlines Co., Ltd.","FM":"Shanghai Airlines","ZH":"Shenzhen Airlines Co. Ltd.","SQ":"SINGAPORE AIR","S7":"Siberia Airlines","3U":"Sichuan Airlines Co. Ltd.","MI":"Silkair","JZ":"Skyways","SN":" Brussels Airlines","IE":"Solomon Airlines","JK":"Spanair","UL":"SriLankan","SD":"Sudan Airways","PY":"Surinam Airways","LX":"SWISS","RB":"Syrianair","TA":"TACA","PZ":"Transportes airline","JJ":"Linhas Airline","TP":"Air Portugal","RO":"TAROM S.A.",
        "SF":"Tassili ","TG":"Thai Airways","TK":"Turkish Airlines ️","3V":"TNT Airways","UN":"Transaero","GE":"TransAsia Airways","TU":"Tunis Air","PS":"Ukraine International","UA":"United Airlines","5X":"UPS Airlines","US":"US Airways","LC":"Varig Log","VN":"Vietnam Airlines","VS":"Virgin Atlantic","VK":"Virgin Nigeria","XF":"Vladivostok Air","VI":"Volga-Dnepr"
    };

arrfilterline.forEach(element => {
        airlineLoop = '<div class="padding-10 input_row12">' +
    '<span class="span_input"><input type="checkbox" class="form-check-input" value="'+ element.code+ '">'+'<img src="{{ asset('assets/images/flight/') }}/'+element.code+'.png" width="20px" height="20px" alt="">' + deskiata[element.name]+ ' </span>' +
    '<span class="float-right">₹ '+ element.airFare + ' </span>' +
    '</div>';
    $('#Airline').append(airlineLoop);
    });
    arrfilterline.forEach(element => {
        airlineLoop = '<div class="padding-10 input_row12">' +
    '<span class="span_input"><input type="checkbox" class="form-check-input" value="'+ element.code+ '">'+'<img src="{{ asset('assets/images/flight/') }}/'+element.code+'.png" width="20px" height="20px" alt="">' + deskiata[element.name]+ ' </span>' +
    '<span class="float-right">₹ '+ element.airFare + ' </span>' +
    '</div>';

    $('#Airline2').append(airlineLoop);


});


arrfilterStop.forEach(element => {
    airlineStopLoop = '<div class="input_row"><input type="checkbox" class="form-check-input" value="'+element.stop+'">'+ element.stop +
    
   ' <span class="float-right">₹ '+ element.airFare + ' </span>' + '</div>';

    $('#Stops .padding-10').append(airlineStopLoop);
    $('#Stops2 .padding-10').append(airlineStopLoop);
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




});


//code by Neelesh End

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

// \\\\\\\\\\\\\\\\\\\\\\\\\\\\
</script>

{{-- <x-footer /> --}}
@endsection
