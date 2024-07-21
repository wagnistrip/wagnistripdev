@extends('layouts.master')
@section('title', 'Wagnistrip ')
@section('body')

@php
    use App\Models\Agent\Agent;
    $Agent = Session()->get("Agent");
    if($Agent != null){
        $mail = $Agent->email;
        $Agent = Agent::where('email', '=', $mail)->first();
        $Charge = 70;
    }else{
        $Charge = 118;
    }
    $code = !empty($code) ?  $code : 'INR';
    $code = is_array($code) ? $code[0] : $code; 
    $icon = !empty(__('common.'.$code)) ? __('common.'.$code) : '';
    $cvalue = !empty($cvalue) ? $cvalue : 1;   
    function modify_amt($amt , $cvalue){
        if(!empty($amt)){
            return ceil($amt*$cvalue);
        }
        else{
            return 0;
        }
    }
@endphp
    <!-- DESKTOP VIEW START -->

    <section class="bgcolor pt-6p pb-10">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <span class="h22">Review your booking</span>
                </div>
                <div class="col-sm-6">
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width:25%">
                            Flight selected
                        </div>
                        <div class="progress-bar bg-light text-dark" style="width:25%">
                            Review
                        </div>
                        <div class="progress-bar bg-light text-dark" style="width:25%">
                            Traveller Details
                        </div>
                        <div class="progress-bar bg-light text-dark" style="width:25%">
                            Make Payment
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    @php
    $originCountry = 'DEL';
    $destinationCountry = 'DEL';
    use App\Http\Controllers\Airline\AirportiatacodesController;
    @endphp


    {{-- Itnarry start --}}
    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-8 pt-20 pb-20 kuchh-bhi">
                    {{-- <div class="scrollfix"> --}}

                    <h4>Itinerary</h4>
                    {{-- Flight Review Start --}}
                    
                    @if (isset($GlRoundtripNonstopNonstop))
                        @php
                            $flightData =[ $GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries'] , $GlRoundtripNonstopNonstop[1]['AirPricingResponse'][0]['Itineraries'],];
                            $jurneyDate = getDateFormat($GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                            $OutboundSessionID = $Sessions['OutboundSessionID'];
                            $OutboundReferenceNo = $GlRoundtripNonstopNonstop[0]['ReferenceNo'];
                            $OutboundProvider = $GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Provider'];
                            $OutboundKey = $GlRoundtripNonstopNonstop[0]['Key'];
                            $InboundSessionID = $Sessions['InboundSessionID'];
                            $InboundReferenceNo = $GlRoundtripNonstopNonstop[1]['ReferenceNo'];
                            $InboundProvider = $GlRoundtripNonstopNonstop[1]['AirPricingResponse'][0]['Provider'];
                            $InboundKey = $GlRoundtripNonstopNonstop[1]['Key'];
                            $response1 = $GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0];
                            $response2 = $GlRoundtripNonstopNonstop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0];
                            
                            $code = $GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['AirLine']['Code'];
                            $time1 =$GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime'];
                            $time2 =$GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['DateTime'];
                            $city1 =$GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['CityName'];
                            $city2 =$GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['CityName'];
                            $delay = $GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Duration'];
                            $stop ='Round trip Non stop Non stop';
                            $userdata ='';
                            
                        @endphp
                        
                        <x-flight.segment-gl-section trip="DEPART"
                            :segment="$GlRoundtripNonstopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />
                        <x-flight.segment-gl-section trip="RETURN"
                            :segment="$GlRoundtripNonstopNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @elseif (isset($GlRoundtripNonstopOnestop))

                        @php
                            $flightData =[ $GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries'] , $GlRoundtripNonstopOnestop[1]['AirPricingResponse'][0]['Itineraries'],];
                            $jurneyDate = getDateFormat($GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                            $OutboundSessionID = $Sessions['OutboundSessionID'];
                            $OutboundReferenceNo = $GlRoundtripNonstopOnestop[0]['ReferenceNo'];
                            $OutboundProvider = $GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Provider'];
                            $OutboundKey = $GlRoundtripNonstopOnestop[0]['Key'];
                            $InboundSessionID = $Sessions['InboundSessionID'];
                            $InboundReferenceNo = $GlRoundtripNonstopOnestop[1]['ReferenceNo'];
                            $InboundProvider = $GlRoundtripNonstopOnestop[1]['AirPricingResponse'][0]['Provider'];
                            $InboundKey = $GlRoundtripNonstopOnestop[1]['Key'];
                            
                            $response1 = $GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0];
                            $response2 = $GlRoundtripNonstopOnestop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0];
                            
                            $code = $GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['AirLine']['Code'];
                            $time1 =$GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime'];
                            $time2 =$GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['DateTime'];
                            $city1 =$GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['CityName'];
                            $city2 =$GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['CityName'];
                            $delay = $GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Duration'];
                            $stop ='Round trip Non stop One stop';
                            $userdata ='';
                        @endphp


                        <x-flight.segment-gl-section trip="DEPART"
                            :segment="$GlRoundtripNonstopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />
                        <x-flight.segment-gl-section trip="RETURN"
                            :segment="$GlRoundtripNonstopOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @elseif (isset($GlRoundtripOnestopNonstop))
                        @php
                            $flightData =[ $GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries'] , $GlRoundtripOnestopNonstop[1]['AirPricingResponse'][0]['Itineraries'],];
                            $jurneyDate = getDateFormat($GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                            $OutboundSessionID = $Sessions['OutboundSessionID'];
                            $OutboundReferenceNo = $GlRoundtripOnestopNonstop[0]['ReferenceNo'];
                            $OutboundProvider = $GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Provider'];
                            $OutboundKey = $GlRoundtripOnestopNonstop[0]['Key'];
                            $InboundSessionID = $Sessions['InboundSessionID'];
                            $InboundReferenceNo = $GlRoundtripOnestopNonstop[1]['ReferenceNo'];
                            $InboundProvider = $GlRoundtripOnestopNonstop[1]['AirPricingResponse'][0]['Provider'];
                            $InboundKey = $GlRoundtripOnestopNonstop[1]['Key'];
                            
                            $response1 = $GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0];
                            $response2 = $GlRoundtripOnestopNonstop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0];
                            
                            $code = $GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['AirLine']['Code'];
                            $time1 =$GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime'];
                            $time2 =$GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['DateTime'];
                            $city1 =$GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['CityName'];
                            $city2 =$GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['CityName'];
                            $delay = $GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Duration'];
                            $stop ='Round trip One stop Non stop';
                            $userdata ='';
                        @endphp

                        <x-flight.segment-gl-section trip="DEPART"
                            :segment="$GlRoundtripOnestopNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />
                        <x-flight.segment-gl-section trip="RETURN"
                            :segment="$GlRoundtripOnestopNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @elseif (isset($GlRoundtripOnestopOnestop))
                    
                        @php
                            $flightData =[ $GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries'] , $GlRoundtripOnestopOnestop[1]['AirPricingResponse'][0]['Itineraries'],];
                            $jurneyDate = getDateFormat($GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                            $OutboundSessionID = $Sessions['OutboundSessionID'];
                            $OutboundReferenceNo = $GlRoundtripOnestopOnestop[0]['ReferenceNo'];
                            $OutboundProvider = $GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Provider'];
                            $OutboundKey = $GlRoundtripOnestopOnestop[0]['Key'];
                            $InboundSessionID = $Sessions['InboundSessionID'];
                            $InboundReferenceNo = $GlRoundtripOnestopOnestop[1]['ReferenceNo'];
                            $InboundProvider = $GlRoundtripOnestopOnestop[1]['AirPricingResponse'][0]['Provider'];
                            $InboundKey = $GlRoundtripOnestopOnestop[1]['Key'];
                            $response1 = $GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0];
                            $response2 = $GlRoundtripOnestopOnestop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0];
                            
                            $code = $GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['AirLine']['Code'];
                            $time1 =$GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime'];
                            $time2 =$GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['DateTime'];
                            $city1 =$GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['CityName'];
                            $city2 =$GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['CityName'];
                            $delay = $GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Duration'];
                            $stop ='Round trip One stop One stop';
                            $userdata ='';
                        @endphp

                        <x-flight.segment-gl-section trip="DEPART"
                            :segment="$GlRoundtripOnestopOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />
                        <x-flight.segment-gl-section trip="RETURN"
                            :segment="$GlRoundtripOnestopOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />
                    @endif
                    <!-- Flight Review End -->
                    <div class="row kuchh-bhi">
                        <div class="container">
                            <div id="information" class="collapse p-10">
                                <div class="boxunder p-10 bgpolicy">
                                    <h4>Important Information</h4>
                                    <h6> <img src="/public/assets/images/imp-info.png" alt="" width="20"> Mandatory
                                        check-list for passengers </h6>
                                    <ul class="onwfnt-11">
                                        <li>Vaccination requirements : None.</li>
                                        <li>COVID test requirements : Non-vaccinated passengers entering the
                                            state from Maharashtra and Kerala must carry a negative RT-PCR test
                                            report with a sample taken within 72 hours before arrival. RT-PCR
                                            Test timeline starts from the swab collection time. Negative RT-PCR
                                            test report is not required for passengers travelling from other
                                            states.</li>
                                        <li>Passengers travelling to the state might not be allowed to board
                                            their flights if they are not carrying a valid test report.</li>
                                        <li>Pre-registration or e-Pass requirements : Download and update
                                            Aarogya Setu app</li>
                                        <li>Quarantine Guidelines : None</li>
                                        <li>Destination Restrictions : A lockdown is in effect at the moment,
                                            however, flight operations remain unaffected during this time.
                                            Please check the latest state guidelines before travelling.</li>
                                        <li>Remember to web check-in before arriving at the airport; carry a
                                            printed or soft copy of the boarding pass.</li>
                                        <li>Please reach at least 2 hours prior to flight departure.</li>
                                        <li>The latest DGCA guidelines state that it is compulsory to wear a
                                            mask that covers the nose and mouth properly while at the airport
                                            and on the flight. Any lapse might result in de-boarding. Know More
                                        </li>
                                        <li>Remember to download the baggage tag(s) and affix it on your bag(s).
                                        </li>
                                    </ul>
                                    <h6> <img src="/public/assets/images/imp-info.png" alt="" width="20"> State
                                        Guidelines </h6>
                                    <ul class="onwfnt-11">
                                        <li>Check the detailed list of travel guidelines issued by Indian States
                                            and UTs.Know More</li>
                                    </ul>
                                    <h6> <img src="/public/assets/images/imp-info.png" alt="" width="20"> Baggage
                                        information </h6>
                                    <ul class="onwfnt-11">
                                        <li>Carry no more than 1 check-in baggage and 1 hand baggage per passenger.
                                            Additional pieces of Baggage will be subject to additional charges per piece in
                                            addition to the excess baggage charges.</li>
                                    </ul>
                                    <h6> <img src="/public/assets/images/imp-info.png" alt="" width="20"> A Note on
                                        Guidelines </h6>
                                    <ul class="onwfnt-11">
                                        <li>Disclaimer: The information provided above is only for ready reference and
                                            convenience of customers, and may not be exhaustive. We strongly recommend that
                                            you check the full text of the guidelines issued by the State Governments before
                                            travelling. Wagnistrip accepts no liability in this regard.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="text-center" id="booking-btn-section" class="collapse in " style=" width: 100%;">
                            <button id="booking-btn" type="button" class="btn btn-primary" data-toggle="collapse"
                             style=" width: 97%;"   data-toggle="collapse in"> CONTINUE </button>
    
                        </div>
                    </div>

                </div>

                {{-- Fare Rules Section Start --}}
                <div class="col-sm-4 pt-20">
                    <h5>Fare Summary</h5>

                    @if ($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] == 0 && $travellers['noOfInfants'] == 0)

                        {{-- Data at Start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare</div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][0]['PaxType'] . '(' . $travellers['noOfAdults'] . 'X' }}
                                        {!! $icon !!}
                                        <?php $cus_arr_sum  = array_sum([$response1['FareBreakDowns']['FareBreakDown'][0]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][0]['BaseFare']]); ?>
                                        {{ ceil($cus_arr_sum*$cvalue) }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                    <?php $arr_sum_cus2 = array_sum([$response1['FareBreakDowns']['FareBreakDown'][0]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][0]['BaseFare']]); ?>
                                        {{ (int) $travellers['noOfAdults'] * ceil($arr_sum_cus2*$cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                    <?php $arr_sum_cus3 = (int) array_sum([$response1['FareBreakDowns']['FareBreakDown'][0]['TotalTax'], $response2['FareBreakDowns']['FareBreakDown'][0]['TotalTax']]); ?>
                                        {{ ceil((((int) $travellers['noOfAdults'] * $Charge) +(int) $travellers['noOfAdults'] * $arr_sum_cus3)*$cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services

                                </div>
                                <div  class="collapse show rmvCharity">
                                    <div class="form-check ">
                                      <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                      <label class="form-check-label" for="flexCheckChecked">
                                        Charity 
                                      </label>
                                    <span class="float-right fontsize-17">{!! $icon !!} <span id="ChaAm">10</span></span>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Discount </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}  <span id="DisAm">0</span></span>
                                </div>
                                <div class="border-bottom"></div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Convenience fee </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} 0</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}

                                        @php
                                            $total_fare = ((int)array_sum( [$response1['Total']['Fare'], $response2['Total']['Fare']])) + ((int) $travellers['noOfAdults'] * $Charge);
                                        @endphp
                                        <span id="TotalFare">
                                        {{ ceil(($total_fare+10)*$cvalue) }}
                                        </span>
                                    </span>

                                </div>
                            </div>
                        </div>

                    @elseif($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] != 0 &&
                        $travellers['noOfInfants'] == 0)

                        {{-- Data start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][0]['PaxType'] . '(' . $travellers['noOfAdults'] . 'X' }}
                                        {!! $icon !!}
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        <?php $arr_sum_cus4 = (int) array_sum([$response1['FareBreakDowns']['FareBreakDown'][0]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][0]['BaseFare']]); ?>
                                        {{ ceil(((int) $travellers['noOfAdults'] * $arr_sum_cus4)*$cvalue)  }}</span>
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][1]['PaxType'] . '(' . $travellers['noOfChilds'] . 'X' }}
                                        {!! $icon !!}
                                        {{ ceil($response1['FareBreakDowns']['FareBreakDown'][1]['BaseFare']*$cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        <?php
                                         $arr_sum_cus5 = (int) array_sum([$response1['FareBreakDowns']['FareBreakDown'][1]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][0]['BaseFare']]);
                                        ?>
                                        {{ ceil(((int) $travellers['noOfChilds'] * $arr_sum_cus5)*$cvalue)  }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        <?php $arr_sum_cus6 = array_sum([$response1['Total']['FuelSurcharge']+$Charge, $response2['Total']['FuelSurcharge']+$Charge, $response1['Total']['OtherTax'], $response2['Total']['OtherTax']]); ?>
                                        {{ ceil($arr_sum_cus6*$cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services

                                </div>
                                <div  class="collapse show rmvCharity">
                                    <div class="form-check ">
                                      <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                      <label class="form-check-label" for="flexCheckChecked">
                                        Charity 
                                      </label>
                                    <span class="float-right fontsize-17">{!! $icon !!} <span id="ChaAm">10</span></span>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Discount </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}  <span id="DisAm">0</span></span>
                                </div>
                                <div class="border-bottom"></div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Convenience fee </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} 0</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        @php
                                            $total_fare = array_sum([$response1['Total']['Fare']+$Charge, $response2['Total']['Fare']+$Charge]);
                                        @endphp
                                         <span id="TotalFare">
                                        {{ ceil(($total_fare+10)*$cvalue) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    @elseif($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] == 0 &&
                        $travellers['noOfInfants'] != 0)

                        {{-- Data start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][0]['PaxType'] . '(' . $travellers['noOfAdults'] . 'X' }}
                                        {!! $icon !!}
                                        <?php $arr_sum_cus7 = array_sum([$response1['FareBreakDowns']['FareBreakDown'][0]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][0]['BaseFare']]);  ?>
                                        {{  ceil($arr_sum_cus7*$cvalue). ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                    <?php
                                        $arr_sum_cus8 =(int) array_sum([$response1['FareBreakDowns']['FareBreakDown'][0]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][0]['BaseFare']]);
                                    ?>
                                        {{ ceil(((int) $travellers['noOfAdults'] * $arr_sum_cus8)*$cvalue)  }}</span>
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][1]['PaxType'] . '(' . $travellers['noOfInfants'] . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$response1['FareBreakDowns']['FareBreakDown'][1]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][1]['BaseFare']]) , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $travellers['noOfInfants'] * (int) array_sum([$response1['FareBreakDowns']['FareBreakDown'][1]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][1]['BaseFare']]) , $cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt(array_sum([$response1['Total']['FuelSurcharge'], $response1['Total']['OtherTax']+$Charge, $response2['Total']['FuelSurcharge'], $response2['Total']['OtherTax']+$Charge]) , $cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services

                                </div>
                                <div  class="collapse show rmvCharity">
                                    <div class="form-check ">
                                      <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                      <label class="form-check-label" for="flexCheckChecked">
                                        Charity 
                                      </label>
                                    <span class="float-right fontsize-17">{!! $icon !!} <span id="ChaAm">10</span></span>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Discount </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}  <span id="DisAm">0</span></span>
                                </div>
                                <div class="border-bottom"></div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Convenience fee </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} 0</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        @php
                                            $total_fare = array_sum([$response1['Total']['Fare']+$Charge, $response2['Total']['Fare']+$Charge]);
                                        @endphp
                                         <span id="TotalFare">
                                        {{ modify_amt($total_fare+10  , $cvalue) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    @elseif($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] != 0 &&
                        $travellers['noOfInfants'] != 0)

                        {{-- Data start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][0]['PaxType'] . '(' . $travellers['noOfAdults'] . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$response1['FareBreakDowns']['FareBreakDown'][0]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][0]['BaseFare']]) , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $travellers['noOfAdults'] * (int) array_sum([$response1['FareBreakDowns']['FareBreakDown'][0]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][0]['BaseFare']]) , $cvalue) }}</span>
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][1]['PaxType'] . '(' . $travellers['noOfChilds'] . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$response1['FareBreakDowns']['FareBreakDown'][1]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][1]['BaseFare']]) , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $travellers['noOfChilds'] * (int) array_sum([$response1['FareBreakDowns']['FareBreakDown'][1]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][1]['BaseFare']]) , $cvalue) }}</span>
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response1['FareBreakDowns']['FareBreakDown'][2]['PaxType'] . '(' . $travellers['noOfInfants'] . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$response1['FareBreakDowns']['FareBreakDown'][2]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][2]['BaseFare']]) , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $travellers['noOfInfants'] * (int) array_sum([$response1['FareBreakDowns']['FareBreakDown'][2]['BaseFare'], $response2['FareBreakDowns']['FareBreakDown'][2]['BaseFare']]) , $cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt(array_sum([$response1['Total']['FuelSurcharge']+$Charge, $response1['Total']['OtherTax'], $response2['Total']['FuelSurcharge']+$Charge, $response2['Total']['OtherTax']]) , $cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services

                                </div>
                                <div  class="collapse show rmvCharity">
                                    <div class="form-check ">
                                      <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                      <label class="form-check-label" for="flexCheckChecked">
                                        Charity 
                                      </label>
                                    <span class="float-right fontsize-17">{!! $icon !!} <span id="ChaAm">10</span></span>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Discount </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}  <span id="DisAm">0</span></span>
                                </div>
                                <div class="border-bottom"></div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Convenience fee </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} 0</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        @php
                                            $total_fare = array_sum([$response1['Total']['Fare']+$Charge, $response2['Total']['Fare']+$Charge]);
                                        @endphp
                                         <span id="TotalFare">
                                        {{ modify_amt($total_fare+10 , $cvalue) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    @endif

                    <div class="pb-10"></div>
                    {{-- <div class="boxunder">
                        <div class="ranjepp">
                            <div class="owstitle pb-10">Cancellation & Data change charges</div>
                        </div>
                           <div class="ranjepp">
                            <div class="onwfnt-11"><i class=""></i> Cancellation Fees Apply</div>
                            <p class="onwfnt-11">For cancellation please contact. <i class="fa fa-phone"> 08069145571</i> 
                                 </p>
                            <span class="onewflydetbtn"> VIEW POLICY </span>
                            <span class="onwfnt-11 float-right">
                                
                            </span>

                        </div>
                    </div> --}}
                    @php
                        $heading = 'HOT DEALS';
                        $text = 'Use this coupon and get Rs 50 instant discount on your flight booking.';
                    @endphp
                    <div class="pb-10"></div>
                    <div class="boxunder rmvHotDeals" id="boxunder">
                        @if($icon == '₹')
                        <div class="card-header fontsize-22 bg-info">{{ $icon == '₹' ? $heading : '' }}</div>
                        @endif
                        <div class="ranjepp">
                            
                            <div class="form-check">
                                @if($icon == '₹')
                              <input class="form-check-input" type="radio" name="DisAmou" id="flexRadioDefault1" value="Yes">
                              
                              <label class="form-check-label" for="flexRadioDefault1">
                                  @endif
                               <b id="DisText">
                                   {{ $icon == '₹' ? $text : '' }}
                               </b> 
                              </label>
                            </div>
                            <div id="remove-btn"class="form-check ">
                                @if($icon == '₹')
                              <input class="form-check-input" type="radio" name="DisAmou" id="flexRadioDefault2" value="No" checked>
                              <label class="form-check-label" for="flexRadioDefault2">
                                Remove
                              </label>
                              @endif
                            </div>
                            {{--<div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
                            <p class="onwfnt-11">Use this code to get special discount of INR 35 for you</p>
                            <div class="borderbotum"></div>
                            <div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
                            <p class="onwfnt-11">Use this code to get special discount of INR 350 for you</p>
                            <div class="borderbotum"></div>
                            <div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
                            <p class="onwfnt-11">Use this code to get special discount of INR 350 for you</p>
                            <div class="borderbotum"></div>
                            <div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
                            <p class="onwfnt-11">Use this code to get special discount of INR 350 for you</p>
                            <div class="borderbotum"></div>--}}
                        </div>
                        
                        @if($Agent != null)
                            <script>
                            setTimeout(() => {
                                $('#boxunder').remove();
                            }, 800);
                            </script>
                        @endif
                    </div>
                </div>
                {{-- Fare Rules Section End --}}

                <div class="col-md-8 col-md-offset-2 kuchh-bhi2">
                    <!-- Travller Form Data Start -->
                    <div id="traveller-section" class="collapse pb-20">
                        <form id="main-form" action="{{ route('galelio-traveller-details-roundtrip') }}" method="post"
                            data-parsley-validate>
                            @csrf
                            
                            <input type="hidden" name="code" value="{{$code}}">
                            <input type="hidden" name="city1" value="{{$city1}}">
                            <input type="hidden" name="city2" value="{{$city2}}">
                            <input type="hidden" name="time1" value="{{$time1}}">
                            <input type="hidden" name="time2" value="{{$time2}}">
                            <input type="hidden" name="delay" value="{{$delay}}">
                            <input type="hidden" name="stop" value="{{$stop}}">
                            <input type="hidden" name="travellers" value="{{ json_encode($travellers, true) }}">
                            
                            <input type="hidden" name="flightData" value="{{ json_encode($flightData??'', true) }}">
                            
                            <input type="hidden" name="SessionID"
                                value="{{ json_encode(['Outbound' => $OutboundSessionID, 'Inbound' => $InboundSessionID], true) }}">
                            <input type="hidden" name="ReferenceNo"
                                value="{{ json_encode(['Outbound' => $OutboundReferenceNo, 'Inbound' => $InboundReferenceNo], true) }}">
                            <input type="hidden" name="Provider"
                                value="{{ json_encode(['Outbound' => $OutboundProvider, 'Inbound' => $InboundProvider], true) }}">
                            <input type="hidden" name="Key"
                                value="{{ json_encode(['Outbound' => $OutboundKey, 'Inbound' => $InboundKey], true) }}">
                                @php
                                 session(['total_fare'=>$total_fare]);
                                @endphp
                            <input type="hidden" name="fare" value="{{ $total_fare }}">
                            <input type="hidden" id="Chari"name="Chari">
                            <input type="hidden" id="textDis"name="textDis" value="no">
                            <input type="hidden" name="trip" value="RoundTripGal">
                            <x-flight.travellerform :travellers="$travellers" :originCountry="$originCountry"
                                :destinationCountry="$destinationCountry" :jurneyDate="$jurneyDate" />
                        </form>
                    </div>
                    <!-- Travller Form Data End -->
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>
    {{-- Itnarry End --}}
    </div>
    <!-- DESKTOP VIEW END -->

    {{-- <x-footer />--}}
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/userstyle.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
@stop
@section('script')
    <script src="{{asset('assets/js/review_page.js')}}"></script>
    <script>
        $(document).ready(function() {

            $('#travller-btn').on('click', function() {
                $('#main-form').submit();
            });

            $("#booking-btn-section").show();
            $("#traveller-section").hide();
            $("#payment-section").hide();
            $("#information").show();

            $("#booking-btn").click(function() {
                $("#booking-btn-section").hide();
                $("#traveller-section").show();
                $("#information").hide();
            });
            $("#travller-btn").click(function() {
                $("#payment-section").show();
            });

            $('.js-example-basic-single').select2();


            function togglePopup() {
                $(".content").toggle();
            }

        });
    </script>
    <script>
    let checkbox = document.getElementById("flexCheckChecked");
    let DisAmBox = document.getElementById("flexRadioDefault1");
    let DisText = document.getElementById("DisText");
    let text = document.getElementById("Chari");
    let textDis = document.getElementById("textDis");
    let TotalFare = document.getElementById("TotalFare");
    let ChaAm = document.getElementById("ChaAm");
    let DisAm = document.getElementById("DisAm");
    let removrBtn = document.getElementById("remove-btn");
      checkbox.addEventListener( "change", () => {
            // console.log(TotalFare , TotalFare.innerText);
         if ( checkbox.checked ) {
            text.value = "yes";
            TotalFare.innerText = parseInt(TotalFare.innerText) +10;
            ChaAm.innerText = parseInt(ChaAm.innerText) +10;
         } else {
            text.value = "no";
            TotalFare.innerText = parseInt(TotalFare.innerText) - 10;
            ChaAm.innerText = parseInt(ChaAm.innerText) - 10;
         }
      });
      
        removrBtn.style.display= "none";
      $('input[name=DisAmou]').on('change',function () {
          let Disvalue = $(this).filter(':checked').val();
          if ( Disvalue == 'Yes' ) {
            textDis.value = "yes";
            DisAm.innerText = parseInt(DisAm.innerText) +50;
            TotalFare.innerText = parseInt(TotalFare.innerText) - 50;
            DisText.innerText = "Congratulations! Promo Discount of Rs. 50 applied successfully.";
            DisText.style.color= "green";
            removrBtn.style.display= "block";
            DisText.style.display= "block";
            // console.log($(this).filter(':checked').val() , Disvalue);
         } else {
            textDis.value = "no";
            DisAm.innerText = parseInt(DisAm.innerText) - 50;
            TotalFare.innerText = parseInt(TotalFare.innerText) + 50;
            DisText.innerText = "Use this coupon and get Rs 50 instant discount on your flight booking.";
            DisText.style.color= "black";
            removrBtn.style.display= "none";
            removrBtn.style.color= "black";
         }
            // console.log($(this).filter(':checked').val() , Disvalue);
    });
    </script>
    
    <script>
       window.addEventListener( "pageshow", function ( event ) {
      var historyTraversal = event.persisted || 
                             ( typeof window.performance != "undefined" && 
                                  window.performance.navigation.type === 2 );
      if ( historyTraversal ) {
       
        // Handle page restore.
        window.location.reload();
      }
    });
    </script>
@stop
@endsection
