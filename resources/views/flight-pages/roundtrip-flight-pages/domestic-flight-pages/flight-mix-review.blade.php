@extends('layouts.master')
@section('title', 'Wagnistrip  ')
@section('body')
    <!-- DESKTOP VIEW START -->

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
    $_GET['cvalue'] = $cvalue;
    function modify_amt($amt){
    $cvalue = $_GET['cvalue'];
        if(!empty($amt)){
            return ceil($amt*$cvalue);
        }
        else{
            return 0;
        }
    }      
@endphp
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
    use App\Http\Controllers\Airline\AirportiatacodesController;
    @endphp
    {{-- Itnarry start --}}
    <section>
        <div class="container">
            <div class="row rom-rev">
               
                <div class="col-sm-8 pt-20 pb-20">
                    {{-- <div class="scrollfix"> --}}
                    <h4>Itinerary</h4>
                    {{-- Flight Review Start --}}
                @if (isset($MixRoundtripGalNonstopAmdNonstop))
                    @php
                    $jurneyDate = getDateFormat($MixRoundtripGalNonstopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    $originCountry = $MixRoundtripGalNonstopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripGalNonstopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['AirportCode'];
                    $fare = $MixRoundtripGalNonstopAmdNonstop[1]['fareInformative'];
                    $otherInformation = $MixRoundtripGalNonstopAmdNonstop[1]['otherInformation'];
                    $getsession = $MixRoundtripGalNonstopAmdNonstop[1]['getsession'];
                    $fareGal = $MixRoundtripGalNonstopAmdNonstop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripGalNonstopAmdNonstop[0]['ReferenceNo'];
                    $GalKey = $MixRoundtripGalNonstopAmdNonstop[0]['Key'];
                    $GalProvider = $MixRoundtripGalNonstopAmdNonstop[0]['AirPricingResponse'][0]['Provider'];
                    $flightData = [ $MixRoundtripGalNonstopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'] ,$MixRoundtripGalNonstopAmdNonstop[1]['sellResult']->response->itineraryDetails->segmentInformation ] ;
                   
                    @endphp
                        <x-flight.segment-gl-section trip="DEPART" triptype="NON-STOP"
                            :segment="$MixRoundtripGalNonstopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                        <div class="pb-10">
                            <div class="boxunder">

                                <x-flight.segmentsection trip="RETURN" triptype="NON STOP"
                                    :segmentInformation="$MixRoundtripGalNonstopAmdNonstop[1]['sellResult']->response->itineraryDetails->segmentInformation"
                                    :itineraryDetails="$MixRoundtripGalNonstopAmdNonstop[1]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripGalNonstopAmdNonstop[1]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalNonstopAmdNonstop[1]['sellResult']->response->itineraryDetails->segmentInformation"
                                        :arrivalingTime="$MixRoundtripGalNonstopAmdNonstop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalNonstopAmdNonstop[1]['otherInformation']['operatingCompany']" />

                                </div>
                            </div>
                        </div>

                @elseif (isset($MixRoundtripGalNonstopAmdOnestop))

                    @php
                    
                    $jurneyDate = getDateFormat($MixRoundtripGalNonstopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    $originCountry = $MixRoundtripGalNonstopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripGalNonstopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['AirportCode'];
                    $fare = $MixRoundtripGalNonstopAmdOnestop[1]['fareInformative'];
                    $otherInformation = $MixRoundtripGalNonstopAmdOnestop[1]['otherInformation'];
                    $getsession = $MixRoundtripGalNonstopAmdOnestop[1]['getsession'];
                    $fareGal = $MixRoundtripGalNonstopAmdOnestop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $GalKey = $MixRoundtripGalNonstopAmdOnestop[0]['Key'];
                    $ReferenceNo = $MixRoundtripGalNonstopAmdOnestop[0]['ReferenceNo'];
                    $SessionID = $SessionID;
                    $GalProvider = $MixRoundtripGalNonstopAmdOnestop[0]['AirPricingResponse'][0]['Provider'];

                    $flightData = [ $MixRoundtripGalNonstopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'] ,$MixRoundtripGalNonstopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation ] ;
                   
                    @endphp
                    
                        <x-flight.segment-gl-section trip="DEPART" triptype="NON-STOP"
                            :segment="$MixRoundtripGalNonstopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="1 STOP"
                                    :segmentInformation="$MixRoundtripGalNonstopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                    :itineraryDetails="$MixRoundtripGalNonstopAmdOnestop[1]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripGalNonstopAmdOnestop[1]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalNonstopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                        :arrivalingTime="$MixRoundtripGalNonstopAmdOnestop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalNonstopAmdOnestop[1]['otherInformation']['operatingCompany_1']" />

                                    <div class="col-sm-12 col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($MixRoundtripGalNonstopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripGalNonstopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalNonstopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[1]"
                                        :arrivalingTime="$MixRoundtripGalNonstopAmdOnestop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalNonstopAmdOnestop[1]['otherInformation']['operatingCompany_2']" />

                                </div>
                            </div>
                        </div>
                    @elseif (isset($MixRoundtripGalNonstopAmdTwostop))
                    @php
                    
                    $originCountry = $MixRoundtripGalNonstopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripGalNonstopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripGalNonstopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
            
                    $fare = $MixRoundtripGalNonstopAmdTwostop[1]['fareInformative'];
                    $otherInformation = $MixRoundtripGalNonstopAmdTwostop[1]['otherInformation'];
                    $getsession = $MixRoundtripGalNonstopAmdTwostop[1]['getsession'];
                    $fareGal = $MixRoundtripGalNonstopAmdTwostop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripGalNonstopAmdTwostop[0]['ReferenceNo'];
                    $GalKey = $MixRoundtripGalNonstopAmdTwostop[0]['Key'];
                    $GalProvider = $MixRoundtripGalNonstopAmdTwostop[0]['AirPricingResponse'][0]['Provider'];
                    
                    $flightData = [ $MixRoundtripGalNonstopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'] ,$MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation ] ;
                   
                    @endphp

                        <x-flight.segment-gl-section trip="DEPART" triptype="NON-STOP"
                            :segment="$MixRoundtripGalNonstopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="1 STOP"
                                    :segmentInformation="$MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                    :itineraryDetails="$MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripGalNonstopAmdTwostop[1]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                        :arrivalingTime="$MixRoundtripGalNonstopAmdTwostop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalNonstopAmdTwostop[1]['otherInformation']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[1]"
                                        :arrivalingTime="$MixRoundtripGalNonstopAmdTwostop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalNonstopAmdTwostop[1]['otherInformation']['operatingCompany_2']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[1], $MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[2]) }}
                                        </div>
                                    </div>
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalNonstopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[2]"
                                        :arrivalingTime="$MixRoundtripGalNonstopAmdTwostop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalNonstopAmdTwostop[1]['otherInformation']['operatingCompany_3']" />

                                </div>
                            </div>
                        </div>

                    @elseif (isset($MixRoundtripAmdNonstopGalNonstop))

                    @php
                    
                    $originCountry = $MixRoundtripAmdNonstopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripAmdNonstopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripAmdNonstopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    $fare = $MixRoundtripAmdNonstopGalNonstop[0]['fareInformative'];
                    $otherInformation = $MixRoundtripAmdNonstopGalNonstop[0]['otherInformation'];
                    $getsession = $MixRoundtripAmdNonstopGalNonstop[0]['getsession'];
                    $fareGal = $MixRoundtripAmdNonstopGalNonstop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripAmdNonstopGalNonstop[1]['ReferenceNo'];
                    $GalKey = $MixRoundtripAmdNonstopGalNonstop[1]['Key'];
                    $GalProvider = $MixRoundtripAmdNonstopGalNonstop[1]['AirPricingResponse'][0]['Provider'];
                
                    $flightData = [$MixRoundtripAmdNonstopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation , $MixRoundtripAmdNonstopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']] ;
                   
                    @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="NON STOP"
                                    :segmentInformation="$MixRoundtripAmdNonstopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation"
                                    :itineraryDetails="$MixRoundtripAmdNonstopGalNonstop[0]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripAmdNonstopGalNonstop[0]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdNonstopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation"
                                        :arrivalingTime="$MixRoundtripAmdNonstopGalNonstop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdNonstopGalNonstop[0]['otherInformation']['operatingCompany']" />

                                </div>
                            </div>
                        </div>

                        <x-flight.segment-gl-section trip="RETRUN" triptype="NON-STOP"
                            :segment="$MixRoundtripAmdNonstopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @elseif (isset($MixRoundtripAmdOnestopGalNonstop))

                        @php
                        $originCountry = $MixRoundtripAmdOnestopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                        $destinationCountry = $MixRoundtripAmdOnestopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['AirportCode'];
                        $jurneyDate = getDateFormat($MixRoundtripAmdOnestopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                        
                        $fare = $MixRoundtripAmdOnestopGalNonstop[0]['fareInformative'];
                        $otherInformation = $MixRoundtripAmdOnestopGalNonstop[0]['otherInformation'];
                        $getsession = $MixRoundtripAmdOnestopGalNonstop[0]['getsession'];
                        $fareGal = $MixRoundtripAmdOnestopGalNonstop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                        $SessionID = $SessionID;
                        $ReferenceNo = $MixRoundtripAmdOnestopGalNonstop[1]['ReferenceNo'];
                        $GalKey = $MixRoundtripAmdOnestopGalNonstop[1]['Key'];
                        $GalProvider = $MixRoundtripAmdOnestopGalNonstop[1]['AirPricingResponse'][0]['Provider'];

                    $flightData = [$MixRoundtripAmdOnestopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation , $MixRoundtripAmdOnestopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']] ;
                   
                        
                        @endphp

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="1 STOP"
                                    :segmentInformation="$MixRoundtripAmdOnestopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                    :itineraryDetails="$MixRoundtripAmdOnestopGalNonstop[0]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripAmdOnestopGalNonstop[0]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdOnestopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                        :arrivalingTime="$MixRoundtripAmdOnestopGalNonstop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdOnestopGalNonstop[0]['otherInformation']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($MixRoundtripAmdOnestopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripAmdOnestopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdOnestopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]"
                                        :arrivalingTime="$MixRoundtripAmdOnestopGalNonstop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdOnestopGalNonstop[0]['otherInformation']['operatingCompany_2']" />

                                </div>
                            </div>
                        </div>

                        <x-flight.segment-gl-section trip="RETRUN" triptype="NON-STOP"
                            :segment="$MixRoundtripAmdOnestopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @elseif (isset($MixRoundtripAmdTwostopGalNonstop))
                    @php
                    
                    $originCountry = $MixRoundtripAmdTwostopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripAmdTwostopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripAmdTwostopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    
                    $fare = $MixRoundtripAmdTwostopGalNonstop[0]['fareInformative'];
                    $otherInformation = $MixRoundtripAmdTwostopGalNonstop[0]['otherInformation'];
                    $getsession = $MixRoundtripAmdTwostopGalNonstop[0]['getsession'];
                    $fareGal = $MixRoundtripAmdTwostopGalNonstop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripAmdTwostopGalNonstop[1]['ReferenceNo'];
                    $GalKey = $MixRoundtripAmdTwostopGalNonstop[1]['Key'];
                    $GalProvider = $MixRoundtripAmdTwostopGalNonstop[1]['AirPricingResponse'][0]['Provider'];
                    
                    $flightData = [$MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation , $MixRoundtripAmdTwostopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']] ;
                   
                    @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="1 STOP"
                                    :segmentInformation="$MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                    :itineraryDetails="$MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripAmdTwostopGalNonstop[0]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                        :arrivalingTime="$MixRoundtripAmdTwostopGalNonstop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdTwostopGalNonstop[0]['otherInformation']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]"
                                        :arrivalingTime="$MixRoundtripAmdTwostopGalNonstop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdTwostopGalNonstop[0]['otherInformation']['operatingCompany_2']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[1], $MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[2]) }}
                                        </div>
                                    </div>
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdTwostopGalNonstop[0]['sellResult']->response->itineraryDetails->segmentInformation[2]"
                                        :arrivalingTime="$MixRoundtripAmdTwostopGalNonstop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdTwostopGalNonstop[0]['otherInformation']['operatingCompany_3']" />

                                </div>
                            </div>
                        </div>

                        <x-flight.segment-gl-section trip="RETRUN" triptype="NON-STOP"
                            :segment="$MixRoundtripAmdTwostopGalNonstop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @elseif (isset($MixRoundtripGalOnestopAmdNonstop))
                    @php
                    
                    $originCountry = $MixRoundtripGalOnestopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripGalOnestopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][1]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripGalOnestopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    
                    $fare = $MixRoundtripGalOnestopAmdNonstop[1]['fareInformative'];
                    $otherInformation = $MixRoundtripGalOnestopAmdNonstop[1]['otherInformation'];
                    $getsession = $MixRoundtripGalOnestopAmdNonstop[1]['getsession'];
                    $fareGal = $MixRoundtripGalOnestopAmdNonstop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripGalOnestopAmdNonstop[0]['ReferenceNo'];
                    $GalKey = $MixRoundtripGalOnestopAmdNonstop[0]['Key'];
                    $GalProvider = $MixRoundtripGalOnestopAmdNonstop[0]['AirPricingResponse'][0]['Provider'];

                    $flightData = [$MixRoundtripGalOnestopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'] , $MixRoundtripGalOnestopAmdNonstop[1]['sellResult']->response->itineraryDetails->segmentInformation] ;
                   
                    @endphp
                        <x-flight.segment-gl-section trip="DEPART" triptype="1-STOP"
                            :segment="$MixRoundtripGalOnestopAmdNonstop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="NON STOP"
                                    :segmentInformation="$MixRoundtripGalOnestopAmdNonstop[1]['sellResult']->response->itineraryDetails->segmentInformation"
                                    :itineraryDetails="$MixRoundtripGalOnestopAmdNonstop[1]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripGalOnestopAmdNonstop[1]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalOnestopAmdNonstop[1]['sellResult']->response->itineraryDetails->segmentInformation"
                                        :arrivalingTime="$MixRoundtripGalOnestopAmdNonstop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalOnestopAmdNonstop[1]['otherInformation']['operatingCompany']" />
                                </div>
                            </div>
                        </div>

                    @elseif (isset($MixRoundtripGalOnestopAmdOnestop))
                    @php
                         
                    $originCountry = $MixRoundtripGalOnestopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripGalOnestopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][1]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripGalOnestopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    
                    $fare = $MixRoundtripGalOnestopAmdOnestop[1]['fareInformative'];
                    $otherInformation = $MixRoundtripGalOnestopAmdOnestop[1]['otherInformation'];
                    $getsession = $MixRoundtripGalOnestopAmdOnestop[1]['getsession'];
                    $fareGal = $MixRoundtripGalOnestopAmdOnestop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripGalOnestopAmdOnestop[0]['ReferenceNo'];
                    $GalKey = $MixRoundtripGalOnestopAmdOnestop[0]['Key'];
                    $GalProvider = $MixRoundtripGalOnestopAmdOnestop[0]['AirPricingResponse'][0]['Provider'];

                    $flightData = [$MixRoundtripGalOnestopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'] , $MixRoundtripGalOnestopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation] ;
                    @endphp
                        <x-flight.segment-gl-section trip="DEPART" triptype="1-STOP"
                            :segment="$MixRoundtripGalOnestopAmdOnestop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="1-STOP"
                                    :segmentInformation="$MixRoundtripGalOnestopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                    :itineraryDetails="$MixRoundtripGalOnestopAmdOnestop[1]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripGalOnestopAmdOnestop[1]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalOnestopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                        :arrivalingTime="$MixRoundtripGalOnestopAmdOnestop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalOnestopAmdOnestop[1]['otherInformation']['operatingCompany_1']" />
                                </div>

                                <div class="col-sm-12  col_sm-121">
                                    <div class="borderbotum-2"></div>
                                    <div class="borderraduesround">
                                        {{ getTimeDff_fn($MixRoundtripGalOnestopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripGalOnestopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                    </div>
                                </div>

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalOnestopAmdOnestop[1]['sellResult']->response->itineraryDetails->segmentInformation[1]"
                                        :arrivalingTime="$MixRoundtripGalOnestopAmdOnestop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalOnestopAmdOnestop[1]['otherInformation']['operatingCompany_2']" />
                                </div>
                            </div>
                        </div>

                    @elseif (isset($MixRoundtripGalOnestopAmdTwostop))
                    @php
                    
                    $originCountry = $MixRoundtripGalOnestopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripGalOnestopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][1]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripGalOnestopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    
                    $fare = $MixRoundtripGalOnestopAmdTwostop[1]['fareInformative'];
                    $otherInformation = $MixRoundtripGalOnestopAmdTwostop[1]['otherInformation'];
                    $getsession = $MixRoundtripGalOnestopAmdTwostop[1]['getsession'];
                    $fareGal = $MixRoundtripGalOnestopAmdTwostop[0]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $GalKey = $MixRoundtripGalOnestopAmdTwostop[0]['Key'];
                    $ReferenceNo = $MixRoundtripGalOnestopAmdTwostop[0]['ReferenceNo'];
                    $SessionID = $SessionID;
                    $GalProvider = $MixRoundtripGalOnestopAmdTwostop[0]['AirPricingResponse'][0]['Provider'];

                    $flightData = [$MixRoundtripGalOnestopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary'] , $MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation] ;
                    @endphp
                        <x-flight.segment-gl-section trip="DEPART" triptype="1-STOP"
                            :segment="$MixRoundtripGalOnestopAmdTwostop[0]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="NON STOP"
                                    :segmentInformation="$MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                    :itineraryDetails="$MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripGalOnestopAmdTwostop[1]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                        :arrivalingTime="$MixRoundtripGalOnestopAmdTwostop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalOnestopAmdTwostop[1]['otherInformation']['operatingCompany_1']" />
                                </div>

                                <div class="col-sm-12  col_sm-121">
                                    <div class="borderbotum-2"></div>
                                    <div class="borderraduesround">
                                        {{ getTimeDff_fn($MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                    </div>
                                </div>

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[1]"
                                        :arrivalingTime="$MixRoundtripGalOnestopAmdTwostop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalOnestopAmdTwostop[1]['otherInformation']['operatingCompany_2']" />
                                </div>
                                <div class="col-sm-12  col_sm-121">
                                    <div class="borderbotum-2"></div>
                                    <div class="borderraduesround">
                                        {{ getTimeDff_fn($MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[1], $MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[2]) }}
                                    </div>
                                </div>

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripGalOnestopAmdTwostop[1]['sellResult']->response->itineraryDetails->segmentInformation[2]"
                                        :arrivalingTime="$MixRoundtripGalOnestopAmdTwostop[1]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripGalOnestopAmdTwostop[1]['otherInformation']['operatingCompany_3']" />
                                </div>
                            </div>
                        </div>
                    @elseif (isset($MixRoundtripAmdNonstopGalOnestop))
                    @php
                    
                    $originCountry = $MixRoundtripAmdNonstopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripAmdNonstopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][1]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripAmdNonstopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    
                    $fare = $MixRoundtripAmdNonstopGalOnestop[0]['fareInformative'];
                    $otherInformation = $MixRoundtripAmdNonstopGalOnestop[0]['otherInformation'];
                    $getsession = $MixRoundtripAmdNonstopGalOnestop[0]['getsession'];
                    $fareGal = $MixRoundtripAmdNonstopGalOnestop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripAmdNonstopGalOnestop[1]['ReferenceNo'];
                    $GalKey = $MixRoundtripAmdNonstopGalOnestop[1]['Key'];
                    $GalProvider = $MixRoundtripAmdNonstopGalOnestop[1]['AirPricingResponse'][0]['Provider'];
                    
                    $flightData = [$MixRoundtripAmdNonstopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation , $MixRoundtripAmdNonstopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'] ] ;
                    
                    @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="NON STOP"
                                    :segmentInformation="$MixRoundtripAmdNonstopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation"
                                    :itineraryDetails="$MixRoundtripAmdNonstopGalOnestop[0]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripAmdNonstopGalOnestop[0]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdNonstopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation"
                                        :arrivalingTime="$MixRoundtripAmdNonstopGalOnestop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdNonstopGalOnestop[0]['otherInformation']['operatingCompany']" />
                                </div>
                            </div>
                        </div>

                        <x-flight.segment-gl-section trip="RETRUN" triptype="1-STOP"
                            :segment="$MixRoundtripAmdNonstopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @elseif (isset($MixRoundtripAmdOnestopGalOnestop))
                    @php
                             
                    $originCountry = $MixRoundtripAmdOnestopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripAmdOnestopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][1]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripAmdOnestopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripAmdOnestopGalOnestop[1]['ReferenceNo'];
                    $GalKey = $MixRoundtripAmdOnestopGalOnestop[1]['Key'];
                    $fareGal = $MixRoundtripAmdOnestopGalOnestop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $fare = $MixRoundtripAmdOnestopGalOnestop[0]['fareInformative'];
                    $otherInformation = $MixRoundtripAmdOnestopGalOnestop[0]['otherInformation'];
                    $getsession = $MixRoundtripAmdOnestopGalOnestop[0]['getsession'];
                    $GalProvider = $MixRoundtripAmdOnestopGalOnestop[1]['AirPricingResponse'][0]['Provider'];
                    
                    $flightData = [$MixRoundtripAmdOnestopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation , $MixRoundtripAmdOnestopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'] ] ;
                    
                    @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="1 STOP"
                                    :segmentInformation="$MixRoundtripAmdOnestopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                    :itineraryDetails="$MixRoundtripAmdOnestopGalOnestop[0]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripAmdOnestopGalOnestop[0]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdOnestopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                        :arrivalingTime="$MixRoundtripAmdOnestopGalOnestop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdOnestopGalOnestop[0]['otherInformation']['operatingCompany_1']" />
                                </div>

                                <div class="col-sm-12  col_sm-121">
                                    <div class="borderbotum-2"></div>
                                    <div class="borderraduesround">
                                        {{ getTimeDff_fn($MixRoundtripAmdOnestopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripAmdOnestopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                    </div>
                                </div>

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdOnestopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]"
                                        :arrivalingTime="$MixRoundtripAmdOnestopGalOnestop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdOnestopGalOnestop[0]['otherInformation']['operatingCompany_2']" />
                                </div>
                            </div>
                        </div>

                        <x-flight.segment-gl-section trip="RETRUN" triptype="1-STOP"
                        :segment="$MixRoundtripAmdOnestopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @elseif (isset($MixRoundtripAmdTwostopGalOnestop))
                    @php
                    
                    $originCountry = $MixRoundtripAmdTwostopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['AirportCode'];
                    $destinationCountry = $MixRoundtripAmdTwostopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][1]['Destination']['AirportCode'];
                    $jurneyDate = getDateFormat($MixRoundtripAmdTwostopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'][0]['Origin']['DateTime']);
                    
                    $SessionID = $SessionID;
                    $ReferenceNo = $MixRoundtripAmdTwostopGalOnestop[1]['ReferenceNo'];
                    $GalKey = $MixRoundtripAmdTwostopGalOnestop[1]['Key'];
                    $fareGal = $MixRoundtripAmdTwostopGalOnestop[1]['AirPricingResponse'][0]['PricingInfos']['PricingInfo'];
                    $otherInformation = $MixRoundtripAmdTwostopGalOnestop[0]['otherInformation'];
                    $fare = $MixRoundtripAmdTwostopGalOnestop[0]['fareInformative'];
                    $getsession = $MixRoundtripAmdTwostopGalOnestop[0]['getsession'];
                    $GalProvider = $MixRoundtripAmdTwostopGalOnestop[1]['AirPricingResponse'][0]['Provider'];
                    
                    $flightData = [$MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation , $MixRoundtripAmdTwostopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary'] ] ;
                    
                    @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="NON STOP"
                                    :segmentInformation="$MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                    :itineraryDetails="$MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails"
                                    :arrivalingTime="$MixRoundtripAmdTwostopGalOnestop[0]['otherInformation']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[0]"
                                        :arrivalingTime="$MixRoundtripAmdTwostopGalOnestop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdTwostopGalOnestop[0]['otherInformation']['operatingCompany_1']" />
                                </div>

                                <div class="col-sm-12  col_sm-121">
                                    <div class="borderbotum-2"></div>
                                    <div class="borderraduesround">
                                        {{ getTimeDff_fn($MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                    </div>
                                </div>

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]"
                                        :arrivalingTime="$MixRoundtripAmdTwostopGalOnestop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdTwostopGalOnestop[0]['otherInformation']['operatingCompany_2']" />
                                </div>

                                <div class="col-sm-12 col_sm-121">
                                    <div class="borderbotum-2"></div>
                                    <div class="borderraduesround">
                                        {{ getTimeDff_fn($MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[0], $MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[1]) }}
                                    </div>
                                </div>

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$MixRoundtripAmdTwostopGalOnestop[0]['sellResult']->response->itineraryDetails->segmentInformation[2]"
                                        :arrivalingTime="$MixRoundtripAmdTwostopGalOnestop[0]['otherInformation']['arrivalingTime']"
                                        :operatingCompany="$MixRoundtripAmdTwostopGalOnestop[0]['otherInformation']['operatingCompany_3']" />
                                </div>

                            </div>
                        </div>

                        <x-flight.segment-gl-section trip="RETRUN" triptype="1-STOP"
                            :segment="$MixRoundtripAmdTwostopGalOnestop[1]['AirPricingResponse'][0]['Itineraries']['Itinerary']" />

                    @endif
                    {{-- Flight Review End --}}

                    <div class="row">
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
                    </div>

                    <div class="text-center" id="booking-btn-section" class="collapse in " style="width:100%;">
                        <button id="booking-btn" type="button" class="btn btn-primary" data-toggle="collapse"
                           style="width:97%;"  data-toggle="collapse in"> CONTINUE </button>
                    </div>
                    {{-- Travller Form Data Start --}}
                    <div id="traveller-section" class="collapse pb-20">
                        <form id="main-form" action="{{ url('/booking/mix') }}" method="Post" data-parsley-validate>
                            @csrf
                            <input type="hidden" name="SessionID" value="{{ $SessionID }}">
                            <input type="hidden" name="ReferenceNo" value="{{ $ReferenceNo }}">
                            <input type="hidden" name="Key" value="{{ $GalKey }}">
                            
                            <input type="hidden" name="flightData" value="{{ json_encode($flightData??'', true) }}">
                            <input type="hidden" name="travellers" value="{{ json_encode($travellers, true) }}">
                            <input type="hidden" name="getsession" value="{{ json_encode($getsession, true) }}">
                            <input type="hidden" name="otherInformations"
                                value="{{ json_encode($otherInformation, true) }}">
                            {{-- <input type="hidden" name="fare" value="{{ dd($fare) }}"> --}}
                            <input type="hidden" id="Chari"name="Chari">
                            <input type="hidden" id="textDis"name="textDis" value="no">
                            <input type="hidden" name="trip" value="DomesticRoundTrip">
                            <input type="hidden" name="GalProvider" value="{{$GalProvider?? ''}}">
                            <x-flight.travellerform :travellers="$travellers" :originCountry="$originCountry"
                                :destinationCountry="$destinationCountry" :jurneyDate="$jurneyDate" />
                        </form>
                    </div>
                    {{-- Travller Form Data End --}}

                </div>

                {{-- Fare Rules Section Start --}}
                <div class="col-sm-4 pt-20">
                    <h5>Fare Summary</h5>

                    @php
                        if (is_array($fare->response->mainGroup->pricingGroupLevelGroup) == true) {
                            $newFare = $fare->response->mainGroup->pricingGroupLevelGroup;
                        } else {
                            $newFare = [$fare->response->mainGroup->pricingGroupLevelGroup];
                        }
                    @endphp

                    @if ($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] == 0 && $travellers['noOfInfants'] == 0)

                        {{-- Data at Start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14"> @php
                                        is_array($newFare[0]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup = $newFare[0]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup = [$newFare[0]->fareInfoGroup->segmentLevelGroup]);
                                        
                                        if ($newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->currency === 'INR') {

                                            $monetaryDetails = $newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount;
                                            $otherMonetaryDetails = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount;
                                            
                                        } else {

                                            $monetaryDetails = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails[0]->amount;
                                            $otherMonetaryDetails = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails[1]->amount;
                                        }
                                        
                                    @endphp
                                        {{ $segmentLevelGroup[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits . 'X' }} {!! $icon !!}
                                        {{ modify_amt(array_sum([$monetaryDetails, $fareGal[0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare']])) }} )
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * array_sum([(int) $monetaryDetails, $fareGal[0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare']])) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt(array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails+$Charge - (int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $monetaryDetails, $fareGal[0]['Total']['FuelSurcharge']+$Charge, $fareGal[0]['Total']['OtherTax']])) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services

                                </div>
                                
                                <div  class="collapse show">
                                <div class="form-check ">
                                  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                  <label class="form-check-label" for="flexCheckChecked">
                                    Charity 
                                  </label>
                                <span class="float-right fontsize-17">{!! $icon !!} <span id="ChaAm">10</span></span>
                                  
                                </div>
                                </div>
                                 <div id="price" class="collapse show">
                                    <span class="font-14">Discount </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} <span id="DisAm">0</span></span>
                                </div> 
                                
                                <div id="price" class="collapse show">
                                    <span class="font-14">Convenience fee </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} 0</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            @php $totalAmount =  array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails+$Charge, $fareGal[0]['Total']['Fare']+$Charge]); @endphp
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        {{session()->put('totalAmount',$totalAmount)}} 
                                        
                                        <span id="TotalFare">
                                        {{ modify_amt($totalAmount+10) }}
                                        </span>
                                        </span>
                                </div>
                            </div>
                        </div>


                        @elseif($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] != 0 && $travellers['noOfInfants'] == 0)

                        @php
                            is_array($newFare[0]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup1 = $newFare[0]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup1 = [$newFare[0]->fareInfoGroup->segmentLevelGroup]);
                            is_array($newFare[1]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup2 = $newFare[1]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup2 = [$newFare[1]->fareInfoGroup->segmentLevelGroup]);
                            
                            if ($newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->currency === 'INR') {
                                $monetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount;
                                $otherMonetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount;
                            } else {
                                $monetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails[0]->amount;
                                $otherMonetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails[1]->amount;
                            }
                            
                            if ($newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->currency === 'INR') {
                                $monetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount;
                                $otherMonetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount;
                            } else {
                                $monetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails[0]->amount;
                                $otherMonetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails[1]->amount;
                            }
                            
                        @endphp
                        {{-- Data start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare</div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup1[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$monetaryDetails_1, $fareGal[0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare']])) }} )
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$monetaryDetails_1, $fareGal[0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare']])) }}</span>
                                </div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup2[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$monetaryDetails_2, $fareGal[0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare']])) }} )
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$monetaryDetails_2, $fareGal[0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare']])) }}</span>
                                </div>
                            </div>

                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div class="p-1">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt(array_sum([array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails_1+$Charge, $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails_2]) - array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $monetaryDetails_1, $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $monetaryDetails_2]), $fareGal[0]['Total']['FuelSurcharge'], $fareGal[0]['Total']['OtherTax']])) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services
                                </div>
                                <div  class="collapse show">
                                <div class="form-check ">
                                  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                  <label class="form-check-label" for="flexCheckChecked">
                                    Charity 
                                  </label>
                                <span class="float-right fontsize-17">{!! $icon !!} <span id="ChaAm">10</span></span>
                                  
                                </div>
                                </div>
                                 <div id="price" class="collapse show">
                                    <span class="font-14">Discount </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} <span id="DisAm">0</span></span>
                                </div> 
                                <div id="price" class="collapse show">
                                    <span class="font-14">Convenience fee </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} 0</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            @php $totalAmount = array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails_1+$Charge, (int) $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails_2, $fareGal[0]['Total']['Fare']]); @endphp
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                      {{session()->put('totalAmount',$totalAmount)}}
                                      <span id="TotalFare">
                                        {{ modify_amt($totalAmount+10) }}
                                        </span>
                                      </span>
                                </div>
                            </div>
                        </div>


                        @elseif($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] == 0 && $travellers['noOfInfants'] != 0)

                        @php
                            is_array($newFare[0]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup1 = $newFare[0]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup1 = [$newFare[0]->fareInfoGroup->segmentLevelGroup]);
                            is_array($newFare[1]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup2 = $newFare[1]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup2 = [$newFare[1]->fareInfoGroup->segmentLevelGroup]);
                            
                            if ($newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->currency === 'INR') {
                                $monetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount;
                                $otherMonetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount;
                            } else {
                                $monetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails[0]->amount;
                                $otherMonetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails[1]->amount;
                            }
                            
                            if ($newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->currency === 'INR') {
                                $monetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount;
                                $otherMonetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount;
                            } else {
                                $monetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails[0]->amount;
                                $otherMonetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails[1]->amount;
                            }
                            
                        @endphp
                        {{-- Data start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare</div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup1[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$monetaryDetails_1, $fareGal[0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare']])) }} )
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$monetaryDetails_1, $fareGal[0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare']])) }}</span>
                                </div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup2[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$monetaryDetails_2, $fareGal[0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare']])) }} )
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$monetaryDetails_2, $fareGal[0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare']])) }}</span>
                                </div>
                            </div>

                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div class="p-1">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt(array_sum([array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails_1+$Charge, $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails_2]) - array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $monetaryDetails_1, $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $monetaryDetails_2]), $fareGal[0]['Total']['FuelSurcharge'], $fareGal[0]['Total']['OtherTax']])) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services
                                </div>
                                <div  class="collapse show">
                                <div class="form-check ">
                                  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                  <label class="form-check-label" for="flexCheckChecked">
                                    Charity 
                                  </label>
                                <span class="float-right fontsize-17">{!! $icon !!} <span id="ChaAm">10</span></span>
                                  
                                </div>
                                </div>
                                 <div id="price" class="collapse show">
                                    <span class="font-14">Discount </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} <span id="DisAm">0</span></span>
                                </div> 
                                <div id="price" class="collapse show">
                                    <span class="font-14">Convenience fee </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} 0</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            @php $totalAmount = array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails_1+$Charge, (int) $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) $otherMonetaryDetails_2, $fareGal[0]['Total']['Fare']]); @endphp
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                       {{session()->put('totalAmount',$totalAmount)}}<span id="TotalFare">
                                        {{ modify_amt($totalAmount+10) }}
                                        </span></span>
                                    
                                </div>
                            </div>
                        </div>

                    @elseif($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] != 0 &&
                        $travellers['noOfInfants'] != 0)
                        @php
                            is_array($newFare[0]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup1 = $newFare[0]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup1 = [$newFare[0]->fareInfoGroup->segmentLevelGroup]);
                            is_array($newFare[1]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup2 = $newFare[1]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup2 = [$newFare[1]->fareInfoGroup->segmentLevelGroup]);
                            is_array($newFare[2]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup3 = $newFare[2]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup3 = [$newFare[2]->fareInfoGroup->segmentLevelGroup]);
                        @endphp


                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                @php
                                    
                                    if ($newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->currency === 'INR') {
                                        $monetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount;
                                        $otherMonetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount;
                                    } else {
                                        $monetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails[0]->amount;
                                        $otherMonetaryDetails_1 = $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails[1]->amount;
                                    }
                                    
                                    if ($newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->currency === 'INR') {
                                        $monetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount;
                                        $otherMonetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount;
                                    } else {
                                        $monetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails[0]->amount;
                                        $otherMonetaryDetails_2 = $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails[1]->amount;
                                    }
                                    
                                    if ($newFare[2]->fareInfoGroup->fareAmount->monetaryDetails->currency === 'INR') {
                                        $monetaryDetails_3 = $newFare[2]->fareInfoGroup->fareAmount->monetaryDetails->amount;
                                        $otherMonetaryDetails_3 = $newFare[2]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount;
                                    } else {
                                        $monetaryDetails_3 = $newFare[2]->fareInfoGroup->fareAmount->otherMonetaryDetails[0]->amount;
                                        $otherMonetaryDetails_3 = $newFare[2]->fareInfoGroup->fareAmount->otherMonetaryDetails[1]->amount;
                                    }
                                @endphp
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare</div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup1[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$monetaryDetails_1, $fareGal[0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare']])) }} )
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$monetaryDetails_1, $fareGal[0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare']])) }}</span>
                                </div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup2[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$monetaryDetails_2, $fareGal[0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare']])) }} )
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$monetaryDetails_2, $fareGal[0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare']])) }}</span>
                                </div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup3[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[2]->numberOfPax->segmentControlDetails->numberOfUnits . 'X' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$monetaryDetails_3, $fareGal[0]['FareBreakDowns']['FareBreakDown'][2]['BaseFare']])) }} )
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[2]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$monetaryDetails_3, $fareGal[0]['FareBreakDowns']['FareBreakDown'][2]['BaseFare']])) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt(getTotalTaxesWithGal($newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[2]->numberOfPax->segmentControlDetails->numberOfUnits, $otherMonetaryDetails_1, $otherMonetaryDetails_2, $otherMonetaryDetails_3, $monetaryDetails_1, $monetaryDetails_2, $monetaryDetails_3, array_sum([$fareGal[0]['Total']['FuelSurcharge'], $fareGal[0]['Total']['OtherTax']]))) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services

                                </div>
                               <div  class="collapse show">
                                <div class="form-check ">
                                  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                  <label class="form-check-label" for="flexCheckChecked">
                                    Charity 
                                  </label>
                                <span class="float-right fontsize-17">{!! $icon !!} <span id="ChaAm">10</span></span>
                                  
                                </div>
                                </div>
                                 <div id="price" class="collapse show">
                                    <span class="font-14">Discount </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} <span id="DisAm">0</span></span>
                                </div> 
                                <div id="price" class="collapse show">
                                    <span class="font-14">Convenience fee </span>
                                    <span class="float-right fontsize-17">{!! $icon !!} 0</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            @php $totalAmount = getTotalAmountWithGal($newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[2]->numberOfPax->segmentControlDetails->numberOfUnits, $otherMonetaryDetails_1, $otherMonetaryDetails_2, $otherMonetaryDetails_3, $fareGal[0]['Total']['Fare']); @endphp
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        {{session()->put('totalAmount',$totalAmount)}}
                                        <span id="TotalFare">
                                        {{ modify_amt($totalAmount+10) }}
                                        </span></span>
                                    
                                </div>
                            </div>
                        </div>

                    @endif

                    <div class="pb-10"></div>
                    {{--<div class="boxunder">
                        <div class="ranjepp">
                            <div class="owstitle pb-10">Cancellation & Data change charges</div>
                        </div>
                        <div class="ranjepp">
                            <div class="onwfnt-11"><i class="fa fa-rupee"></i> Cancellation Fees Apply</div>
                            <p class="onwfnt-11">Passengers travelling to the state might not be allowed to board
                                their flights if they are not carrying a valid test report.
                                Pre-registration </p>
                            <span class="onewflydetbtn"> VIEW POLICY </span>
                            <span class="onwfnt-11 float-right">
                                <i class="fa fa-rupee"></i> 3,655 Approx refund
                            </span>

                        </div>
                    </div> --}}
                    <div class="pb-10"></div>
                    <div class="boxunder" id="boxunder">
                        <div class="card-header fontsize-22 bg-info">HOT DEALS</div>
                        <div class="ranjepp">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="DisAmou" id="flexRadioDefault1" value="Yes">
                              <label class="form-check-label" for="flexRadioDefault1">
                               <b id="DisText">
                                   Use this coupon and get Rs 50 instant discount on your flight booking.
                               </b> 
                              </label>
                            </div>
                            <div id="remove-btn"class="form-check ">
                              <input class="form-check-input" type="radio" name="DisAmou" id="flexRadioDefault2" value="No" checked>
                              <label class="form-check-label" for="flexRadioDefault2">
                                Remove
                              </label>
                            </div>
                            {{--<div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
                            <p class="onwfnt-11">Use this code to get special discount of INR 30 for you</p>
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
            </div>
        </div>
    </section>

    {{-- Itnarry End --}}

    </div>
    <!-- DESKTOP VIEW END -->

    {{-- <x-footer /> --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/userstyle.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
@stop
@section('script')
    <script>
        $(document).ready(function() {
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

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        function togglePopup() {
            $(".content").toggle();
        }
        $('#travller-btn').on('click',function(){
            $('#main-form').submit();
          });
        });

    </script><script>
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
