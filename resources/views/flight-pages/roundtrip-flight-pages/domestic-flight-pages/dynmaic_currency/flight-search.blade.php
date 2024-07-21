@extends('layouts.master')
@section('title', 'Wagnistrip')
@section('body')
    <!-- DESKTOP VIEW START -->
    <x-search-bar />
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    {{--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
     <link rel="stylesheet" type="text/css" src="{{url('assets/css/jQuery.UI.css')}}"> 
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css">--}}
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
        
        .ui-slider .ui-slider-handle {
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
        
        .ui-state-default,
        .ui-widget-content .ui-state-default {
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
        
        .activetime {
            background: #004068;
            color: #fff;
        }
        
        .inputbox1 input {
            width: 62px
        }
        
        .padding-twenty {
            padding-top: 21px !important;
        }
        
        .padding-twenty-more {
            position: relative !important;
            right: 65PX !important;
        }
        
        .customStickyDiv {
            position: sticky;
            top: 88px;
        }


@media only screen and (max-width: 1200px) {
    #flightMainCard {
        position: relative;
        left: 30px;
    }
}


@media only screen and (max-width: 575px) {
    #flightMainCard {
        position: relative;
        left: 0px;
    }

    .boxunder-styling {
        width: 100% !important;
        margin-left: 60px !important;
    }

    price-filter-container {
        width: 0px !important;
    }
    
    #mobile_navbar-12 .img-fluid img{
        height:4rem;
    }

}
    </style>
    @php
        $segments = Session::get('segments');
        $Agent = Session()->get("Agent");
        
        if($Agent != null){
            $isAgent = true;
            $Charge = 70;
        }else{
            $isAgent = false;
            $Charge = 118;
        }
        
        $currency_symbol  = !empty($currency_symbol->symbol) ? $currency_symbol->symbol : '<i class="fa fa-inr"></i>';
    @endphp

      
        <div class="container">
            @php
             //  dd(["gail" => [$availabilityOutbounds, $availabilityInbounds], "amd" => [$roundtripOutbounds, $roundtripInbounds]]);
                use App\Http\Controllers\Airline\AirportiatacodesController;
            @endphp
            @php
                $segSessionDep = json_decode($segments['departure'], true);
                $segSessionArr = json_decode($segments['arrival'], true);
            @endphp
            
            
            <div class="row" >
                <div class="col-sm-2 padding-twenty padding-twenty-more">
                    <div class="boxunder boxunder-styling customStickyDiv" style="width: 184px; margin-left: 35px;">
                        <div>
                            <div class="card-header owstitle" data-toggle="collapse" data-target="#FILTER">FILTER
                            <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div id="FILTER">
                        <div class="ranjepp">
                            <div class="owstitle pb-10" data-toggle="collapse" data-target="#price">Pricing
                                <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                            </div>
                            <div id="price" class="collapse show">
                                <div class="wrapper">
                                    <div class="ranjepp">
                                    <div class="owstitle pb-10" >
                                        Onward
                                    </div>
                                        <div class="inputbox1 text-center">
                                            <input type="number" min=0 max="9900" id="minprice1" class="price-range-field" style="width:100px;border:none; text-align: center;" readonly/>
                                            <input type="hidden" min=0 max="10000" id="maxprice1" class="price-range-field" style="border:none; text-align: center;" readonly/>
                                        </div>
                                        <div id="slider-range">
                                            <div class="ui-slider-range ui-widget-header" style="left: 0%; width: 100%;"></div>
                                            <a class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%; border: 2px solid;"></a>
                                            <a class="ui-slider-handle ui-state-default ui-corner-all" style="left: 100%; border: 2px solid;"></a>
                                        </div>
                                    </div>
                                    <div class="ranjepp">
                                        <div class="owstitle pb-10" >
                                            Return
                                        </div>
                                            <div class="inputbox1 text-center">
                                                <input type="number" min=0 max="9900" id="minprice2" class="price-range-field" style="width:100px;border:none; text-align: center;" readonly/>
                                                <input type="hidden" min=0 max="10000" id="maxprice2" class="price-range-field" style="border:none; text-align: center;" readonly/>
                                            </div>
                                            <div id="slider-range2">
                                                <div class="ui-slider-range ui-widget-header" style="left: 0%; width: 100%;"></div>
                                                <a class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%; border: 2px solid;"></a>
                                                <a class="ui-slider-handle ui-state-default ui-corner-all" style="left: 100%; border: 2px solid;"></a>
                                            </div>                                       
                                    </div>
                                    <!--<select class="form-control1" name="price-sorting">-->
                                    <!--    <option value="0">Sort Price</option>-->
                                    <!--    <option value="l2h">Low - High Price</option>-->
                                    <!--    <option value="h2l">High - Low Price</option>-->
                                    <!--</select>-->
                                </div>
                            </div>
                        </div>
                        <div class="borderbotum"></div>
                        <div class="ranjepp">
                            <div class="owstitle pb-10" data-toggle="collapse" data-target="#FLIGHT">FLIGHT TIMING
                                <span class="float-right"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                            </div>
                            <div id="FLIGHT" class="collapse show price-filter-container">
                                <i class="onwfnt-11">Departure : {{ $segSessionDep['city'] }}</i>
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
                                            <div class="card another-card take-off-timing  ">
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

                                <i class="onwfnt-11">Return :{{ $segSessionArr['city'] }}</i>
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

                    </div>
                    </div>
                </div>
            


                {{-- ///First Tab //// --}}
                <div class="col-sm-5 isotope-grid" id="flightMainCard" >
                    <div class="pt-10 pb-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="flightMainCard12">
                                    <div class="col-sm-4">
                                        <span class="prebtn prebtn12"> <i class="fa fa-arrow-circle-o-right"></i> </span>
                                    </div>

                                    <div class=" col-sm-4">
                                        
                                        <span class="owstitle prebtn12">{{ $segSessionDep['city'] . '→' . $segSessionArr['city'] }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="owstitle prebtn12"> {{ $segments['departDate'] }} </span>
                                        

                                    </div>
                                    <div class="col-sm-4">
                                        <span class="prebtn float-right prebtn12"> <i class="fa fa-arrow-circle-o-left"></i> </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    @php
                        $OutboundSessionID = $availabilityOutbounds['SessionID'];
                        $OutboundSegmentKey = $availabilityOutbounds['Key'];
                        $airlineArr = [];
                    
                    @endphp

                    @foreach ($availabilityOutbounds['Availibilities'][0]['Availibility'] as $AvailOutKey => $itinerariesOutbound)
                        @if (isset($itinerariesOutbound['Itineraries']['Itinerary'][0]) && isset($itinerariesOutbound['Itineraries']['Itinerary'][1]) && !isset($itinerariesOutbound['Itineraries']['Itinerary'][2]))
                            @php
                            
                                if($itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] == "SG"){
                                        continue;
                                }
                                array_push($airlineArr, ['code' => $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'name' => $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'stop' => '1-Stop', 'layover' => '1-Stop']);
                            @endphp

                        <div class="pb-10 airline_hide stops_hide 1-Stop {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] }}" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">

                            <div class="boxunder">
                                <div class="row ranjepp">
                                {{--  <div class="col-sm-2 ob-flight"> --}}
                                         <div class="col-2 col-md-2 col-sm-2 ob-flight">
                                        <img src="{{ asset('assets/images/flight/' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                            alt="flight" class="imgonewayw">
                                        <div class="owstitle1">
                                           
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Name'] }}
                                     </div>
                                        <div class="owstitle">
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}
                                        </div>
                                    </div>
                         <div class="col-2 col-md-2 col-sm-2 mt-3">
                            {{-- <div class="col-sm-2 mt-3"> --}}
                                        <span class="font-18 ob-dep-time takeoff">
                                            {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                        <h6 class="colorgrey fontsize-14 ob-dep-location">
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['CityName'] }}
                                        </h6>
                                    </div>
                            {{-- <div class="col-sm-2 mt-3 ob-dur-loc"> --}}
                            <div class="col-3 col-md-2 col-sm-2 mt-3 ob-dur-loc">
                                        <div class="searchtitle text-center">
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Duration'] }}
                                        </div>
                                        <div class="borderbotum"></div>
                                        <div class="searchtitle colorgrey-sm text-center">
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] }} 
                                            | 1-Stop
                                        </div>
                                    </div>
                                   <div class="col-2 col-md-2 col-sm-2 mt-3">
                            {{-- <div class="col-sm-2 mt-3"> --}}
                                        <span class="font-18 ob-arr-time ">
                                            {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                        </span>
                                        <h6 class="colorgrey fontsize-14 ob-arr-location">
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][1]['Destination']['CityName'] }}
                                        </h6>
                                    </div>
                                 {{-- <div class="col-sm-3 mt-3"> --}}
                                @if($isAgent)
                                    <div class="col-2 col-md-3 col-sm-3 mt-3">
                                        <span class="fontsize-22 ob-fare" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $Charge }}"> {!! $currency_symbol !!}}
                                            {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $Charge }}</span>
                                    </div>
                                @else
                                    <div class="col-2 col-md-3 col-sm-3 mt-3">
                                        <span class="fontsize-22 ob-fare" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}"> {!! $currency_symbol !!}}
                                            {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}</span>
                                    </div>
                                @endif
                                {{--    <div class="col-sm-1 mt-3"> --}}
                                 <div class="col-1 col-md-1 col-sm-1 mt-3">
                                        <input type="radio" class="form-check-input" id="input_box1" name="outbound-flights"
                                            value="{{ 0 . $AvailOutKey }}">
                                    </div>
                                    <div class="ob-form-data">
                                        <input type="hidden" name="dom_gl_outbound_onestop">
                                        <input type="hidden" name="OutboundSessionID"  value="{{ $OutboundSessionID }}">
                                        <input type="hidden" name="OutboundKey" value="{{ $OutboundSegmentKey }}">
                                        <input type="hidden" name="OutboundPricingkey" value="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['Pricingkey'] }}">
                                        <input type="hidden" name="OutboundProvider" value="{{ $itinerariesOutbound['Provider'] }}">
                                        <input type="hidden" name="OutboundResultIndex" value="{{ $itinerariesOutbound['ItemNo'] }}">
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                           {{-- <span class="onewflydetbtn {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">
                                                {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                            </span> --}}
                                        </div>
                                        <div class="col-md-6">
                                            <span data-toggle="collapse"
                                                data-target="#flight-outbound-details1{{ 0 . $AvailOutKey }}"
                                                class="onewflydetbtn" style="float: right;">Flight Details <i class="fa fa-regular fa-angle-down"></i></span>
                                        </div>
                                    </div>

                                    <div id="flight-outbound-details1{{ 0 . $AvailOutKey }}"
                                        class="collapse">
                                        <div class="container">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab"
                                                        href="#Information1{{ 0 . $AvailOutKey }}"> Flight
                                                        Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                        href="#Details1{{ 0 . $AvailOutKey }}"> Fare
                                                        Details </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                        href="#Baggage1{{ 0 . $AvailOutKey }}">
                                                        Baggage Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                        href="#Cancellation1{{ 0 . $AvailOutKey }}">
                                                        Cancellation Rules </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane container active"
                                                    id="Information1{{ 0 . $AvailOutKey }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . '->' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['CityName'] . '(' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['CityName'] . '(' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="pt-10 text-center">
                                                                <div class="owstitle">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Duration'] }}
                                                                </div>
                                                                <div class="flh"></div>
                                                                <div class="owstitle">By: Air</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $itinerariesOutbound['Itineraries']['Itinerary'][1]['Origin']['AirportCode'] . '->' . $itinerariesOutbound['Itineraries']['Itinerary'][1]['Destination']['AirportCode'] }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $itinerariesOutbound['Itineraries']['Itinerary'][1]['AirLine']['Code']) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $itinerariesOutbound['Itineraries']['Itinerary'][1]['AirLine']['Code'] . '-' . $itinerariesOutbound['Itineraries']['Itinerary'][1]['AirLine']['Identification'] }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][1]['Origin']['CityName'] . '(' . $itinerariesOutbound['Itineraries']['Itinerary'][1]['Origin']['AirportCode'] . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][1]['Destination']['CityName'] . '(' . $itinerariesOutbound['Itineraries']['Itinerary'][1]['Destination']['AirportCode'] . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="Details1{{ 0 . $AvailOutKey }}">

                                                    <div>
                                                        <span class="text-left"> Fare Rules :</span>
                                                        <span class="text-right onewflydetbtn {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">
                                                            {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                                        </span>

                                                    </div>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td class="onwfnt-11">1 Adult</td>
                                                                <td class="text-right "> {!! $currency_symbol !!}}
                                                                    {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total Tax +</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalTax'] +  $Charge  }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="Baggage1{{ 0 . $AvailOutKey }}">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Airline</th>
                                                                <th>Check-in Baggage</th>
                                                                <th>Cabin Baggage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                </td>
                                                                <td class="onwfnt-11">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                                </td>

                                                                <td class="onwfnt-11">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                </td>
                                                                <td class="onwfnt-11">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                                </td>

                                                                <td class="onwfnt-11">
                                                                    {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
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
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
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
                                                    id="Cancellation1{{ 0 . $AvailOutKey }}">
                                                    <table class="table table-bordered">
                                                        <tbody>
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
                                                                <td>{!! $currency_symbol !!}} 500</td>
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
                                                                <td>{!! $currency_symbol !!}} 500</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                    <ul class="onwfnt-11">
                                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                            Difference if applicable + WT Fees.</li>
                                                        <li>The airline cancel reschedule fees is indicative and can be
                                                            changed without any prior notice by the airlines..</li>
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
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

                            </div>
                        </div>

                    @elseif (isset($itinerariesOutbound['Itineraries']['Itinerary'][0]) &&
                        !isset($itinerariesOutbound['Itineraries']['Itinerary'][1]) &&
                        !isset($itinerariesOutbound['Itineraries']['Itinerary'][2]))
                        @php
                            if($itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] == "SG"){
                                continue;
                            }
                            array_push($airlineArr, ['code' => $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'name' => $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'stop' => 'Non-Stop', 'layover' => 'Non-Stop']);
                        @endphp

                        <div class="pb-10 airline_hide stops_hide Non-Stop {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] }}" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">

                            <div class="boxunder">
                                <div class="row ranjepp">
                                {{--    <div class="col-sm-2 ob-flight"> --}}
                                 <div class="col-2 col-md-2 col-sm-2 ob-flight">
                                        <img src="{{ asset('assets/images/flight/' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                            alt="flight" class="imgonewayw">
                                        <div class="owstitle1">
                                                    {{     $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Name'] }}
                                          
                                        </div>
                                        <div class="owstitle">

                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}
                                        </div>
                                    </div>
                                 <div class="col-2 col-md-2 col-sm-2 mt-3">
                            {{-- <div class="col-sm-2 mt-3"> --}}
                                        <span class="font-18 ob-dep-time takeoff">
                                            {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                        <h6 class="colorgrey fontsize-14 ob-dep-location">
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['CityName'] }}
                                        </h6>
                                    </div>
                     {{--<div class="col-sm-2 mt-3 ob-dur-loc"> --}}
                            <div class="col-3 col-md-2 col-sm-2 mt-3 ob-dur-loc">
                                        <div class="searchtitle text-center">
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Duration'] }}
                                        </div>
                                        <div class="borderbotum"></div>
                                        <div class="searchtitle colorgrey-sm text-center">Nonstop
                                        </div>
                                    </div>
                                  <div class="col-2 col-md-2 col-sm-2 mt-3">
                            {{-- <div class="col-sm-2 mt-3"> --}}
                                        <span class="font-18 ob-arr-time ">
                                            {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                        </span>
                                        <h6 class="colorgrey fontsize-14 ob-arr-location">
                                            {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['CityName'] }}
                                        </h6>
                                    </div>
                                     {{--    <div class="col-sm-3 mt-3"> --}}
                                     @if($isAgent)
                                    <div class="col-2 col-md-3 col-sm-3 mt-3">
                                        <span class="fontsize-22 ob-fare" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $Charge }}"> {!! $currency_symbol !!}}
                                            {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $Charge }}</span>
                                    </div>
                                    @else
                                    <div class="col-2 col-md-3 col-sm-3 mt-3">
                                        <span class="fontsize-22 ob-fare" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}"> {!! $currency_symbol !!}}
                                            {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}</span>
                                    </div>
                                    @endif
                                     {{--    <div class="col-sm-1 mt-3"> --}}
                                 <div class="col-1 col-md-1 col-sm-1 mt-3">
                                        <input type="radio" class="form-check-input"  id="input_box1" name="outbound-flights"
                                            value="{{ 0 . $AvailOutKey }}">
                                    </div>
                                    <div class="ob-form-data">
                                        <input type="hidden" name="dom_gl_outbound_nonstop">
                                        <input type="hidden" name="OutboundSessionID" value="{{ $OutboundSessionID }}">
                                        <input type="hidden" name="OutboundKey" value="{{ $OutboundSegmentKey }}">
                                        <input type="hidden" name="OutboundPricingkey" value="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['Pricingkey'] }}">
                                        <input type="hidden" name="OutboundProvider" value="{{ $itinerariesOutbound['Provider'] }}">
                                        <input type="hidden" name="OutboundResultIndex" value="{{ $itinerariesOutbound['ItemNo'] }}">
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                           {{-- <span
                                                class="onewflydetbtn {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}</span> --}}
                                        </div>
                                        <div class="col-md-6">
                                            <span data-toggle="collapse"
                                                data-target="#flight-outbound-details1{{ 0 . $AvailOutKey }}"
                                                class="onewflydetbtn" style="float: right;">Flight
                                                Details</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="flight-outbound-details1{{ 0 . $AvailOutKey }}" class="collapse">
                                    <div class="container">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab"
                                                    href="#Information1{{ 0 . $AvailOutKey }}"> Flight
                                                    Information </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab"
                                                    href="#Details1{{ 0 . $AvailOutKey }}"> Fare
                                                    Details </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab"
                                                    href="#Baggage1{{ 0 . $AvailOutKey }}">
                                                    Baggage Information </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab"
                                                    href="#Cancellation1{{ 0 . $AvailOutKey }}">
                                                    Cancellation Rules </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane container active"
                                                id="Information1{{ 0 . $AvailOutKey }}">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="pt-10">
                                                            <span
                                                                class="searchtitle">{{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . '->' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] }}
                                                            </span>
                                                            <span
                                                                class="onwfnt-11">{{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                                            <div>
                                                                <img src="{{ asset('assets/images/flight/' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                    alt="fligt">
                                                                <span
                                                                    class="onwfnt-11">{{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="pt-10 text-center">
                                                            <div class="searchtitle">
                                                                {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                            </div>
                                                            <div class="owstitle">
                                                                {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['CityName'] . '(' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}
                                                            </div>
                                                            <div class="owstitle">
                                                                {{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                            </div>
                                                            {{-- <div class="owstitle">Terminal - </div> --}}
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="pt-10 float-right">
                                                            <div class="searchtitle">
                                                                {{ getTimeFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                            </div>
                                                            <div class="owstitle">
                                                                {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['CityName'] . '(' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] . ')' }}
                                                            </div>
                                                            <div class="owstitle">
                                                                {{ getDateFormat($itinerariesOutbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                            </div>
                                                            {{-- <div class="owstitle">Terminal - </div> --}}
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-sm-12">
                                                        <div class="pt-10 text-center">
                                                            <div class="owstitle">
                                                                {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Duration'] }}
                                                            </div>
                                                            <div class="flh"></div>
                                                            <div class="owstitle">By: Air</div>
                                                        </div>
                                                    </div> --}}

                                                </div>
                                            </div>
                                            <div class="tab-pane container fade"
                                                id="Details1{{ 0 . $AvailOutKey }}">

                                                <div>
                                                    <span class="text-left"> Fare Rules :</span>
                                                    <span class="text-right onewflydetbtn {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">
                                                        {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                                    </span>
                                                </div>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td class="onwfnt-11">1 Adult</td>
                                                            <td class="text-right"> {!! $currency_symbol !!}}
                                                                {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="onwfnt-11">Total (Base Fare)</td>
                                                            <td class="text-right"> {!! $currency_symbol !!}}
                                                                {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="onwfnt-11">Total Tax +</td>
                                                            <td class="text-right"> {!! $currency_symbol !!}}
                                                                {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalTax']   +  $Charge}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                            <td class="text-right"> {!! $currency_symbol !!}}
                                                                {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="tab-pane container fade"
                                                id="Baggage1{{ 0 . $AvailOutKey }}">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Airline</th>
                                                            <th>Check-in Baggage</th>
                                                            <th>Cabin Baggage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td> <img
                                                                    src="{{ asset('assets/images/flight/' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                    alt="">
                                                                <span
                                                                    class="onwfnt-11">{{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesOutbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                            </td>
                                                            <td class="onwfnt-11">
                                                                {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                            </td>

                                                            <td class="onwfnt-11">
                                                                {{ $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itinerariesOutbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
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
                                                    <li>Wagnistrip does not guarantee the accuracy of cancel
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
                                                id="Cancellation1{{ 0 . $AvailOutKey }}">
                                                <table class="table table-bordered">
                                                    <tbody>
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
                                                            <td> {!! $currency_symbol !!}} 500</td>
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
                                                            <td> {!! $currency_symbol !!}} 500</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                <ul class="onwfnt-11">
                                                    <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                        Difference if applicable + WT Fees.</li>
                                                    <li>The airline cancel reschedule fees is indicative and can be
                                                        changed without any prior notice by the airlines..</li>
                                                    <li>Wagnistrip does not guarantee the accuracy of cancel
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
                        </div>
                    @endif
                    @endforeach

                    {{-- ////////////////////////////////////////  A M A D E U S    S E R V I C E   P R O V I D E R --}}

                    <?php 
                    if(isset($roundtripOutbounds->response)){
                        (is_array($roundtripOutbounds->response->recommendation) == true) ? $roundtripOutboundsRecommendation = $roundtripOutbounds->response->recommendation : $roundtripOutboundsRecommendation = [$roundtripOutbounds->response->recommendation];
                        (is_array($roundtripOutbounds->response->flightIndex->groupOfFlights) == true) ? $roundtripOutboundsGroupOfFlights = $roundtripOutbounds->response->flightIndex->groupOfFlights : $roundtripOutboundsGroupOfFlights = [$roundtripOutbounds->response->flightIndex->groupOfFlights];
                    }else{
                        $roundtripOutboundsGroupOfFlights =[];
                    }
                    ?>

                    {{-- {{ dd([$roundtripOutboundsRecommendation,$roundtripOutboundsGroupOfFlights]) }} --}}

                    @foreach ($roundtripOutboundsGroupOfFlights as $outBoundkey => $outBoundFlights)
                        @if (is_array($outBoundFlights->flightDetails) == true && isset($outBoundFlights->flightDetails[6]) && !isset($outBoundFlights->flightDetails[7]))
                        @elseif (is_array($outBoundFlights->flightDetails) == true && isset($outBoundFlights->flightDetails[5]) && !isset($outBoundFlights->flightDetails[6]))
                        @elseif (is_array($outBoundFlights->flightDetails) == true && isset($outBoundFlights->flightDetails[4]) && !isset($outBoundFlights->flightDetails[5]))
                        @elseif (is_array($outBoundFlights->flightDetails) == true && isset($outBoundFlights->flightDetails[3]) && !isset($outBoundFlights->flightDetails[4]))
                        @elseif (is_array($outBoundFlights->flightDetails) == true && isset($outBoundFlights->flightDetails[2]) && !isset($outBoundFlights->flightDetails[3]))
                            @php
                                if( $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier == "SG"){
                                    continue;
                                }
                                array_push($airlineArr, ['code' => $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'name' => $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'stop' => '2-Stop', 'layover' => '1-Stop']);
                            @endphp

                            <div class="pb-10 airline_hide stops_hide 2-Stop {{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">

                                <div class="boxunder">
                                    <div class="row ranjepp">
                                        <div class="col-2 col-md-2 col-sm-2 ob-flight">
                                            <img class=""
                                                src="
                                                    {{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                alt="flight" class="imgonewayw">
                                                <div class="owstitle1">
                                              
                                                          {{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}
                                          
                                            </div>
                                            <div class="owstitle">
                                                
                                                {{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ob-dep-time takeoff">
                                                {{ substr_replace($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ob-dep-location">
                                                {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3 ob-dur-loc">
                                            <div class="searchtitle text-center">
                                                {{ substr_replace(substr_replace($outBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                            </div>
                                            <div class="borderbotum"></div>
                                            <div class="searchtitle colorgrey-sm text-center">
                                                {{ $outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId . '-' . $outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                | 2-Stop</div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ob-arr-time ">
                                                {{ substr_replace($outBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ob-arr-location">
                                                {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-3 col-md-3 col-sm-3 mt-3 ">
                                            @foreach ($roundtripOutboundsRecommendation as $recommendation)
                                                <?php (is_array($recommendation->segmentFlightRef) == true) ? $segmentFlightRefs = $recommendation->segmentFlightRef : $segmentFlightRefs = [$recommendation->segmentFlightRef];
                                                ?>
                                                @foreach ($segmentFlightRefs as $segmentFlightRef)
                                                    @if ($segmentFlightRef->referencingDetail[0]->refNumber == $outBoundFlights->propFlightGrDetail->flightProposal[0]->ref)
                                                        @php
                                                            $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                            $baggRef = $baggRefArray[0]->refNumber;
                                                            
                                                            is_array($recommendation->paxFareProduct) == true ? ($paxFareProduct = $recommendation->paxFareProduct[0]) : ($paxFareProduct = $recommendation->paxFareProduct);
                                                            
                                                            is_array($paxFareProduct->fare) ? ($fareDetailsRule = $paxFareProduct->fare) : ($fareDetailsRule = [$paxFareProduct->fare]);
                                                            
                                                            is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                            
                                                            $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                            
                                                            $outbound_twostop_bookingClass_1 = $paxFareProduct->fareDetails->groupOfFares[0]->productInformation->cabinProduct->rbd;
                                                            
                                                            $outbound_twostop_bookingClass_2 = $paxFareProduct->fareDetails->groupOfFares[1]->productInformation->cabinProduct->rbd;
                                                            
                                                            $outbound_twostop_bookingClass_3 = $paxFareProduct->fareDetails->groupOfFares[2]->productInformation->cabinProduct->rbd;
                                                            
                                                            $outbound_twostop_fareBasis_1 = $paxFareProduct->fareDetails->groupOfFares[0]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                            $outbound_twostop_fareBasis_2 = $paxFareProduct->fareDetails->groupOfFares[1]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                            $outbound_twostop_fareBasis_3 = $paxFareProduct->fareDetails->groupOfFares[2]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                        @endphp
                                                        @if($isAgent)
                                                        <span class="fontsize-22 ob-fare" data-price1="{{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}"> {!! $currency_symbol !!}}
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}
                                                        @else
                                                        <span class="fontsize-22 ob-fare" data-price1="{{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}"> {!! $currency_symbol !!}}
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}
                                                        @endif
                                                            @php
                                                                $totalFareAmount = $paxFareProduct->paxFareDetail->totalFareAmount;
                                                                $totalTaxAmount = $paxFareProduct->paxFareDetail->totalTaxAmount;
                                                            @endphp
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </div>
                                        <div class="col-1 col-md-1 col-sm-1 mt-3">
                                            <input type="radio" class="form-check-input" id="input_box1" name="outbound-flights"
                                                value="{{ $outBoundkey }}">
                                        </div>
                                        <div class="ob-form-data">

                                            <input type="hidden" name="dom_outbound_twostop" value="dom_outbound_twostop">

                                            <input type="hidden" name="outbound_twostop_arrivalingTime"
                                                value="{{ $outBoundFlights->propFlightGrDetail->flightProposal[1]->ref }}">

                                            <input type="hidden" name="outbound_twostop_bookingClass_1"
                                                value="{{ $outbound_twostop_bookingClass_1 }}">

                                            <input type="hidden" name="outbound_twostop_bookingClass_2"
                                                value="{{ $outbound_twostop_bookingClass_2 }}">

                                            <input type="hidden" name="outbound_twostop_bookingClass_3"
                                                value="{{ $outbound_twostop_bookingClass_3 }}">

                                            <input type="hidden" name="outbound_twostop_fareBasis_1"
                                                value="{{ $outbound_twostop_fareBasis_1 }}">

                                            <input type="hidden" name="outbound_twostop_fareBasis_2"
                                                value="{{ $outbound_twostop_fareBasis_2 }}">

                                            <input type="hidden" name="outbound_twostop_fareBasis_3"
                                                value="{{ $outbound_twostop_fareBasis_3 }}">

                                            <input type="hidden" name="outbound_twostop_arrivalTime_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">

                                            <input type="hidden" name="outbound_twostop_arrivalTime_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">

                                            <input type="hidden" name="outbound_twostop_arrivalTime_3"
                                                value="{{ $outBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfArrival }}">

                                            <input type="hidden" name="outbound_twostop_departure_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="outbound_twostop_departure_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="outbound_twostop_departure_3"
                                                value="{{ $outBoundFlights->flightDetails[2]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="outbound_twostop_arrival_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="outbound_twostop_arrival_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="outbound_twostop_arrival_3"
                                                value="{{ $outBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="outbound_twostop_departureDate_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="outbound_twostop_departureDate_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="outbound_twostop_departureDate_3"
                                                value="{{ $outBoundFlights->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="outbound_twostop_departureTime_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="outbound_twostop_departureTime_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="outbound_twostop_departureTime_3"
                                                value="{{ $outBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="outbound_twostop_marketingCompany_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">

                                            <input type="hidden" name="outbound_twostop_marketingCompany_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">

                                            <input type="hidden" name="outbound_twostop_marketingCompany_3"
                                                value="{{ $outBoundFlights->flightDetails[2]->flightInformation->companyId->marketingCarrier }}">

                                            <input type="hidden" name="outbound_twostop_operatingCompany_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="outbound_twostop_operatingCompany_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="outbound_twostop_operatingCompany_3"
                                                value="{{ $outBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="outbound_twostop_flightNumber_1"  value="{{ $outBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}">

                                            <input type="hidden" name="outbound_twostop_flightNumber_2" value="{{ $outBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}">

                                            <input type="hidden" name="outbound_twostop_flightNumber_3" value="{{ $outBoundFlights->flightDetails[2]->flightInformation->flightOrtrainNumber }}">

                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-md-6">
                                              {{--  <span class="onewflydetbtn {{ $farerule }}"> {{ $farerule }}</span> --}}
                                            </div>
                                            <div class="col-6 col-md-6 col-md-6">
                                                <span data-toggle="collapse"
                                                    data-target="#outbound-details{{ $outBoundkey }}"
                                                    class="onewflydetbtn" style="float: right;">Flight
                                                    Details</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="outbound-details{{ $outBoundkey }}" class="collapse">
                                        <div class="container">
                                            <ul class="nav nav-tabs w-100">
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px active" data-toggle="tab"
                                                        href="#outbound-flight-Information{{ $outBoundkey }}"> Flight
                                                        Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Details{{ $outBoundkey }}"> Fare
                                                        Details </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Baggage{{ $outBoundkey }}">
                                                        Baggage Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Cancellation{{ $outBoundkey }}">
                                                        Cancellation Rules </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane container active"
                                                    id="outbound-flight-Information{{ $outBoundkey }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId) . '(' . $outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId) . '(' . $outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="pt-10 text-center">
                                                                <div class="owstitle">
                                                                    {{ substr_replace(substr_replace($outBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                </div>
                                                                <div class="flh"></div>
                                                                {{-- <div class="owstitle">By: Air</div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $outBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId) . '(' . $outBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId) . '(' . $outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="pt-10 text-center">
                                                                <div class="owstitle">
                                                                    {{ substr_replace(substr_replace($outBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                </div>
                                                                <div class="flh"></div>
                                                                {{-- <div class="owstitle">By: Air</div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $outBoundFlights->flightDetails[2]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $outBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($outBoundFlights->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[2]->flightInformation->flightOrtrainNumber }}</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[2]->flightInformation->location[0]->locationId) . '(' . $outBoundFlights->flightDetails[2]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId) . '(' . $outBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[2]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="outbound-flight-Details{{ $outBoundkey }}">
                                                    <div>
                                                        <span class="text-left"> Fare Rules :</span>
                                                        <span class="text-right onewflydetbtn {{ $farerule }}"> {{ $farerule }} </span>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td class="onwfnt-11">1 x Adult</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total Tax +</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalTaxAmount  +  $Charge}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount }}</td>
                                                            </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="outbound-flight-Baggage{{ $outBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Airline</th>
                                                                <th>Check-in Baggage</th>
                                                                <th>Cabin Baggage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                <?php (is_array($roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp = $roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp : $onewaysServiceFeesCoverageInfoGrp = [$roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                ?>
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $outBoundServiceBagAllowanceGrp =
                                                                        $roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $outBoundServiceBagAllowanceGrp =
                                                                        [$roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp

                                                                        @foreach ($outBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                                <td class="onwfnt-11">7KG</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp
                                                                : $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $outBoundServiceBagAllowanceGrp =
                                                                        $roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $outBoundServiceBagAllowanceGrp =
                                                                        [$roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($outBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                                <td class="onwfnt-11">7KG</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[2]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp
                                                                : $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $outBoundServiceBagAllowanceGrp =
                                                                        $roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $outBoundServiceBagAllowanceGrp =
                                                                        [$roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($outBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                                                    id="outbound-flight-Cancellation{{ $outBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td> <b>Time Frame to Reissue</b>
                                                                    <div class="onwfnt-11">(Before scheduled departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!}} 500</td>
                                                            </tr>

                                                            <tr>
                                                                <td> <b>Time Frame to cancel</b>
                                                                    <div class="onwfnt-11">(Before scheduled departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!}} 500</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                    <ul class="onwfnt-11">
                                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                            Difference if applicable + WT Fees.</li>
                                                        <li>The airline cancel reschedule fees is indicative and can be
                                                            changed without any prior notice by the airlines..</li>
                                                        <li>Wagnitrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                            </div>
                        @elseif (is_array($outBoundFlights->flightDetails) == true &&
                            isset($outBoundFlights->flightDetails[1]) && !isset($outBoundFlights->flightDetails[2]))
                            @php
                                if( $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier == "SG"){
                                        continue;
                                }
                             array_push($airlineArr, ['code' => $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'name' => $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'stop' => '1-Stop', 'layover' => '1-Stop']);
                            @endphp

                         <div class="pb-10 airline_hide stops_hide 1-Stop {{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">

                                <div class="boxunder">
                                    <div class="row ranjepp">
                                        <div class="col-2 col-md-2 col-sm-2 ob-flight">
                                            <img src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                alt="flight" class="imgonewayw">
                                                <div class="owstitle1">
                                               
                                                        {{  $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}
                                            </div>
                                                 
                                            <div class="owstitle">
                                                {{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ob-dep-time takeoff">
                                                {{ substr_replace($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ob-dep-location">
                                                {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-3 col-md-2 col-sm-2 mt-3 ob-dur-loc">
                                            <div class="searchtitle text-center">
                                                {{ substr_replace(substr_replace($outBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                            </div>
                                            <div class="borderbotum"></div>
                                            <div class="searchtitle colorgrey-sm text-center">
                                                {{ $outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                | 1-Stop</div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ob-arr-time ">
                                                {{ substr_replace($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ob-arr-location">
                                                {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-2 col-md-3 col-sm-3 mt-3 ">
                                            @foreach ($roundtripOutboundsRecommendation as $recommendation)
                                                @php
                                                                           (is_array($recommendation->segmentFlightRef) == true) ? $segmentFlightRefs =
                                                $recommendation->segmentFlightRef : $segmentFlightRefs =
                                                [$recommendation->segmentFlightRef];
                                                @endphp
                                                @foreach ($segmentFlightRefs as $segmentFlightRef)
                                                    @if ($segmentFlightRef->referencingDetail[0]->refNumber == $outBoundFlights->propFlightGrDetail->flightProposal[0]->ref)
                                                        @php
                                                            $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                            $baggRef = $baggRefArray[0]->refNumber;
                                                            
                                                            is_array($recommendation->paxFareProduct) == true ? ($paxFareProduct = $recommendation->paxFareProduct[0]) : ($paxFareProduct = $recommendation->paxFareProduct);
                                                            
                                                            is_array($paxFareProduct->fare) ? ($fareDetailsRule = $paxFareProduct->fare) : ($fareDetailsRule = [$paxFareProduct->fare]);
                                                            
                                                            is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                            
                                                            $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                            
                                                            $outbound_onestop_bookingClass_1 = $paxFareProduct->fareDetails->groupOfFares[0]->productInformation->cabinProduct->rbd;
                                                            
                                                            $outbound_onestop_bookingClass_2 = $paxFareProduct->fareDetails->groupOfFares[1]->productInformation->cabinProduct->rbd;
                                                            
                                                            $outbound_onestop_fareBasis_1 = $paxFareProduct->fareDetails->groupOfFares[0]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                            $outbound_onestop_fareBasis_2 = $paxFareProduct->fareDetails->groupOfFares[1]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                        @endphp
                                                        
                                                            @if($isAgent)
                                                            <span class="fontsize-22 ob-fare" data-price1="{{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}"> {!! $currency_symbol !!}}
                                                                {{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}
                                                            @else
                                                            <span class="fontsize-22 ob-fare" data-price1="{{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount}}"> {!! $currency_symbol !!}}
                                                                {{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount}}
                                                            @endif
                                                        
                                                            @php
                                                                $totalFareAmount = $paxFareProduct->paxFareDetail->totalFareAmount;
                                                                $totalTaxAmount = $paxFareProduct->paxFareDetail->totalTaxAmount;
                                                            @endphp
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </div>
                                        <div class="col-1 col-md-1 col-sm-1 mt-3">
                                            <input type="radio" class="form-check-input" id="input_box1" name="outbound-flights"
                                                value="{{ $outBoundkey }}">
                                        </div>
                                        <div class="ob-form-data">

                                            <input type="hidden" name="dom_outbound_onestop" value="dom_outbound_onestop">

                                            <input type="hidden" name="outbound_onestop_arrivalingTime"
                                                value="{{ $outBoundFlights->propFlightGrDetail->flightProposal[1]->ref }}">

                                            <input type="hidden" name="outbound_onestop_bookingClass_1"
                                                value="{{ $outbound_onestop_bookingClass_1 }}">

                                            <input type="hidden" name="outbound_onestop_bookingClass_2"
                                                value="{{ $outbound_onestop_bookingClass_2 }}">

                                            <input type="hidden" name="outbound_onestop_fareBasis_1"
                                                value="{{ $outbound_onestop_fareBasis_1 }}">

                                            <input type="hidden" name="outbound_onestop_fareBasis_2"
                                                value="{{ $outbound_onestop_fareBasis_2 }}">

                                            <input type="hidden" name="outbound_onestop_arrivalTime_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">

                                            <input type="hidden" name="outbound_onestop_arrivalTime_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">
                                            <input type="hidden" name="outbound_onestop_departure_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="outbound_onestop_arrival_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="outbound_onestop_departureDate_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="outbound_onestop_departureTime_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="outbound_onestop_marketingCompany_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">
                                            <input type="hidden" name="outbound_onestop_operatingCompany_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="outbound_onestop_flightNumber_1"
                                                value="{{ $outBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}">

                                            <input type="hidden" name="outbound_onestop_departure_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="outbound_onestop_arrival_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="outbound_onestop_departureDate_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="outbound_onestop_departureTime_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="outbound_onestop_marketingCompany_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">

                                            <input type="hidden" name="outbound_onestop_operatingCompany_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="outbound_onestop_flightNumber_2"
                                                value="{{ $outBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}">

                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-md-6">
                                              {{--  <span class="onewflydetbtn {{ $farerule }}">{{ $farerule }} </span> --}}
                                            </div>
                                            <div class="col-6 col-md-6 col-md-6">
                                                <span data-toggle="collapse"
                                                    data-target="#outbound-details{{ $outBoundkey }}"
                                                    class="onewflydetbtn" style="float: right;">Flight
                                                    Details</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="outbound-details{{ $outBoundkey }}" class="collapse">
                                        <div class="container">
                                            <ul class="nav nav-tabs w-100">
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px active" data-toggle="tab"
                                                        href="#outbound-flight-Information{{ $outBoundkey }}"> Flight
                                                        Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Details{{ $outBoundkey }}"> Fare
                                                        Details </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Baggage{{ $outBoundkey }}">
                                                        Baggage Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Cancellation{{ $outBoundkey }}">
                                                        Cancellation Rules </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane container active"
                                                    id="outbound-flight-Information{{ $outBoundkey }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId) . '(' . $outBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId) . '(' . $outBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="pt-10 text-center">
                                                                <div class="owstitle">
                                                                    {{ substr_replace(substr_replace($outBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                </div>
                                                                <div class="flh"></div>
                                                                {{-- <div class="owstitle">By: Air</div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $outBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId) . '(' . $outBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId) . '(' . $outBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="outbound-flight-Details{{ $outBoundkey }}">

                                                    <div>
                                                        <span class="text-left"> Fare Rules :</span>
                                                        <span class="text-right onewflydetbtn {{ $farerule }}"> {{ $farerule }} </span>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td class="onwfnt-11">1 x Adult</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total Tax +</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalTaxAmount +  $Charge }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="outbound-flight-Baggage{{ $outBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Airline</th>
                                                                <th>Check-in Baggage</th>
                                                                <th>Cabin Baggage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp
                                                                : $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $outBoundServiceBagAllowanceGrp =
                                                                        $roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $outBoundServiceBagAllowanceGrp =
                                                                        [$roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp

                                                                        @foreach ($outBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                                <td class="onwfnt-11">7KG</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp
                                                                : $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $outBoundServiceBagAllowanceGrp =
                                                                        $roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $outBoundServiceBagAllowanceGrp =
                                                                        [$roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($outBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)

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
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                                                    id="outbound-flight-Cancellation{{ $outBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td> <b>Time Frame to Reissue</b>
                                                                    <div class="onwfnt-11">(Before scheduled departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!}} 500</td>
                                                            </tr>

                                                            <tr>
                                                                <td> <b>Time Frame to cancel</b>
                                                                    <div class="onwfnt-11">(Before scheduled departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!}} 500</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                    <ul class="onwfnt-11">
                                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                            Difference if applicable + WT Fees.</li>
                                                        <li>The airline cancel reschedule fees is indicative and can be
                                                            changed without any prior notice by the airlines..</li>
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                            </div>
                        @else
                        @php
                        
                                if( $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier == "SG"){
                                        continue;
                                }
                            array_push($airlineArr, ['code' => $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier, 'name' => $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier, 'stop' => 'Non-Stop', 'layover' => '1-Stop']);
                        @endphp

                     <div class="pb-10 airline_hide stops_hide Non-Stop {{ $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier }}" data-price1="{{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">

                                <div class="boxunder">
                                    <div class="row ranjepp">
                                        <div class="col-2 col-md-2 col-sm-2 ob-flight">
                                            <img src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                alt="flight" class="imgonewayw">
                                                <div class="owstitle1">
                                              
                                                       {{  $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier }}
                                            </div>
                                                 
                                            <div class="owstitle">
                                                {{ $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails->flightInformation->flightOrtrainNumber }}
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ob-dep-time takeoff">
                                                {{ substr_replace($outBoundFlights->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                            <h6 class="colorgrey fontsize-14 ob-dep-location">
                                                {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails->flightInformation->location[0]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-3 col-md-2 col-sm-2 mt-3 ob-dur-loc">
                                            <div class="searchtitle text-center">
                                                {{ substr_replace(substr_replace($outBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                            </div>
                                            <div class="borderbotum"></div>
                                            <div class="searchtitle colorgrey-sm text-center">Nonstop
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ob-arr-time ">
                                                {{ substr_replace($outBoundFlights->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ob-arr-location">
                                                {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails->flightInformation->location[1]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-2 col-md-3 col-sm-3 mt-3">
                                            @foreach ($roundtripOutboundsRecommendation as $recommendation)
                                                @php
                                                                           (is_array($recommendation->segmentFlightRef) == true) ? $segmentFlightRefs =
                                                $recommendation->segmentFlightRef : $segmentFlightRefs =
                                                [$recommendation->segmentFlightRef];
                                                @endphp

                                                @foreach ($segmentFlightRefs as $segmentFlightRef)
                                                    @if ($segmentFlightRef->referencingDetail[0]->refNumber == $outBoundFlights->propFlightGrDetail->flightProposal[0]->ref)
                                                        @php
                                                            
                                                            $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                            $baggRef = $baggRefArray[0]->refNumber;
                                                            
                                                            is_array($recommendation->paxFareProduct) == true ? ($paxFareProduct = $recommendation->paxFareProduct[0]) : ($paxFareProduct = $recommendation->paxFareProduct);
                                                            is_array($paxFareProduct->fare) ? ($fareDetailsRule = $paxFareProduct->fare) : ($fareDetailsRule = [$paxFareProduct->fare]);
                                                            
                                                            is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                            
                                                            $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                            
                                                            $outbound_nonstop_bookingClass = $paxFareProduct->fareDetails->groupOfFares->productInformation->cabinProduct->rbd;
                                                            
                                                            $outbound_nonstop_fareBasis = $paxFareProduct->fareDetails->groupOfFares->productInformation->fareProductDetail->fareBasis;
                                                        @endphp
                                                        @if($isAgent)
                                                        <span class="fontsize-22 ob-fare" data-price1="{{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}"> {!! $currency_symbol !!}}
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}
                                                        @else
                                                        <span class="fontsize-22 ob-fare" data-price1="{{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}"> <i class="fa fa-inr"></i>
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}
                                                        @endif
                                                            @php
                                                                $totalFareAmount = $paxFareProduct->paxFareDetail->totalFareAmount;
                                                                $totalTaxAmount = $paxFareProduct->paxFareDetail->totalTaxAmount;
                                                            @endphp
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </div>
                                        <div class="col-1 col-md-1 col-sm-1 mt-3">
                                            <input type="radio" class="form-check-input" id="input_box1" name="outbound-flights"
                                                value="{{ $outBoundkey }}">
                                        </div>
                                        <div class="ob-form-data">

                                            <input type="hidden" name="dom_outbound_nonstop" value="dom_outbound_nonstop">

                                            <input type="hidden" name="outbound_nonstop_arrivalingTime"
                                                value="{{ $outBoundFlights->propFlightGrDetail->flightProposal[1]->ref }}">

                                            <input type="hidden" name="outbound_nonstop_bookingClass"
                                                value="{{ $outbound_nonstop_bookingClass }}">

                                            <input type="hidden" name="outbound_nonstop_fareBasis"
                                                value="{{ $outbound_nonstop_fareBasis }}">

                                            <input type="hidden" value="" name="dom_outbound_nonstop">


                                            <input type="hidden" name="outbound_nonstop_departure"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->location[0]->locationId }}">
                                            <input type="hidden" name="outbound_nonstop_arrival"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->location[1]->locationId }}">
                                            <input type="hidden" name="outbound_nonstop_departureDate"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->productDateTime->dateOfDeparture }}">
                                            <input type="hidden" name="outbound_nonstop_arrivalDate"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->productDateTime->dateOfArrival }}">
                                            <input type="hidden" name="outbound_nonstop_marketingCompany"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->companyId->marketingCarrier }}">
                                            <input type="hidden" name="outbound_nonstop_operatingCompany"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="outbound_nonstop_flightNumber"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->flightOrtrainNumber }}">

                                            <input type="hidden" name="outbound_nonstop_departureTime"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->productDateTime->timeOfDeparture }}">
                                            <input type="hidden" name="outbound_nonstop_arrivalTime"
                                                value="{{ $outBoundFlights->flightDetails->flightInformation->productDateTime->timeOfArrival }}">

                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-md-6">
                                               {{-- <span class="onewflydetbtn {{ $farerule }}"> {{ $farerule }} </span> --}}
                                            </div>
                                            <div class="col-6 col-md-6 col-md-6">
                                                <span data-toggle="collapse"
                                                    data-target="#outbound-details{{ $outBoundkey }}"
                                                    class="onewflydetbtn" style="float: right;">Flight
                                                    Details</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="outbound-details{{ $outBoundkey }}" class="collapse">
                                        <div class="container">
                                            <ul class="nav nav-tabs w-100">
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px active" data-toggle="tab"
                                                        href="#outbound-flight-Information{{ $outBoundkey }}"> Flight
                                                        Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Details{{ $outBoundkey }}"> Fare
                                                        Details </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Baggage{{ $outBoundkey }}">
                                                        Baggage Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#outbound-flight-Cancellation{{ $outBoundkey }}">
                                                        Cancellation Rules </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane container active"
                                                    id="outbound-flight-Information{{ $outBoundkey }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $outBoundFlights->flightDetails->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $outBoundFlights->flightDetails->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($outBoundFlights->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails->flightInformation->flightOrtrainNumber }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails->flightInformation->location[0]->locationId) . '(' . $outBoundFlights->flightDetails->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($outBoundFlights->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($outBoundFlights->flightDetails->flightInformation->location[1]->locationId) . '(' . $outBoundFlights->flightDetails->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($outBoundFlights->flightDetails->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="outbound-flight-Details{{ $outBoundkey }}">

                                                    <div>
                                                        <span class="text-left"> Fare Rules :</span>
                                                        <span class="text-right onewflydetbtn {{ $farerule }}"> {{ $farerule }} </span>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td class="onwfnt-11">1 x Adult</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total Tax +</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalTaxAmount +  $Charge }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}}
                                                                    {{ $totalFareAmount }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="outbound-flight-Baggage{{ $outBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Airline</th>
                                                                <th>Check-in Baggage</th>
                                                                <th>Cabin Baggage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $outBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $outBoundFlights->flightDetails->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp
                                                                : $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripOutbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $outBoundServiceBagAllowanceGrp =
                                                                        $roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $outBoundServiceBagAllowanceGrp =
                                                                        [$roundtripOutbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($outBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                                                    id="outbound-flight-Cancellation{{ $outBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td> <b>Time Frame to Reissue</b>
                                                                    <div class="onwfnt-11">(Before scheduled departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!}} 500</td>
                                                            </tr>

                                                            <tr>
                                                                <td> <b>Time Frame to cancel</b>
                                                                    <div class="onwfnt-11">(Before scheduled departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!} 500</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                    <ul class="onwfnt-11">
                                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                            Difference if applicable + WT Fees.</li>
                                                        <li>The airline cancel reschedule fees is indicative and can be
                                                            changed without any prior notice by the airlines..</li>
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                     </div>
                        @endif
                    @endforeach
                </div>
                {{-- ///// Second Tab //// --}}
                <div class="col-sm-5 isotope-grid2" id="flightMainCard2">
                    <div class="pt-10 pb-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="row"  id="flightMainCard12">
                                    <div class="col-sm-4">
                                        <span class="prebtn prebtn12"> <i class="fa fa-arrow-circle-o-right"></i> </span>
                                       
                                    </div>

                                    <div class="col-sm-4">
                                        <span class="owstitle prebtn12">
                                            {{ $segSessionArr['city'] . '→' . $segSessionDep['city'] }} </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="owstitle prebtn12"> {{ $segments['returnDate'] }} </span>
                                    </div>
                                    <div class="col-sm-4 prebtn12">
                                        <span class="prebtn float-right"> <i class="fa fa-arrow-circle-o-left"></i>
                                        </span>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- ////////////////////////  I N B O U N D - F L I G H T S //////////////////////////////////////// --}}

                    @php
                        $InboundSessionID = $availabilityInbounds['SessionID'];
                        $InboundSegmentKey = $availabilityInbounds['Key'];
                    @endphp

                    @foreach ($availabilityInbounds['Availibilities'][0]['Availibility'] as $AvailInKey => $itinerariesInbound)
                        @if (isset($itinerariesInbound['Itineraries']['Itinerary'][0]) && isset($itinerariesInbound['Itineraries']['Itinerary'][1]) && !isset($itinerariesInbound['Itineraries']['Itinerary'][2]))

                         @php
                         
                                if( $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] == "SG"){
                                        continue;
                                }
                            array_push($airlineArr, ['code' => $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'name' => $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'stop' => '1-Stop', 'layover' => '1-Stop']);
                          @endphp

                            <div class="pb-10 airline_hide stops_hide secound-list 1-Stop {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] }}" data-price1="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">

                                <div class="boxunder">
                                    <div class="row ranjepp">
                                {{--    <div class="col-sm-2 ib-flight"> --}}
                                        <div class="col-2 col-md-2 col-sm-2 ib-flight">
                                            <img src="{{ asset('assets/images/flight/' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                alt="flight" class="imgonewayw">
                                            <div class="owstitle1">
                                                
                                                    {{  $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Name'] }}
                                            </div>
                                            <div class="owstitle">

                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                       {{-- <div class="col-sm-2 mt-3"> --}}
                                            <span class="font-18 ib-dep-time landing">
                                                {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                            <h6 class="colorgrey fontsize-14 ib-dep-location">
                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['CityName'] }}
                                            </h6>
                                        </div>
                                    {{--    <div class="col-sm-2 mt-3 ib-dur-loc"> col-3 col-md-2 col-sm-2 mt-3 ob-dur-loc ////col-sm-2 mt-3 ib-dur-loc/////  col-3 col-md-2 col-sm-2 mt-3 ob-dur-loc --}}
                                        <div class="col-3 col-md-2 col-sm-2 mt-3 ib-dur-loc">
                                            <div class="searchtitle text-center">
                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Duration'] }}
                                            </div>
                                            <div class="borderbotum"></div>
                                            <div class="searchtitle colorgrey-sm text-center">
                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] }}
                                                | 1-Stop
                                            </div>
                                        </div>
                                       <div class="col-2 col-md-2 col-sm-2 mt-3">
                                          {{-- <div class="col-sm-2 mt-3"> --}}
                                             <span class="font-18 ib-arr-time ">
                                                {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                            </span>
                                        {{--    <h6 class="colorgrey fontsize-14 ib-arr-location">  --}}
                                        <h6 class="colorgrey fontsize-14 ob-arr-location">
                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][1]['Destination']['CityName'] }}
                                            </h6>
                                        </div>
                                          {{--    <div class="col-sm-3 mt-3"> --}}
                                        @if($isAgent)
                                           <div class="col-2 col-md-3 col-sm-3 mt-3">
                                                <span class="fontsize-22 ib-fare" data-price2="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $Charge}}"> {!! $currency_symbol !!}
                                                    {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] + $Charge }}</span>
                                            </div>
                                        @else
                                           <div class="col-2 col-md-3 col-sm-3 mt-3">
                                                <span class="fontsize-22 ib-fare" data-price2="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}"> {!! $currency_symbol !!}
                                                    {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}</span>
                                            </div>
                                        @endif
                                        {{--    <div class="col-sm-1 mt-3"> --}}
                                 <div class="col-1 col-md-1 col-sm-1 mt-3">
                                            <input type="radio" class="form-check-input" id="input_box1" name="inbound-flights"
                                                value="{{ 0 . $AvailInKey }}">
                                        </div>
                                        <div class="ib-form-data">
                                            <input type="hidden" name="dom_gl_inbound_onestop">
                                            <input type="hidden" name="InboundSessionID"
                                                value="{{ $InboundSessionID }}">
                                            <input type="hidden" name="InboundKey" value="{{ $InboundSegmentKey }}">
                                            <input type="hidden" name="InboundPricingkey"
                                                value="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['Pricingkey'] }}">
                                            <input type="hidden" name="InboundProvider"
                                                value="{{ $itinerariesInbound['Provider'] }}">
                                            <input type="hidden" name="InboundResultIndex"
                                                value="{{ $itinerariesInbound['ItemNo'] }}">
                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                               {{-- <span class="onewflydetbtn {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">
                                                     {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                                </span> --}}
                                            </div>
                                            <div class="col-md-6">
                                                <span data-toggle="collapse"
                                                    data-target="#flight-inbound-details1{{ 0 . $AvailInKey }}" class="onewflydetbtn" style="float: right;">Flight Details <i class="fa fa-regular fa-angle-down"></i></span>
                                            </div>
                                        </div>
                                        <div id="flight-inbound-details1{{ 0 . $AvailInKey }}" class="collapse">
                                            <div class="container">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab"
                                                            href="#inbound-Information1{{ 0 . $AvailInKey }}"> Flight
                                                            Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#inbound-Details1{{ 0 . $AvailInKey }}"> Fare
                                                            Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#inbound-Baggage1{{ 0 . $AvailInKey }}">
                                                            Baggage Information </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#inbound-Cancellation1{{ 0 . $AvailInKey }}">
                                                            Cancellation Rules </a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane container active"
                                                        id="inbound-Information1{{ 0 . $AvailInKey }}">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . '->' . $itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                            alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['CityName'] . '(' . $itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['CityName'] . '(' . $itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="pt-10 text-center">
                                                                    <div class="owstitle">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Duration'] }}
                                                                    </div>
                                                                    <div class="flh"></div>
                                                                    <div class="owstitle">By: Air</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="pt-10">
                                                                    <span
                                                                        class="searchtitle">{{ $itinerariesInbound['Itineraries']['Itinerary'][1]['Origin']['AirportCode'] . '->' . $itinerariesInbound['Itineraries']['Itinerary'][1]['Destination']['AirportCode'] }}
                                                                    </span>
                                                                    <span
                                                                        class="onwfnt-11">{{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}</span>
                                                                    <div>
                                                                        <img src="{{ asset('assets/images/flight/' . $itinerariesInbound['Itineraries']['Itinerary'][1]['AirLine']['Code']) }}.png"
                                                                            alt="fligt">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itinerariesInbound['Itineraries']['Itinerary'][1]['AirLine']['Code'] . '-' . $itinerariesInbound['Itineraries']['Itinerary'][1]['AirLine']['Identification'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="pt-10 text-center">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][1]['Origin']['CityName'] . '(' . $itinerariesInbound['Itineraries']['Itinerary'][1]['Origin']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][1]['Origin']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="pt-10 float-right">
                                                                    <div class="searchtitle">
                                                                        {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][1]['Destination']['CityName'] . '(' . $itinerariesInbound['Itineraries']['Itinerary'][1]['Destination']['AirportCode'] . ')' }}
                                                                    </div>
                                                                    <div class="owstitle">
                                                                        {{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][1]['Destination']['DateTime']) }}
                                                                    </div>
                                                                    {{-- <div class="owstitle">Terminal - </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane container fade"
                                                        id="inbound-Details1{{ 0 . $AvailInKey }}">

                                                        <div>
                                                            <span class="text-left"> Fare Rules :</span>
                                                            <span class="text-right onewflydetbtn {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">
                                                                {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                                            </span>

                                                        </div>
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="onwfnt-11">1 Adult</td>
                                                                    <td class="text-right"> {!! $currency_symbol !!}
                                                                        {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Base Fare)</td>
                                                                    <td class="text-right"> {!! $currency_symbol !!}
                                                                        {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total Tax +</td>
                                                                    <td class="text-right"> {!! $currency_symbol !!}
                                                                        {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalTax'] +  $Charge }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                    <td class="text-right"> {!! $currency_symbol !!}
                                                                        {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="tab-pane container fade"
                                                        id="inbound-Baggage1{{ 0 . $AvailInKey }}">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Airline</th>
                                                                    <th>Check-in Baggage</th>
                                                                    <th>Cabin Baggage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <tr>
                                                                    <td> <img
                                                                            src="{{ asset('assets/images/flight/' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                            alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                                    </td>

                                                                    <td class="onwfnt-11">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <img
                                                                            src="{{ asset('assets/images/flight/' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                            alt="">
                                                                        <span
                                                                            class="onwfnt-11">{{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                    </td>
                                                                    <td class="onwfnt-11">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                                    </td>

                                                                    <td class="onwfnt-11">
                                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
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
                                                            <li>Wagnistrip does not guarantee the accuracy of cancel
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
                                                        id="inbound-Cancellation1{{ 0 . $AvailInKey }}">
                                                        <table class="table table-bordered">
                                                            <tbody>
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
                                                                    <td> {!! $currency_symbol !!} 500</td>
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
                                                                    <td> {!! $currency_symbol !!} 500</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                        <ul class="onwfnt-11">
                                                            <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                                Difference if applicable + WT Fees.</li>
                                                            <li>The airline cancel reschedule fees is indicative and can be
                                                                changed without any prior notice by the airlines..</li>
                                                            <li>Wagnistrip does not guarantee the accuracy of cancel
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

                                </div>
                            </div>

                        @elseif (isset($itinerariesInbound['Itineraries']['Itinerary'][0]) &&
                            !isset($itinerariesInbound['Itineraries']['Itinerary'][1]) &&
                            !isset($itinerariesInbound['Itineraries']['Itinerary'][2]))
                               @php
                                if( $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] == "SG"){
                                        continue;
                                }
                               array_push($airlineArr, ['code' => $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'name' => $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'], 'stop' => 'Non-Stop', 'layover' => '1-Stop']);
                              @endphp
       
                                   <div class="pb-10 airline_hide stops_hide secound-list Non-Stop {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] }}" data-price1="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">
       
                                <div class="boxunder">
                                    <div class="row ranjepp">
                                    {{--   <div class="col-sm-2 ib-flight"> --}}
                                     <div class="col-2 col-md-2 col-sm-2 ib-flight">
                                            <img src="{{ asset('assets/images/flight/' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                alt="flight" class="imgonewayw">
                                            <div class="owstitle1">
                                            
                                                        {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Name']}}
                                              
                                            </div>
                                            <div class="owstitle">

                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}
                                            </div>
                                        </div>
                                      <div class="col-2 col-md-2 col-sm-2 mt-3">
                                  {{-- <div class="col-sm-2 mt-3"> --}}
                                            <span class="font-18 ib-dep-time landing">
                                                {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                            <h6 class="colorgrey fontsize-14 ib-dep-location">
                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['CityName'] }}
                                            </h6>
                                        </div>
                                        <div class="col-3 col-md-2 col-sm-2 mt-3 ib-dur-loc">
                                            <div class="searchtitle text-center">
                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Duration'] }}
                                            </div>
                                            <div class="borderbotum"></div>
                                            <div class="searchtitle colorgrey-sm text-center">Nonstop
                                            </div>
                                        </div>
                                   <div class="col-2 col-md-2 col-sm-2 mt-3">
                            {{-- <div class="col-sm-2 mt-3"> --}}
                                            <span class="font-18 ib-arr-time ">
                                                {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ib-arr-location">
                                                {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['CityName'] }}
                                            </h6>
                                        </div>
                                    {{--    <div class="col-sm-3 mt-3"> --}}
                                    <div class="col-2 col-md-3 col-sm-3 mt-3">
                                            <span class="fontsize-22 ib-fare" data-price2="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}"> {!! $currency_symbol !!}
                                                {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}</span>
                                        </div>
                                        {{--    <div class="col-sm-1 mt-3"> --}}
                                 <div class="col-1 col-md-1 col-sm-1 mt-3">
                                            <input type="radio" class="form-check-input" id="input_box1" name="inbound-flights"
                                                value="{{ 0 . $AvailInKey }}">
                                        </div>
                                        <div class="ib-form-data">
                                            <input type="hidden" name="dom_gl_inbound_nonstop">
                                            <input type="hidden" name="InboundSessionID"
                                                value="{{ $InboundSessionID }}">
                                            <input type="hidden" name="InboundKey" value="{{ $InboundSegmentKey }}">
                                            <input type="hidden" name="InboundPricingkey"
                                                value="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['Pricingkey'] }}">
                                            <input type="hidden" name="InboundProvider"
                                                value="{{ $itinerariesInbound['Provider'] }}">
                                            <input type="hidden" name="InboundResultIndex"
                                                value="{{ $itinerariesInbound['ItemNo'] }}">
                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                              {{--  <span
                                                    class="onewflydetbtn {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}</span> --}}
                                            </div>
                                            <div class="col-md-6">
                                                <span data-toggle="collapse"
                                                    data-target="#flight-inbound-details1{{ 0 . $AvailInKey }}"
                                                    class="onewflydetbtn" style="float: right;">Flight
                                                    Details</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="flight-inbound-details1{{ 0 . $AvailInKey }}" class="collapse">
                                        <div class="container">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab"
                                                        href="#inbound-Information1{{ 0 . $AvailInKey }}"> Flight
                                                        Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                        href="#inbound-Details1{{ 0 . $AvailInKey }}"> Fare
                                                        Details </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                        href="#inbound-Baggage1{{ 0 . $AvailInKey }}">
                                                        Baggage Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                        href="#inbound-Cancellation1{{ 0 . $AvailInKey }}">
                                                        Cancellation Rules </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane container active"
                                                    id="inbound-Information1{{ 0 . $AvailInKey }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . '->' . $itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['CityName'] . '(' . $itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['AirportCode'] . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Origin']['DateTime']) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ getTimeFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['CityName'] . '(' . $itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['AirportCode'] . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDateFormat($itinerariesInbound['Itineraries']['Itinerary'][0]['Destination']['DateTime']) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-sm-12">
                                                            <div class="pt-10 text-center">
                                                                <div class="owstitle">
                                                                    {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Duration'] }}
                                                                </div>
                                                                <div class="flh"></div>
                                                                <div class="owstitle">By: Air</div>
                                                            </div>
                                                        </div> --}}

                                                    </div>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="inbound-Details1{{ 0 . $AvailInKey }}">

                                                    <div>
                                                        <span class="text-left"> Fare Rules :</span>
                                                        <span class="text-right onewflydetbtn {{ $itinerariesOutbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}">
                                                            {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['Refundable'] }}
                                                        </span>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td class="onwfnt-11">1 Adult</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total Tax +</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalTax'] +  $Charge }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="inbound-Baggage1{{ 0 . $AvailInKey }}">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Airline</th>
                                                                <th>Check-in Baggage</th>
                                                                <th>Cabin Baggage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code']) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Code'] . '-' . $itinerariesInbound['Itineraries']['Itinerary'][0]['AirLine']['Identification'] }}</span>
                                                                </td>
                                                                <td class="onwfnt-11">
                                                                    {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] != 0 ? $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckIn'] . 'KG' : $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CheckInPiece'] . 'PC' }}
                                                                </td>

                                                                <td class="onwfnt-11">
                                                                    {{ $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] != 0 ? $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['Cabin'] . 'KG' : $itinerariesInbound['Itineraries']['Itinerary'][0]['Baggage']['Allowance']['CabinPiece'] . 'PC' }}
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
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
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
                                                    id="inbound-Cancellation1{{ 0 . $AvailInKey }}">
                                                    <table class="table table-bordered">
                                                        <tbody>
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
                                                                <td> {!! $currency_symbol !!} 500</td>
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
                                                                <td> {!! $currency_symbol !!} 500</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                    <ul class="onwfnt-11">
                                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                            Difference if applicable + WT Fees.</li>
                                                        <li>The airline cancel reschedule fees is indicative and can be
                                                            changed without any prior notice by the airlines..</li>
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
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
                            </div>
                        @endif
                    @endforeach

                    {{-- ///////////////////////////////////////////////   A M A D E U S     S E R V I E S     P R O V I D E R ////////////////////////////// --}}

                    <?php
                    if(isset($roundtripInbounds->response)){
                        (is_array($roundtripInbounds->response->recommendation) == true) ? $roundtripInboundsRecommendation = $roundtripInbounds->response->recommendation :
                        $roundtripInboundsRecommendation = [$roundtripInbounds->response->recommendation];
                        (is_array($roundtripInbounds->response->flightIndex->groupOfFlights) == true) ? $roundtripInboundsGroupOfFlights
                        = $roundtripInbounds->response->flightIndex->groupOfFlights : $roundtripInboundsGroupOfFlights =
                        [$roundtripInbounds->response->flightIndex->groupOfFlights];
                    }else{
                        $roundtripInboundsGroupOfFlights = [];
                    }
                    ?>

                    @foreach ($roundtripInboundsGroupOfFlights as $inBoundkey => $inBoundFlights)
                        @if (is_array($inBoundFlights->flightDetails) == true && isset($inBoundFlights->flightDetails[6]) && !isset($inBoundFlights->flightDetails[7]))
                        @elseif (is_array($inBoundFlights->flightDetails) == true &&
                            isset($inBoundFlights->flightDetails[5]) && !isset($inBoundFlights->flightDetails[6]))
                        @elseif (is_array($inBoundFlights->flightDetails) == true &&
                            isset($inBoundFlights->flightDetails[4]) && !isset($inBoundFlights->flightDetails[5]))
                        @elseif (is_array($inBoundFlights->flightDetails) == true &&
                            isset($inBoundFlights->flightDetails[3]) && !isset($inBoundFlights->flightDetails[4]))
                        @elseif (is_array($inBoundFlights->flightDetails) == true &&
                            isset($inBoundFlights->flightDetails[2]) && !isset($inBoundFlights->flightDetails[3]))
                                @php
                                
                                if( $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier == "SG"){
                                        continue;
                                }
                                array_push($airlineArr, ['code' => $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'name' => $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'stop' => '2-Stop', 'layover' => '1-Stop']);
                               @endphp
        
                            <div class="pb-10 airline_hide stops_hide secound-list 2-Stop {{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}" data-price1="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">
        
                                <div class="boxunder">
                                    <div class="row ranjepp">
                                {{-- <div class="col-sm-2 ib-flight"> --}}
                                 <div class="col-2 col-md-2 col-sm-2 ib-flight">
                                            <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                alt="flight" class="imgonewayw">
                                                
                                                         {{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}
                                            <div class="owstitle">
                                                {{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                            {{-- <div class="col-sm-2 mt-3"> --}}
                                            <span class="font-18 ib-dep-time landing">
                                                {{ substr_replace($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ib-dep-location">
                                                {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-3 col-md-2 col-sm-2 mt-3 ib-dur-loc">
                                            <div class="searchtitle text-center">
                                                {{ substr_replace(substr_replace($inBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                            </div>
                                            <div class="borderbotum"></div>
                                            <div class="searchtitle colorgrey-sm text-center">
                                                {{ $inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId . '-' . $inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                | 2-Stop</div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                            {{-- <div class="col-sm-2 mt-3"> --}}
                                            <span class="font-18 ib-arr-time ">
                                                {{ substr_replace($inBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ib-arr-location">
                                                {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId) }}
                                            </h6>
                                        </div>
                                         {{--    <div class="col-sm-3 mt-3"> --}}
                                      <div class="col-2 col-md-3 col-sm-3 mt-3">
                                            @foreach ($roundtripInboundsRecommendation as $recommendation)
                                                @php
                                                                           (is_array($recommendation->segmentFlightRef) == true) ? $segmentFlightRefs =
                                                $recommendation->segmentFlightRef : $segmentFlightRefs =
                                                [$recommendation->segmentFlightRef];
                                                @endphp
                                                @foreach ($segmentFlightRefs as $segmentFlightRef)
                                                    @if ($segmentFlightRef->referencingDetail[0]->refNumber == $inBoundFlights->propFlightGrDetail->flightProposal[0]->ref)
                                                        @php
                                                            
                                                            $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                            $baggRef = $baggRefArray[0]->refNumber;
                                                            
                                                            is_array($recommendation->paxFareProduct) == true ? ($paxFareProduct = $recommendation->paxFareProduct[0]) : ($paxFareProduct = $recommendation->paxFareProduct);
                                                            
                                                            is_array($paxFareProduct->fare) ? ($fareDetailsRule = $paxFareProduct->fare) : ($fareDetailsRule = [$paxFareProduct->fare]);
                                                            
                                                            is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                            
                                                            $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                            
                                                            $inbound_twostop_bookingClass_1 = $paxFareProduct->fareDetails->groupOfFares[0]->productInformation->cabinProduct->rbd;
                                                            
                                                            $inbound_twostop_bookingClass_2 = $paxFareProduct->fareDetails->groupOfFares[1]->productInformation->cabinProduct->rbd;
                                                            
                                                            $inbound_twostop_bookingClass_3 = $paxFareProduct->fareDetails->groupOfFares[2]->productInformation->cabinProduct->rbd;
                                                            
                                                            $inbound_twostop_fareBasis_1 = $paxFareProduct->fareDetails->groupOfFares[0]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                            $inbound_twostop_fareBasis_2 = $paxFareProduct->fareDetails->groupOfFares[1]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                            $inbound_twostop_fareBasis_3 = $paxFareProduct->fareDetails->groupOfFares[2]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                        @endphp
                                                        @if($isAgent)
                                                        <span class="fontsize-22 ib-fare" data-price2="{{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}"> {!! $currency_symbol !!}
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge  }}
                                                        @else
                                                        <span class="fontsize-22 ib-fare" data-price2="{{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}"> {!! $currency_symbol !!}
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount}}
                                                        @endif
                                                            @php
                                                                $totalFareAmount = $paxFareProduct->paxFareDetail->totalFareAmount;
                                                                $totalTaxAmount = $paxFareProduct->paxFareDetail->totalTaxAmount;
                                                            @endphp
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </div>
                                        {{--    <div class="col-sm-1 mt-3"> --}}
                                 <div class="col-1 col-md-1 col-sm-1 mt-3">
                                            <input type="radio" class="form-check-input" id="input_box1" name="inbound-flights"
                                                value="{{ $inBoundkey }}">
                                        </div>
                                        <div class="ib-form-data">

                                            <input type="hidden" name="dom_inbound_twostop" value="dom_inbound_twostop">

                                            <input type="hidden" name="inbound_twostop_arrivalingTime"
                                                value="{{ $inBoundFlights->propFlightGrDetail->flightProposal[1]->ref }}">

                                            <input type="hidden" name="inbound_twostop_bookingClass_1"
                                                value="{{ $inbound_twostop_bookingClass_1 }}">

                                            <input type="hidden" name="inbound_twostop_bookingClass_2"
                                                value="{{ $inbound_twostop_bookingClass_2 }}">

                                            <input type="hidden" name="inbound_twostop_bookingClass_3"
                                                value="{{ $inbound_twostop_bookingClass_3 }}">

                                            <input type="hidden" name="inbound_twostop_fareBasis_1"
                                                value="{{ $inbound_twostop_fareBasis_1 }}">

                                            <input type="hidden" name="inbound_twostop_fareBasis_2"
                                                value="{{ $inbound_twostop_fareBasis_2 }}">

                                            <input type="hidden" name="inbound_twostop_fareBasis_3"
                                                value="{{ $inbound_twostop_fareBasis_3 }}">

                                            <input type="hidden" name="inbound_twostop_arrivalTime_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">

                                            <input type="hidden" name="inbound_twostop_arrivalTime_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">

                                            <input type="hidden" name="inbound_twostop_arrivalTime_3"
                                                value="{{ $inBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfArrival }}">

                                            <input type="hidden" name="inbound_twostop_departure_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="inbound_twostop_departure_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="inbound_twostop_departure_3"
                                                value="{{ $inBoundFlights->flightDetails[2]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="inbound_twostop_arrival_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="inbound_twostop_arrival_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="inbound_twostop_arrival_3"
                                                value="{{ $inBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="inbound_twostop_departureDate_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="inbound_twostop_departureDate_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="inbound_twostop_departureDate_3"
                                                value="{{ $inBoundFlights->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="inbound_twostop_departureTime_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="inbound_twostop_departureTime_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="inbound_twostop_departureTime_3"
                                                value="{{ $inBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="inbound_twostop_marketingCompany_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">

                                            <input type="hidden" name="inbound_twostop_marketingCompany_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">

                                            <input type="hidden" name="inbound_twostop_marketingCompany_3"
                                                value="{{ $inBoundFlights->flightDetails[2]->flightInformation->companyId->marketingCarrier }}">

                                            <input type="hidden" name="inbound_twostop_operatingCompany_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="inbound_twostop_operatingCompany_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="inbound_twostop_operatingCompany_3"
                                                value="{{ $inBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="inbound_twostop_flightNumber_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}">

                                            <input type="hidden" name="inbound_twostop_flightNumber_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}">

                                            <input type="hidden" name="inbound_twostop_flightNumber_3"
                                                value="{{ $inBoundFlights->flightDetails[2]->flightInformation->flightOrtrainNumber }}">

                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                              {{--  <span class="onewflydetbtn {{ $farerule }}">{{ $farerule }}</span> --}}
                                            </div>
                                            <div class="col-md-6">
                                                <span data-toggle="collapse"
                                                    data-target="#inbound-details{{ $inBoundkey }}"
                                                    class="onewflydetbtn" style="float: right;">Flight
                                                    Details</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="inbound-details{{ $inBoundkey }}" class="collapse">
                                        <div class="container">
                                            <ul class="nav nav-tabs w-100">
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px active" data-toggle="tab"
                                                        href="#inbound-flight-Information{{ $inBoundkey }}"> Flight
                                                        Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Details{{ $inBoundkey }}"> Fare
                                                        Details </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Baggage{{ $inBoundkey }}">
                                                        Baggage Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Cancellation{{ $inBoundkey }}">
                                                        Cancellation Rules </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane container active"
                                                    id="inbound-flight-Information{{ $inBoundkey }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId) . '(' . $inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId) . '(' . $inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="pt-10 text-center">
                                                                <div class="owstitle">
                                                                    {{ substr_replace(substr_replace($inBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                </div>
                                                                <div class="flh"></div>
                                                                {{-- <div class="owstitle">By: Air</div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $inBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId) . '(' . $inBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId) . '(' . $inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="pt-10 text-center">
                                                                <div class="owstitle">
                                                                    {{ substr_replace(substr_replace($inBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                </div>
                                                                <div class="flh"></div>
                                                                {{-- <div class="owstitle">By: Air</div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $inBoundFlights->flightDetails[2]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $inBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($inBoundFlights->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[2]->flightInformation->flightOrtrainNumber }}</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[2]->flightInformation->location[0]->locationId) . '(' . $inBoundFlights->flightDetails[2]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[2]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[2]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId) . '(' . $inBoundFlights->flightDetails[2]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[2]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="inbound-flight-Details{{ $inBoundkey }}">

                                                    <div>
                                                        <span class="text-left"> Fare Rules :</span>
                                                        <span class="text-right onewflydetbtn {{ $farerule }}"> {{ $farerule }} </span>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td class="onwfnt-11">1 x Adult</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total Tax +</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalTaxAmount +  $Charge }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="inbound-flight-Baggage{{ $inBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Airline</th>
                                                                <th>Check-in Baggage</th>
                                                                <th>Cabin Baggage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $inBoundServiceBagAllowanceGrp =
                                                                        $roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $inBoundServiceBagAllowanceGrp =
                                                                        [$roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($inBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                        
                                                                            @if (isset($serviceCoverage->serviceCovInfoGrp->refInfo))
                                                                                @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                                            @endif
                                                                            
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                                <td class="onwfnt-11">7KG</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $inBoundServiceBagAllowanceGrp =
                                                                        $roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $inBoundServiceBagAllowanceGrp =
                                                                        [$roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($inBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                        @if (isset($serviceCoverage->serviceCovInfoGrp->refInfo))
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                                        @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                                <td class="onwfnt-11">7KG</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[2]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[2]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $inBoundServiceBagAllowanceGrp =
                                                                        $roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $inBoundServiceBagAllowanceGrp =
                                                                        [$roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($inBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                        @if (isset($serviceCoverage->serviceCovInfoGrp->refInfo))
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                                        @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
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
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                                                    id="inbound-flight-Cancellation{{ $inBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td> <b>Time Frame to Reissue</b>
                                                                    <div class="onwfnt-11">(Before scheduled
                                                                        departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!} 500</td>
                                                            </tr>

                                                            <tr>
                                                                <td> <b>Time Frame to cancel</b>
                                                                    <div class="onwfnt-11">(Before scheduled
                                                                        departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!} 500</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                    <ul class="onwfnt-11">
                                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                            Difference if applicable + WT Fees.</li>
                                                        <li>The airline cancel reschedule fees is indicative and can be
                                                            changed without any prior notice by the airlines..</li>
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                            </div>
                        @elseif (is_array($inBoundFlights->flightDetails) == true &&
                            isset($inBoundFlights->flightDetails[1]) && !isset($inBoundFlights->flightDetails[2]))
                               @php
                               
                                if( $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier == "SG"){
                                        continue;
                                }
                               array_push($airlineArr, ['code' => $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'name' => $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier, 'stop' => '1-Stop', 'layover' => '1-Stop']);
                              @endphp
       
                           <div class="pb-10 airline_hide stops_hide secound-list 1-Stop {{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}" data-price1="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">
       
                                <div class="boxunder">
                                    <div class="row ranjepp">
                                        <div class="col-2 cl-md-2 col-sm-2 ib-flight">
                                            <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                alt="flight" class="imgonewayw">
                                                 <div class="owstitle1">
                                                         {{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}
                                                         </div>
                                            <div class="owstitle">
                                                {{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}
                                            </div>
                                        </div>
                                        <div class="col-2 cl-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ib-dep-time landing">
                                                {{ substr_replace($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ib-dep-location">
                                                {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-3 cl-md-2 col-sm-2 mt-3 ib-dur-loc">
                                            <div class="searchtitle text-center">
                                                {{ substr_replace(substr_replace($inBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                            </div>
                                            <div class="borderbotum"></div>
                                            <div class="searchtitle colorgrey-sm text-center">
                                                {{ $inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                | 1-Stop</div>
                                        </div>
                                        <div class="col-2 cl-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ib-arr-time ">
                                                {{ substr_replace($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ib-arr-location">
                                                {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-2 cl-md-3 col-sm-3 mt-3">
                                            @foreach ($roundtripInboundsRecommendation as $recommendation)
                                                @php
                                                                           (is_array($recommendation->segmentFlightRef) == true) ? $segmentFlightRefs =
                                                $recommendation->segmentFlightRef : $segmentFlightRefs =
                                                [$recommendation->segmentFlightRef];
                                                @endphp
                                                @foreach ($segmentFlightRefs as $segmentFlightRef)
                                                    @if ($segmentFlightRef->referencingDetail[0]->refNumber == $inBoundFlights->propFlightGrDetail->flightProposal[0]->ref)
                                                        @php
                                                            
                                                            $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                            $baggRef = $baggRefArray[0]->refNumber;
                                                            
                                                            is_array($recommendation->paxFareProduct) == true ? ($paxFareProduct = $recommendation->paxFareProduct[0]) : ($paxFareProduct = $recommendation->paxFareProduct);
                                                            
                                                            is_array($paxFareProduct->fare) ? ($fareDetailsRule = $paxFareProduct->fare) : ($fareDetailsRule = [$paxFareProduct->fare]);
                                                            
                                                            is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                            
                                                            $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                            
                                                            $inbound_onestop_bookingClass_1 = $paxFareProduct->fareDetails->groupOfFares[0]->productInformation->cabinProduct->rbd;
                                                            
                                                            $inbound_onestop_bookingClass_2 = $paxFareProduct->fareDetails->groupOfFares[1]->productInformation->cabinProduct->rbd;
                                                            
                                                            $inbound_onestop_fareBasis_1 = $paxFareProduct->fareDetails->groupOfFares[0]->productInformation->fareProductDetail->fareBasis;
                                                            
                                                            $inbound_onestop_fareBasis_2 = $paxFareProduct->fareDetails->groupOfFares[1]->productInformation->fareProductDetail->fareBasis;
                                                        @endphp
                                                        @if($isAgent)
                                                        <span class="fontsize-22 ib-fare" data-price2="{{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}"> {!! $currency_symbol !!}
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}
                                                        @else
                                                        <span class="fontsize-22 ib-fare" data-price2="{{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}"> {!! $currency_symbol !!}
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}
                                                        
                                                        @endif
                                                            @php
                                                                $totalFareAmount = $paxFareProduct->paxFareDetail->totalFareAmount;
                                                                $totalTaxAmount = $paxFareProduct->paxFareDetail->totalTaxAmount;
                                                            @endphp
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </div>
                                        <div class="col-1 cl-md-1 col-sm-1 mt-3">
                                            <input type="radio" class="form-check-input" name="inbound-flights"
                                                value="{{ $inBoundkey }}">
                                        </div>
                                        <div class="ib-form-data">

                                            <input type="hidden" name="dom_inbound_onestop" value="dom_inbound_onestop">

                                            <input type="hidden" name="inbound_onestop_arrivalingTime"
                                                value="{{ $inBoundFlights->propFlightGrDetail->flightProposal[1]->ref }}">

                                            <input type="hidden" name="inbound_onestop_bookingClass_1"
                                                value="{{ $inbound_onestop_bookingClass_1 }}">

                                            <input type="hidden" name="inbound_onestop_bookingClass_2"
                                                value="{{ $inbound_onestop_bookingClass_2 }}">

                                            <input type="hidden" name="inbound_onestop_fareBasis_1"
                                                value="{{ $inbound_onestop_fareBasis_1 }}">

                                            <input type="hidden" name="inbound_onestop_fareBasis_2"
                                                value="{{ $inbound_onestop_fareBasis_2 }}">


                                            <input type="hidden" value="" name="dom_inbound_onestop">

                                            <input type="hidden" name="inbound_onestop_arrivalTime_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfArrival }}">

                                            <input type="hidden" name="inbound_onestop_arrivalTime_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival }}">
                                            <input type="hidden" name="inbound_onestop_departure_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="inbound_onestop_arrival_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="inbound_onestop_departureDate_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="inbound_onestop_departureTime_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="inbound_onestop_marketingCompany_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->marketingCarrier }}">
                                            <input type="hidden" name="inbound_onestop_operatingCompany_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="inbound_onestop_flightNumber_1"
                                                value="{{ $inBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}">

                                            <input type="hidden" name="inbound_onestop_departure_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId }}">

                                            <input type="hidden" name="inbound_onestop_arrival_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}">

                                            <input type="hidden" name="inbound_onestop_departureDate_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture }}">

                                            <input type="hidden" name="inbound_onestop_departureTime_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture }}">

                                            <input type="hidden" name="inbound_onestop_marketingCompany_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->companyId->marketingCarrier }}">

                                            <input type="hidden" name="inbound_onestop_operatingCompany_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="inbound_onestop_flightNumber_2"
                                                value="{{ $inBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}">

                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6 cl-md-6 col-md-6">
                                               {{-- <span class="onewflydetbtn {{ $farerule }}">{{ $farerule }} </span> --}}
                                            </div>
                                            <div class="col-6 cl-md-6 col-md-6">
                                                <span data-toggle="collapse"
                                                    data-target="#inbound-details{{ $inBoundkey }}"
                                                    class="onewflydetbtn" style="float: right;">Flight
                                                    Details</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="inbound-details{{ $inBoundkey }}" class="collapse">
                                        <div class="container">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px active" data-toggle="tab"
                                                        href="#inbound-flight-Information{{ $inBoundkey }}"> Flight
                                                        Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Details{{ $inBoundkey }}"> Fare
                                                        Details </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Baggage{{ $inBoundkey }}">
                                                        Baggage Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Cancellation{{ $inBoundkey }}">
                                                        Cancellation Rules </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane container active"
                                                    id="inbound-flight-Information{{ $inBoundkey }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId) . '(' . $inBoundFlights->flightDetails[0]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId) . '(' . $inBoundFlights->flightDetails[0]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[0]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="pt-10 text-center">
                                                                <div class="owstitle">
                                                                    {{ substr_replace(substr_replace($inBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                                                </div>
                                                                <div class="flh"></div>
                                                                {{-- <div class="owstitle">By: Air</div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $inBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId }}
                                                                    ->
                                                                    {{ $inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId) . '(' . $inBoundFlights->flightDetails[1]->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId) . '(' . $inBoundFlights->flightDetails[1]->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails[1]->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="inbound-flight-Details{{ $inBoundkey }}">

                                                    <div>
                                                        <span class="text-left"> Fare Rules :</span>
                                                        <span class="text-right onewflydetbtn {{ $farerule }}"> {{ $farerule }} </span>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td class="onwfnt-11">1 x Adult</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total Tax +</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalTaxAmount +  $Charge}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="inbound-flight-Baggage{{ $inBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Airline</th>
                                                                <th>Check-in Baggage</th>
                                                                <th>Cabin Baggage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[0]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[0]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $inBoundServiceBagAllowanceGrp =
                                                                        $roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $inBoundServiceBagAllowanceGrp =
                                                                        [$roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp

                                                                        @foreach ($inBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                                <td class="onwfnt-11">7KG</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails[1]->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails[1]->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $inBoundServiceBagAllowanceGrp =
                                                                        $roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $inBoundServiceBagAllowanceGrp =
                                                                        [$roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($inBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)

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
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                                                    id="inbound-flight-Cancellation{{ $inBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td> <b>Time Frame to Reissue</b>
                                                                    <div class="onwfnt-11">(Before scheduled
                                                                        departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!} 500</td>
                                                            </tr>

                                                            <tr>
                                                                <td> <b>Time Frame to cancel</b>
                                                                    <div class="onwfnt-11">(Before scheduled
                                                                        departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!} 500</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                    <ul class="onwfnt-11">
                                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                            Difference if applicable + WT Fees.</li>
                                                        <li>The airline cancel reschedule fees is indicative and can be
                                                            changed without any prior notice by the airlines..</li>
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                            </div>
                        @else
                          @php
                          
                                if( $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier == "SG"){
                                        continue;
                                }
                          array_push($airlineArr, ['code' => $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier, 'name' => $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier, 'stop' => 'Non-Stop', 'layover' => '1-Stop']);
                          @endphp

                            <div class="pb-10 airline_hide stops_hide secound-list Non-Stop {{ $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier }}" data-price1="{{ $itinerariesInbound['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalFare'] }}">

                                <div class="boxunder">
                                    <div class="row ranjepp">
                                        <div class="col-2 col-md-2 col-sm-2 ib-flight">
                                            <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                alt="flight" class="imgonewayw">
                                                <div class="owstitle1">
                                                         {{ $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier }}
                                                         </div>
                                            <div class="owstitle">
                                                {{ $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails->flightInformation->flightOrtrainNumber }}
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ib-dep-time landing">
                                                {{ substr_replace($inBoundFlights->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}</span>
                                            <h6 class="colorgrey fontsize-14 ib-dep-location">
                                                {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails->flightInformation->location[0]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-3 col-md-2 col-sm-2 mt-3 ib-dur-loc">
                                            <div class="searchtitle text-center">
                                                {{ substr_replace(substr_replace($inBoundFlights->propFlightGrDetail->flightProposal[1]->ref, 'h ', 2, 0), 'm', 6, 0) }}
                                            </div>
                                            <div class="borderbotum"></div>
                                            <div class="searchtitle colorgrey-sm text-center">Nonstop
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-2 mt-3">
                                            <span class="font-18 ib-arr-time ">
                                                {{ substr_replace($inBoundFlights->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                            </span>
                                            <h6 class="colorgrey fontsize-14 ib-arr-location">
                                                {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails->flightInformation->location[1]->locationId) }}
                                            </h6>
                                        </div>
                                        <div class="col-2 col-md-2 col-sm-3 mt-3">
                                            @foreach ($roundtripInboundsRecommendation as $recommendation)
                                                @php
                                                                           (is_array($recommendation->segmentFlightRef) == true) ? $segmentFlightRefs =
                                                $recommendation->segmentFlightRef : $segmentFlightRefs =
                                                [$recommendation->segmentFlightRef];
                                                @endphp

                                                @foreach ($segmentFlightRefs as $segmentFlightRef)
                                                    @if ($segmentFlightRef->referencingDetail[0]->refNumber == $inBoundFlights->propFlightGrDetail->flightProposal[0]->ref)
                                                        @php
                                                            
                                                            $baggRefArray = array_reverse($segmentFlightRef->referencingDetail);
                                                            $baggRef = $baggRefArray[0]->refNumber;
                                                            
                                                            is_array($recommendation->paxFareProduct) == true ? ($paxFareProduct = $recommendation->paxFareProduct[0]) : ($paxFareProduct = $recommendation->paxFareProduct);
                                                            
                                                            is_array($paxFareProduct->fare) ? ($fareDetailsRule = $paxFareProduct->fare) : ($fareDetailsRule = [$paxFareProduct->fare]);
                                                            
                                                            is_array($fareDetailsRule[0]->pricingMessage->description) ? ($farerule = 'NON-REFUNDABLE') : ($farerule = $fareDetailsRule[0]->pricingMessage->description);
                                                            
                                                            $farerule == 'PENALTY APPLIES' ? ($farerule = 'REFUNDABLE') : ($farerule = 'NON-REFUNDABLE');
                                                            
                                                            $inbound_nonstop_bookingClass = $paxFareProduct->fareDetails->groupOfFares->productInformation->cabinProduct->rbd;
                                                            
                                                            $inbound_nonstop_fareBasis = $paxFareProduct->fareDetails->groupOfFares->productInformation->fareProductDetail->fareBasis;
                                                            
                                                        @endphp
                                                        @if($isAgent)
                                                        <span class="fontsize-22 ib-fare" data-price2="{{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}"> {!! $currency_symbol !!}                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount + $Charge }}
                                                        @else
                                                        <span class="fontsize-22 ib-fare" data-price2="{{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}"> <i
                                                                class="fa fa-inr"></i>
                                                            {{ $paxFareProduct->paxFareDetail->totalFareAmount - $paxFareProduct->paxFareDetail->totalTaxAmount }}
                                                        @endif
                                                            @php
                                                                $totalFareAmount = $paxFareProduct->paxFareDetail->totalFareAmount;
                                                                $totalTaxAmount = $paxFareProduct->paxFareDetail->totalTaxAmount;
                                                            @endphp
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </div>
                                        <div class="col-1 col-md-1 col-sm-1 mt-3">
                                            <input type="radio" class="form-check-input" id="input_box1" name="inbound-flights"
                                                value="{{ $inBoundkey }}">
                                        </div>

                                        <div class="ib-form-data">

                                            <input type="hidden" name="dom_inbound_nonstop" value="dom_inbound_nonstop">

                                            <input type="hidden" name="inbound_nonstop_arrivalingTime"
                                                value="{{ $inBoundFlights->propFlightGrDetail->flightProposal[1]->ref }}">

                                            <input type="hidden" name="inbound_nonstop_bookingClass"
                                                value="{{ $inbound_nonstop_bookingClass }}">

                                            <input type="hidden" name="inbound_nonstop_fareBasis"
                                                value="{{ $inbound_nonstop_fareBasis }}">

                                            <input type="hidden" value="" name="dom_inbound_nonstop">

                                            <input type="hidden" name="inbound_nonstop_departure"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->location[0]->locationId }}">
                                            <input type="hidden" name="inbound_nonstop_arrival"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->location[1]->locationId }}">
                                            <input type="hidden" name="inbound_nonstop_departureDate"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->productDateTime->dateOfDeparture }}">
                                            <input type="hidden" name="inbound_nonstop_arrivalDate"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->productDateTime->dateOfArrival }}">
                                            <input type="hidden" name="inbound_nonstop_marketingCompany"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->companyId->marketingCarrier }}">
                                            <input type="hidden" name="inbound_nonstop_operatingCompany"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier }}">

                                            <input type="hidden" name="inbound_nonstop_flightNumber"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->flightOrtrainNumber }}">

                                            <input type="hidden" name="inbound_nonstop_departureTime"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->productDateTime->timeOfDeparture }}">
                                            <input type="hidden" name="inbound_nonstop_arrivalTime"
                                                value="{{ $inBoundFlights->flightDetails->flightInformation->productDateTime->timeOfArrival }}">

                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-md-6">
                                               {{-- <span class="onewflydetbtn {{ $farerule }}">{{ $farerule }} </span> --}}
                                            </div>
                                            <div class="col-6 col-md-6 col-md-6">
                                                <span data-toggle="collapse"
                                                    data-target="#inbound-details{{ $inBoundkey }}"
                                                    class="onewflydetbtn" style="float: right;">Flight
                                                    Details</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="inbound-details{{ $inBoundkey }}" class="collapse">
                                        <div class="container">
                                            <ul class="nav nav-tabs w-100">
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px active" data-toggle="tab"
                                                        href="#inbound-flight-Information{{ $inBoundkey }}"> Flight
                                                        Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Details{{ $inBoundkey }}"> Fare
                                                        Details </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Baggage{{ $inBoundkey }}">
                                                        Baggage Information </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link wth-125px" data-toggle="tab"
                                                        href="#inbound-flight-Cancellation{{ $inBoundkey }}">
                                                        Cancellation Rules </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane container active"
                                                    id="inbound-flight-Information{{ $inBoundkey }}">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="pt-10">
                                                                <span
                                                                    class="searchtitle">{{ $inBoundFlights->flightDetails->flightInformation->location[0]->locationId . '->' . $inBoundFlights->flightDetails->flightInformation->location[1]->locationId }}
                                                                </span>
                                                                <span
                                                                    class="onwfnt-11">{{ getDate_fn($inBoundFlights->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}</span>
                                                                <div>
                                                                    <img src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="fligt">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails->flightInformation->flightOrtrainNumber }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="pt-10 text-center">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails->flightInformation->productDateTime->timeOfDeparture, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails->flightInformation->location[0]->locationId) . '(' . $inBoundFlights->flightDetails->flightInformation->location[0]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails->flightInformation->productDateTime->dateOfDeparture) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="pt-10 float-right">
                                                                <div class="searchtitle">
                                                                    {{ substr_replace($inBoundFlights->flightDetails->flightInformation->productDateTime->timeOfArrival, ':', 2, 0) }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ AirportiatacodesController::getCity($inBoundFlights->flightDetails->flightInformation->location[1]->locationId) . '(' . $inBoundFlights->flightDetails->flightInformation->location[1]->locationId . ')' }}
                                                                </div>
                                                                <div class="owstitle">
                                                                    {{ getDate_fn($inBoundFlights->flightDetails->flightInformation->productDateTime->dateOfArrival) }}
                                                                </div>
                                                                {{-- <div class="owstitle">Terminal - </div> --}}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="inbound-flight-Details{{ $inBoundkey }}">

                                                    <div>
                                                        <span class="text-left"> Fare Rules :</span>
                                                        <span class="text-right onewflydetbtn {{ $farerule }}"> {{ $farerule }} </span>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td class="onwfnt-11">1 x Adult</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Base Fare)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount - $totalTaxAmount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total Tax +</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalTaxAmount +  $Charge }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="onwfnt-11">Total (Fee & Surcharge)</td>
                                                                <td class="text-right"> {!! $currency_symbol !!}
                                                                    {{ $totalFareAmount }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane container fade"
                                                    id="inbound-flight-Baggage{{ $inBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Airline</th>
                                                                <th>Check-in Baggage</th>
                                                                <th>Cabin Baggage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td> <img
                                                                        src="{{ asset('assets/images/flight/' . $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier) }}.png"
                                                                        alt="">
                                                                    <span
                                                                        class="onwfnt-11">{{ $inBoundFlights->flightDetails->flightInformation->companyId->operatingCarrier . '-' . $inBoundFlights->flightDetails->flightInformation->flightOrtrainNumber }}</span>
                                                                </td>
                                                                @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp) == true) ?
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                $roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp :
                                                                $onewaysServiceFeesCoverageInfoGrp =
                                                                [$roundtripInbounds->response->serviceFeesGrp->serviceCoverageInfoGrp];
                                                                @endphp
                                                                @foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage)

                                                                    @if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number)
                                                                        @php
                                                                           (is_array($roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp) == true) ?
                                                                        $inBoundServiceBagAllowanceGrp =
                                                                        $roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp
                                                                        : $inBoundServiceBagAllowanceGrp =
                                                                        [$roundtripInbounds->response->serviceFeesGrp->freeBagAllowanceGrp];
                                                                        @endphp
                                                                        @foreach ($inBoundServiceBagAllowanceGrp as $freeBagAllowance)
                                                                            @if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number)
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
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                                                    id="inbound-flight-Cancellation{{ $inBoundkey }}">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td> <b>Time Frame to Reissue</b>
                                                                    <div class="onwfnt-11">(Before scheduled
                                                                        departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!} 500</td>
                                                            </tr>

                                                            <tr>
                                                                <td> <b>Time Frame to cancel</b>
                                                                    <div class="onwfnt-11">(Before scheduled
                                                                        departure
                                                                        time)
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
                                                                <td> {!! $currency_symbol !!} 500</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="onwfnt-11 font-weight-bold">Terms & Conditions</span>
                                                    <ul class="onwfnt-11">
                                                        <li>Total Rescheduling Charges Airlines Rescheduling fees Fare
                                                            Difference if applicable + WT Fees.</li>
                                                        <li>The airline cancel reschedule fees is indicative and can be
                                                            changed without any prior notice by the airlines..</li>
                                                        <li>Wagnistrip does not guarantee the accuracy of cancel
                                                            reschedule
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
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </section>
    </div>
    <!-- DESKTOP VIEW END -->
    <!-- FLIGHT MOBILE VIEW START -->
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
    <!-- FLIGHT MOBILE VIEW END -->

    <div class="fixfooter">
        <div class="container">
            <form id="form-selected-segment" action="{{ route('flight-review') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-10 col-sm-5 out-bound-data"></div>
                    <div class="col-10 col-sm-5 in-bound-data"></div>
                    <input type="hidden" name="noOfAdults" value="{{ $travellers['noOfAdults'] }}">
                    <input type="hidden" name="noOfChilds" value="{{ $travellers['noOfChilds'] }}">
                    <input type="hidden" name="noOfInfants" value="{{ $travellers['noOfInfants'] }}">
                    <div class="col-2 col-md-2 col-sm-2 roundtripbookbtn">
                        <div class="onwfnt-16 total-fare"> </div>
                        <a type="submit" id="form-submit-btn" class="mt-3 btn btn-sm btn-info responsivebtnbook"> Book Now </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/range.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sliderstyle/custom.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
    <script src="{{ asset('assets/js/domestic-roundtrip.js') }}"></script>
@stop

@section('script')
    {{-- <script src="{{ asset('assets/js/range.js') }}"></script> --}}
    <script>
       $(document).ready(function () {
           
 /////// API Data code By Neelesh //////  

   
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

  ///////  End  Code By Neelesh ////// 
  

           
        $('#form-submit-btn').on('click', function () {
     
        $('#form-selected-segment').submit();
      });
      
      
  let airlineDataArr = {!! json_encode($airlineArr, true)!!};
        

    let airlineKey = 'code';

    let airlineStopKey = 'stop';

    // let airlineLayoverKey = 'layover';

    airlineFileterArr = [...new Map(airlineDataArr.map(item => [item[airlineKey], item])).values()];

    airlineStopArr = [...new Map(airlineDataArr.map(item => [item[airlineStopKey], item])).values()];


    //////////////////////////////////Code BY Neelesh Start for showing airline and filter it///////////////////
const deskiata = {
    "AI":"Air India","IndiGo":"IndiGo","B3":"Bhutan Airlines","6E":"IndiGo","SG":"SpiceJet","UK":"Vistara","G8":"GoAir","I5":"AirAsia India","IX":"Air India Express","9I":"Alliance","2T":"TruJet","OG":"Star Air","EI":"Aer Lingus","SU":"Aeroflot","AR":"Argentinas","AM":"AeroMexico","G9":"Air Arabia","KC":"Air Astana","UU":"Air Austral","BT":"Air Baltic","HY":"Uzbekistan","AC":"Air Canada",
    "CA":"Air China","XK":"Air Corsica","UX":"Air Europa","AF":"Air France","AI":"Air India","NX":"Air Macau","KM":"Air Malta","MK":"Air Mauritius","9U":"Air Moldova","SW":"Air Namibia","NZ":"Air New Zealand","PX":"Air Niugini","JU":"Air Serbia","TN":"Air Tahiti Nui","TS":"Air Transat","NF":"Air Vanuatu","AS":"Alaska Airlines","AZ":"Alitalia","NH":"All Nippon","AA":"American Airlines","OZ":"Asiana Airlines","OS":"Austrian Airlines","AV":"Avianca","J2":"Azerbaijan Airlines","AD":"Azul Brazilian Airlines","PG":"Bangkok Airways","B2":"Belavia Belarusian Airlines","BG":"Biman Bangladesh Airlines","BA":"British Airways","SN":"Brussels Airlines","FB":"Bulgaria Air","CX":"Cathay Pacific","5J":"Cebu Pacific","CI":"China Airlines", "MU":"China Eastern Airlines","CZ":"China Southern Airlines","DE":"Condor","CM":"Copa Airlines","OU":"Croatia Airlines","OK":"Czech Airlines","DL":"Delta Air Lines","U2":"easyJet","MS":"Egypt Air","LY":"El Al Israel Airlines","EK":"Emirates Airline","ET":"Ethiopian Airlines","EY":"Etihad Airways","EW":"Eurowings","BR":"EVA Airline","FJ":"Fiji Airways","AY":"Finnair","FZ":"Flydubai","F9":"Frontier Airlines","GA":"Garuda Indonesia","ST":"Germania Fluggesellschaft","G3":"Gol Transportes Aéreos","GF":"Gulf Air","HU":"Hainan Airlines","HA":"Hawaiian Airlines","HX":"Hong Kong Airlines","IB":"Iberia","FI":"Icelandair","6E":"IndiGo","4O":"Interjet","IR":"Iran Air","JL":"Japan Airlines","9W":"Jet Airways","B6":"JetBlue Airways","KQ":"Kenya Airways","KL":"KLM Royal Dutch Airlines","KE":"Korean Air","KU":"Kuwait Airways","LA":"LATAM Airlines","LO":"LOT Polish","LH":"Lufthansa","MH":"Malaysia Airlines","OD":"Batik Air","JE":"Mango","ME":"Middle East Airlines","YM":"Montenegro Airlines","8M":"Myanmar Airways International","RA":"Nepal Airlines","DY":"Norwegian Air Shuttle","WY":"Oman Air","MM":"Peach Aviation","PR":"Philippine Airlines","DP":"Pobeda Airlines","QF":"Qantas","QR":"Qatar Airways","AT":"Royal Air Maroc","BI":"Royal Brunei Airlines","RJ":"Royal Jordanian","ES":"DHL International E.C.","MS":"Egyptair","LY":"EL AL","EK":"Emirates","OV":"Estonian Air","ET":"Ethiopian Airlines","EY":"Etihad Airways","EA":"EEuropean Air Express","QY":"European Air Transport","EW":"Eurowings","BR":"EVA Air","EF":"Far Eastern Air Transport","FX":"Federal Express","AY":"Finnair","BE":"flybe.British European","TE":"FlyLAL - Lithuanian Airlines","GA":"Garuda","GT":"GB Airways","GF":"Gulf Air","HR":"Hahn Air","HU":"Hainan Airlines","HF":"Hapag Lloyd","HJ":"Hellas Jet","DU":"Hemus Air","IB":"IBERIA Air","FI":"Icelandair","IC":"Indian Airlines","D6":"Interair","IR":"Iran Air","EP":"Iran Aseman Airlines","IA":"Iraqi Airways","6H":"Israir","JO":"JALways Co. Ltd","JL":"Japan Airlines","JU":"Jat Airways","9W":"Jet Airways","R5":"Jordan Aviation","KQ":"Kenya Airways","Y9":"Kish Air","KR":"Kitty Hawk","KL":"KLM Airline","KE":"Korean Air","KU":"Kuwait Airways","LB":"LAB","LR":"LACSA","TM":"LAM Airline","LA":"Lan Airline","4M":"Lan Argentina","UC":"Lan Chile Cargo","LP":"Lan Peru","XL":"Lan Ecuador","NG":"Lauda Air","LN":"Libyan Arab Airlines","ZE":"Lineas Aereas Azteca S.A. de C.V.","LT":"LTU Airline","LH":"Lufthansa","LH":"Lufthansa Cargo","CL":"Lufthansa CityLine","LG":"Lux airline","W5":"Mahan Air","MH":"Malaysia Airlines","MA":"MALEV","TF":"Malm Aviation","IN":"MAT -Macedonian Airlines","ME":"MEA Airline","IG":"Meridiana","MX":"Mexicana","OM":"MIAT Airline","YM":"Montenegro Airlines","CE":"Nationwide Airlines","KZ":"Nippon Cargo Airlines (NCA)","NW":"Northwest Airlines","OA":"Olympic Airlines S.A.","WY":"Oman Air","8Q":"Onur Air","PR":"PAL Airline","PF":"Palestinian Airlines","H9":"Pegasus Airlines","NI":"PGA-Portug?lia Airlines","PK":"PIA Airline","PU":"PLUNA","PW":"Precision Air","QF":"Qantas","QR":"Qatar Airways","FV":"Rossiya - Russian Airlines","AT":"Royal Air Maroc","BI":"Royal Brunei","WB":"Rwandair Express","4Z":"SA Airlink","SA":"SAA Airline","FA":"Safair","SK":"SAS Airline","BU":"SAS Braathens","XY":"Flynas ","SP":"SATA Air A?ores","SV":"Saudi Arabian","SC":"Shandong Airlines Co., Ltd.","FM":"Shanghai Airlines","ZH":"Shenzhen Airlines Co. Ltd.","SQ":"SIA Cargo","S7":"Siberia Airlines","3U":"Sichuan Airlines Co. Ltd.","MI":"Silkair","JZ":"Skyways","SN":" Brussels Airlines","IE":"Solomon Airlines","JK":"Spanair","UL":"SriLankan","SD":"Sudan Airways","PY":"Surinam Airways","LX":"SWISS","RB":"Syrianair","TA":"TACA","PZ":"Transportes airline","JJ":"Linhas Airline","TP":"Air Portugal","RO":"TAROM S.A.","SF":"Tassili ","TG":"Thai Airways","TK":"THY Airline","3V":"TNT Airways","UN":"Transaero","GE":"TransAsia Airways","TU":"Tunis Air","PS":"Ukraine International","UA":"United Airlines","5X":"UPS Airlines","US":"US Airways","LC":"Varig Log","VN":"Vietnam Airlines","VS":"Virgin Atlantic","VK":"Virgin Nigeria","XF":"Vladivostok Air","VI":"Volga-Dnepr","WF":"Wideroe","MF":"Xiamen","IY":"Yemenia","Q3":"Zambian Airways"
 };

airlineFileterArr.forEach(element => {
        airlineLoop = '<div class="padding-10 input_row12">' +
    '<span class="span_input"><input type="checkbox" class="form-check-input" value="'+ element.code+ '">'+'<img src="{{ asset('assets/images/flight/') }}/'+element.code+'.png" width="20px" height="20px" alt="">' +' '+ deskiata[element.code] + ' </span>' +
     
    '</div>';
    $('#Airline').append(airlineLoop);
    });
    


//  ENd of code Neelesh

    

    airlineStopArr.forEach(element => {
        airlineStopLoop = '<div class="input_row"><input type="checkbox" class="form-check-input" value="' + element.stop + '">' + element.stop + '</div>';

        $('#Stops .padding-10').append(airlineStopLoop);
    });


                var airlineArr = [];
                var stopsArr = [];

                $("#Airline :checkbox, #Stops :checkbox").click(function () {
                    // reset the filters
                    $(".airline_hide").show();
                    $(".stops_hide").show();
                    $(".too-many-filters").hide();
                    showMatchingCardLists();
                });
                // time sorting by vikas
                // Take-off timing filtering
                $('.take-off-timing, .landing-timing').click(function() {
                    $(this).toggleClass('activetime');
                    showMatchingCardLists();
                });

                function showMatchingCardLists() {
                    const activeTakeOffButtons = $('.take-off-timing.activetime');
                    const takeOffTimeRanges = activeTakeOffButtons.map(function() {
                        return $(this).text().toLowerCase().trim();
                    }).toArray();

                    const activeLandingButtons = $('.landing-timing.activetime');
                    const landingTimeRanges = activeLandingButtons.map(function() {
                        return $(this).text().toLowerCase().trim();
                    }).toArray();

                    const timeRanges = takeOffTimeRanges;
                    const timeRange2 = landingTimeRanges;

                    $('.isotope-grid .airline_hide').each(function() {
                        const time = $(this).find('.takeoff').text().trim();
                        $(this).toggle(timeRanges.length === 0 || timeRanges.some(function(range) {
                            return isTimeInRange(time, range);
                        }));
                    });
                    $('.isotope-grid2 .airline_hide').each(function() {
                        const time = $(this).find('.landing').text().trim();
                        $(this).toggle(timeRange2.length === 0 || timeRange2.some(function(range) {
                            return isTimeInRange(time, range);
                        }));
                    });

                    // update the airline and stops value arrays with all checked checkboxes
                    airlineArr = $("#Airline :checkbox:checked").map(function() {
                        return "." + $(this).val();
                    }).get();
                    stopsArr = $("#Stops :checkbox:checked").map(function() {
                        return "." + $(this).val();
                    }).get();

                    if (airlineArr.length > 0 && stopsArr.length > 0) {
                        var filteredCards = $(".airline_hide" + airlineArr.join(", .airline_hide") + stopsArr.join(", .stops_hide"));
                        if (filteredCards.length === 0) {
                            // if no cards match the filters, add the "too-many-filters" div
                            $(".too-many-filters").show();
                        }
                    }

                    // hide the elements that don't match the filters
                    if (airlineArr.length > 0) {
                        $(".airline_hide").not(airlineArr.join(", ")).hide();
                    }
                    if (stopsArr.length > 0) {
                        $(".stops_hide").not(stopsArr.join(", ")).hide();
                    }

                }

                function isTimeInRange(time, timeRange) {
                    const hour = parseInt(time.split(':')[0]);
                    switch (timeRange) {
                        case 'before 6 am':
                            return hour < 6;
                        case '6 am - 12 pm':
                            return hour >= 6 && hour < 12;
                        case '12 pm - 6 pm':
                            return hour >= 12 && hour < 18;
                        case 'after 6 pm':
                            return hour >= 18;
                        default:
                            return false;
                    }
                }

             $('.js-example-basic-single').select2();
         
             function togglePopup() {
                 $(".content").toggle();
             }
         
//              $('#exampleSlider').multislider({
//                  interval: 0,
//                  slideAll: false,
//                  duration: 100
//              });
            
// =========================================================
    // price range slider 1  
        // new \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        var minPrice = parseInt($('.ob-fare').first().text());
        var maxPrice = parseInt($('.ob-fare').first().text());
            $('.ob-fare').each(function() {
                var price = parseInt($(this).text());
                if (price < minPrice) minPrice = price;
                if (price > maxPrice) maxPrice = price;
            });
            $('#minprice1').val(minPrice);
            $("#slider-range").slider({
                range: false,
                min: minPrice,
                max: maxPrice,
                value: minPrice,
                slide: function(event, ui) {
                    $("#minprice1").val(ui.value);
                    filterAirlineHide(ui.value, maxPrice);
                }
            });
            $('#minprice1').on('input', function() {
                var minPrice = parseInt($('#minprice1').val());
                if (minPrice > maxPrice) {
                    var temp = minPrice;
                    minPrice = maxPrice;
                    maxPrice = temp;
                    $('#minprice1').val(minPrice);
                }
                $("#slider-range").slider("value", minPrice);
                filterAirlineHide(minPrice, maxPrice);
            });
                filterAirlineHide(parseInt($('#minprice1').val()), parseInt($('#maxprice1').val()));
            function filterAirlineHide(minPrice, maxPrice) {
                $('#flightMainCard .airline_hide').each(function() {
                    var fare = parseInt($(this).find('.ob-fare').text());
                    if (fare >= minPrice) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
            
            // slider 2 new 
            var minPrice = parseInt($('.ib-fare').first().text());
            var maxPrice = parseInt($('.ib-fare').first().text());
                $('.ib-fare').each(function() {
                    var price = parseInt($(this).text());
                    if (price < minPrice) minPrice = price;
                    if (price > maxPrice) maxPrice = price;
                });
                $('#minprice2').val(minPrice);
                $("#slider-range2").slider({
                    range: false,
                    min: minPrice,
                    max: maxPrice,
                    value: minPrice,
                    slide: function(event, ui) {
                        $("#minprice2").val(ui.value);
                        filterAirlineHides(ui.value, maxPrice);
                    }
                });
                $('#minprice2').on('input', function() {
                    var minPrice = parseInt($('#minprice2').val());
                    if (minPrice > maxPrice) {
                        var temp = minPrice;
                        minPrice = maxPrice;
                        maxPrice = temp;
                        $('#minprice2').val(minPrice);
                    }
                    $("#slider-range2").slider("value", minPrice);
                    filterAirlineHides(minPrice, maxPrice);
                });
                    filterAirlineHides(parseInt($('#minprice2').val()), parseInt($('#maxprice2').val()));
                function filterAirlineHides(minPrice, maxPrice) {
                    $('#flightMainCard2 .airline_hide').each(function() {
                        var fare = parseInt($(this).find('.ib-fare').text());
                        if (fare >= minPrice) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            
    });
    
    
    


// \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


// // timing sorting

// const buttons = document.querySelectorAll('.take-off-timing');
// const cardLists = document.querySelectorAll('.isotope-grid .airline_hide');

// buttons.forEach(button => {
//   button.addEventListener('click', () => {
//     // Toggle the active class on the button
//     button.classList.toggle('activetime');
//     showMatchingCardLists();
//   });
// });

// function showMatchingCardLists() {
//   // Find the active button and get its time range
//   const activeButton = document.querySelector('.take-off-timing.activetime');
//   let timeRange;
//   if (activeButton) {
//     timeRange = activeButton.textContent.toLowerCase().trim();
//   }

//   // Filter the card-list elements based on the time range
//   cardLists.forEach(cardList => {
//     const time = cardList.querySelector('.takeoff').textContent.trim();
//     if (!activeButton || isTimeInRange(time, timeRange)) {
//       cardList.style.display = 'block';
//     } else {
//       cardList.style.display = 'none';
//     }
//   });
// }

// function isTimeInRange(time, timeRange) {
//   const hour = parseInt(time.split(':')[0]);
//   if (timeRange === 'before 6 am') {
//     return hour < 6;
//   } else if (timeRange === '6 am - 12 pm') {
//     return hour >= 6 && hour < 12;
//   } else if (timeRange === '12 pm - 6 pm') {
//     return hour >= 12 && hour < 18;
//   } else if (timeRange === 'after 6 pm') {
//     return hour >= 18;
//   } else {
//     return false;
//   }
// }

// const buttons2 = document.querySelectorAll('.landing-timing');
// const cardLists2 = document.querySelectorAll('.isotope-grid2 .airline_hide');

// buttons2.forEach(button => {
//   button.addEventListener('click', () => {
//     // Toggle the active class on the button
//     button.classList.toggle('activetime');
//     showMatchingCardListss();
//   });
// });

// function showMatchingCardListss() {
//   // Find the active button and get its time range
//   const activeButton2 = document.querySelector('.landing-timing.activetime');
//   let timeRange2;
//   if (activeButton2) {
//     timeRange2 = activeButton2.textContent.toLowerCase().trim();
//   }

//   // Filter the card-list elements based on the time range
//   cardLists2.forEach(cardList => {
//     const time2 = cardList.querySelector('.landing').textContent.trim();
//     if (!activeButton2 || isTimeInRangee(time2, timeRange2)) {
//       cardList.style.display = 'block';
//     } else {
//       cardList.style.display = 'none';
//     }
//   });
// }

// function isTimeInRangee(time2, timeRange2) {
//   const hours = parseInt(time2.split(':')[0]);
//   if (timeRange2 === 'before 6 am') {
//     return hours < 6;
//   } else if (timeRange2 === '6 am - 12 pm') {
//     return hours >= 6 && hours < 12;
//   } else if (timeRange2 === '12 pm - 6 pm') {
//     return hours >= 12 && hours < 18;
//   } else if (timeRange2 === 'after 6 pm') {
//     return hours >= 18;
//   } else {
//     return false;
//   }
// }


// // Show all the card-list elements on page load
// showMatchingCardLists();
// showMatchingCardListss();
// =================================================
setTimeout(() => {
  sortProductsPriceAscending();
}, 500);

function sortProductsPriceAscending() {
  var gridItems = $('.airline_hide');

  // Find the minimum price
  var maxPrice = 0; // Set initial value to infinity
  var minPrice = Infinity; // Set initial value to infinity
  gridItems.each(function() {
      var price = $(this).find('.ob-fare').data('price1');
      if (price < minPrice) {
          minPrice = price;
      }
      if (price > maxPrice) {
        maxPrice = price;
    }
  });

  // Sort the products by price
  gridItems.sort(function (a, b) {
      return $('.ob-fare', a).data("price1") - $('.ob-fare', b).data("price1");
  });

  $(".isotope-grid").append(gridItems);
  
  // Log the minimum price
//   console.log("Minimum price: " + minPrice);
  document.getElementById("todayMinp").innerHTML = minPrice;
  document.getElementById("max_price").max = maxPrice;
  
}
setTimeout(() => {
  sortProductsPriceAscendingg();
}, 600);

function sortProductsPriceAscendingg() {
  var gridItems = $('.secound-list');

  // Find the minimum price
  var maxPrice = 0; // Set initial value to infinity
  var minPrice = Infinity; // Set initial value to infinity
  gridItems.each(function() {
      var price = $(this).find('.ib-fare').data('price2');
      if (price < minPrice) {
          minPrice = price;
      }
      if (price > maxPrice) {
        maxPrice = price;
    }
  });

  // Sort the products by price
  gridItems.sort(function (a, b) {
      return $('.ib-fare', a).data("price2") - $('.ib-fare', b).data("price2");
  });

  $(".isotope-grid2").append(gridItems);
  
  // Log the minimum price
//   console.log("Minimum price: " + minPrice);
  document.getElementById("todayMinp").innerHTML = minPrice;
  document.getElementById("max_price").max = maxPrice;
  
}
</script>
    
@stop

@endsection










