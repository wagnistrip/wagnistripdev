@extends('layouts.master')
@section('title', 'WAGNISTRIP')
@section('body')

<link rel="stylesheet" href="{{url('assets\css\webcheck.css')}}">

<section class="margintoosss pt-6p pb-20">
    <div class="headingCheckIn">
        <div class="overlay"></div>
        <h1>
            Airline Web Check-In
        </h1>
    </div>
    <div class="container mainContent">
        <div class="webCheckSub">
            <p>Web Check-In</p>
        </div>
        <div class="impo">
            <p>
                <strong>Important Information :</strong> Airlines may change their rules without notice, at their discretion, please refer to airline policies for the most recent update. For any amendments and cancellations, you will be charged as per the latest airline policy applicable.
            </p>
        </div>
        <div class="row">
            <div class="col-6 mainFirst">
                <div class="spiceJet">
                    <img src="{{url('/assets/images/logo/s1-logo.png')}}" alt="SpiceJet">
                </div>
                <div class="row p-btns3">
                    <div class="col-sm-4 p-btn3" data-btn-num="1">
                        Check Flight Status  
                    </div>
        
                    <div class="col-sm-4 p-btn3 p-btn-active" data-btn-num="2">
                        Web Check-in 
                    </div>
            
                    <div class="col-sm-4 p-btn3" data-btn-num="3">
                        Update Contact Details
                    </div>
                </div>
                <div class="CheckFlight p-btn3--1 card-c3 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.book.spicejet.com/FlightStatus">&nbsp;  www.book.spicejet.com/FlightStatus</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Origin, Destination, Flight date & flight number, e.g. SG8161 Or Search by Route</li>
                            <li>Click on Find Flights</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp;  Flight Status can be checked for flights on the previous day, same day and next day.</p>
                </div>
                <div class="CheckFlight p-btn3--2 card-c3 ">
                    <p><strong>Please visit:</strong><a href="https://www.book.spicejet.com/SearchWebCheckin">&nbsp;   www.book.spicejet.com/SearchWebCheckin </a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the PNR and Email/Last Name as per the booking</li>
                            <li>Select the passenger and add Nationality </li>
                            <li>Tick to complete the Covid-19 and other self-declarations</li>
                            <li>Select add ons (Seats, Baggage, etc.) and continue </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Guests are required to report 3 hrs prior to departure with sufficient time to complete all the formalities.</p>
                </div>
                <div class="CheckFlight p-btn3--3 card-c3 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.book.spicejet.com/RetrieveBooking">&nbsp; www.book.spicejet.com/RetrieveBooking</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the PNR, Email/Last Name & Click on Retrieve Booking</li>
                            <li>Click on Manage Booking, Guest and Contact details  </li>
                            <li>update Contact info </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; It is mandatory to provide a guest contact number and email ID in the booking.</p>
                </div>
            </div>
            <div class="col-6 mainFirst">
                <div class="airIndia">
                    <img src="{{url('/assets/images/logo/airindia.png')}}" alt="AirIndia">
                </div>
                <div class="row p-btns6">
                    <div class="col-sm-4 p-btn6" data-btn-num="1">
                        Check Flight Status  
                    </div>
        
                    <div class="col-sm-4 p-btn6 p-btn-active" data-btn-num="2">
                        Web Check-in 
                    </div>
            
                    <div class="col-sm-4 p-btn6" data-btn-num="3">
                        Update Contact Details
                    </div>
                </div>
                <div class="CheckFlight p-btn6--1 card-c6 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.book.airindia.in/itd/itd/lang/en/travel/advancedFlightStatus">&nbsp; www.book.airindia.in/itd/itd/lang/en/travel/advancedFlightStatus</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Search By. Flight No/Airport/Flight Route</li>
                            <li>Fill the details and Search</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Flight Status can be checked for flights on the previous day, same day and next day.</p>
                </div>
                <div class="CheckFlight p-btn6--2 card-c6 ">
                    <p><strong>Please visit:</strong><a href="https://www.airindia.in/ssci.htm">&nbsp; www.airindia.in/ssci.htm</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the E-ticket number or Booking Reference And Last Name</li>
                            <li>Click on Submit </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp;  Guests are required to report 3 hrs prior to departure with sufficient time to complete all the formalities.</p>
                </div>
                <div class="CheckFlight p-btn6--3 card-c6 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.bookme.airindia.in/AirIndiaB2C/Manage/Retrieve">&nbsp; www.bookme.airindia.in/AirIndiaB2C/Manage/Retrieve</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Booking Refernece Number, Last Name</li>
                            <li>Click on Retrieve Booking  </li>
                            <li>Update Contact info </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; It is mandatory to provide a guest contact number and email ID in the booking.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mainFirst">
                <div class="airAsia">
                    <img src="{{url('/assets/images/logo/air-asia.png')}}" alt="AirAsia">
                </div>
                <div class="row p-btns">
                    <div class="col-sm-4 p-btn" data-btn-num="1">
                        Check Flight Status  
                    </div>
        
                    <div class="col-sm-4 p-btn p-btn-active" data-btn-num="2">
                        Web Check-in 
                    </div>
            
                    <div class="col-sm-4 p-btn" data-btn-num="3">
                        Update Contact Details
                    </div>
                </div>
                <div class="CheckFlight p-btn--1 card-c1 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.airasia.com/flightstatus">&nbsp; www.airasia.com/flightstatus</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the carrier code and flight number, e.g. I5798 Or Search by Route</li>
                            <li>Click on Find Flights</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Flight Status can be checked for flights on the previous day, same day and next day.</p>
                </div>
                <div class="CheckFlight p-btn--2 card-c1 ">
                    <p><strong>Please visit:</strong><a href="https://www.airasia.com/check-in">&nbsp;  www.airasia.com/check-in </a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Departure City, PNR and Last Name as per the booking</li>
                            <li>Select the passenger and add Nationality </li>
                            <li>Tick to complete the Covid-19 and other self-declarations</li>
                            <li>Select add ons (Seats, Baggage, etc.) and continue</li>
                        </ol>
                    </p>
                    <p>
                        The AirAsia boarding pass will be generated which is required to access the terminal building
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Guests are required to report 3 hrs prior to departure with sufficient time to complete all the formalities. To reprint the boarding pass, guests would need to visit www.airasia.com and input the PNR details which they have already checked in.</p>
                </div>
                <div class="CheckFlight p-btn--3 card-c1 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.airasia.com/member/search">&nbsp;www.airasia.com/member/search</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Departure City, PNR, Last Name & Click on Search</li>
                            <li>Click on Manage Booking, Guest and Contact details </li>
                            <li>Scroll and update Contact info </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; It is mandatory to provide a guest contact number and email ID in the booking.</p>
                </div>
            </div>
            <div class="col-6 mainFirst">
                <div class="goAir">
                    <img src="{{url('/assets/images/logo/go-logo.png')}}" alt="GoAir">
                </div>
                <div class="row p-btns4">
                    <div class="col-sm-4 p-btn4" data-btn-num="1">
                        Check Flight Status  
                    </div>
        
                    <div class="col-sm-4 p-btn4 p-btn-active" data-btn-num="2">
                        Web Check-in 
                    </div>
            
                    <div class="col-sm-4 p-btn4" data-btn-num="3">
                        Update Contact Details
                    </div>
                </div>
                <div class="CheckFlight p-btn4--1 card-c4 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.goair.in/plan-my-trip/flight-status">&nbsp;www.goair.in/plan-my-trip/flight-status</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Origin, Destination, Flight date</li>
                            <li>Click on Check Now</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp;  Flight Status can be checked for flights on the previous day, same day and next day.</p>
                </div>
                <div class="CheckFlight p-btn4--2 card-c4 ">
                    <p><strong>Please visit:</strong><a href="https://www.goair.in/plan-my-trip/web-check-in">&nbsp;www.goair.in/plan-my-trip/web-check-in</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the PNR and Email/Last Name as per the booking</li>
                            <li>Select the passenger and add Nationality  </li>
                            <li>Tick to complete the Covid-19 and other self-declarations</li>
                            <li>Select add ons (Seats, Baggage, etc.) and continue </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Guests are required to report 3 hrs prior to departure with sufficient time to complete all the formalities.</p>
                </div>
                <div class="CheckFlight p-btn4--3 card-c4 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.goair.in/plan-my-trip/manage-booking">&nbsp;www.goair.in/plan-my-trip/manage-booking</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Departure City, PNR, Last Name & Click on Search</li>
                            <li>Click on Manage Booking, Guest and Contact details </li>
                            <li>Scroll and update Contact info </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; It is mandatory to provide a guest contact number and email ID in the booking.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mainFirst">
                <div class="visTara">
                    <img src="{{url('/assets/images/logo/vistara.png')}}" alt="Vistara">
                </div>
                <div class="row p-btns5">
                    <div class="col-sm-4 p-btn5" data-btn-num="1">
                        Check Flight Status  
                    </div>
        
                    <div class="col-sm-4 p-btn5 p-btn-active" data-btn-num="2">
                        Web Check-in 
                    </div>
            
                    <div class="col-sm-4 p-btn5" data-btn-num="3">
                        Update Contact Details
                    </div>
                </div>
                <div class="CheckFlight p-btn5--1 card-c5 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.airvistara.com/in/en">&nbsp;  www.airvistara.com/in/en</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Click on Flight Status Tab</li>
                            <li>Input the Origin, Flight No. and Date </li>
                            <li>Click on Find Status</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Flight Status can be checked for flights on the previous day, same day and next day.</p>
                </div>
                <div class="CheckFlight p-btn5--2 card-c5 ">
                    <p><strong>Please visit:</strong><a href="https://www.airvistara.com/in/en">&nbsp;    www.airvistara.com/in/en </a><p>
                    <p class="checkList">
                        <ol>
                            <li>Click on Check-in Tab</li>
                            <li>Input the Booking Reference Number, Last name </li>
                            <li>Click on Check-in</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp;  Guests are required to report 3 hrs prior to departure with sufficient time to complete all the formalities.</p>
                </div>
                <div class="CheckFlight p-btn5--3 card-c5 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.airvistara.com/in/en">&nbsp;  www.airvistara.com/in/en</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Click on Manage My Booking Tab</li>
                            <li>Input the Booking Refernece Number, Last Name  </li>
                            <li>Update Contact info </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp;   It is mandatory to provide a guest contact number and email ID in the booking.</p>
                </div>
            </div>
            <div class="col-6 mainFirst">
                <div class="indigo">
                    <img src="{{url('/assets/images/logo/indigo-logo.png')}}" alt="Indigo">
                </div>
                <div class="row p-btns2">
                    <div class="col-sm-4 p-btn2" data-btn-num="1">
                        Check Flight Status  
                    </div>
        
                    <div class="col-sm-4 p-btn2 p-btn-active" data-btn-num="2">
                        Web Check-in 
                    </div>
            
                    <div class="col-sm-4 p-btn2" data-btn-num="3">
                        Update Contact Details
                    </div>
                </div>
                <div class="CheckFlight p-btn2--1 card-c2 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.goindigo.in/check-flight-status">&nbsp;www.goindigo.in/check-flight-status</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Departing, Arrival and flight number, e.g. I5798 Or Search by Route</li>
                            <li>Click on Search Flights</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Flight Status can be checked for flights on the previous day, same day and next day.</p>
                </div>
                <div class="CheckFlight p-btn2--2 card-c2 ">
                    <p><strong>Please visit:</strong><a href="https://www.goindigo.in/web-check-in">&nbsp;  www.goindigo.in/web-check-in</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the PNR and Email/Last Name as per the booking</li>
                            <li>Select the passenger and add Nationality </li>
                            <li>Tick to complete the Covid-19 and other self-declarations</li>
                            <li>Select add ons (Seats, Baggage, etc.) and continue </li>
                        </ol>
                    </p>
                    
                    <p><strong>Please Note:</strong>&nbsp; Guests are required to report 3 hrs prior to departure with sufficient time to complete all the formalities. To reprint the boarding pass, guests would need to visit www.goindigo.in and input the PNR details which they have already checked in.</p>
                </div>
                <div class="CheckFlight p-btn2--3 card-c2 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.goindigo.in/update-contact-details">&nbsp;www.goindigo.in/update-contact-details</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the PNR, Email/Last Name & Click on Update Contact</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; It is mandatory to provide a guest contact number and email ID in the booking.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mainFirst">
                <div class="truJet">
                    <img src="{{url('/assets/images/logo/Trujet.png')}}" alt="Trujet">
                </div>
                <div class="row p-btns7">
                    <div class="col-sm-4 p-btn7" data-btn-num="1">
                        Check Flight Status  
                    </div>
        
                    <div class="col-sm-4 p-btn7 p-btn-active" data-btn-num="2">
                        Web Check-in 
                    </div>
            
                    <div class="col-sm-4 p-btn7" data-btn-num="3">
                        Update Contact Details
                    </div>
                </div>
                <div class="CheckFlight p-btn7--1 card-c7 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.trujet.com/reservation/ibe/modify">&nbsp;  www.trujet.com/reservation/ibe/modify</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Last name and Booking Number</li>
                            <li>Click on Retrieve Booking</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Flight Status can be checked for flights on the previous day, same day and next day.</p>
                </div>
                <div class="CheckFlight p-btn7--2 card-c7 ">
                    <p><strong>Please visit:</strong><a href="https://www.trujet.com/WebCheckIn/web/checkin?locale=en_US">&nbsp;     www.trujet.com/WebCheckIn/web/checkin?locale=en_US </a><p>
                    <p class="checkList">
                        <ol>
                            <li>Choose PNR</li>
                            <li>Input the PNR Number, First name & Surname </li>
                            <li>Click on Check-in</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp;Guests are required to report 3 hrs prior to departure with sufficient time to complete all the formalities.</p>
                </div>
                <div class="CheckFlight p-btn7--3 card-c7 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.trujet.com/reservation/ibe/modify">&nbsp; www.trujet.com/reservation/ibe/modify</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Click on Manage tag > update contact info</li>
                            <li>Input the Last Name & Booking Number </li>
                            <li>Click on Retrieve Booking </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; It is mandatory to provide a guest contact number and email ID in the booking.</p>
                </div>
            </div>
            {{-- <div class="col-6 mainFirst">
                <div class="airIndia">
                    <img src="{{url('/assets/images/logo/airindia.png')}}" alt="AirIndia">
                </div>
                <div class="row p-btns6">
                    <div class="col-sm-4 p-btn6" data-btn-num="1">
                        Check Flight Status  
                    </div>
        
                    <div class="col-sm-4 p-btn6 p-btn-active" data-btn-num="2">
                        Web Check-in 
                    </div>
            
                    <div class="col-sm-4 p-btn6" data-btn-num="3">
                        Update Contact Details
                    </div>
                </div>
                <div class="CheckFlight p-btn6--1 card-c6 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.book.airindia.in/itd/itd/lang/en/travel/advancedFlightStatus">&nbsp; www.book.airindia.in/itd/itd/lang/en/travel/advancedFlightStatus</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the carrier code and flight number, e.g. I5798 Or Search by Route</li>
                            <li>Click on Find Flights</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Flight Status can be checked for flights on the previous day, same day and next day.</p>
                </div>
                <div class="CheckFlight p-btn6--2 card-c6 ">
                    <p><strong>Please visit:</strong><a href="https://www.airindia.in/ssci.htm">&nbsp; www.airindia.in/ssci.htm</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Departure City, PNR and Last Name as per the booking</li>
                            <li>Select the passenger and add Nationality </li>
                            <li>Tick to complete the Covid-19 and other self-declarations</li>
                            <li>Select add ons (Seats, Baggage, etc.) and continue</li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; Guests are required to report 3 hrs prior to departure with sufficient time to complete all the formalities. To reprint the boarding pass, guests would need to visit www.airasia.com and input the PNR details which they have already checked in.</p>
                </div>
                <div class="CheckFlight p-btn6--3 card-c6 card-not-active">
                    <p><strong>Please visit:</strong><a href="https://www.bookme.airindia.in/AirIndiaB2C/Manage/Retrieve">&nbsp; www.bookme.airindia.in/AirIndiaB2C/Manage/Retrieve</a><p>
                    <p class="checkList">
                        <ol>
                            <li>Input the Departure City, PNR, Last Name & Click on Search</li>
                            <li>Click on Manage Booking, Guest and Contact details </li>
                            <li>Scroll and update Contact info </li>
                        </ol>
                    </p>
                    <p><strong>Please Note:</strong>&nbsp; It is mandatory to provide a guest contact number and email ID in the booking.</p>
                </div>
            </div> --}}
        </div>
    </div>


