@extends('layouts.master')
@section('title', 'Wagnistrip')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
@section('body')

@php
    use App\Models\Agent\Agent;
    $Agent = Session()->get("Agent");
    if($Agent != null){
        $mail = $Agent->email;
        $Agent = Agent::where('email', '=', $mail)->first();
        $Charge = 100;
    }else{
        $Charge = 400;
    }
    $code = !empty($code) ? $code : 'INR';
    $icon = !empty(__('common.'.$code)) ? __('common.'.$code) : '';
    $cvalue = !empty($cvalue) ? $cvalue : 1; 
    
    function  converter($value , $cvalue) {
        return ceil($value*$cvalue);
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
                        <div class="progress-bar bg-success border-right" style="width:25%">
                            Flight selected
                        </div>
                        <div class="progress-bar bg-success border-right" style="width:25%">
                            Review
                        </div>
                        <div class="progress-bar bg-light text-dark border-right" style="width:25%">
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

    <section>
        <div class="container">
            <div class="row">

                {{-- Fare Rules Section Start --}}
                <div class="col-sm-4 pt-20">
                    <h5>Fare Summary</h5>

                    @if ($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] == 0 && $travellers['noOfInfants'] == 0)
                        {{-- Data at Start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['PaxType'] . '(' . $travellers['noOfAdults'] . 'X' }}
                                        {!! $icon !!}
                                        {{ converter($response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter((int) $travellers['noOfAdults'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] , $cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges
        
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter((int) $travellers['noOfAdults'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['TotalTax']+$Charge , $cvalue) }}</span>
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
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        @php
                                         $total_fare = $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['Fare']+((int) $travellers['noOfAdults'] * $Charge);
                                        @endphp
                                        <span id="TotalFare">
                                        {{ converter($total_fare+10 , $cvalue) }}
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
                                        {{ $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['PaxType'] . '(' . $travellers['noOfAdults'] . 'X' }}
                                        {!! $icon !!}
                                        {{ converter($response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter((int) $travellers['noOfAdults'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] , $cvalue) }}</span>
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['PaxType'] . '(' . $travellers['noOfChilds'] . 'X' }}
                                        {!! $icon !!}
                                        {{ converter($response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare'] , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter((int) $travellers['noOfChilds'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare'] , $cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter(array_sum([$response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['FuelSurcharge']+((int) $travellers['noOfChilds'] * $Charge)+ ((int) $travellers['noOfAdults'] *$Charge), $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['OtherTax']]) , $cvalue) }}</span>
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
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        @php
                                        $total_fare = $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['Fare']+((int) $travellers['noOfChilds'] * $Charge) + ((int) $travellers['noOfAdults'] * $Charge);
                                        @endphp
                                        <span id="TotalFare">
                                        {{ converter($total_fare+10 , $cvalue) }}
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
                                        {{ $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['PaxType'] . '(' . $travellers['noOfAdults'] . 'X' }}
                                        {!! $icon !!}
                                        {{ converter($response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter((int) $travellers['noOfAdults'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] , $cvalue) }}</span>
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['PaxType'] . '(' . $travellers['noOfInfants'] . 'X' }}
                                        {!! $icon !!}
                                        {{ converter($response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare'] , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter((int) $travellers['noOfInfants'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare'] , $cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges</div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ array_sum([$response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['FuelSurcharge'] + ((int) $travellers['noOfAdults'] * $Charge), $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['OtherTax']]) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services</div>
                                <div  class="collapse show rmvCharity">
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
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22">Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        @php 
                                        $total_fare = $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['Fare'] + ((int) $travellers['noOfAdults'] * $Charge);
                                        @endphp
                                        <span id="TotalFare">
                                        {{ converter($total_fare+10 , $cvalue) }}
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
                                        {{ $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['PaxType'] . '(' . $travellers['noOfAdults'] . 'X' }}
                                        {!! $icon !!}
                                        {{ converter($response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter((int) $travellers['noOfAdults'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][0]['BaseFare'] , $cvalue) }}</span>
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['PaxType'] . '(' . $travellers['noOfChilds'] . 'X' }}
                                        {!! $icon !!}
                                        {{ converter($response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare'] , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter((int) $travellers['noOfChilds'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][1]['BaseFare'] , $cvalue) }}</span>
                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        {{ $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][2]['PaxType'] . '(' . $travellers['noOfInfants'] . 'X' }}
                                        {!! $icon !!}
                                        {{ converter($response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][2]['BaseFare'] , $cvalue) . ')' }}
                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ (int) $travellers['noOfInfants'] * (int) $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['FareBreakDowns']['FareBreakDown'][2]['BaseFare'] }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges</div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ converter(array_sum([$response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['FuelSurcharge']+ ( (int) $travellers['noOfAdults'] * $Charge)+ ( (int) $travellers['noOfChilds'] * $Charge), $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['OtherTax']]) , $cvalue) }}</span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Other Services</div>
                                <div  class="collapse show rmvCharity">
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
                            <div class="ranjepp">
                                <div class="owstitle pb-10" data-toggle="collapse" data-target="#price1">
                                    <span class="fontsize-22"> Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        @php
                                         $total_fare = $response['AirPricingResponse'][0]['PricingInfos']['PricingInfo'][0]['Total']['Fare']+ ( (int) $travellers['noOfAdults'] * $Charge)+ ( (int) $travellers['noOfChilds'] * $Charge);
                                         @endphp<span id="TotalFare">
                                        {{ $total_fare+10 }}
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
                    <div class="boxunder rmvHotDeals" id="boxunder">
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
                            <p class="onwfnt-11">Use this code to get special discount of INR 350 for you</p>
                            <div class="borderbotum"></div>
                            <div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
                            <p class="onwfnt-11">Use this code to get special discount of INR 350 for you</p>
                            <div class="borderbotum"></div>
                            <div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
                            <p class="onwfnt-11">Use this code to get special discount of INR 350 for you</p>
                            <div class="borderbotum"></div>
                            <div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
                            <p class="onwfnt-11">Use this code to get special discount of INR 350 for you</p>
                            <div class="borderbotum"></div> --}}
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
                
                <div class="col-sm-8 pt-20 pb-20">
                    {{-- <div class="scrollfix"> --}}
                    <h4>Itinerary</h4>
                    @php
                        $segmentItemOut = [];
                        $segmentItemIn = [];
                    @endphp
                    @foreach ($response['AirPricingResponse'][0]['Itineraries']['Itinerary'] as $galSagments)

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
                    <div class="mergediv">
                        <x-flight.segment-gl-section trip="DEPART" :segment="$segmentItemOut" />

                        <x-flight.segment-gl-section trip="RETURN" :segment="$segmentItemIn" />
                    </div>
                    @php
                        $originCountry = $segmentItemOut[0]['Origin']['AirportCode'];
                        $destinationCountry = $segmentItemIn[0]['Origin']['AirportCode'];
                        $jurneyDate = getDateFormat($segmentItemOut[0]['Origin']['DateTime']);
                        $SessionID = $SessionID;
                        $ReferenceNo = $response['ReferenceNo'];
                        $Key = $response['Key'];
                        
                        $code = $segmentItemOut[0]['AirLine']['Code'];
                        $time1 =$segmentItemOut[0]['Origin']['DateTime'];
                        $time2 = $segmentItemOut[0]['Destination']['DateTime'];
                        $city1 =$segmentItemOut[0]['Origin']['CityName'];
                        $city2 = $segmentItemOut[0]['Destination']['CityName'];
                        $delay = $segmentItemOut[0]['Duration'];
                        $stop =$segmentItemOut[0]['StopCount'];
                        
                        $Provider = $response['AirPricingResponse'][0]['Provider'];
                        
                        $FlightData = $response['AirPricingResponse'][0]['Itineraries']['Itinerary'];
                    @endphp
                    <div class="row">
                        <div class="container">
                            <div id="information" class="collapse p-10">
                                <div class="boxunder p-10 bgpolicy">
                                    <h4>Important Information</h4>
                                    <h6> <img src="{{url('/public/assets/images/imp-info.png') }}" alt="" width="20"> Mandatory
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
                                    <h6> <img src="{{url('/public/assets/images/imp-info.png') }}" alt="" width="20"> State Guidelines </h6>
                                    <ul class="onwfnt-11">
                                        <li>Check the detailed list of travel guidelines issued by Indian States
                                            and UTs.Know More</li>
                                    </ul>
                                    <h6> <img src="{{url('/public/assets/images/imp-info.png') }}" alt="" width="20"> Baggage information </h6>
                                    <ul class="onwfnt-11">
                                        <li>Carry no more than 1 check-in baggage and 1 hand baggage per passenger.
                                            Additional pieces of Baggage will be subject to additional charges per piece in
                                            addition to the excess baggage charges.</li>
                                    </ul>
                                    <h6> <img src="{{url('/public/assets/images/imp-info.png') }}" alt="" width="20"> A Note on Guidelines </h6>
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

                    <div class="text-left" id="booking-btn-section" class="collapse in "  style=" width: 100%;">
                        <button id="booking-btn" type="button" class="btn btn-primary" data-toggle="collapse"
                         style=" width: 97%;"   data-toggle="collapse in"> CONTINUE </button>
                    </div>

                    {{-- Travller Form Data Start --}}
                    <div id="traveller-section" class="collapse pb-20">

                        <form id="main-form" action="{{ route('galelio-traveller-details') }}" method="post" data-parsley-validate>
                            @csrf
                            <input type="hidden" name="travellers" value="{{ json_encode($travellers, true) }}">
                            <input type="hidden" name="IntRoundFlight" value="{{ json_encode($FlightData, true) }}">
                            <input type="hidden" name="SessionID" value="{{ $SessionID }}">
                            <input type="hidden" name="ReferenceNo" value="{{ $ReferenceNo }}">
                            
                            <input type="hidden" name="triveltime" value="{{ $time1 }}">
                            <input type="hidden" name="time1" value="{{ $time1 }}">
                            <input type="hidden" name="time2" value="{{ $time2 }}">
                            <input type="hidden" name="city1" value="{{ $city1 }}">
                            <input type="hidden" name="city2" value="{{ $city2 }}">
                            <input type="hidden" name="code" value="{{ $code }}">
                            <input type="hidden" name="delay" value="{{ $delay }}">
                            <input type="hidden" name="stop" value="{{ $stop }}">
                            
                            <input type="hidden" name="Key" value="{{ $Key }}">
                            <input type="hidden" name="trip" value="Internation-Roundtrip">
                            <input type="hidden" id="Chari"name="Chari">
                            <input type="hidden" id="textDis"name="textDis">
                            <input type="hidden" name="Provider" value="{{$Provider}}">
                            @php
                            session(['total_fare'=>$total_fare]);
                            @endphp
                            <input type="hidden" name="fare" value="{{ $total_fare }}">
                            <x-flight.travellerform :travellers="$travellers" :originCountry="$originCountry"
                                :destinationCountry="$destinationCountry" :jurneyDate="$jurneyDate" />
                        </form>
                    </div>
                    {{-- Travller Form Data End --}}

                    {{-- </div> --}}
                </div>

            </div>
        </div>
    </section>
    </div>
    <!-- DESKTOP VIEW END -->

    {{-- <x-footer /> --}}

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/userstyle.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
@stop
@section('script')
    <script src="{{asset('assets/js/review_page.js')}}"></script>
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
            // $(this).hide();
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
