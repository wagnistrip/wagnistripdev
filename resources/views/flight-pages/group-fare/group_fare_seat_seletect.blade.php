    @extends('layouts.master')
    @section('title', 'Wagnistrip')
    @section('body')

    <style>
        .groupfareDetailMain {
            margin-top: 100px;
        }

        select {

            margin-bottom: 20px;
        }

        select option {
            font-size: 17px;
        }

        @media only screen and (min-device-width: 275px) and (max-device-width: 576px) {}
    </style>
    
    @php
    $itinerary = json_decode($data->itinerary, true);

    @endphp
    <main class="container groupfareDetailMain">
         @if($errors->any())
                @if($errors->first() !="Not Updated successfully" )
                    <div class="alert alert-danger" role="alert">
                         <button type="button" class="close text-dark" data-dismiss="alert">&times;</button>
                         <strong></</strong> {{$errors->first()}} .
                    </div>
                @else
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>OOps !!</strong> Not Updated anyone
                    </div>
                @endif
            @endif
        <div class="container">
            <div class="row">
                <div class="col-sm-4 pt-20">
                    <h5 class="responsivetexttitle">Fare Summary</h5>
                    <div class="boxunder p-2">
                        <div class="ranjepp">
                            <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare
                            </div>
                            <div id="price" class="collapse show">
                                <span class="font-14">
                                    ADT( <span id="numberOfTraveller">1</span> X
                                    <i class="fa fa-inr"></i>
                                    <spna id="getprice">{{$itinerary['price']}}</spna> )
                                </span>
                                <span class="float-right fontsize-17"><i class="fa fa-inr"></i>
                                    <spna id="totalprice">{{$itinerary['price']}}</spna>
                                </span>
                            </div>
                        </div>
                        <div class="ranjepp">

                            <div class="collapse show">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" value="checked" id="flexCheckChecked"
                                        checked="">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Charity
                                    </label>
                                    <span class="float-right fontsize-17"><i class="fa fa-inr"></i> <span
                                            id="ChaAm">{{$Charity}}</span></span>
                                </div>
                            </div>

                        </div>

                        <div class="ranjepp">
                            <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                <span class="fontsize-22"> Total Amount</span>
                                <span class="fontsize-22 float-right"> <i class="fa fa-inr"></i>
                                    <span id="TotalFare">
                                        {{$itinerary['price'] + $Charity}}
                                    </span>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="pb-10"></div>
                    <div class="pb-10"></div>
                </div>



                <div class="col-sm-8 pt-20 pb-20">
                    <div class="d-flex">
                        <div class="col-6">
                            <h4 class="responsivetexttitle">Adult</h4>
                            <input type="hidden" value="{{$itinerary['leftSeatn']}}" id="leftseats"></span>
                            <select class="form-control" id="aioConceptName">
                                @php
                                $seat = $itinerary['leftSeatn'];
                                for($i = 1; $i<=$seat; $i++){ @endphp <option value="{{$i}}">{{$i}}</option>
                                    @php
                                    }
                                    @endphp
                            </select>
                        </div>
                        <div class="col-6">
                            <h4 class="responsivetexttitle">Child</h4>
                            <select class="form-control" id="aioConceptName1">
                                @php
                              $seat = $itinerary['leftSeatn'];
                               for($i = 0; $i<$seat; $i++){ @endphp <option value="{{$i}}">{{$i}}</option>
                                   @php
                                   }
                                   @endphp
                            
                            
                            </select>
                        </div>
                    </div>

                    <div class="pb-10">
                        <div class="boxunder">
                            <div class="row" style="display: none;">
                                <div class="col-7 col-md-7 col-sm-6">
                                    <span class="bg-dark px-3 rounded-right text-light fnt40">DEPART</span>
                                    <span class="dpf">
                                        <span class="fontsize-22">{{$itinerary['departure']}}
                                            | <small class="owstitle">{{$itinerary['departure_date']}}</small>
                                        </span><br>
                                        <span class="owstitle"> {{$itinerary['Stop']}}</span> |
                                        {{$itinerary['TotalTrevelTime']}}</span>
                                </div>
                                <div class="col-5 col-md-5 col-sm-6">
                                    <div class="float-right ranjepp">
                                        <span class="prebtn marginright-20"> Cancellation Fees Apply </span>
                                        <span class="fontsize-22 text-center"> Fare Rules </span>
                                    </div>
                                </div>
                            </div>
                            <div class="borderbotum"></div>
                            <input type="hidden" id="imgtype" value="" name="image">
                            <div class="row ranjepp py-3">
                                <div class="col-2 col-md-2 col-sm-2">
                                    <img src="{{$itinerary['airlineImage']}}" alt="flight" class="imgonewayw">
                                    <div class="owstitle1">{{$itinerary['airlineName']}}</div>
                                    <div class="owstitle">
                                        {{$itinerary['FlightNumber']}}
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 col-sm-3">
                                    <div class="fontsize-22">
                                        {{$itinerary['departure_time']}}
                                    </div>
                                    <span class="onwfnt-22 font-weight-bold">{{$itinerary['departure']}}</span>
                                    <div class="owstitle">
                                        {{$itinerary['departure_date']}}
                                    </div>
                                    <div class="onwfnt-11 colorgrey">
                                        {!! $itinerary['departure_airport'] !!}
                                    </div>

                                </div>
                                <div class="col-2 col-md-2 col-sm-2 text-center pt-4">
                                    <div style="margin-left: -40px;">
                                        <div class="owstitle-22">
                                            {{$itinerary['TotalTrevelTime']}}
                                        </div>
                                        <div class="borderbotum"></div>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 col-sm-3">
                                    <div class="fontsize-22">
                                        {{$itinerary['arriavel_time']}}
                                    </div>
                                    <span class="onwfnt-22 font-weight-bold">{{$itinerary['arriavel']}}</span>
                                    <div class="owstitle">
                                        {{$itinerary['arriavel_date']}}
                                    </div>
                                    <div class="onwfnt-11 colorgrey">
                                        {!! $itinerary['arriavel_airport'] !!}
                                    </div>

                                </div>
                                <div class="col-2 col-md-2 col-sm-2">
                                    <span class="owstitle mb-2">Fare Type</span>
                                    <button type="button" class="btn-sm btn btn-outline-success btnressaver"
                                        fdprocessedid="pxa9ww">SAVER</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="container">
                            <div id="information" class="collapse p-10" style="display: none;">
                                <div class="boxunder p-10 bgpolicy">
                                    <h4 class="restitleof">Important Information</h4>
                                    <h6 class="restitleof"> <i class="fa fa-info-circle textcolorinfo"></i> Mandatory
                                        check-list for passengers
                                    </h6>
                                    <ul class="onwfnt-11">
                                        <li>Vaccination requirements : None.</li>
                                        <li>COVID test requirements : Non-vaccinated passengers entering the
                                            state from Maharashtra and Kerala must carry a negative RT-PCR test
                                            report with a sample taken within 72 hours before arrival. RT-PCR
                                            Test timeline starts from the swab collection time. Negative RT-PCR
                                            test report is not required for passengers travelling from other
                                            states.
                                        </li>
                                        <li>Passengers travelling to the state might not be allowed to board
                                            their flights if they are not carrying a valid test report.
                                        </li>
                                        <li>Pre-registration or e-Pass requirements : Download and update
                                            Aarogya Setu app
                                        </li>
                                        <li>Quarantine Guidelines : None</li>
                                        <li>Destination Restrictions : A lockdown is in effect at the moment,
                                            however, flight operations remain unaffected during this time.
                                            Please check the latest state guidelines before travelling.
                                        </li>
                                        <li>Remember to web check-in before arriving at the airport; carry a
                                            printed or soft copy of the boarding pass.
                                        </li>
                                        <li>Please reach at least 2 hours prior to flight departure.</li>
                                        <li>The latest DGCA guidelines state that it is compulsory to wear a
                                            mask that covers the nose and mouth properly while at the airport
                                            and on the flight. Any lapse might result in de-boarding. Know More
                                        </li>
                                        <li>Remember to download the baggage tag(s) and affix it on your bag(s).
                                        </li>
                                    </ul>
                                    <h6 class="restitleof"> <i class="fa fa-info-circle textcolorinfo"></i> State
                                        Guidelines
                                    </h6>
                                    <ul class="onwfnt-11">
                                        <li>Check the detailed list of travel guidelines issued by Indian States
                                            and UTs.Know More
                                        </li>
                                    </ul>
                                    <h6 class="restitleof"> <i class="fa fa-info-circle textcolorinfo"></i> Baggage
                                        information
                                    </h6>
                                    <ul class="onwfnt-11">
                                        <li>Carry no more than 1 check-in baggage and 1 hand baggage per passenger.
                                            Additional pieces of Baggage will be subject to additional charges per piece
                                            in
                                            addition to the excess baggage charges.
                                        </li>
                                    </ul>
                                    <h6 class="restitleof"> <i class="fa fa-info-circle textcolorinfo"></i> A Note on
                                        Guidelines
                                    </h6>
                                    <ul class="onwfnt-11">
                                        <li>Disclaimer: The information provided above is only for ready reference and
                                            convenience of customers, and may not be exhaustive. We strongly recommend
                                            that
                                            you check the full text of the guidelines issued by the State Governments
                                            before
                                            travelling. Wagnistrip accepts no liability in this regard.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-left" id="booking-btn-section" id="btnco" style="display: none;">
                    </div>
                    <div id="traveller-section" class="collapse pb-20" style="display: block;">

                        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                        <style>
                            .select2-container--default .select2-selection--single {
                                display: block;
                                padding: 5px;
                                color: #495057;
                                background-color: #fff;
                                background-clip: padding-box;
                                border: 1px solid #ced4da;
                                border-radius: 0.25rem;
                                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                            }

                            .select2-container--default .select2-selection--single .select2-selection__rendered {
                                line-height: 1.5;
                            }

                            .select2-container--default .select2-selection--single {
                                font-size: 16px;
                                font-weight: 400;
                                width: 170px;
                                height: calc(1.5em + 0.75rem + 2px);
                            }
                        </style>
                        

                        <form action="{{url('/group_fare_submit')}}" method="post">
                            <input type="hidden" name="group_fare_flight_id" value="{{$data->id}}" />
                            <input type="hidden" name="charity_check" class="myInput" value="checked" />
                            @csrf
                            <div id="parentformFields" style="background: #fff; padding:5px; ">
                                <div class="searchtitle pt-10 pb-10 border-top">ADULT</div>
                                <div id="adult-section1" class="pt-10 pb-10">
                                    <div class="card fadshoww">
                                        <div class="card-body">
                                            <div id="adult-body1" class="pt-20">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <span class="searchtitle"> Title
                                                            </span>
                                                            <select name="adultTitle[]" class="form-control adultTitle1"
                                                                required="" fdprocessedid="31e1dfh">
                                                                <option value="" selected="" disabled="">Select</option>
                                                                <option value="Mr">MR</option>
                                                                <option value="MS">MS</option>
                                                                <option value="MRS">Mrs</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-5">
                                                        <div class="form-group">
                                                            <span class="searchtitle">
                                                                First Name &amp; (middle name, if any)
                                                            </span>

                                                            <input type="text" name="adultFirstName[]"
                                                                class="form-control" placeholder="First Name"
                                                                required="" data-parsley-pattern="^[a-z A-Z]+$"
                                                                fdprocessedid="9vm3ew">
                                                            <input type="hidden" name="price"
                                                                value="{{$itinerary['price']}}" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="form-group">
                                                            <span class="searchtitle">Last Name
                                                            </span>
                                                            <input type="text" name="adultLastName[]"
                                                                class="form-control" placeholder="Last Name"
                                                                data-parsley-minlength="3"
                                                                data-parsley-pattern="^[a-z A-Z]+$" required=""
                                                                fdprocessedid="iz3bt7">
                                                        </div>
                                                        <span class="b-10 float-right" data-toggle="collapse"
                                                            data-target="#Frequentflyer1" style="font-size: 10px;"><i
                                                                class="fa fa-plus" aria-hidden="true"></i>
                                                            Frequent flyer number and Meal preference (optional)</span>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="parentformFieldsChild" style="background: #fff; padding:5px">
                            </div>
                             <div class="card fadshoww mobilefadshow" id="mobilefadshow">
                                    <div class="card-body">
                                        <div id="adult-body2" class="pt-20">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="searchtitle"> Country Code</label><br>
                                                        <select name="countryCode2"
                                                            class="countryCode select2-hidden-accessible" required=""
                                                            data-select2-id="select2-data-1-ehlo" tabindex="-1"
                                                            aria-hidden="true">
                                                            <option value="+91" selected=""
                                                                data-select2-id="select2-data-3-twcz">India(+91)
                                                            </option>
                                                        </select><span
                                                            class="select2 select2-container select2-container--default"
                                                            dir="ltr" data-select2-id="select2-data-1-omi7"
                                                            style="width: 1px;"><span class="selection"><span
                                                                    class="select2-selection select2-selection--single"
                                                                    role="combobox" aria-haspopup="true"
                                                                    aria-expanded="false" tabindex="-1"
                                                                    aria-disabled="false"
                                                                    aria-labelledby="select2-countryCode2-gl-container"
                                                                    aria-controls="select2-countryCode2-gl-container"><span
                                                                        class="select2-selection__rendered"
                                                                        id="select2-countryCode2-gl-container"
                                                                        role="textbox" aria-readonly="true"
                                                                        title="India(+91)">India(+91)</span><span
                                                                        class="select2-selection__arrow"
                                                                        role="presentation"><b
                                                                            role="presentation"></b></span></span></span><span
                                                                class="dropdown-wrapper"
                                                                aria-hidden="true"></span></span>
                                                        <span
                                                            class="select2 select2-container select2-container--default"
                                                            dir="ltr" data-select2-id="select2-data-2-wrhe"
                                                            style="width: 2px;"><span class="selection"><span
                                                                    class="select2-selection select2-selection--single"
                                                                    role="combobox" aria-haspopup="true"
                                                                    aria-expanded="false" tabindex="0"
                                                                    aria-disabled="false"
                                                                    aria-labelledby="select2-countryCode2-av-container"
                                                                    aria-controls="select2-countryCode2-av-container"><span
                                                                        class="select2-selection__rendered"
                                                                        id="select2-countryCode2-av-container"
                                                                        role="textbox" aria-readonly="true"
                                                                        title="India(+91)">India(+91)</span><span
                                                                        class="select2-selection__arrow"
                                                                        role="presentation"><b
                                                                            role="presentation"></b></span></span></span><span
                                                                class="dropdown-wrapper"
                                                                aria-hidden="true"></span></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group">
                                                        <label class="searchtitle">
                                                            Mobile
                                                        </label>
                                                        <input type="text" name="phoneNumber" class="form-control"
                                                            placeholder="Enter Mobile" required=""
                                                            data-parsley-type="number" data-parsley-maxlength="10"
                                                            data-parsley-minlength="10" fdprocessedid="hm3gvq">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="searchtitle"> Email</label>
                                                        <input type="text" name="email" class="form-control"
                                                            placeholder="Enter Email" required=""
                                                            data-parsley-type="email" fdprocessedid="hld6b">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="pt-10">
                                <button type="submit" name="traveller-bnt" class="btn btn-primary continueres-btn"
                                    style="width: 100%;">
                                    CONTINUE </button>
                            </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
        </div>

    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
            
       var conceptName1 = 0;
       var conceptName=1;
       

        $(document).ready(function () {
     
        
            $('#aioConceptName').on('change', function () {
                 conceptName = $('#aioConceptName :selected').text();
                 var leftseats = $('#leftseats').val();
                 
                 
                 // var leftseats = $("#leftseats").val();

                var leftseats = $("#leftseats").val();
                $('#aioConceptName1').html(`<option value="0">0</option>`)
               var leftseats1=leftseats-conceptName;
                for (let i = 1; i <= leftseats1; i++) {
                    if(conceptName1 == i){
                  $('#aioConceptName1').append(`<option selected value="${i}">${i}</option>`)
                        
                    }else{
                  $('#aioConceptName1').append(`<option value="${i}">${i}</option>`)
                        
                    }
                }
                
                pr = +(conceptName1)+ +(conceptName);
                
                var numberOfTraveller = $('#numberOfTraveller')
                numberOfTraveller.html(pr);
                var getprice = $('#getprice').html();
                var totalPrice = getprice * pr;
                var total = $('#totalprice').html(totalPrice);
                var ChaAm = + $('#ChaAm').html();
                var TotalFare = $('#TotalFare').html(totalPrice + ChaAm);
                var newhtml = ``;
                $("#parentformFields").html(newhtml);
                var newhtml = `<div class="customFomrFileds"><div class="container pb-10">
                    <div class="searchtitle pt-10 pb-10 border-top">ADULT</div>
                    <div id="adult-section1" class="pt-10 pb-10">
                    <div class="card fadshoww">
                        <div class="card-body">
                            <div id="adult-body1" class="pt-20">
                                <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <span class="searchtitle"> Title
                                        </span>
                                        <select name="adultTitle[]" class="form-control adultTitle1" required="" fdprocessedid="31e1dfh">
                                            <option value="" selected="" disabled="">Select</option>
                                            <option value="Mr">MR</option>
                                            <option value="MS">MS</option>
                                            <option value="MRS">Mrs</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <span class="searchtitle">
                                        First Name &amp; (middle name, if any)
                                        </span>
                                        <input type="text" name="adultFirstName[]" class="form-control" placeholder="First Name" required="" data-parsley-pattern="^[a-z A-Z]+$" fdprocessedid="9vm3ew">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <span class="searchtitle">Last Name
                                        </span>
                                        <input type="text" name="adultLastName[]" class="form-control" placeholder="Last Name" data-parsley-minlength="3" data-parsley-pattern="^[a-z A-Z]+$" required="" fdprocessedid="iz3bt7">
                                        <input type="hidden" name="price" value="{{$itinerary['price']}}" class="form-control">
                                    </div>
                                    <span class="b-10 float-right" data-toggle="collapse" data-target="#Frequentflyer1" style="font-size: 10px;"><i class="fa fa-plus" aria-hidden="true"></i>
                                    Frequent flyer number and Meal preference (optional)</span>
                                </div>
                                </div>
                            </div>
                            <div id="adult-frequent1" class="collapse">
                                <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <span class="searchtitle">Frequent Flyer no. </span>
                                        <input type="text" class="form-control" placeholder="Frequent flyer no.">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <span class="searchtitle">
                                        Airline
                                        </span>
                                        <input type="text" class="form-control" placeholder="Airline">
                                    </div>
                                </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                

                </div>`


                for (let index = 0; index < conceptName; index++) {
                    $("#parentformFields").append(newhtml);
                }
                   $("#mobilefadshow").html('');
                var data = `<div class="card fadshoww">
                        <div class="card-body">
                        <div id="adult-body2" class="pt-20">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <label class="searchtitle"> Country Code</label><br>
                                    <select name="countryCode2" class="countryCode select2-hidden-accessible" required="" data-select2-id="select2-data-1-ehlo" tabindex="-1" aria-hidden="true">
                                        <option value="+91" selected="" data-select2-id="select2-data-3-twcz">India(+91)</option>
                                    </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-1-omi7" style="width: 1px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false" aria-labelledby="select2-countryCode2-gl-container" aria-controls="select2-countryCode2-gl-container"><span class="select2-selection__rendered" id="select2-countryCode2-gl-container" role="textbox" aria-readonly="true" title="India(+91)">India(+91)</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-2-wrhe" style="width: 2px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-countryCode2-av-container" aria-controls="select2-countryCode2-av-container"><span class="select2-selection__rendered" id="select2-countryCode2-av-container" role="textbox" aria-readonly="true" title="India(+91)">India(+91)</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                    <label class="searchtitle">
                                    Mobile
                                    </label>
                                    <input type="text" name="phoneNumber" class="form-control" placeholder="Enter Mobile" required="" data-parsley-type="number" data-parsley-maxlength="10" data-parsley-minlength="10" fdprocessedid="hm3gvq">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label class="searchtitle"> Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Enter Email" required="" data-parsley-type="email" fdprocessedid="hld6b">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="adult-frequent2" class="collapse">
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <span class="searchtitle">
                                    Frequent Flyer no. </span>
                                    <input type="text" class="form-control" placeholder="Frequent flyer no.">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <span class="searchtitle">
                                    Airline
                                    </span>
                                    <input type="text" class="form-control" placeholder="Airline">
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>`;
                $("#mobilefadshow").append(data);


            });

   
        $('#aioConceptName1').on('change', function () {
                conceptName1 = $('#aioConceptName1 :selected').text();
                
                var leftseats = $("#leftseats").val();
                $('#aioConceptName').html(`<option value="1">1</option>`)
               var leftseats1=leftseats-conceptName1;
                for (let i = 2; i <= leftseats1; i++) {
                    if(conceptName == i){
                  $('#aioConceptName').append(`<option selected value="${i}">${i}</option>`)
                    }else{
                  $('#aioConceptName').append(`<option value="${i}">${i}</option>`)
                        
                    }
                }
                
                pr = +(conceptName1)+ +(conceptName);
                 
                 
                 
                var numberOfTraveller = $('#numberOfTraveller')
                numberOfTraveller.html(pr);
                var getprice = $('#getprice').html();
                var totalPrice = getprice * pr;
                var total = $('#totalprice').html(totalPrice);
                var ChaAm = + $('#ChaAm').html();
                var TotalFare = $('#TotalFare').html(totalPrice + ChaAm);
                var newhtml = ``;
                $("#parentformFieldsChild").html(newhtml);   
                var newhtml = `<div class="searchtitle p-10 border-top">Child</div>
                                <div id="adult-section1" class="p-10">
                                    <div class="card fadshoww">
                                        <div class="card-body">
                                            <div id="adult-body1" class="pt-20">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <span class="searchtitle"> Title
                                                            </span>
                                                            <select name="childTitle[]" class="form-control adultTitle1"
                                                                required="" fdprocessedid="31e1dfh">
                                                                <option value="" selected="" disabled="">Select</option>
                                                                <option value="Mr">MR</option>
                                                                <option value="MS">MS</option>
                                                                <option value="MRS">Mrs</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-5">
                                                        <div class="form-group">
                                                            <span class="searchtitle">
                                                                First Name &amp; (middle name, if any)
                                                            </span>

                                                            <input type="text" name="childFirstName[]"
                                                                class="form-control" placeholder="First Name"
                                                                required="" data-parsley-pattern="^[a-z A-Z]+$"
                                                                fdprocessedid="9vm3ew">
                                                            <input type="hidden" name="price"
                                                                value="{{$itinerary['price']}}" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="form-group">
                                                            <span class="searchtitle">Last Name
                                                            </span>
                                                            <input type="text" name="childLastName[]"
                                                                class="form-control" placeholder="Last Name"
                                                                data-parsley-minlength="3"
                                                                data-parsley-pattern="^[a-z A-Z]+$" required=""
                                                                fdprocessedid="iz3bt7">
                                                        </div>
                                                        <span class="b-10 float-right" data-toggle="collapse"
                                                            data-target="#Frequentflyer1" style="font-size: 10px;"><i
                                                                class="fa fa-plus" aria-hidden="true"></i>
                                                            Frequent flyer number and Meal preference (optional)</span>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>`
                for (let index = 0; index < conceptName1; index++) {
                    $("#parentformFieldsChild").append(newhtml);
                }
                
                  
        });
        
        });
        
    $(document).ready(function() {
  $('input[type="checkbox"]').change(function() {
    var checkboxData = [];

    $('input[type="checkbox"]:checked').each(function() {
      checkboxData.push($(this).val());
     
    });
    $('.myInput').val(checkboxData);
    if(checkboxData[0] == 'checked'){
       $('#ChaAm').html({{$Charity}});  
       $('#TotalFare').html( {{$itinerary['price'] + $Charity}});
    }else{
         $('#ChaAm').html('0');
       $('#TotalFare').html( {{$itinerary['price']}});
    }
    // You can perform further actions with the checkboxData array here
  });
});
        

    </script>




    @endsection