</section>


<script>
    // 1st card air
    const p_btns = document.querySelector(".p-btns");
        const card123 = document.querySelectorAll(".card-c1");
        
        p_btns.addEventListener("click", (e) => {
          const p_btn_clicked = e.target.closest(".p-btn");
          if (!p_btn_clicked) return;
        
          const p_btns = document.querySelectorAll(".p-btn");
          p_btns.forEach((curElem) => curElem.classList.remove("p-btn-active"));
          p_btn_clicked.classList.add("p-btn-active");
        
          const btn_num = p_btn_clicked.dataset.btnNum;
          const cardActive = document.querySelectorAll(`.p-btn--${btn_num}`);
          card123.forEach((curElem) => curElem.classList.add("card-not-active"));
          cardActive.forEach((curElem) => curElem.classList.remove("card-not-active"));
        });

        // 2nd card indi
        const p_btns2 = document.querySelector(".p-btns2");
        const card456 = document.querySelectorAll(".card-c2");
        
        p_btns2.addEventListener("click", (e) => {
          const p_btn_clicked2 = e.target.closest(".p-btn2");
          if (!p_btn_clicked2) return;
        
          const p_btns2 = document.querySelectorAll(".p-btn2");
          p_btns2.forEach((curElem) => curElem.classList.remove("p-btn-active"));
          p_btn_clicked2.classList.add("p-btn-active");
        
          const btn_num2 = p_btn_clicked2.dataset.btnNum;
          const cardActive2 = document.querySelectorAll(`.p-btn2--${btn_num2}`);
          card456.forEach((curElem) => curElem.classList.add("card-not-active"));
          cardActive2.forEach((curElem) => curElem.classList.remove("card-not-active"));
        });

        // 3rd card spice
        const p_btns3 = document.querySelector(".p-btns3");
        const card789 = document.querySelectorAll(".card-c3");
        
        p_btns3.addEventListener("click", (e) => {
          const p_btn_clicked3 = e.target.closest(".p-btn3");
          if (!p_btn_clicked3) return;
        
          const p_btns3 = document.querySelectorAll(".p-btn3");
          p_btns3.forEach((curElem) => curElem.classList.remove("p-btn-active"));
          p_btn_clicked3.classList.add("p-btn-active");
        
          const btn_num3 = p_btn_clicked3.dataset.btnNum;
          const cardActive3 = document.querySelectorAll(`.p-btn3--${btn_num3}`);
          card789.forEach((curElem) => curElem.classList.add("card-not-active"));
          cardActive3.forEach((curElem) => curElem.classList.remove("card-not-active"));
        });
        
        // 4th card go
        const p_btns4 = document.querySelector(".p-btns4");
        const card101112 = document.querySelectorAll(".card-c4");
        
        p_btns4.addEventListener("click", (e) => {
          const p_btn_clicked4 = e.target.closest(".p-btn4");
          if (!p_btn_clicked4) return;
        
          const p_btns4 = document.querySelectorAll(".p-btn4");
          p_btns4.forEach((curElem) => curElem.classList.remove("p-btn-active"));
          p_btn_clicked4.classList.add("p-btn-active");
        
          const btn_num4 = p_btn_clicked4.dataset.btnNum;
          const cardActive4 = document.querySelectorAll(`.p-btn4--${btn_num4}`);
          card101112.forEach((curElem) => curElem.classList.add("card-not-active"));
          cardActive4.forEach((curElem) => curElem.classList.remove("card-not-active"));
        });
        
        // 5th card vis
        const p_btns5 = document.querySelector(".p-btns5");
        const card131415 = document.querySelectorAll(".card-c5");
        
        p_btns5.addEventListener("click", (e) => {
          const p_btn_clicked5 = e.target.closest(".p-btn5");
          if (!p_btn_clicked5) return;
        
          const p_btns5 = document.querySelectorAll(".p-btn5");
          p_btns5.forEach((curElem) => curElem.classList.remove("p-btn-active"));
          p_btn_clicked5.classList.add("p-btn-active");
        
          const btn_num5 = p_btn_clicked5.dataset.btnNum;
          const cardActive5 = document.querySelectorAll(`.p-btn5--${btn_num5}`);
          card131415.forEach((curElem) => curElem.classList.add("card-not-active"));
          cardActive5.forEach((curElem) => curElem.classList.remove("card-not-active"));
        });
        
        // 6th card air-indi
        const p_btns6 = document.querySelector(".p-btns6");
        const card161718 = document.querySelectorAll(".card-c6");
        
        p_btns6.addEventListener("click", (e) => {
          const p_btn_clicked6 = e.target.closest(".p-btn6");
          if (!p_btn_clicked6) return;
        
          const p_btns6 = document.querySelectorAll(".p-btn6");
          p_btns6.forEach((curElem) => curElem.classList.remove("p-btn-active"));
          p_btn_clicked6.classList.add("p-btn-active");
        
          const btn_num6 = p_btn_clicked6.dataset.btnNum;
          const cardActive6 = document.querySelectorAll(`.p-btn6--${btn_num6}`);
          card161718.forEach((curElem) => curElem.classList.add("card-not-active"));
          cardActive6.forEach((curElem) => curElem.classList.remove("card-not-active"));
        });
        
        // 7th card trujet
        const p_btns7 = document.querySelector(".p-btns7");
        const card192021 = document.querySelectorAll(".card-c7");
        
        p_btns7.addEventListener("click", (e) => {
          const p_btn_clicked7 = e.target.closest(".p-btn7");
          if (!p_btn_clicked7) return;
        
          const p_btns7 = document.querySelectorAll(".p-btn7");
          p_btns7.forEach((curElem) => curElem.classList.remove("p-btn-active"));
          p_btn_clicked7.classList.add("p-btn-active");
        
          const btn_num7 = p_btn_clicked7.dataset.btnNum;
          const cardActive7 = document.querySelectorAll(`.p-btn7--${btn_num7}`);
          card192021.forEach((curElem) => curElem.classList.add("card-not-active"));
          cardActive7.forEach((curElem) => curElem.classList.remove("card-not-active"));
        });
