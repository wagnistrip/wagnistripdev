
    <body style="background-color:#fff !important;">
   
@php
$bookings = $both['FristpnrRetrieve'];
$bookings2 = $both['book'];
@endphp
        <div class="container p-0">
            <div class="card-body">
                
            </div>
            <table id="main-content">
                <tr >
                <td colspan="3" style="border-bottom:1px solid #0065a5;">
                    <img src="{{ url('assets/images/logo.png') }}" alt="">
                </td>
                
                <td colspan="3" style="border-bottom:1px solid #0065a5; text-align:right;">
                  <h4>Toll Free No.- +91 8069145571</h4>
                    <p style="color: green;">
                        <i class="fa fa-check-circle"></i>
                        Booking Confirmed
                    </p>
                    @php
                        $itinerarys = json_decode($bookings->itinerary);
                     @endphp 
                    <p>
                        <small>
                            <strong>Booking Date:-
                            </strong> {{ date('d-m-Y', strtotime($bookings->created_at)) }} | 
                            <strong>Booking Time:- </strong> {{ date('H:i', strtotime($bookings->created_at))??'' }}
                        </small>
                    </p>
                </td>
            </tr>
                
                @php
                    use App\Http\Controllers\Airline\AirportiatacodesController;
                @endphp
            <tr>
                <td colspan="6">
                    <h4 class="font-weight-bold m-0">E-Ticket</h4>
                    <h5 class="m-0">Wagnistrip Booking ID: <strong>{{ $bookings->booking_id }}</strong>
                    </h5>
                    <p>
                        <small>
                            <strong>Booking Date:-
                            </strong> {{ date('d-m-Y', strtotime($bookings->created_at)) }} | 
                            <strong>Booking Time:- </strong> {{ date('H:i', strtotime($bookings->created_at))??'' }}
                        </small>
                    </p>
                </td>
            </tr>
            
            <tr>
                <td colspan="6" style="padding: 10px; border: 1px solid #d3d3d3d4; border-radius: 21px; box-shadow: 0.5px 0.5px 1px 1px #0000;" >
                    @foreach (json_decode($bookings->itinerary) as $itinerary)
                    @endforeach
                    @php
                        $fristcity = json_decode($bookings->itinerary)[0]->DepartCityName ?? json_decode($bookings->itinerary)->DepartCityName ?? '';
                        $lastcity = json_decode($bookings->itinerary)[count(json_decode($bookings->itinerary))-1]->ArrivalCityName ?? json_decode($bookings->itinerary)->ArrivalCityName ?? '';
                    @endphp
                    <p><i class="fa fa-check-circle text-success" aria-hidden="true"
                            style="font-size:30px;"></i> Your Flight Ticket for
                        {{ AirportiatacodesController::getCity($fristcity) }} to {{ AirportiatacodesController::getCity($lastcity) }} is
                        <strong>confirmed</strong> and your e-ticket has been mailed to you. Please carry a
                        printout
                        of your e-ticket along with a valid government issued photo ID to the airline check-in
                        counter.
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid #d3d3d347; background-color: #d3d3d347; font-size: 22px; padding-left: 7px; padding-top: 23px;">
                    <h4 >Itinerary and Reservation Details</h4>
                </td>
            </tr>

            <tr>
                <th style="border-bottom: 1px solid #d3d3d3d4;">Flight</th>
                <th style="border-bottom: 1px solid #d3d3d3d4;">Departure</th>
                <th style="border-bottom: 1px solid #d3d3d3d4;">Arrival</th>
                {{--
                <th colspan="3" style="border-bottom: 1px solid #d3d3d3d4;">Class & Aviation</th>
                --}}
            </tr>
                    
                    @php
                            $itinerarys = json_decode($bookings->itinerary);
                    @endphp 
                    @foreach (json_decode($bookings->itinerary) as $itinerary)
                        
            <tr style="text-align:center;">
                <td style="border-right: 1px solid #d3d3d3d4;border-bottom: 1px solid #d3d3d3d4;">
                    <img src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode??'') }}.png" alt="{{ $itinerary->AirLineCode??'' }}">
                    <h6 >{{ $itinerary->AirLineName }}</h6>
                    <p style="margin-top: -16px;">{{ $itinerary->AirLineCode??'' . '-' . $itinerary->FlightNumber??'' }}</p>
                </td>
                <td style="border-right: 1px solid #d3d3d3d4;border-bottom: 1px solid #d3d3d3d4; font-size: 17.7px;">
                    <h5 >{{ $itinerary->DepartCityName }} </h5>
                    <h6 style="margin-top: -16px;">Terminal {{ $itinerary->DepartTerminal??'' }}</h6>
                    <h6 style="margin-top: -16px;">{{  getDate_fn($itinerary->DepartDate)??'' ?? date('d-m-Y', strtotime($itinerary->DepartDate))??'' }} | <strong>{{ date('H:i', strtotime($itinerary->DepartDateTime))??'' }}</strong>
                    </h6>
                    <p style="margin-top: -16px;">{{ $itinerary->DepartAirportName??'' }}</p>
                </td>
                <td style="border-right: 1px solid #d3d3d3d4;border-bottom: 1px solid #d3d3d3d4; font-size: 17.7px;">
                    <h5 >{{ AirportiatacodesController::getCity($itinerary->ArrivalCityName) }}</h5>
                    <h6 style="margin-top: -16px;">Terminal {{ $itinerary->ArrivalTerminal }}</h6>
                    <h6 style="margin-top: -16px;"><strong>{{ getDate_fn($itinerary->ArrivalDate)??date('d-m-Y', strtotime($itinerary->ArrivalDate)) }} | {{ date('H:i', strtotime($itinerary->ArrivalDateTime)) }}</strong>
                    </h6>
                    <p style="margin-top: -16px;">{{ $itinerary->ArrivalAirportName }}</p>
                </td>
                {{--
                <td colspan="3" style="border-bottom: 1px solid #d3d3d3d4;width: 8%; font-size: 17.7px;">
                    <h6 >Economy : {{ $itinerary->TravelClass }}</h6>
                    <h6 style="margin-top: -16px;">Flight : {{ $bookings->trip_stop }} </h6>
                    <h6 style="margin-top: -16px;">Duration: {{ $itinerary->Duration }} | Aviation</h6>
                    <h6 style="margin-top: -16px;">*Non Refundable</h6>
                </td>
                --}}
            </tr>
                    @endforeach
                    @php
                            $itinerarys2 = json_decode($bookings2->itinerary);
                    @endphp 
                    @foreach (json_decode($bookings2->itinerary) as $itinerary)
            <tr style="text-align:center;">
                <td style="border-right: 1px solid #d3d3d3d4;border-bottom: 1px solid #d3d3d3d4;">
                        <img src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode??'') }}.png" alt="{{ $itinerary->AirLineCode??'' }}">
                    <h6 class="small m-0">{{ $itinerary->AirLineName }}</h6>
                    <p style="margin-top: -16px;">
                        {{ $itinerary->AirLineCode??'' . '-' . $itinerary->FlightNumber??'' }}</p>
                </td>
                <td style="border-right: 1px solid #d3d3d3d4;border-bottom: 1px solid #d3d3d3d4; font-size: 17.7px;">
                    <h5 class="m-0">{{ $itinerary->DepartCityName }} </h5>
                    <h6 style="margin-top: -16px;">Terminal {{ $itinerary->DepartTerminal??'' }}</h6>
                    <h6 style="margin-top: -16px;">{{  getDate_fn($itinerary->DepartDate)??'' ?? date('d-m-Y', strtotime($itinerary->DepartDate))??'' }}
                        |
                        <strong>{{ date('H:i', strtotime($itinerary->DepartDateTime))??'' }}</strong>
                    </h6>
                    <p style="margin-top: -16px;">{{ $itinerary->DepartAirportName??'' }}</p>
                </td>
                <td style="border-right: 1px solid #d3d3d3d4;border-bottom: 1px solid #d3d3d3d4; font-size: 17.7px;">
                    <h5 class="m-0">{{ AirportiatacodesController::getCity($itinerary->ArrivalCityName) }}</h5>
                    <h6 style="margin-top: -16px;">Terminal {{ $itinerary->ArrivalTerminal }}</h6>
                    <h6 style="margin-top: -16px;">
                        <strong>{{ getDate_fn($itinerary->ArrivalDate)??date('d-m-Y', strtotime($itinerary->ArrivalDate)) }} |
                            {{ date('H:i', strtotime($itinerary->ArrivalDateTime)) }}</strong>
                    </h6>
                    <p style="margin-top: -16px;">{{ $itinerary->ArrivalAirportName }}</p>
                </td>
                {{--
                <td colspan="3" style="border-bottom: 1px solid #d3d3d3d4;width: 8%; font-size: 17.7px;">
                    <h6 >Economy : {{ $itinerary->TravelClass }}</h6>
                    <h6 style="margin-top: -16px;">Flight : {{ $bookings2->trip_stop }} </h6>
                    <h6 style="margin-top: -16px;">Duration: {{ $itinerary->Duration }} | Aviation</h6>
                    <h6 style="margin-top: -16px;">*Non Refundable</h6>
                </td>
                --}}

            </tr>
                    @endforeach
                        
                
            <tr>
                <td colspan="6" style="border: 1px solid #d3d3d3d4; font-size: 23px; padding-top: 5px; margin-top: 1rem; padding-left: 8px; background-color: #d3d3d354;">
                    Passenger Details
                </td>
            </tr>
            <tr style="border: 1px solid #d3d3d3d4; font-size: 23px; background-color: #48484833;">
                <th colspan="2">
                    Passenger Name
                </th>

                <th >
                    Airline PNR
                </th>
                {{-- <th scope="col">
                    E-Ticket No.
                </th> --}}
                <th >
                    Seat
                </th>
                <th >
                    Food
                </th>
                <th >
                    Insurance
                </th>
            </tr>
            
            @php
                $itinerarys = json_decode($bookings->itinerary);
                $itinerarys2 = json_decode($bookings2->itinerary);
            @endphp

            @foreach (json_decode($bookings->passenger) as $passenger)
                <tr style="text-align:center;">
                    <td colspan="2" style="border-bottom:1px solid #d3d3d3d4">
                        {{ $passenger->Title??'' . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                        </small>

                    </td>

                    <td style="border-bottom:1px solid #d3d3d3d4">
                        {{ $bookings->airline_pnr }}
                    </td>
                    {{-- <td scope="col">
                        {{ $passenger->TicketNumber }}
                    </td> --}}
                    <td style="border-bottom:1px solid #d3d3d3d4">
                    {{--{{ $itinerary->AvailableSeats }} --}}
                        NA
                    </td>
                    <td style="border-bottom:1px solid #d3d3d3d4">
                        NA
                    </td>
                    <td style="border-bottom:1px solid #d3d3d3d4">
                        NA
                    </td>
                </tr>
                
            @endforeach
            @foreach (json_decode($bookings2->passenger) as $passenger)
                <tr style="text-align:center;">
                    <td colspan="2" style="border-bottom:1px solid #d3d3d3d4">
                        {{ $passenger->Title??'' . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                        </small>

                    </td>

                    <td style="border-bottom:1px solid #d3d3d3d4">
                        {{ $bookings2->airline_pnr }}
                    </td>
                    {{-- <td scope="col">
                        {{ $passenger->TicketNumber }}
                    </td> --}}
                    <td style="border-bottom:1px solid #d3d3d3d4">
                    {{--{{ $itinerary->AvailableSeats }} --}}
                        NA
                    </td>
                    <td style="border-bottom:1px solid #d3d3d3d4">
                        NA
                    </td>
                    <td style="border-bottom:1px solid #d3d3d3d4">
                        NA
                    </td>
                </tr>
                
            @endforeach
            
            <tr >
                <td colspan="6" style="font-size: 16px; text-align: left; padding: 5px; background: #d3d3d354;">
                    <h6 style="font-size:20px;">Baggage Details:</h6>
                    <p style="margin-top: -37px;"><span>(Hand Baggage)</span>15KG </p>
                    <p ><span class="font-weight-bold">(Check-in Baggage)7KG</span>
                    </p>
                </td>
            </tr>
            <!--<div class="row">-->
            <!--    <div class="col-sm-6 p-3">-->
            <!--        <div class="card">-->
            <!--            <img src="{{ url('assets/images/offers/img-1540472874.jpg') }}" alt="">-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="col-sm-6 p-3">-->
            <!--        <div class="card">-->
            <!--            <img src=" {{ url('assets/images/offers/img-1574918641.jpg') }}" alt="">-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="row">-->
            <!--    <div class="col-sm-6 p-3">-->
            <!--        <div class="card">-->
            <!--            <img src="{{ url('assets/images/offers/top-1620027189.jpg') }}" alt="">-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="col-sm-6 p-3">-->
            <!--        <div class="card">-->
            <!--            <img src="{{ url('assets/images/offers/top-1602673275.jpg') }}" alt="">-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--    <div class="col-sm-12 p-3">-->
            <!--        <div class="card">-->
            <!--            <img src="{{ url('assets/images/offers/top-1620027189.jpg') }}" alt="">-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            <!-- Add on please -->

            <!-- Contact Information Starts -->
            
            <tr >
                <th colspan="6" style="font-size: 23px; text-align: left; padding: 5px; border: 1px solid #d3d3d3d4; background: #d3d3d354;">
                    Contact Details:
                </th>
            </tr>
            <tr style="line-height:15px;">
                <td colspan="3" style="border-bottom: 1px solid #cbc9c994; width: 13%;">Customer Name:-</td>
                <td colspan="3" style="border-bottom: 1px solid #cbc9c994;">{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                </td>
            </tr>
            <tr style="line-height:15px;">
                <td colspan="3" style="border-bottom: 1px solid #cbc9c994; width: 13%;">Mobile:-</td>
                <td colspan="3" style="border-bottom: 1px solid #cbc9c994;">{{ $bookings->mobile }}</td>
            </tr>
            <tr style="line-height:15px;">
                <td colspan="3" style="border-bottom: 1px solid #cbc9c994; width: 13%;">Email:-</td>
                <td colspan="3" style="border-bottom: 1px solid #cbc9c994;">{{ $bookings->email }}</td>
            </tr>
            <tr style="line-height:15px;">
                <td colspan="3" style="border-bottom: 1px solid #cbc9c994; width: 13%;">Address:-</td>
                <td colspan="3" style="border-bottom: 1px solid #cbc9c994;">NA</td>
            </tr>
            <tr>
                <th colspan="6" style="font-size: 23px; text-align: left; padding: 5px; border: 1px solid #d3d3d3d4; background: #d3d3d354;">Fare Details:</th>
            </tr>
            
                <?php $fare = json_decode($bookings->fare); ?>
                @foreach (json_decode($bookings->fare) as $fare)
                
                    {{-- <tr style="border-top: 1px solid;">
                        <td colspan="3" style="border-bottom: 1px solid #cbc9c994;">Total Base Fare</td>
                        <td colspan="3" style="border-bottom: 1px solid #cbc9c994;">Rs: {{ $fare->PaxBaseFare }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom: 1px solid #cbc9c994;">Total Other Tax</td>
                        <td colspan="3" style="border-bottom: 1px solid #cbc9c994;">Rs: {{ $fare->PaxTotalFare - $fare->PaxBaseFare }}</td>
                    </tr> --}}
                    <tr>
                        <td colspan="3" style="font-size: 16px; text-align: left; padding: 5px; background: #d3d3d354;"><strong>Total Fare</strong></td>
                        <td colspan="3" style="font-size: 16px; text-align: left; padding: 5px; background: #d3d3d354;">Rs: {{ $fare->PaxTotalFare }}</td>
                    </tr>
                @endforeach
                        
                    
                    
                    
                
            
            <!-- Contact Information End -->

             <tr>
                    <td colspan="6" style="font-size: 23px; text-align: left; padding: 5px; border: 1px solid #d3d3d3d4; background: #d3d3d354;">
                        <b>Note</b>
                    </td>
                </tr>
                <tr class="card-body p-0">
                    <td colspan="6">
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
                    </td>
                </tr>
        
                <tr >
                    <td colspan="6" style="font-size: 19px; text-align: left; padding: 5px; border: 1px solid #d3d3d3d4; background: #d3d3d354;"> 
                        <b>
                            Guidelines for Domestic travel by Ministry of Health and Family welfare
                        <b>
                    </td>    
                </tr>
                <tr>
                    <td colspan="6" style="font-size: 13px; text-align: left; padding: 5px; border: 1px solid #d3d3d3d4; background: #d3d3d354;">
                        <b>Passengers must follow required health protocols, as detailed below, during their travel</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
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
                    </td>
                </tr>
                <tr >
                    <td colspan="6" style="width:50%; height:auto;text-align:center;">
                        <img src="{{ url('assets/images/mask.png') }}" alt="">
                    </td>
                </tr>
        
            </table>
            <!-- Add on End -->
        </div>
    </body>
