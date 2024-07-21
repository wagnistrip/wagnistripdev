
    <body style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class="container p-0">
            <div class="card-body">
            </div>
            <div id="main-content">
            <br>
            <h4 class="m-0 text-right text-dark font-weight-bold">Toll Free No.- +91 7669988012</h4>
            <div class="d-flex bd-highlight mt-3 mb-3" style="border-bottom:1px solid #0065a5;">
                <div class="p-2 bd-highlight">
                    <img class="ticketlogo" src="{{ url('assets/images/logo.png') }}" alt="">
                </div>

                <div class="ml-auto p-2 bd-highlight">
                    <p class="h3 text-success"><i class="fa fa-check-circle"></i>Booking Confirmed
                    </p>
                    @php
                        $itinerarys = json_decode($bookings->itinerary);
                     @endphp 
                        
                        <small>
                            <strong>Booking Date:-
                            </strong> {{ date('d-m-Y', strtotime($bookings->created_at)) }} | 
                            <strong>Booking Time:- </strong> {{ date('H:i', strtotime($bookings->created_at))??'' }}
                        </small>
                </div>
            </div>
            <div class="card-body">
                @php
                    use App\Http\Controllers\Airline\AirportiatacodesController;
                @endphp
                <div class="row">
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-6">
                        <div class="card-body p-2 rounded-lg" style="background-color:#e74c3c;">
                            <h4 class="font-weight-bold m-0 text-white">FLAT 30% OFF On Domestic Flights</h4>
                            <h6 class="m-0 text-white">Use your flight booking ID as e-coupon code before payment <a href="#" class="font-weight-bold">Book Now</a></h6>
                        </div>
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
                                        style="font-size:30px;"></i> Your Flight Ticket for
                                    {{ AirportiatacodesController::getCity($fristcity) }} to {{ AirportiatacodesController::getCity($lastcity) }} is
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
            <h4 style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Itinerary and Reservation Details</h4>

            <div class="card p-2 mb-3 d-flex-row">
                <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
                    <thead class="thead-color text-center">
                        <tr>
                            <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Flight</th>
                            <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Departure</th>
                            <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Arrivel</th>
                            <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Class & Aviation</th>
                        </tr>
                    </thead>
                    @php
                            $itinerarys = json_decode($bookings->itinerary);
                    @endphp 
                    @foreach (json_decode($bookings->itinerarys) as $itinerary)
                        <tbody>
                            <tr>
                                <th class="border-right text-center" scope="row">
                                    <img src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode??'') }}.png" alt="{{ $itinerary->AirLineCode??'' }}">
                                    <h6 class="small m-0">{{ $itinerary->AirLineName }}</h6>
                                    <p class="small font-weight-bold m-0">
                                        {{ $itinerary->AirLineCode??'' . '-' . $itinerary->FlightNumber??'' }}</p>
                                </th>
                                <td class="border-right text-center">
                                    <h5 class="m-0">{{ $itinerary->DepartCityName }} </h5>
                                    <h6 class="small m-0">Terminal {{ $itinerary->DepartTerminal??'' }}</h6>
                                    <h6 class="small m-0">{{  getDate_fn($itinerary->DepartDate)??'' ?? date('d-m-Y', strtotime($itinerary->DepartDate))??'' }}
                                        |
                                        <strong>{{ date('H:i', strtotime($itinerary->DepartDateTime))??'' }}</strong>
                                    </h6>
                                    <p class="small m-0">{{ $itinerary->DepartAirportName??'' }}</p>
                                </td>
                                <td class="border-right text-center">
                                    <h5 class="m-0">{{ AirportiatacodesController::getCity($itinerary->ArrivalCityName) }}</h5>
                                    <h6 class="small m-0">Terminal {{ $itinerary->ArrivalTerminal }}</h6>
                                    <h6 class="small m-0">
                                        <strong>{{ getDate_fn($itinerary->ArrivalDate)??date('d-m-Y', strtotime($itinerary->ArrivalDate)) }} |
                                            {{ date('H:i', strtotime($itinerary->ArrivalDateTime)) }}</strong>
                                    </h6>
                                    <p class="small m-0">{{ $itinerary->ArrivalAirportName }}</p>
                                </td>
                                <td class=" text-center">
                                    <h6 class="small m-0">Economy : {{ $itinerary->TravelClass }}</h6>
                                    <h6 class="small m-0">Flight : {{ $bookings->trip_stop }} </h6>
                                    <h6 class="small m-0">Duration: {{ $itinerary->Duration }} | Aviation</h6>
                                    <h6 class="small m-0">*Non Refundable</h6>
                                </td>

                            </tr>
                    @endforeach
                    @php
                            $itinerarys2 = json_decode($bookings2->itinerary);
                    @endphp 
                    @foreach (json_decode($bookings2->itinerary) as $itinerary)
                            <tr>
                                <th class="border-right text-center" scope="row">
                                        <img src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode??'') }}.png" alt="{{ $itinerary->AirLineCode??'' }}">
                                    <h6 class="small m-0">{{ $itinerary->AirLineName }}</h6>
                                    <p class="small font-weight-bold m-0">
                                        {{ $itinerary->AirLineCode??'' . '-' . $itinerary->FlightNumber??'' }}</p>
                                </th>
                                <td class="border-right text-center">
                                    <h5 class="m-0">{{ $itinerary->DepartCityName }} </h5>
                                    <h6 class="small m-0">Terminal {{ $itinerary->DepartTerminal??'' }}</h6>
                                    <h6 class="small m-0">{{  getDate_fn($itinerary->DepartDate)??'' ?? date('d-m-Y', strtotime($itinerary->DepartDate))??'' }}
                                        |
                                        <strong>{{ date('H:i', strtotime($itinerary->DepartDateTime))??'' }}</strong>
                                    </h6>
                                    <p class="small m-0">{{ $itinerary->DepartAirportName??'' }}</p>
                                </td>
                                <td class="border-right text-center">
                                    <h5 class="m-0">{{ AirportiatacodesController::getCity($itinerary->ArrivalCityName) }}</h5>
                                    <h6 class="small m-0">Terminal {{ $itinerary->ArrivalTerminal }}</h6>
                                    <h6 class="small m-0">
                                        <strong>{{ getDate_fn($itinerary->ArrivalDate)??date('d-m-Y', strtotime($itinerary->ArrivalDate)) }} |
                                            {{ date('H:i', strtotime($itinerary->ArrivalDateTime)) }}</strong>
                                    </h6>
                                    <p class="small m-0">{{ $itinerary->ArrivalAirportName }}</p>
                                </td>
                                <td class=" text-center">
                                    <h6 class="small m-0">Economy : {{ $itinerary->TravelClass }}</h6>
                                    <h6 class="small m-0">Flight : {{ $bookings2->trip_stop }} </h6>
                                    <h6 class="small m-0">Duration: {{ $itinerary->Duration }} | Aviation</h6>
                                    <h6 class="small m-0">*Non Refundable</h6>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
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
                            $itinerarys2 = json_decode($bookings2->itinerary);
                        @endphp

                        @foreach (json_decode($bookings->passenger) as $passenger)
                            <tr style="text-align:center;">
                                <td scope="col">
                                    {{ $passenger->Title??'' . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                    <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                    </small>

                                </td>

                                <td scope="col">
                                    {{ $bookings->airline_pnr }}
                                </td>
                                {{-- <td scope="col">
                                    {{ $passenger->TicketNumber }}
                                </td> --}}
                                <td scope="col">
                                {{--{{ $itinerary->AvailableSeats }} --}}
                                    NA
                                </td>
                                <td scope="col">
                                    NA
                                </td>
                                <td scope="col">
                                    NA
                                </td>
                            </tr>
                            
                        @endforeach
                        @foreach (json_decode($bookings2->passenger) as $passenger)
                            <tr style="text-align:center;">
                                <td scope="col">
                                    {{ $passenger->Title??'' . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                    <small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})
                                    </small>

                                </td>

                                <td scope="col">
                                    {{ $bookings2->airline_pnr }}
                                </td>
                                {{-- <td scope="col">
                                    {{ $passenger->TicketNumber }}
                                </td> --}}
                                <td scope="col">
                                {{--{{ $itinerary->AvailableSeats }} --}}
                                    NA
                                </td>
                                <td scope="col">
                                    NA
                                </td>
                                <td scope="col">
                                    NA
                                </td>
                            </tr>
                            
                        @endforeach

                    </tbody>

                </table>
            </div>
            <div class="card border-dotted mb-3 p-3">
                <h6 class="m-0 font-weight-bold">Baggage Details:</h6>

                <p class="m-0 small"><span>(Hand Baggage)</span>15KG</p>
                <p class="m-0 small"><span class="font-weight-bold">(Check-in Baggage)7KG</span>
                    additional 10 kg for student booking.</p>

            </div>
            <div class="row">
                <div class="col-sm-6 p-3">
                    <div class="card">
                        <!--<img src="{{ url('assets/images/offers/img-1540472874.jpg') }}" alt="">-->
                    </div>
                </div>
                <div class="col-sm-6 p-3">
                    <div class="card">
                        <!--<img src=" {{ url('assets/images/offers/img-1574918641.jpg') }}" alt="">-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 p-3">
                    <div class="card">
                        <img src="{{ url('assets/images/offers/top-1620027189.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-sm-6 p-3">
                    <div class="card">
                        <img src="{{ url('assets/images/offers/top-1602673275.jpg') }}" alt="">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 p-3">
                    <div class="card">
                        <img src="{{ url('assets/images/offers/top-1620027189.jpg') }}" alt="">
                    </div>
                </div>
            </div>

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
                                    <td>{{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
                                    </td>
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
                            <?php $fare = json_decode($bookings->fare); ?>
                            @foreach (json_decode($bookings->fare) as $fare)
                            <tbody>
                                <tr>
                                    <td>Total Base Fare</td>
                                    <td class="text-right">Rs: {{ $fare->PaxBaseFare }}</td>
                                </tr>
                                <tr>
                                    <td>Total Other Tax</td>
                                    <td class="text-right">Rs: {{ $fare->PaxTotalFare - $fare->PaxBaseFare }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Fare</strong></td>
                                    <td class="text-right">Rs: {{ $fare->PaxTotalFare }}</td>
                                </tr>
                            </tbody>
                            @endforeach
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
                <h6 class="p-3">Passengers must follow required health protocols, as detailed below, during
                    their travel
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
        </div>
            <!-- Add on End -->
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

