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
    <!-- DESKTOP VIEW START -->

    <section class="bgcolor pt-6p">
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
            <div class="row">
                {{-- Fare Rules Section Start --}}
                <div class="col-sm-4 pt-20">
                    <h5>Fare Summary</h5>
                    @php
                        if (is_array($fare['fareOutbound']->mainGroup->pricingGroupLevelGroup) == true) {
                            $newFare = $fare['fareOutbound']->mainGroup->pricingGroupLevelGroup;
                        } else {
                            $newFare = [$fare['fareOutbound']->mainGroup->pricingGroupLevelGroup];
                        }
                        if (is_array($fare['fareInbound']->mainGroup->pricingGroupLevelGroup) == true) {
                            $newFare2 = $fare['fareInbound']->mainGroup->pricingGroupLevelGroup;
                        } else {
                            $newFare2 = [$fare['fareInbound']->mainGroup->pricingGroupLevelGroup];
                        }
                    @endphp

                    @if ($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] == 0 && $travellers['noOfInfants'] == 0)

                        {{-- Data at Start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">
                                        @php
                                            is_array($newFare[0]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup = $newFare[0]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup = [$newFare[0]->fareInfoGroup->segmentLevelGroup]);
                                        @endphp
                                        @php
                                            is_array($newFare2[0]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup2 = $newFare2[0]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup2 = [$newFare2[0]->fareInfoGroup->segmentLevelGroup]);
                                        @endphp
                                        {{ $segmentLevelGroup[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits . 'X ' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount])) . ')' }}

                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount])) }}
                                    </span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee & Surcharges</div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{modify_amt(((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * $Charge) +  (int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([(int)($newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount), ($newFare2[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount)]) - (int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount])) }}
                                    </span>
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
                                    <span class="fontsize-22">Total Amount</span>
                                    <span class="fontsize-22 float-right"> {!! $icon !!}
                                        @php
                                            $totalAmount = (int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge, $newFare2[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge]);
                                        @endphp
                                         <span id="TotalFare">
                                        {{ modify_amt($totalAmount+10) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    @elseif($travellers['noOfAdults'] != 0 && $travellers['noOfChilds'] != 0 &&
                        $travellers['noOfInfants'] == 0 || $travellers['noOfAdults'] != 0 &&
                        $travellers['noOfChilds'] == 0 && $travellers['noOfInfants'] != 0)
                        @php
                            is_array($newFare[0]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup1 = $newFare[0]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup1 = [$newFare[0]->fareInfoGroup->segmentLevelGroup]);
                            is_array($newFare[1]->fareInfoGroup->segmentLevelGroup) ? ($segmentLevelGroup2 = $newFare[1]->fareInfoGroup->segmentLevelGroup) : ($segmentLevelGroup2 = [$newFare[1]->fareInfoGroup->segmentLevelGroup]);
                        @endphp
                        {{-- Data start --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare</div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup1[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits . 'X ' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount])) . ')' }}

                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount])) }}
                                    </span>
                                </div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup2[0]->ptcSegment->quantityDetails->unitQualifier . '(' . $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits . 'X ' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->monetaryDetails->amount])) . ')' }}

                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->monetaryDetails->amount])) }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee &
 Surcharges
                                </div>
                                <div class="p-1">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                    {{ modify_amt(((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits* $Charge) + array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount]), $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount])]) - array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount]), $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->monetaryDetails->amount])])) }}
                                    </span>
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
                                            $totalAmount = array_sum([(int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge, $newFare2[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge]), (int) $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge, $newFare2[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge])]);
                                        @endphp
                                         <span id="TotalFare">
                                        {{ modify_amt($totalAmount+10) }}
                                        </span>
                                    </span>
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

                        {{-- Data in --}}
                        <div class="boxunder p-2">

                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Base Fare</div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup1[0]->ptcSegment->quantityDetails->unitQualifier . ' ( ' . $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits . ' X ' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount])) . ')' }}

                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount])) }}
                                    </span>
                                </div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup2[0]->ptcSegment->quantityDetails->unitQualifier . ' ( ' . $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits . ' X ' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->monetaryDetails->amount])) . ')' }}

                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->monetaryDetails->amount])) }}
                                    </span>
                                </div>
                                <div class="p-1">
                                    <span class="font-14">
                                        {{ $segmentLevelGroup2[0]->ptcSegment->quantityDetails->unitQualifier . ' ( ' . $newFare[2]->numberOfPax->segmentControlDetails->numberOfUnits . ' X ' }}
                                        {!! $icon !!}
                                        {{ modify_amt(array_sum([$newFare[2]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[2]->fareInfoGroup->fareAmount->monetaryDetails->amount])) . ')' }}

                                    </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt((int) $newFare[2]->numberOfPax->segmentControlDetails->numberOfUnits * (int) array_sum([$newFare[2]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[2]->fareInfoGroup->fareAmount->monetaryDetails->amount])) }}
                                    </span>
                                </div>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="ranjepp">
                                <div class="fontsize-17 pb-10" data-toggle="collapse" data-target="#price">Fee &
                                    Surcharges

                                </div>
                                <div id="price" class="collapse show">
                                    <span class="font-14">Total Fee & Surcharges : </span>
                                    <span class="float-right fontsize-17">{!! $icon !!}
                                        {{ modify_amt(array_sum([getTotalTaxes($newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[2]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge, $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge, $newFare[2]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount, $newFare[0]->fareInfoGroup->fareAmount->monetaryDetails->amount+$Charge, $newFare[1]->fareInfoGroup->fareAmount->monetaryDetails->amount+$Charge, $newFare[2]->fareInfoGroup->fareAmount->monetaryDetails->amount), getTotalTaxes($newFare2[0]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare2[1]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare2[2]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare2[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount, $newFare2[2]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount, $newFare2[0]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->monetaryDetails->amount, $newFare2[2]->fareInfoGroup->fareAmount->monetaryDetails->amount)])) }}
                                    </span>
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
                                        @php $totalAmount = array_sum([getTotalAmount($newFare[0]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[1]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[2]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge, $newFare[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge, $newFare[2]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount+$Charge), getTotalAmount($newFare2[0]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare2[1]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare2[2]->numberOfPax->segmentControlDetails->numberOfUnits, $newFare2[0]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount, $newFare2[1]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount, $newFare2[2]->fareInfoGroup->fareAmount->otherMonetaryDetails->amount)]);  @endphp
                                         <span id="TotalFare">
                                        {{ modify_amt($totalAmount+10) }}
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
                           {{-- <div class="owstitle"> <i class="fa fa-tag"></i> FLYFLASH</div>
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
                    <div class="topGridDiv">
                        
                    
                    <h4>Itinerary</h4>

                    {{-- Flight Review Start --}}
                    
                    @if (isset($roundtripNonstopNonstop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripNonstopNonstop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripNonstopNonstop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripNonstopNonstop->itineraryDetails[0]->segmentInformation->flightDetails->flightDate->departureDate);
                          $AmdFlight = [$roundtripNonstopNonstop->itineraryDetails[0]->segmentInformation, $roundtripNonstopNonstop->itineraryDetails[1]->segmentInformation];
                        @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="NON STOP"
                                    :segmentInformation="$roundtripNonstopNonstop->itineraryDetails[0]->segmentInformation"
                                    :itineraryDetails="$roundtripNonstopNonstop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopNonstop->itineraryDetails[0]->segmentInformation"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany']" />
                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="NON STOP"
                                    :segmentInformation="$roundtripNonstopNonstop->itineraryDetails[1]->segmentInformation"
                                    :itineraryDetails="$roundtripNonstopNonstop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />
                                <div class="row ranjepp">
                                <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopNonstop->itineraryDetails[0]->segmentInformation"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany']" />
                                </div>
                            </div>
                        </div>
                    @elseif (isset($roundtripNonstopOnestop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripNonstopOnestop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripNonstopOnestop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripNonstopOnestop->itineraryDetails[0]->segmentInformation->flightDetails->flightDate->departureDate);
                          $AmdFlight = [$roundtripNonstopOnestop->itineraryDetails[0]->segmentInformation, $roundtripNonstopOnestop->itineraryDetails[1]->segmentInformation];
                        @endphp
                        </div>
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="NON STOP"
                                    :segmentInformation="$roundtripNonstopOnestop->itineraryDetails[0]->segmentInformation"
                                    :itineraryDetails="$roundtripNonstopOnestop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopOnestop->itineraryDetails[0]->segmentInformation"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany']" />
                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="1 STOP"
                                    :segmentInformation="$roundtripNonstopOnestop->itineraryDetails[1]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripNonstopOnestop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopOnestop->itineraryDetails[1]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripNonstopOnestop->itineraryDetails[1]->segmentInformation[0], $roundtripNonstopOnestop->itineraryDetails[1]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopOnestop->itineraryDetails[1]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_2']" />
                                </div>
                            </div>
                        </div>
                    @elseif (isset($roundtripOnestopNonstop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripOnestopNonstop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripOnestopNonstop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripOnestopNonstop->itineraryDetails[0]->segmentInformation[0]->flightDetails->flightDate->departureDate);
                           $AmdFlight = [$roundtripOnestopNonstop->itineraryDetails[0]->segmentInformation, $roundtripOnestopNonstop->itineraryDetails[1]->segmentInformation];
                       @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="1 STOP"
                                    :segmentInformation="$roundtripOnestopNonstop->itineraryDetails[0]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripOnestopNonstop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopNonstop->itineraryDetails[0]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_1']" />
 
                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripOnestopNonstop->itineraryDetails[0]->segmentInformation[0], $roundtripOnestopNonstop->itineraryDetails[0]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopNonstop->itineraryDetails[0]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_2']" />
                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="NON STOP"
                                    :segmentInformation="$roundtripOnestopNonstop->itineraryDetails[1]->segmentInformation"
                                    :itineraryDetails="$roundtripOnestopNonstop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopNonstop->itineraryDetails[1]->segmentInformation"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany']" />
                                </div>
                            </div>
                        </div>
                    @elseif (isset($roundtripOnestopOnestop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripOnestopOnestop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripOnestopOnestop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripOnestopOnestop->itineraryDetails[0]->segmentInformation[0]->flightDetails->flightDate->departureDate);
                            $AmdFlight = [$roundtripOnestopOnestop->itineraryDetails[0]->segmentInformation, $roundtripOnestopOnestop->itineraryDetails[1]->segmentInformation];
                        @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="1 STOP"
                                    :segmentInformation="$roundtripOnestopOnestop->itineraryDetails[0]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripOnestopOnestop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopOnestop->itineraryDetails[0]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripOnestopOnestop->itineraryDetails[0]->segmentInformation[0], $roundtripOnestopOnestop->itineraryDetails[0]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopOnestop->itineraryDetails[0]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_2']" />
                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="1 STOP"
                                    :segmentInformation="$roundtripOnestopOnestop->itineraryDetails[1]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripOnestopOnestop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopOnestop->itineraryDetails[1]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripOnestopOnestop->itineraryDetails[1]->segmentInformation[0], $roundtripOnestopOnestop->itineraryDetails[1]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopOnestop->itineraryDetails[1]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_2']" />
                                </div>
                            </div>
                        </div>
                    @elseif (isset($roundtripNonstopTwostop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripNonstopTwostop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripNonstopTwostop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripNonstopTwostop->itineraryDetails[0]->segmentInformation->flightDetails->flightDate->departureDate);
                           $AmdFlight = [$roundtripNonstopTwostop->itineraryDetails[0]->segmentInformation, $roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation];
                       @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="NON STOP"
                                    :segmentInformation="$roundtripNonstopTwostop->itineraryDetails[0]->segmentInformation"
                                    :itineraryDetails="$roundtripNonstopTwostop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopTwostop->itineraryDetails[0]->segmentInformation"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany']" />

                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="2 STOP"
                                    :segmentInformation="$roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripNonstopTwostop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation[0], $roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_2']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation[1], $roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation[2]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripNonstopTwostop->itineraryDetails[1]->segmentInformation[2]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_3']" />
                                </div>
                            </div>
                        </div>

                    @elseif (isset($roundtripOnestopTwostop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripOnestopTwostop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripOnestopTwostop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripOnestopTwostop->itineraryDetails[0]->segmentInformation[0]->flightDetails->flightDate->departureDate);
                          $AmdFlight = [$roundtripOnestopTwostop->itineraryDetails[0]->segmentInformation, $roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation];
                        @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="1 STOP"
                                    :segmentInformation="$roundtripOnestopTwostop->itineraryDetails[0]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripOnestopTwostop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopTwostop->itineraryDetails[0]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripOnestopTwostop->itineraryDetails[0]->segmentInformation[0], $roundtripOnestopTwostop->itineraryDetails[0]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopTwostop->itineraryDetails[0]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_2']" />

                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="2 STOP"
                                    :segmentInformation="$roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripOnestopTwostop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation[0], $roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_2']" />

                                    <div class="col-sm-12 col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation[1], $roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation[2]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripOnestopTwostop->itineraryDetails[1]->segmentInformation[2]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_3']" />
                                </div>
                            </div>
                        </div>

                    @elseif (isset($roundtripTwostopNonstop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripTwostopNonstop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripTwostopNonstop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[0]->flightDetails->flightDate->departureDate);
                           $AmdFlight = [$roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation, $roundtripTwostopNonstop->itineraryDetails[1]->segmentInformation];
                       @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="2 STOP"
                                    :segmentInformation="$roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripTwostopNonstop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[0], $roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_2']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[1], $roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[2]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopNonstop->itineraryDetails[0]->segmentInformation[2]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_3']" />

                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="NON STOP"
                                    :segmentInformation="$roundtripTwostopNonstop->itineraryDetails[1]->segmentInformation"
                                    :itineraryDetails="$roundtripTwostopNonstop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopNonstop->itineraryDetails[1]->segmentInformation"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany']" />

                                </div>
                            </div>
                        </div>

                    @elseif (isset($roundtripTwostopOnestop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripTwostopOnestop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripTwostopOnestop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[0]->flightDetails->flightDate->departureDate);
                           $AmdFlight = [$roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation, $roundtripTwostopOnestop->itineraryDetails[1]->segmentInformation];
                       @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="2 STOP"
                                    :segmentInformation="$roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripTwostopOnestop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[0], $roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_2']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[1], $roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[2]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopOnestop->itineraryDetails[0]->segmentInformation[2]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_3']" />

                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="1 STOP"
                                    :segmentInformation="$roundtripTwostopOnestop->itineraryDetails[1]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripTwostopOnestop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopOnestop->itineraryDetails[1]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopOnestop->itineraryDetails[1]->segmentInformation[0], $roundtripTwostopOnestop->itineraryDetails[1]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopOnestop->itineraryDetails[1]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_2']" />

                                </div>
                            </div>
                        </div>
                    @elseif (isset($roundtripTwostopTwostop))
                        @php
                            $originCountry = AirportiatacodesController::getCountry($roundtripTwostopTwostop->itineraryDetails[0]->originDestination->origin);
                            $destinationCountry = AirportiatacodesController::getCountry($roundtripTwostopTwostop->itineraryDetails[0]->originDestination->destination);
                            $jurneyDate = getDate($roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[0]->flightDetails->flightDate->departureDate);
                          $AmdFlight = [$roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation, $roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation];
                        @endphp
                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="DEPART" triptype="2 STOP"
                                    :segmentInformation="$roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripTwostopTwostop->itineraryDetails[0]"
                                    :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[0], $roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_2']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[1], $roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[2]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopTwostop->itineraryDetails[0]->segmentInformation[2]"
                                        :arrivalingTime="$otherInformation['otherInfoOutbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoOutbound']['operatingCompany_3']" />

                                </div>
                            </div>
                        </div>

                        <div class="pb-10">
                            <div class="boxunder">
                                <x-flight.segmentsection trip="RETRUN" triptype="2 STOP"
                                    :segmentInformation="$roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation[0]"
                                    :itineraryDetails="$roundtripTwostopTwostop->itineraryDetails[1]"
                                    :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']" />

                                <div class="row ranjepp">
                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation[0]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_1']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation[0], $roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation[1]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation[1]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_2']" />

                                    <div class="col-sm-12  col_sm-121">
                                        <div class="borderbotum-2"></div>
                                        <div class="borderraduesround">
                                            {{ getTimeDff_fn($roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation[1], $roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation[2]) }}
                                        </div>
                                    </div>

                                    <x-flight.segmentdetails
                                        :segmentInformation="$roundtripTwostopTwostop->itineraryDetails[1]->segmentInformation[2]"
                                        :arrivalingTime="$otherInformation['otherInfoInbound']['arrivalingTime']"
                                        :operatingCompany="$otherInformation['otherInfoInbound']['operatingCompany_3']" />

                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Flight Review End --}}

                    <div class="row">
                        <div class="container">
                            <div id="information" class="collapse p-10">
                                <div class="boxunder p-10 bgpolicy">
                                    <h4 class="restitleof">Important Information</h4>
                                    <h6 class="restitleof"> <img src="assets/images/imp-info.png" alt="" width="20"> Mandatory
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
                                    <h6 class="restitleof"> <img src="assets/images/imp-info.png" alt="" width="20"> State
                                        Guidelines </h6>
                                    <ul class="onwfnt-11">
                                        <li>Check the detailed list of travel guidelines issued by Indian States
                                            and UTs.Know More</li>
                                    </ul>
                                    <h6 class="restitleof"> <img src="assets/images/imp-info.png" alt="" width="20"> Baggage
                                        information </h6>
                                    <ul class="onwfnt-11">
                                        <li>Carry no more than 1 check-in baggage and 1 hand baggage per passenger.
                                            Additional pieces of Baggage will be subject to additional charges per piece in
                                            addition to the excess baggage charges.</li>
                                    </ul>
                                    <h6 class="restitleof"> <img src="assets/images/imp-info.png" alt="" width="20"> A Note on
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

                    <div class="text-left" id="booking-btn-section" class="collapse in ">
                        <button id="booking-btn" type="button" class="btn btn-primary continueres-btn" data-toggle="collapse" style=" width: 97%;" 
                            data-toggle="collapse in"> CONTINUE </button>

                    </div>
                    
                    {{-- Travller Form Data Start --}}
                    <div id="traveller-section" class="collapse pb-20">
                        <form id="main-form" action="{{ url('/Payment/payment') }}" method="Post" data-parsley-validate>
                            @csrf
                            <input type="hidden" name="travellers" value="{{ json_encode($travellers, true) }}">
                            <input type="hidden" name="getsessions" value="{{ json_encode($getsession, true) }}">
                            <input type="hidden" name="otherInformations" value="{{ json_encode($otherInformation, true) }}">
                            <input type="hidden" name="AmdFlight" value="{{ json_encode($AmdFlight, true) }}">
                            @php
                             session(['total_fare'=>$totalAmount]);
                            @endphp
                            <input type="hidden" name="fare" value="{{ $totalAmount }}">
                            <input type="hidden" id="Chari"name="Chari">
                            <input type="hidden" id="textDis"name="textDis" value="no">
                            <input type="hidden" name="trip" value="DomesticRoundTrip">
                            <x-flight.travellerform :travellers="$travellers" :originCountry="$originCountry" :destinationCountry="$destinationCountry" :jurneyDate="$jurneyDate" />
                        </form>
                    </div>
                    {{-- Travller Form Data End --}}
                </div>
            </div>
            </div>
        </div>
    </section>

    {{-- Itnarry End --}}

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
    <div class="dpnr">
        {{-- <x-footer /> --}}
    </div>
    <div class="ddn">
        {{-- <x-mobilefooter /> --}}
    </div>

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
            $("#payment-section").show();
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

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
