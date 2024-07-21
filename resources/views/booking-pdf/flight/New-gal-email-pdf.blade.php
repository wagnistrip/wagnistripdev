<!-- 
@extends('layouts.master')
@section('title', 'Booking Confirmation')
@section('css') -->
    <link rel="stylesheet" href="{{ asset('assets/css/range.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sliderstyle/custom.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
<!-- @endsection -->
<style type="text/css">
    @media only screen and (max-width: 630px) {
        .flight {
            padding: 0px 5px !important;
        }
    }

    @media only screen and (max-width: 600px) {
        .bookingId {
            position: relative !important;
            right: 15px !important;
        }

        .wagnistrip-support-table {
            position: relative !important;
            left: 8px !important;
        }

        .logoAndBookingId .grid {
            gap: 40% !important;
        }
    }


    @media only screen and (max-width: 500px) {
        .thanks {
            padding: 0px 0px !important;
        }

        .logoAndBookingId .grid {
            gap: 30% !important;
        }

        .flight-details p:nth-child(1),
        p:nth-child(2) {
            text-align: center;
        }

        .flight-img .indigo-airlines-para {
            position: relative !important;
            right: 92px !important;
        }

        .timing {
            position: relative !important;
            left: 0px !important;
        }

        .timing .timingpara {
            position: relative !important;
            left: -82px !important;
        }

        .timing .timinghr {
            margin-right: 160px !important;
        }

        .flight .grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        .flight-details {
            position: relative !important;
            right: 100px !important;
        }

        .date p,
        .place p,
        .time p {
            font-size: 11px !important;
        }

        .passenger-name .grid p {
            font-size: 10px !important;
        }

        .important-info p {
            font-size: 10px !important;
        }

        .baggage-info {
            width: 90.5% !important;
        }

        .baggage-info p {
            font-size: 10px !important;
        }

        .payment-info p {
            font-size: 10px !important;
        }

        .cancellation p {
            font-size: 10px !important;
        }

        .customer-support p {
            font-size: 10px !important;
        }
    }

    @media only screen and (max-width: 400px) {
        .customer-support {
            width: 90% !important;
        }

        .support .grid {
            flex-direction: column !important;
        }

        .wagnistrip-support-table {
            width: 90% !important;
        }

        .wagnistrip-airline-table {
            width: 90% !important;
            position: relative !important;
            left: 8px !important;
            top: 20px !important;
        }

        .logoAndBookingId .grid {
            gap: 20% !important;
        }
    }

    @media only screen and (max-width: 350px) {
        .bookingId {
            position: relative !important;
            right: 40px !important;
            top: 10px !important;
        }

        .thanks .grid {
            grid-template-columns: repeat(1, 1fr) !important;
        }

        .svg-icon {
            margin-left: 100px;
        }

        .flight-details {
            position: relative !important;
            right: 10px !important;
        }

        .flight-details p:nth-child(1) {
            font-size: 10px !important;
        }

        .flight-details p:nth-child(2) {
            font-size: 12px !important;
        }

        .web-check-in-para {
            max-width: 65% !important;
            margin: 10px auto !important;
        }

        .destination .grid {
            flex-direction: column !important;
        }

        .place {
            width: 280px !important;
        }
    }

    @media only screen and (max-width: 330px) {
        .containing {
            padding: 10px 55px !important;
            width: 100% !important;
        }

        .logoAndBookingId .grid {
            gap: 0% !important;
            grid-template-columns: repeat(1, 1fr) !important;
        }

        .bookingId {
            position: relative !important;
            top: 10px !important;
            left: 10px;
        }

        .bookingId p:nth-child(2) {
            text-align: left !important;
        }

        .flight .grid {
            grid-template-columns: repeat(1, 1fr) !important;
        }

        .flight-img {
            padding: 0px 110px !important;
        }

        .flight-img .indigo-airlines-para {
            position: relative !important;
            right: 2px !important;
            bottom: 5px !important;
        }

        .timing {
            position: relative !important;
            left: 95px !important;
        }

        .timing .timingpara {
            position: relative !important;
            right: 105px !important;
        }

        .timing .timinghr {
            margin-right: 208px !important;
        }
    }

    @media only screen and (max-width: 300px) {
        .baggage-info {
            width: 89% !important;
            margin-left: 0px !important;
        }

        .baggage-info-table {
            margin-left: 0px !important;
        }

        .payment-info {
            width: 89% !important;
            margin-left: 0px !important;
        }

        .cancellation {
            width: 89% !important;
            margin-left: 0px !important;
        }

        .cancellation-table {
            margin-left: 23px !important;
        }

        .date-change-table {
            margin-left: 23px !important;
        }

        .customer-support {
            width: 89% !important;
            margin-left: 0px !important;
        }

        .wagnistrip-airline-table {
            position: relative !important;
            top: 9px !important;
        }

        .support {
            position: relative !important;
            right: 27px !important;
        }

        .important-info-ul {
            padding: 0px 25px !important;
        }
    }

    table,
    tr,
    td,
    th {

        padding: 10px;

        margin: auto;

        border: none;

    }
 @media only screen and (max-width: 768px) {
table {
display: block;
overflow-x: auto;
}
}
</style>
<!-- @section('body') -->

    <!-- DESKTOP VIEW END -->
    <body style="background-color:#fff !important;margin-top:100px max-width 650px;">
            <table >
                <tr>
                  <!-- <td><img src="{{url('assets/images/logo.png')}}" alt="Ticket logo"></td> -->
                  <td> <p style="font-size: 24px; margin-left: 700px;">Toll Free No.- +91 7669988012</p>
                    <p style="font-size: 24px; margin-left: 700px ;color: #28a745;">
                        <i class=""></i>Booking Confirmed
                    </p>
                    <p>
                      <small>
                        <strong style="font-size: 24px; margin-left: 700px ;">
                            Booking Date:-
                            <!-- {{  date('d-m-Y', strtotime($bookings->created_at)) }} -->
                         </strong> | <strong>
                            Booking Time:- 
                            <!-- {{ date("H:i",strtotime($bookings->created_at)) }} -->
                        </strong>
                      </small>
                    </p>
                  </td>
                </tr>
              </table>
              <hr style="height:2px;border-width:0;color:gray;background: #0164a3">
              <table class="" style="width: 100%; border-collapse: collapse; border: none;">
                <tr>
                    <td class="col-md-6" style="padding: 15px;">
                        <p style="font-size: 24px;">E-Ticket</p>
                        <p>
                            Wagnistrip Booking ID: <strong>
                                <!-- WT000{{ $bookings->gds_pnr }} -->
                            </strong>
                        </p>
                        <p>
                            <small><strong>Booking Date:- </strong>
                                <!-- {{ date('d-m-Y', strtotime($bookings->created_at)) }} |  -->
                                <strong>Booking Time:- </strong>
                                <!-- {{ date("H:i", strtotime($bookings->created_at)) }} -->
                            </small>
                        </p>
                    </td>
                </tr>
            </table>

            <table style="border-collapse: collapse; margin-bottom: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.2);"> 
                 <tbody>
                    <tr>
                        <td>
                            @foreach (json_decode($bookings->itinerary) as $itinerary)
                            @endforeach
                            @php
                            $fristcity = json_decode($bookings->itinerary)[0]->DepartCityName ?? json_decode($bookings->itinerary)->DepartCityName ?? '';
                            $lastcity = json_decode($bookings->itinerary)[count(json_decode($bookings->itinerary))-1]->ArrivalCityName ?? json_decode($bookings->itinerary)->ArrivalCityName ?? '';
                            @endphp
                            <p style="font-size: 16px; line-height: 22px; margin-bottom: 0;">
                                <!-- <i class="fa fa-check-circle text-success" aria-hidden="true" style="font-size: 30px;"></i> -->
                                Your Flight Ticket for {{ $fristcity }} to {{ $lastcity}} is <strong>confirmed</strong> and your
                                e-ticket has been mailed to you. Please carry a printout of your e-ticket along with a valid
                                government issued photo ID to the airline check-in counter.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
                <table style="padding: 8px;margin-bottom: 1rem;display: flex;flex-direction: row;">
                    <tr>
                        <td>
                            <h4 style="font-weight: bold;">Itinerary and Reservation Details</h4>
                        </td>
                    </tr>
                </table>
                <table class="table">
                    <thead style="font-weight: bold; text-align: center;">
                        <tr>
                                <th style="text-align: center;">Flight</th> 
                                <th style="text-align: center;">Departure</th> 
                                <th style="text-align: center;">Arrivel</th>
                                <th style="text-align: center;">class & Aviation</th> 
                        </tr>
                    </thead>
                    @foreach (json_decode($bookings->itinerary) as $itinerary)
                    <tbody>
                        <tr>
                                <td style="border-right: 1px solid #dee2e6; text-align: center;"></td>
                                <img src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode) }}.png"
                                alt="{{ $itinerary->AirLineCode }}">
                                <h6 style="font-size: small; margin: 0;">{{ $itinerary->AirLineName }}</h6>
                                <span style="font-size: small; font-weight: bold; margin: 0;">{{ $itinerary->AirLineCode . '-' . $itinerary->FlightNumber }}</p>
                            </th>
                            <!-- <td class="border-right text-center"> -->
                                <td style="border-right: 1px solid #dee2e6; text-align: center;">
                                  <!-- <h5 class="m-0"> -->
                                    <h5 style="margin: 0;"> {{ $itinerary->DepartCityName }} </h5>
                                <h6 style="font-size: small; margin: 0;">Terminal {{ $itinerary->DepartTerminal }}</h6>
                                <h6 style="font-size: small; margin: 0;">{{ getDateFormat_db($itinerary->DepartDateTime) }} | <strong>{{ getTimeFormat_db($itinerary->DepartDateTime) }}</h6>
                                <p style="font-size: small; margin: 0;">{{ $itinerary->DepartAirportName }}</p>
                            </td>
                            <td style="border-right: 1px solid #dee2e6; text-align: center;">
                                <h5 style="margin: 0;">{{ $itinerary->ArrivalCityName }}</h5>
                                <h6 style="font-size: small; margin: 0;">Terminal {{ $itinerary->ArrivalTerminal }}</h6>
                                <h6 style="font-size: small; margin: 0;"><strong>{{ getDateFormat_db($itinerary->ArrivalDateTime) }} | {{ getTimeFormat_db($itinerary->ArrivalDateTime) }}</strong></h6>
                                <p style="font-size: small; margin: 0;">{{ $itinerary->ArrivalAirportName }}</p>
                            </td>
                            <!-- <td class=" text-center"> -->
                                <td style="text-align: center;">
                                <h6 style="font-size: small; margin: 0;">Economy : {{ $itinerary->TravelClass }}</h6>
                                <h6 style="font-size: small; margin: 0;">Flight :  {{ $bookings->trip_stop }} </h6>
                                <h6 style="font-size: small; margin: 0;">Duration: {{ $itinerary->Duration }} | Aviation</h6>
                                <h6 style="font-size: small; margin: 0;">Refundable Fare </h6>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </table>
            <h4 style="font-weight: bold;">Passenger Details</h4>
            <!-- <div class="card p-2 mb-3"> -->
                <div style="padding: 0.5rem; margin-bottom: 1rem;"></div>
                <!-- <table class="table"> -->
                    <table style="display: table;">
                        <thead style="background-color: #1b4b72; color: white; text-align: center;"></thead>
                    <!-- <thead class="thead-color text-center"> -->
                        <tr>
                            
                                <th style="text-align: center;">
                                Passenger Name
                            </th>
                            
                                <th style="text-align: center;">
                                Airline Sector
                            </th>
                            
                                <th style="text-align: center;">
                                Airline PNR
                            </th>                            
                                <th style="text-align: center;">
                                Seat
                            </th>
                            
                                <th style="text-align: center;">
                                Food
                            </th>
                            
                                <th style="text-align: center;">
                                Insurance
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- @php
                            $itinerarys = json_decode($bookings->itinerary);
                        @endphp
    
                        @foreach (json_decode($bookings->passenger) as $passenger)
    
                            @if ($bookings->trip_type == 2)
    
                                @php
                                    $OutboundItinerays = [];
                                    $InboundItinerays = [];
                                @endphp
    
                                @foreach ($itinerarys as $itinerary)
    
                                    @if ($itinerary->FlightCount === 1)
    
                                        @php
                                            array_push($OutboundItinerays, $itinerary);
                                        @endphp
    
                                    @elseif ($itinerary->FlightCount === 2)
    
                                        @php
                                            array_push($InboundItinerays, $itinerary);
                                        @endphp
    
                                    @endif
    
                                @endforeach
    
                                @if (isset($OutboundItinerays[3]) && !isset($OutboundItinerays[4]))
     -->
                                        <tr style="text-align: center;">
                                        <td>
                                            <!-- {{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }} -->
                                            <small
                                                style="font-size: 12px;">
                                                <!-- ({{ $passenger->PaxTypeCode }}) -->
                                            </small>
                                        </td>
                                        <td>
                                            <!-- {{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode . '-' . $OutboundItinerays[1]->ArrivalAirportCode . '-' . $OutboundItinerays[2]->ArrivalAirportCode . '-' . $OutboundItinerays[3]->ArrivalAirportCode }} -->
                                        </td>                                 
                                        <td>
                                            <!-- {{ $OutboundItinerays[0]->AirLineName }} | {{ $bookings->airline_pnr }} -->
                                        </td>
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td>   
                                    </tr>
    
                                <!-- @elseif (isset($OutboundItinerays[2]) &&
                                    !isset($OutboundItinerays[3])) -->
    
                                        <tr style="text-align: center;">
                                        <td>
                                            <!-- {{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }} -->
                                            <small
                                                style="font-size: 12px;">
                                                <!-- ({{ $passenger->PaxTypeCode }}) -->
                                            </small>
                                        </td>
                                        <td>
                                            <!-- {{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode . '-' . $OutboundItinerays[1]->ArrivalAirportCode . '-' . $OutboundItinerays[2]->ArrivalAirportCode }} -->
                                        </td>
                                        <td> 
                                            <!-- {{ $OutboundItinerays[0]->AirLineName }} -->
                                        </td>
                                        <td>
                                            <!-- {{ $bookings->airline_pnr }}  -->

                                        </td>
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                <!-- @elseif (isset($OutboundItinerays[1]) &&
                                    !isset($OutboundItinerays[2])) -->
    
                                        <tr style="text-align: center; ">
                                        <td > 
                                            <!-- {{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }} -->
                                            <small
                                                style="font-size: 12px;">
                                                <!-- ({{ $passenger->PaxTypeCode }}) -->
                                            </small>
                                        </td>
                                        <td>
                                            <!-- {{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode . '-' . $OutboundItinerays[1]->ArrivalAirportCode }} -->
                                        </td>
                                        <td> 
                                            <!-- {{ $OutboundItinerays[0]->AirLineName }} -->
                                        </td>
                                        <td>
                                            <!-- {{ $bookings->airline_pnr }} -->

                                        </td>
                                    
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                <!-- @elseif (isset($OutboundItinerays[0]) &&
                                    !isset($OutboundItinerays[1])) -->
    
                                        <tr style="text-align: center;">
                                        <td> 
                                            <!-- {{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }} -->
                                            <small
                                                style="font-size: 12px;">
                                                <!-- ({{ $passenger->PaxTypeCode }}) -->
                                            </small>
                                        </td>
                                        <td>
                                            <!-- {{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode }} -->
                                        </td>
                                        <td>
                                            <!-- {{ $OutboundItinerays[0]->AirLineName }} -->
                                        </td>
                                        <td>
                                            <!-- {{ $bookings->airline_pnr }} -->

                                        </td>
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                <!-- @endif
    
                                @if (isset($InboundItinerays[3]) && !isset($InboundItinerays[4]))
     -->
                                    <tr style="text-align: center;">
                                    <td> 
                                        <!-- {{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }} -->
                                        <small
                                            style="font-size: 12px;">
                                            <!-- ({{ $passenger->PaxTypeCode }}) -->
                                        </small>
                                    </td>
                                    <td>
                                        <!-- {{ $InboundItinerays[0]->DepartAirportCode . '-' . $InboundItinerays[0]->ArrivalAirportCode . '-' . $InboundItinerays[1]->ArrivalAirportCode . '-' . $InboundItinerays[2]->ArrivalAirportCode . '-' . $InboundItinerays[3]->ArrivalAirportCode }} -->
                                    </td>
                                    <td>
                                        <!-- {{ $InboundItinerays[0]->AirLineName }} -->

                                    </td>
                                    <td>
                                        <!-- {{ $bookings->airline_pnr }} -->
                                    </td>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td> 
                                </tr>
    
                            <!-- @elseif (isset($InboundItinerays[2]) &&
                                !isset($InboundItinerays[3])) -->
    
                                <!-- <tr class="text-center"> -->
                                    <tr style="text-align: center ,color:#0164a3;">
                                    <td>
                                        <!-- {{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }} -->
                                        <small
                                            style="font-size: 12px;">
                                            <!-- ({{ $passenger->PaxTypeCode }}) -->
                                        </small>
                                    </td>
                                    <td>
                                        <!-- {{ $InboundItinerays[0]->DepartAirportCode . '-' . $InboundItinerays[0]->ArrivalAirportCode . '-' . $InboundItinerays[1]->ArrivalAirportCode . '-' . $InboundItinerays[2]->ArrivalAirportCode }} -->
                                    </td>
                                    <td>
                                        <!-- {{ $InboundItinerays[0]->AirLineName }} -->
                                    </td>
                                    <td>
                                        <!-- {{ $bookings->airline_pnr }}  -->
                                    </td>
                                        <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td> 
                                </tr>
    
                            <!-- @elseif (isset($InboundItinerays[1]) &&
                                !isset($InboundItinerays[2])) -->
    
                                <!-- <tr class="text-center"> -->
                                    <tr style="text-align: center;">
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small
                                            style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $InboundItinerays[0]->DepartAirportCode . '-' . $InboundItinerays[0]->ArrivalAirportCode . '-' . $InboundItinerays[1]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $InboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    {{--<td>{{ $passenger->TicketNumber }}</td>
                                    <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td> 
                                </tr>
    
                            @elseif (isset($InboundItinerays[0]) &&
                                !isset($InboundItinerays[1]))
    
                                <!-- <tr class="text-center"> -->
                                    <tr style="text-align: center;">
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small
                                            style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $InboundItinerays[0]->DepartAirportCode . '-' . $InboundItinerays[0]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $InboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    {{--<td>{{ $passenger->TicketNumber }}</td>
                                    <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td> 
                                </tr>
    
                            @endif
    
                            @elseif($bookings->trip_type == 1)
    
                                @if (isset($itinerarys[3]) && !isset($itinerarys[4]))
    
                                    <!-- <tr class="text-center"> -->
                                        <tr style="text-align: center;">
                                        <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                            <small
                                                style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                            </small>
                                        </td>
                                        <td>{{ $itinerarys[0]->DepartAirportCode . '-' . $itinerarys[0]->ArrivalAirportCode . '-' . $itinerarys[1]->ArrivalAirportCode . '-' . $itinerarys[2]->ArrivalAirportCode . '-' . $itinerarys[3]->ArrivalAirportCode }}
                                        </td>
                                        <td>{{ $itinerarys[0]->AirLineName }}</td>
                                        <td>{{ $bookings->airline_pnr }}</td>
                                        {{--<td>{{ $passenger->TicketNumber }}</td>
                                        <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                @elseif (isset($itinerarys[2]) &&
                                    !isset($itinerarys[3]))
    
                                    <!-- <tr class="text-center"> -->
                                        <tr style="text-align: center;">
                                        <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                            <small
                                                style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                            </small>
                                        </td>
                                        <td>{{ $itinerarys[0]->DepartAirportCode . '-' . $itinerarys[0]->ArrivalAirportCode . '-' . $itinerarys[1]->ArrivalAirportCode . '-' . $itinerarys[2]->ArrivalAirportCode }}
                                        </td>
                                        <td>{{ $itinerarys[0]->AirLineName }}</td>
                                        <td>{{ $bookings->airline_pnr }}</td>
                                        {{--<td>{{ $passenger->TicketNumber }}</td>
                                        <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                        
                                    </tr>
    
                                @elseif (isset($itinerarys[1]) &&
                                    !isset($itinerarys[2]))
    
                                    <!-- <tr class="text-center"> -->
                                        <tr style="text-align: center;">
                                        <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                            <small
                                                style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                            </small>
                                        </td>
                                        <td>{{ $itinerarys[0]->DepartAirportCode . '-' . $itinerarys[0]->ArrivalAirportCode . '-' . $itinerarys[1]->ArrivalAirportCode }}
                                        </td>
                                        <td>{{ $itinerarys[0]->AirLineName }}  {{ $bookings->airline_pnr }}</td>
                                        
                                        {{--<td>{{ $passenger->TicketNumber }}</td>
                                        <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                @elseif (isset($itinerarys[0]) &&
                                    !isset($itinerarys[1]))
    
                                    <!-- <tr class="text-center"> -->
                                        <tr style="text-align: center;">
                                        <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                            <small
                                                style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                            </small>
                                        </td>
                                        <td>{{ $itinerarys[0]->DepartAirportCode . '-' . $itinerarys[0]->ArrivalAirportCode }}
                                        </td>
                                        <td>{{ $itinerarys[0]->AirLineName }} - {{ $bookings->airline_pnr }} </td>
                                        
                                        {{--<td>{{ $passenger->TicketNumber }}</td>
                                        <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                @endif
    
                            @endif
    
                        @endforeach
                    </tbody>
                </table>
            </div>
            <table style="border-style: dotted; border-width: 1px; margin-bottom: 1rem; padding: 1rem 1.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <h6 style="margin: 0px; font-weight: bold;">Baggage Details:</h6>
                      
                    <!-- <p class="m-0 small"><span>(Hand Baggage)</span>15KG </p>
                    <p class="m-0 small"> <span class="font-weight-bold">(Check-in Baggage)7KG</span>
                        additional 10 kg for student booking.</p> -->
                <p style="margin: 0; font-size: small;"><span>(Hand Baggage)</span>15KG </p>
                <p style="margin: 0; font-size: small;"><span class="font-weight-bold">(Check-in Baggage)7KG</span>
              additional 10 kg for student booking.</p>
                
            </div>
          {{-- <div class="row">
                <div class="col-sm-6 p-3">
                    <div class="card">
                        <img src="{{url('assets/images/offers/img-1540472874.jpg')}}" alt="">
                    </div>
                </div>
                <div class="col-sm-6 p-3">
                    <div class="card">
                        <img src=" {{url('assets/images/offers/img-1574918641.jpg')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 p-3">
                    <div class="card">
                        <img src="{{url('assets/images/offers/top-1620027189.jpg')}}" alt="">
                    </div>
                </div>
                <div class="col-sm-6 p-3">
                    <div class="card">
                        <img src="{{url('assets/images/offers/top-1602673275.jpg')}}" alt="">
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-sm-12 p-3">
                    <div class="card">
                        <img src="{{url('assets/images/offers/top-1620027189.jpg')}}" alt="">
                    </div>
                </div>
            </div> --}}
    <!-- Add on please -->
    
            <!-- Contact Information Starts -->
            <!-- <div class="card-body p-0"> -->
                <table style="padding: 0; margin: 0; border-collapse: collapse; border-spacing: 0;" >
                <div class="row">
                    <!-- <div class="col-md-6">
                        <table class="table border">
                            <thead class="thead-color">
                                <tr>
                                    <th colspan="2">Contact Details:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="line-height:10px;">
                                    <td>Customer Name:-</td>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}</td>
                                </tr>
                                <tr style="line-height:10px;">
                                    <td>Mobile:-</td>
                                    <td>{{ $bookings->mobile }}</td>
                                </tr>
                                <tr style="line-height:10px;">
                                    <td>Email:-</td>
                                    <td>{{ $bookings->email }}</td>
                                </tr>
                                <tr style="line-height:10px;">
                                    <td>Address:-</td>
                                    <td>NA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->

                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width: 50%;">
                                    <table style="border-collapse: collapse;">
                                        <thead style="background-color: #f8f9fa; text-align: center;">
                                            <tr>
                                                <th colspan="2" style="padding: 10px; font-weight: bold;">Contact Details:</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="line-height: 10px;">
                                                <td style="padding: 5px;">Customer Name:-</td>
                                                <td style="padding: 5px;">{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}</td>
                                            </tr>
                                            <tr style="line-height: 10px;">
                                                <td style="padding: 5px;">Mobile:-</td>
                                                <td style="padding: 5px;">{{ $bookings->mobile }}</td>
                                            </tr>
                                            <tr style="line-height: 10px;">
                                                <td style="padding: 5px;">Email:-</td>
                                                <td style="padding: 5px;">{{ $bookings->email }}</td>
                                            </tr>
                                            <tr style="line-height: 10px;">
                                                <td style="padding: 5px;">Address:-</td>
                                                <td style="padding: 5px;">NA</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                    <!-- <div class="col-md-6">
                        <table class="table border">
                            <thead class="thead-color">
                                <tr>
                                    <th colspan="2">Fare Details:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $fare = json_decode($bookings->fare); ?>
                                <tr>
                                    <td>Total Base Fare</td>
                                    <td class="text-right">Rs: {{ $fare->TotalBaseFare }}</td>
                                </tr>
                                <tr>
                                    <td>Total Other Tax</td>
                                    <td class="text-right">Rs: {{ $fare->TotalOtherTax }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Fare</strong></td>
                                    <td class="text-right">Rs: {{ $fare->TotalFare }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> -->
                <table style="display: inline-block; width: 49%; vertical-align: top; margin-right: 1%;" class="col-md-6">
                    <table class="table border">
                        <thead style="background-color: #6777ef; color: #fff;">
                            <tr>
                                <th colspan="2">Fare Details:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $fare = json_decode($bookings->fare); ?>
                            <tr>
                                <td>Total Base Fare</td>
                                <td style="text-align: right;">Rs: {{ $fare->TotalBaseFare }}</td>
                            </tr>
                            <tr>
                                <td>Total Other Tax</td>
                                <td style="text-align: right;">Rs: {{ $fare->TotalOtherTax }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Fare</strong></td>
                                <td style="text-align: right;">Rs: {{ $fare->TotalFare }}</td>
                            </tr>
                        </tbody>
                    </table>
                </table>
            </table>
            <!-- Contact Information End -->
    
            <!-- <div class="card-body p-0"> -->
                <table style="padding: 1rem; padding: 0;">
                <!-- <div class="card-header rounded-0 thead-color"> -->
                    <table style="color: blue; font-size: 18px;">
                    <h6 class="m-0 font-weight-bold pt-1 pb-1">Note</h6>
                </div>
                <ol class="mt-3 small">
                    <li>
                        Passengers are requested to report at least 03 hours prior to flight departure and counters will
                        close 60 minutes prior to departure.
                    </li>
                    <li>
                        Online check-in has been made compulsory for all passengers by Ministry of Civil Aviation.
                    </li>
                    <li>
                        As per government directives, all passengers have to carry a valid photo identification with them
                        throughout the journey to be checked at
                        any point
                    </li>
                    <li>
                        Passenger will have to present their Web or Mobile Boarding pass and download the Aarogya Setu App
                        for entry into the airport terminal
                    </li>
                    <li>
                        Online check-in commences from 72 hours till 01 hour prior departure for Domestic travel and 48
                        hours till 02 hours prior before departure
                        for International travel.
                    </li>
                    <li>
                        Only 1 piece of check-in baggage is permitted upto 15 kgs per passenger and 1 piece of hand baggage
                        upto 07 kgs per passenger.
                    </li>
                    <li>
                        <a href="#">Click here</a> to refer to State wise guidelines for the travellers.
                    </li>
                    <li>
                        Combat Covid - 19 pandemic.Protect yourself and others by taking these precautions:
                        <ul>
                            <li>
                                Cover nose and mouth with mask
                            </li>
                            <li>
                                Follow Social Distancing
                            </li>
                            <li>
                                Wash Hands frequently and use hand sanitizers
                            </li>
                        </ul>
                    </li>
                    <li>
                        Passengers arriving into Port Blair are required to show a valid negative RT PCR test report issued
                        by an ICMR recognized laboratory.
                        <a href="#">Click here</a> for more information.
                    </li>
    
                </ol>
            </table>
    
            <!-- <div class="card-body p-0 mt-5"> -->
                <table style="background-color: #f0f0f0; border: 1px solid #ccc; padding: 10px;">

                    <table style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0; padding: 10px;">
                        <tr style="margin: 0; font-weight: bold; padding-top: 5px; padding-bottom: 5px;">
                            Guidelines for Domestic travel by Ministry of Health and Family welfare
                        </tr>
                    </table>
                    <h6 style="padding: 15px;">Passengers must follow required health protocols, as detailed below, during their travel
                </h6>
                <ol class="mt-1 small">
                    <li>
                        Passengers should self-monitor their health and travel only when they have no symptoms related to
                        COVID-19.
                    </li>
                    <li>
                        All passengers shall follow COVID appropriate behaviour at all times which includes use of mask/face
                        cover, hand hygiene and physical
                        distancing of six feet as far as feasible. Masks/face covers must be worn properly to cover nose and
                        mouth. Touching the front portion of
                        mask/face covers to be avoided.
                    </li>
                    <li>
                        Avoid spitting in public places during travel.
                    </li>
                    <li>
                        All passengers shall be advised to download Arogya Setu app on their mobile devices.
                    </li>
                    <li>
                        If they develop fever during travel, they shall report to cabin crew.
                    </li>
                    <li>
                        Passengers should follow hand hygiene and respiratory hygiene (such as covering the mouth with elbow
                        while coughing) at all times.
                    </li>
                    
                    <li>
                        If they develop symptoms after reaching their final destination, they shall inform the District
                        Surveillance Officer or the State/National Call
                        Center (1075).
                        
                </ol>
            </table>
            <!-- <div style="border: none;">
                <img src="{{ url('assets/images/mask.png') }}" alt="">
            </div> -->
    
            <!-- Add on End -->
         </table>
        </table>
    
    </body>

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
    <script src="{{ asset('assets/js/range.js') }}"></script>
    <script src="{{ asset('assets/sliderstyle/multislider.js') }}"></script>
    <script src="{{ asset('assets/sliderstyle/multislider.min.js') }}"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
    <script>
        $('#exampleSlider').multislider({
            interval: 0,
            slideAll: false,
            duration: 100
        });
        
        $(document).ready(function () {
            $("#download").click(function () {
                $("#main-content").printThis();
            });
        });
    </script>
@endsection

@endsection
oneway-gal-flight-booking-confirm.blade.php
Displaying oneway-gal-flight-booking-confirm.blade.php.
