@extends('layouts.master')
@section('title', 'Wagnistrip')
@section('body')

    <section class="bgcolor pt-6p">
        <div class="container">
            <div class="row d-none" >
                <div class="col-sm-8">
                    <div class="boxunder">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="fa fa-cc-visa" style="font-size:55px;color:#0164a3ed; margin-left: 15px;"></i>
                            </div>
                            <div class="col-sm-7">
                                <span class="fontsize-22">Get additional discounts</span><br>
                                <span class="owstitle">Login to access saved payments and discounts!</span>
                            </div>
                            <div class="col-sm-3 mt-10">
                                <a href="https://www.wagnistrip.com/user/profile">
                                    <button class="btn btn-sm btn-info fontsize-22">LOGIN NOW</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-8 pt-20">
                    <div class="boxunder">
                        <div class="row p-2">
                            <div class="col-sm-4">
        <input type="text" class="form-control" />
                                <div class="paybuton activePay" id="Payment">
                                    <span class="fonts-16"> <img src="{{ asset('assets/images/Cashfree-Dark.svg') }}"
                                            alt="" width="50%"> </span>
                                    <div class="onwfnt-11 pl30-mt-7">Pay Directly From Your Bank Account</div>
                                </div>
                                <div class="paybuton" id="UPI(disable)">
                                    <span class="fonts-16"> <img src="{{ asset('assets/images/upi.png') }}" alt=""
                                            width="25"> UPI </span>
                                    <div class="onwfnt-11 pl30-mt-7">Pay Directly From Your Bank Account</div>
                                </div>
                                <div class="paybuton" id="CREADITATM(disable)">
                                    <span class="fonts-16"> <i class="fa fa-credit-card"></i> Credit/Debit/ATM
                                        Card </span>
                                    <div class="onwfnt-11 pl30-mt-7">Visa, MasterCard, Amex, Rupay And More</div>
                                </div>
                                <div class="paybuton" id="PAYLATER(disable)">
                                    <span class="fonts-16"> <img src="{{ asset('assets/images/netb.jpg') }}" alt=""
                                            width="25"> Net Banking</span>
                                    <div class="onwfnt-11 pl30-mt-7"> All Major Banks Available </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="ranjepp">
                                    <div id="RAZORPAY">
                                        <i class="fa fa-mobile" style="font-size: 22px;"> </i> <span
                                            class="onwfnt-11"> Keep your phone handy ! </span>
                                        <div class="card">
                                            <div class="card-body text-center">
                                                @php
                                                    $totalfare = $data['fare'];
                                                    $fare = $totalfare;
                                                    $Adult = json_decode($data->travllername);
                                                @endphp
                                                <div class="fontsize-22 pb-20"> <i class="fa fa-inr"></i>
                                                    {{ number_format($totalfare) }} DUE NOW</div>
                                                    <form action="{{ url('payment/cashfree-process') }}" method="post">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="uniqueid" value="{{$data['uniqueid']}}">
                                                        <input type="hidden" name="data-key" value="781827d26290a6ea98559e65ec895029923b5fa7"> 
                                                        <input type="hidden" name="data-amount" value="{{ $fare }}">
                                                        <button type="submit" class="btn btn-primary btn-block"
                                                        value="data-buttontext">VERIFY & PAY</button>
                                                        <input type="hidden" name="data-name"
                                                        value="WAGNISTRIP (OPC) PVT.LTD.">
                                                        <input type="hidden" name="data-description" value="Flight Booking">
                                                        <input type="hidden" name="data-image"
                                                        value="https://www.wagnistrip.com/logo.jpg">
                                                        <input type="hidden" name="data-prefill.name" value="Maketruetrip">
                                                        <input type="hidden" name="customerName" value="{{ $Adult[0]->FirstName.' '.$Adult[0]->LastName }}">
                                                        <input type="hidden" name="customerEmail" value="{{ $data['email'] }}"> 
                                                        <input type="hidden" name="customerPhone" value="{{ $data['phonenumber'] }}">  
                                                        
                                                    </form>
                                                    <div class="text-center pt-20">
                                                        <img src="{{ asset('assets/images/alupi.png') }}" alt=""
                                                            class="imgonewayw-70per">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 pt-20">
                    
                    <div class="boxunder">
                        <div class="p-2">
                            <span class="fontsize-22">Your booking </span>
                            <span class="onwfnt-11 float-right pb-10">ROUNDTRIP FLIGHT</span>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="imgonewayw-70per">
                                        <img src="{{ asset('assets/images/flight/') }}/{{$input['code']}}.png" alt="" width="20">
                                    </div>
                                    <span class="owstitle1"> {{$input['code']}} </span><br>
                                    <span class="fontsize-22">{{ getTimeFormat($input['time1']) }}</span><br>
                                    <span class="onwfnt-11">{{$input['city1']}}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="onwfnt-11">{{$input['delay']}}</span>
                                    <div class="borderbotum">Aviation</div>
                                    <span class="onwfnt-11">{{$input['stop']}}</span>
                                </div>
                                <div class="col-sm-4">
                                    <div class="imgonewayw-70per">
                                        <img src="{{ asset('assets/images/flight/') }}/{{$input['code']}}.png" alt="" width="20" >
                                    </div>
                                    <span class="owstitle1"> {{$input['code']}} </span><br>
                                    <span class="fontsize-22">{{getTimeFormat($input['time2'])}}</span><br>
                                    <span class="onwfnt-11">{{$input['city2']}}</span>
                                </div>
                            </div>
                            <div class="borderbotum p-2 pb-10"></div>
                            <span class="fontsize-22"> <i class="fa fa-user"></i> Traveler(s) </span>
                            <div class="onwfnt-11">1.@php 
                                $Adult = json_decode($data->travllername);
                             @endphp
                                {{ $Adult[0]->FirstName.' '.$Adult[0]->LastName }}
                            </div>
                            <div class="onwfnt-11">{{ $data['email'] }} | +91 {{ $data['phonenumber'] }}</div>
                        </div>
                    </div>
                   
                    <div class="pb-10"></div>
                    <div class="boxunder">
                        <div class="p-2">
                            <span class="owstitle"> FARE SUMMERY </span>
                            <span class="fontsize-22"> Total Due </span>
                            <span class="fontsize-22 float-right"> <i class="fa fa-inr"></i> {{ $totalfare }}
                            </span>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
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
        <x-footer />
    </div>
    <div class="ddn">
        <x-mobilefooter />
    </div>
@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
@endsection

@endsection
<script>
   
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