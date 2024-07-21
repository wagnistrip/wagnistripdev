@extends('layouts.master')
@section('title', 'Booking Confirmation')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/range.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sliderstyle/custom.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
@endsection
<style>
    .bg-primary {
       background-color: #da20d3!important;
    }
    .containing {
    z-index: 5;
    position: relative;
  }

  /*.containing::before {*/
  /*  content: "";*/
  /*  position: absolute;*/
  /*  top: 0;*/
  /*  left: 0;*/
  /*  background-image: url(assets/images/images/logo.png);*/
  /*  background-size: 1000px;*/
  /*  background-position: center;*/
  /*  background-repeat: no-repeat;*/
  /*  width: 100%;*/
  /*  height: 100%;*/
  /*  opacity: .1;*/
  /*  z-index: 2;*/
  /*}*/
</style>
@section('body')

    <!-- DESKTOP VIEW END -->
    <body style="background-color:#fff !important;margin-top:100px;">

        <div class="container p-0">
            <div class="card-body">
           
            </div>
             <div id="main-content">
            <br>
            <h4 class="m-0 text-right text-dark font-weight-bold">Toll Free No.- +91 7669988012</h4>
            <div class="d-flex bd-highlight mt-3 mb-3" style="border-bottom:1px solid #0065a5;">
                <div class="p-2 bd-highlight">
                    <img class="ticketlogo" src="{{url('assets/images/logo.png')}}" alt="Ticket logo">
                </div>
                {{-- Changing of 20-04-22 --}}
                <div class="ml-auto p-2 bd-highlight">
                    <p class="h3 text-success"><i class="fa fa-check-circle"></i>Booking Confirmed
                    </p>
                    <p>
                            <small>
                                <strong>Booking Date:-{{  date('d-m-Y', strtotime($bookings->created_at)) }} </strong> | <strong>Booking
                            Time:- {{ date("H:i",strtotime($bookings->created_at)) }}</strong>
                            </small>
                    </p>
                </div>
            </div>
            <div class="card-body">
                @php
                     use App\Http\Controllers\Airline\AirportiatacodesController;
                @endphp    
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="font-weight-bold m-0">E-Ticket</h4>
                        <h5 class="m-0">Wagnistrip Booking ID: <strong>WT000{{ $bookings->gds_pnr }}</strong></h5>
                        <p>
                            <small><strong>Booking Date:- </strong>{{  date('d-m-Y', strtotime($bookings->created_at)) }} | <strong>Booking
                                Time:- </strong> {{ date("H:i",strtotime($bookings->created_at)) }}
                            </small>
                        </p>
                    </div>
                    
                </div>
            </div>
            <div class="card-body mb-4 boxunder">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                 @foreach (json_decode($bookings->itinerary) as $itinerary)
                                 @endforeach
                                 @php
                                    $fristcity = json_decode($bookings->itinerary)[0]->DepartCityName ?? json_decode($bookings->itinerary)->DepartCityName ?? '';
                                    $lastcity = json_decode($bookings->itinerary)[count(json_decode($bookings->itinerary))-1]->ArrivalCityName ?? json_decode($bookings->itinerary)->ArrivalCityName ?? '';
                                @endphp
                                <p><i class="fa fa-check-circle text-success" aria-hidden="true"
                                        style="font-size:30px;"></i> Your Flight Ticket for {{ $fristcity }} to {{ $lastcity}} is
                                    <strong>confirmed</strong> and your e-ticket has been mailed to you. Please carry a
                                    printout
                                    of your e-ticket along with a valid government issued photo ID to the airline check-in
                                    counter.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="font-weight-bold">Itinerary and Reservation Details</h4>
            <div class="card p-2 mb-3 d-flex-row">
                <table class="table">
                    <thead class="thead-color text-center">
                        <tr>
                            <th scope="col">Flight</th>
                            <th scope="col">Departure</th>
                            <th scope="col">Arrivel</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    @foreach (json_decode($bookings->itinerary) as $itinerary)
                    <tbody>
                        <tr>
                            <th class="border-right text-center" scope="row">
                                <img src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode) }}.png"
                                alt="{{ $itinerary->AirLineCode }}">
                                <h6 class="small m-0">{{ $itinerary->AirLineName }}</h6>
                                <p class="small font-weight-bold m-0">{{ $itinerary->AirLineCode . '-' . $itinerary->FlightNumber }}</p>
                            </th>
                            <td class="border-right text-center">
                                <h5 class="m-0">{{ $itinerary->DepartCityName }} </h5>
                                <h6 class="small m-0">Terminal {{ $itinerary->DepartTerminal }}</h6>
                                <h6 class="small m-0">{{ getDateFormat_db($itinerary->DepartDateTime) }} | <strong>{{ getTimeFormat_db($itinerary->DepartDateTime) }}</h6>
                                <p class="small m-0">{{ $itinerary->DepartAirportName }}</p>
                            </td>
                            <td class="border-right text-center">
                                <h5 class="m-0">{{ $itinerary->ArrivalCityName }}</h5>
                                <h6 class="small m-0">Terminal {{ $itinerary->ArrivalTerminal }}</h6>
                                <h6 class="small m-0"><strong>{{ getDateFormat_db($itinerary->ArrivalDateTime) }} | {{ getTimeFormat_db($itinerary->ArrivalDateTime) }}</strong></h6>
                                <p class="small m-0">{{ $itinerary->ArrivalAirportName }}</p>
                            </td>
                            <td class=" text-center">
                                <h6 class="small m-0">Economy : {{ $itinerary->TravelClass }}</h6>
                                <h6 class="small m-0">Flight :  {{ $bookings->trip_stop }} </h6>
                                <h6 class="small m-0">Duration: {{ $itinerary->Duration }} | Aviation</h6>
                                <h6 class="small m-0">Refundable Fare </h6>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            <h4 class="font-weight-bold">Passenger Details</h4>
            <div class="card p-2 mb-3">
                <table class="table">
                    <thead class="thead-color text-center">
                        <tr>
                            <th scope="col">
                                Passenger Name
                            </th>
                            <th scope="col">
                                Airline Sector
                            </th>
                            <th scope="col">
                                Airline PNR
                            </th>
                            {{-- <th scope="col">
                                E-Ticket No.
                            </th> --}}
                            <th scope="col">
                                Seat
                            </th>
                            <th scope="col">
                                Food
                            </th>
                            <th scope="col">
                                Insurance
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
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
    
                                    <tr class="text-center">
                                        <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                            <small
                                                style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                            </small>
                                        </td>
                                        <td>{{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode . '-' . $OutboundItinerays[1]->ArrivalAirportCode . '-' . $OutboundItinerays[2]->ArrivalAirportCode . '-' . $OutboundItinerays[3]->ArrivalAirportCode }}
                                        </td>                                 
                                        <td>{{ $OutboundItinerays[0]->AirLineName }} | {{ $bookings->airline_pnr }}</td>
                                        {{--<td>{{ $passenger->TicketNumber }}</td>
                                        <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td>   
                                    </tr>
    
                                @elseif (isset($OutboundItinerays[2]) &&
                                    !isset($OutboundItinerays[3]))
    
                                    <tr class="text-center">
                                        <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                            <small
                                                style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                            </small>
                                        </td>
                                        <td>{{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode . '-' . $OutboundItinerays[1]->ArrivalAirportCode . '-' . $OutboundItinerays[2]->ArrivalAirportCode }}
                                        </td>
                                        <td>{{ $OutboundItinerays[0]->AirLineName }}</td>
                                        <td>{{ $bookings->airline_pnr }}</td>
                                        {{--<td>{{ $passenger->TicketNumber }}</td>
                                        <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                @elseif (isset($OutboundItinerays[1]) &&
                                    !isset($OutboundItinerays[2]))
    
                                    <tr class="text-center">
                                        <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                            <small
                                                style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                            </small>
                                        </td>
                                        <td>{{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode . '-' . $OutboundItinerays[1]->ArrivalAirportCode }}
                                        </td>
                                        <td>{{ $OutboundItinerays[0]->AirLineName }}</td>
                                        <td>{{ $bookings->airline_pnr }}</td>
                                        {{--<td>{{ $passenger->TicketNumber }}</td>
                                        <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                @elseif (isset($OutboundItinerays[0]) &&
                                    !isset($OutboundItinerays[1]))
    
                                    <tr class="text-center">
                                        <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                            <small
                                                style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                            </small>
                                        </td>
                                        <td>{{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode }}
                                        </td>
                                        <td>{{ $OutboundItinerays[0]->AirLineName }}</td>
                                        <td>{{ $bookings->airline_pnr }}</td>
                                        {{-- <td>{{ $passenger->TicketNumber }}</td>
                                        <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                        <td>NA</td>
                                        <td>NA</td> 
                                    </tr>
    
                                @endif
    
                                @if (isset($InboundItinerays[3]) && !isset($InboundItinerays[4]))
    
                                <tr class="text-center">
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small
                                            style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $InboundItinerays[0]->DepartAirportCode . '-' . $InboundItinerays[0]->ArrivalAirportCode . '-' . $InboundItinerays[1]->ArrivalAirportCode . '-' . $InboundItinerays[2]->ArrivalAirportCode . '-' . $InboundItinerays[3]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $InboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    {{--<td>{{ $passenger->TicketNumber }}</td>
                                    <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td> 
                                </tr>
    
                            @elseif (isset($InboundItinerays[2]) &&
                                !isset($InboundItinerays[3]))
    
                                <tr class="text-center">
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small
                                            style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $InboundItinerays[0]->DepartAirportCode . '-' . $InboundItinerays[0]->ArrivalAirportCode . '-' . $InboundItinerays[1]->ArrivalAirportCode . '-' . $InboundItinerays[2]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $InboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    {{--<td>{{ $passenger->TicketNumber }}</td>
                                    <td>{{ $itinerary->AvailableSeats }}</td>--}}
                                        <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td> 
                                </tr>
    
                            @elseif (isset($InboundItinerays[1]) &&
                                !isset($InboundItinerays[2]))
    
                                <tr class="text-center">
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
    
                                <tr class="text-center">
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
    
                                    <tr class="text-center">
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
    
                                    <tr class="text-center">
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
    
                                    <tr class="text-center">
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
    
                                    <tr class="text-center">
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
            <div class="card border-dotted mb-3 p-3">
                <h6 class="m-0 font-weight-bold">Baggage Details:</h6>
                      
                    <p class="m-0 small"><span>(Hand Baggage)</span>15KG </p>
                    <p class="m-0 small"><span class="font-weight-bold">(Check-in Baggage)7KG</span>
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
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-6">
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
                </div>
            </div>
            <!-- Contact Information End -->
    
            <div class="card-body p-0">
                <div class="card-header rounded-0 thead-color">
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
            </div>
    
            <div class="card-body p-0 mt-5">
                <div class="card-header rounded-0 thead-color">
                    <h6 class="m-0 font-weight-bold pt-1 pb-1">
                        Guidelines for Domestic travel by Ministry of Health and Family welfare
                    </h6>
                </div>
                <h6 class="p-3">Passengers must follow required health protocols, as detailed below, during their travel
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
            </div>
            <div class="card border-0">
                <img src="{{ url('assets/images/mask.png') }}" alt="">
            </div>
    
            <!-- Add on End -->
            
    
        </div>
        </div>
    
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