</script>

    <div class="dpnr">
        <x-footer />
    </div>
    <div class="container-fluid bg-darksar p-0">
        <div class="container mobileVes1 marthide pt-5 pb-3 text-white">
            <h6 class="font-weight-bold"> Our Products </h6>
            <ul class="list-unstyled listed_links">
                <li><a href="https://wagnistrip.com">Flight</a></li>
                <li><a href="https://wagnistrip.com/hotels">Hotel</a></li>
                <li><a href="https://wagnistrip.com/holidays">Holiday</a></li>
                {{-- <li><a href="https://wagnistrip.com/cruise">Cruise</a></li>
                <li><a href="https://wagnistrip.com/visa">Visa</a></li>--}}
                <li><a href="https://wagnistrip.com/about-pages">About Us</a></li>
                <li><a href="https://wagnistrip.com/careerspages">Careers</a></li>
                <li><a href="https://wagnistrip.com/contact">Contact Us</a></li>
                <li><a href="https://wagnistrip.com/terms-and-conditions">Terms and Conditions</a></li>
                <li><a href="https://wagnistrip.com/user-agreement">User Agreement</a></li>
                <li><a href="https://wagnistrip.com/privacy-policy">Privacy Policy</a></li>
                <li><a href="https://wagnistrip.com/activities-main">Activities Tours</a></li>
                <li><a href="https://wagnistrip.com/blog-page">Blog</a></li>
            </ul>
        </div>
    </div>