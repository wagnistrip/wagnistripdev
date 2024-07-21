
<body style="background-color:#fff !important;padding: 5px 5px;">
    <div style="margin: 50px;">
       
        <div  style="border-bottom:1px solid #0065a5;">
            <div>
                <img style="position: relative;
                top: 150px;" src="{{asset('assets/images/logo.png')}}" alt="">
                
            </div>


            <div 
                style="display: flex;flex-direction: column;align-items: end;position: relative;bottom: 150px;">
                <h4>Toll Free No.- +91 7669988012</h4>
                <p  style="color:rgb(16, 226, 16);font-weight: 900;">Booking Confirmed
                </p>
                
                <p> <small><strong>Booking Date:-
                            {{ date('d-m-Y', strtotime($bookings->created_at)) }}
                        </strong> | <strong>Booking
                            Time:- {{ date('H:i', strtotime($bookings->created_at)) }}</strong> </small>
                </p>
            </div>
        </div>
        <div>
              @php
                use App\Http\Controllers\Airline\AirportiatacodesController;
            @endphp  
            <div>
                <div>
                    <h4>E-Ticket</h4>
                    <h5>Wagnistrip Booking ID: <strong>
                              {{ $bookings->booking_id??'' }} 
                        </strong>
                    </h5>
                    <p> <small><strong>Booking Date:-{{ date('d-m-Y', strtotime($bookings->created_at)) }}
                        </strong> | <strong>Booking
                            Time:- {{ date('H:i', strtotime($bookings->created_at)) }}</strong> </small>
                    </p>
                </div>
            </div>
        </div>
        <div>
            <div>
                <div>
                    <div>
                        <div>
                            @foreach (json_decode($bookings->itinerary) as $itinerary)@endforeach
                                @php
                                    $fristcity = json_decode($bookings->itinerary)[0]->DepartCityName ?? json_decode($bookings->itinerary)->DepartCityName ?? '';
                                    $lastcity = json_decode($bookings->itinerary)[count(json_decode($bookings->itinerary))-1]->ArrivalCityName ?? json_decode($bookings->itinerary)->ArrivalCityName ?? '';
                                @endphp
                                <p><i class="fa fa-check-circle text-success" aria-hidden="true"
                                        style="font-size:30px;"></i> Your Flight Ticket for
                                    {{ AirportiatacodesController::getCity($fristcity) }} to {{ AirportiatacodesController::getCity($lastcity) }} is
                                    <strong>confirmed</strong> and your e-ticket has been mailed to you. Please carry a
                                    printout of your e-ticket along with a valid government issued photo ID to the airline check-in
                                    counter.
                                </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 style="font-weight:900;font-size:20px">Itinerary and Reservation Details</h4>

        <div>
            <table  style="border:1px solid #000; border-collapse:collapse; width:100%;"  >
                <tr>
                    <th   style="border:1px solid #000; border-collapse:collapse;" >Flight</th>
                    <th   style="border:1px solid #000;  border-collapse:collapse;" >Departure</th>
                    <th   style="border:1px solid #000;  border-collapse:collapse;">Arrivel</th>
                    <th   style="border:1px solid #000;  border-collapse:collapse;">Class & Aviation</th>
                </tr>
                </thead>
                  @foreach (json_decode($bookings->itinerary) as $itinerary) 
                <tbody style="text-align: center;">
                    <tr>
                        <th   style="border:1px solid #000; border-collapse:collapse;" scope="row">
                               <img src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode) }}.png"
                                    alt="{{ $itinerary->AirLineCode }}">
                            <h6>AirLineName
                                  {{ $itinerary->AirLineName }}  
                            </h6>
                            <p>
                                  {{ $itinerary->AirLineCode . '-' . $itinerary->FlightNumber}}  
                            </p>
                        </th>
                        <td   style="border:1px solid #000;  border-collapse:collapse;" >
                            <h5>
                                  {{ AirportiatacodesController::getCity($itinerary->DepartCityName)}}  
                            </h5>
                            <h6>
                                  Terminal {{ $itinerary->DepartTerminal }}  
                            </h6>
                            <h6>
                                <strong>
                                      {{ date('d-m-Y', strtotime($itinerary->DepartDateTime)) }}  
                                </strong>
                                |
                                <strong>
                                    
                                      {{ date('H:i', strtotime($itinerary->DepartDateTime)) }}  
                                </strong>
                            </h6>
                            <p>
                                  {{ $itinerary->DepartAirportName??'DepartAirportName' }}  
                            </p>
                        </td>
                        <td   style="border:1px solid #000;  border-collapse:collapse;" >
                            <h5>
                                  {{AirportiatacodesController::getCity( $itinerary->ArrivalCityName)}}  
                            </h5>
                            <h6>Terminal
                                  {{ $itinerary->ArrivalTerminal }}  
                            </h6>
                            <h6>
                                <strong>
                                    
                                      {{ date('d-m-Y', strtotime($itinerary->ArrivalDateTime)) }} |
                                        {{ date('H:i', strtotime($itinerary->ArrivalDateTime)) }}  
                                </strong>
                            </h6>
                            <p>
                                  {{ $itinerary->ArrivalAirportName}}  
                            </p>
                        </td>
                        <td   style="border:1px solid #000;" >
                            <h6>Economy :
                                  {{ $itinerary->TravelClass}}  
                            </h6>
                            <h6>
                                Flight :
                                  {{ $bookings->trip_stop }}  
                            </h6>
                            <h6>
                                Duration:
                                  {{ $itinerary->Duration }}  
                                | Aviation
                            </h6>
                            <h6>
                                *Non Refundable Fare
                            </h6>
                        </td>
                    </tr>
                </tbody>
                  @endforeach 
            </table>
        </div>
        <h4>Passenger Details</h4>
        <div>
            <table  style="border:1px solid #000; border-collapse:collapse; width:100%;">
                <thead>
                    <tr>
                        <th  style="border:1px solid #000; border-collapse:collapse; width:100%;" scope="col">
                            Passenger Name
                        </th>

                        <th  style="border:1px solid #000; border-collapse:collapse; width:100%;" scope="col">
                            Airline PNR
                        </th>
                        
                        <th  style="border:1px solid #000; border-collapse:collapse; width:100%;" scope="col">
                            Seat
                        </th>
                        <th  style="border:1px solid #000; border-collapse:collapse; width:100%;" scope="col">
                            Food
                        </th>
                        <th  style="border:1px solid #000; border-collapse:collapse; width:100%;" scope="col">
                            Insurance
                        </th>
                    </tr>
                </thead>
                <tbody>
                      @php
                        $itinerarys = json_decode($bookings->itinerary??'itinerary');
                    @endphp  

                      @foreach (json_decode($bookings->passenger) as $passenger)
                    <tr style="text-align:center;">
                        <td  style="border:1px solid #000; border-collapse:collapse; width:100%;" scope="col">
                              {{ $passenger->Title . ' ' . $passenger->FirstName. ' ' . $passenger->LastName }}  
                            <small style="font-size: 12px;">
                                  ({{ $passenger->PaxTypeCode}})  
                            </small>

                        </td>

                        <td  style="border:1px solid #000; border-collapse:collapse; width:100%;" scope="col">
                            
                              {{ $bookings->airline_pnr }}  
                        </td>
                        <td  style="border:1px solid #000; border-collapse:collapse; width:100%;">
                              {{ $itinerary->AvailableSeats }}  

                        </td>
                        <td   style="border:1px solid #000; border-collapse:collapse;"  scope="col">
                            NA
                        </td>
                        <td  style="border:1px solid #000; border-collapse:collapse;"  scope="col">
                            NA
                        </td>
                    </tr>
                      {{-- @if ($bookings->trip_type == 2)
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
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $OutboundItinerays[0]->DepartAirportCode .'-' .$OutboundItinerays[0]->ArrivalAirportCode .'-' .$OutboundItinerays[1]->ArrivalAirportCode .'-' .$OutboundItinerays[2]->ArrivalAirportCode .'-' .$OutboundItinerays[3]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $OutboundItinerays[0]->AirLineName }} | {{ $bookings->airline_pnr }}
                                    </td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>6</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @elseif (isset($OutboundItinerays[2]) && !isset($OutboundItinerays[3]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $OutboundItinerays[0]->DepartAirportCode .'-' .$OutboundItinerays[0]->ArrivalAirportCode .'-' .$OutboundItinerays[1]->ArrivalAirportCode .'-' .$OutboundItinerays[2]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $OutboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>7</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @elseif (isset($OutboundItinerays[1]) && !isset($OutboundItinerays[2]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $OutboundItinerays[0]->DepartAirportCode .'-' .$OutboundItinerays[0]->ArrivalAirportCode .'-' .$OutboundItinerays[1]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $OutboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>8</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @elseif (isset($OutboundItinerays[0]) && !isset($OutboundItinerays[1]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $OutboundItinerays[0]->DepartAirportCode . '-' . $OutboundItinerays[0]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $OutboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>9</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @endif

                            @if (isset($InboundItinerays[3]) && !isset($InboundItinerays[4]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $InboundItinerays[0]->DepartAirportCode .'-' .$InboundItinerays[0]->ArrivalAirportCode .'-' .$InboundItinerays[1]->ArrivalAirportCode .'-' .$InboundItinerays[2]->ArrivalAirportCode .'-' .$InboundItinerays[3]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $InboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>10</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @elseif (isset($InboundItinerays[2]) && !isset($InboundItinerays[3]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $InboundItinerays[0]->DepartAirportCode .'-' .$InboundItinerays[0]->ArrivalAirportCode .'-' .$InboundItinerays[1]->ArrivalAirportCode .'-' .$InboundItinerays[2]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $InboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>11</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @elseif (isset($InboundItinerays[1]) && !isset($InboundItinerays[2]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $InboundItinerays[0]->DepartAirportCode .'-' .$InboundItinerays[0]->ArrivalAirportCode .'-' .$InboundItinerays[1]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $InboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>12</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @elseif (isset($InboundItinerays[0]) && !isset($InboundItinerays[1]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $InboundItinerays[0]->DepartAirportCode . '-' . $InboundItinerays[0]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $InboundItinerays[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>13</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @endif
                        @elseif($bookings->trip_type == 1)
                            @if (isset($itinerarys[3]) && !isset($itinerarys[4]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $itinerarys[0]->DepartAirportCode .'-' .$itinerarys[0]->ArrivalAirportCode .'-' .$itinerarys[1]->ArrivalAirportCode .'-' .$itinerarys[2]->ArrivalAirportCode .'-' .$itinerarys[3]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $itinerarys[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>14</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @elseif (isset($itinerarys[2]) && !isset($itinerarys[3]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $itinerarys[0]->DepartAirportCode .'-' .$itinerarys[0]->ArrivalAirportCode .'-' .$itinerarys[1]->ArrivalAirportCode .'-' .$itinerarys[2]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $itinerarys[0]->AirLineName }}</td>
                                    <td>{{ $bookings->airline_pnr }}</td>
                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>15</td>
                                    <td>NA</td>
                                    <td>NA</td>

                                </tr>
                            @elseif (isset($itinerarys[1]) && !isset($itinerarys[2]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $itinerarys[0]->DepartAirportCode .'-' .$itinerarys[0]->ArrivalAirportCode .'-' .$itinerarys[1]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $itinerarys[0]->AirLineName }} {{ $bookings->airline_pnr }}</td>

                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>16</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @elseif (isset($itinerarys[0]) && !isset($itinerarys[1]))
                                <tr>
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                        <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                        </small>
                                    </td>
                                    <td>{{ $itinerarys[0]->DepartAirportCode . '-' . $itinerarys[0]->ArrivalAirportCode }}
                                    </td>
                                    <td>{{ $itinerarys[0]->AirLineName }} - {{ $bookings->airline_pnr }} </td>

                                    <td>{{ $passenger->TicketNumber }}</td>
                                    <td>17</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                </tr>
                            @endif
                        @endif --}}  
                     @endforeach 

                </tbody>

            </table>
        </div>
        <div>
            <h6>Baggage Details:</h6>

            <p><span>(Hand Baggage)</span>15KG </p>
            <p><span>(Check-in Baggage)7KG</span>
                additional 10 kg for student booking.</p>

        </div>
        <div>
            
           <img src="{{ url('assets/images/offers/img-1540472874.jpg') }}" alt="">   
           <img src=" {{ url('assets/images/offers/img-1574918641.jpg') }}" alt="">  
                
        </div>
        <div>
            <div>
                <div>
                      {{-- <img src="{{ url('assets/images/offers/top-1620027189.jpg') }}" alt=""> --}}  
                </div>
            </div>
            <div>
                <div>
                      {{-- <img src="{{ url('assets/images/offers/top-1602673275.jpg') }}" alt=""> --}}  
                </div>
            </div>
        </div>

        <div>
            <div>
                <div>
                      {{-- <img src="{{ url('assets/images/offers/top-1620027189.jpg') }}" alt=""> --}}  
                </div>
            </div>
        </div>

        <div>
            <div>
                <div>
                    <table  style="border:1px solid #000; border-collapse:collapse; width:100%;" >
                        <thead   style="border:1px solid #000; border-collapse:collapse;">
                            <tr>
                                <th style="border:1px solid #000; border-collapse:collapse; text-align: left;"  colspan="2">Contact Details:</th>
                            </tr>
                        </thead>
                        <tbody   style="border:1px solid #000; border-collapse:collapse;">
                            <tr>
                                <td  style="border:1px solid #000; border-collapse:collapse;" >Customer Name:-</td>
                                <td  style="border:1px solid #000; border-collapse:collapse;" >
                                      {{ $passenger->Title??'' . ' ' . $passenger->FirstName??'' . ' ' . $passenger->LastName??'' }}  
                                </td>
                            </tr>
                            <tr>
                                <td  style="border:1px solid #000; border-collapse:collapse;" >Mobile:-</td>
                                <td  style="border:1px solid #000; border-collapse:collapse;" >
                                      {{ $bookings->mobile??'' }}  
                                </td>
                            </tr>
                            <tr >
                                <td  style="border:1px solid #000; border-collapse:collapse;" >Email:-</td>
                                <td  style="border:1px solid #000; border-collapse:collapse;" >
                                      {{ $bookings->email??'' }}  
                                </td >
                            </tr>
                            <tr>
                                <td  style="border:1px solid #000; border-collapse:collapse;" >Address:-</td>
                                <td  style="border:1px solid #000; border-collapse:collapse;" >NA</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <br>
                <div>
                    <table  style="border:1px solid #000; border-collapse:collapse; width:100%;" >
                        <tr>
                            <th  style="border:1px solid #000; border-collapse:collapse; text-align: left;"   colspan="2">Fare Details:</th>
                        </tr>
                        </thead>
                        <tbody>
                              <?php $fare = json_decode($bookings->fare??'fare'); ?>  
                              <!--{{dd($fare)}}-->
                            <tr>
                                <td style="border:1px solid #000; border-collapse:collapse;" >Total Base Fare</td>
                                <td style="border:1px solid #000; border-collapse:collapse;" >Rs:
                                      {{ $fare->PaxTotalFare??'' }}  
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #000; border-collapse:collapse;" >Total Other Tax</td>
                                <td style="border:1px solid #000; border-collapse:collapse;" >Rs:
                                      {{ $fare->PaxBaseFare - $fare[0]->PaxTotalFare??'' }}  

                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #000; border-collapse:collapse;" ><strong>Total Fare</strong></td>
                                <td style="border:1px solid #000; border-collapse:collapse;" >Rs:
                                      {{ $fare->PaxBaseFare??'' }}  
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <div>
                <h6  style="margin-left: 25px;
                font-size: 15px;position: relative;
    top: 30px;background: #cbc3c352;
    padding: 10px;">Note:-</h6>
                  <hr style="width: 97.7%;
                margin-left: 25px;">  
            </div>
            <ol style="line-height: 1.5;">
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
                    <a href="#" style="color:rgb(7, 95, 246);text-decoration: none;font-weight: 900;">Click here</a> to
                    refer to State wise guidelines for the travellers.
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
                    <a href="#" style="color:rgb(7, 95, 246);text-decoration: none;font-weight: 900;">Click here</a> for
                    more information.
                </li>

            </ol>
        </div>

        <div>
            <div>
                <h6 style="margin-left: 25px;
                font-size: 15px;position: relative;
    top: 30px;background: #cbc3c352;
    padding: 10px;">
                    Guidelines for Domestic travel by Ministry of Health and Family welfare
                </h6>
                  <hr style="width: 97.7%;
                margin-left: 25px;">  
            </div>
            <h6 style="margin-left: 25px;
            font-size: 15px;">Passengers must follow required health protocols, as detailed below, during
                their travel
            </h6>
            <ol style="line-height: 1.5;">
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
    </div>
</body>
