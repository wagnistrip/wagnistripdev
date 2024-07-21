<!DOCTYPE html>
<html lang="en">

<head>
    <title>Booking </title>
    <style>
        .bg-primary-mtt {
            background-color: #59B6E3;
            color: #fff;
        }

        .table-bordered td,
        .table-bordered th {
            border: 2px solid #93d1ef;
        }
    </style>
</head>

<body>
    <div class="card fadestyle" id="profilePage">
        <div class="card p-5" style="border: none;">
            <h4 class="m-0 text-right text-dark font-weight-bold">Toll Free No.- +91 7669988012</h4>

            <table>
                <tbody>
                    <tr>
                        <td>
                            {{-- <img src="{{ asset('assets/images/logo.png') }}" alt="logo" width="200"> --}}
                        </td>
                        <td class="text-right">
                            <p class="h3 text-success"> <i class="fa fa-check-circle"></i>Booking Confirmed
                            </p>
                            @foreach (json_decode($bookings->itinerary) as $itinerary)
                                <strong>Booking Date:- </strong>{{ date('d-m-Y', strtotime($bookings->created_at)) }}
                                |
                                @foreach (json_decode($bookings->passenger) as $passenger)
                                    <strong>Booking Time:- </strong>
                                    {{ date('H:i', strtotime($passenger->IssueDate)) }}
                                @endforeach
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-1">
                        <p>Hi,</p>
                        <p><i class="fa fa-check-circle text-success" aria-hidden="true" style="font-size:30px;"></i>
                            Your Flight Ticket for
                            {{ $itinerary->DepartCityName }} to {{ $itinerary->ArrivalCityName }} is
                            <strong>confirmed</strong> and your e-ticket has been mailed to you. Please carry a
                            printout
                            of your e-ticket along with a valid government issued photo ID to the airline
                            check-in
                            counter.
                        </p>
                    </div>
                </div>

                <table class="table table-striped">
                    <h4 class="font-weight-bold">Passenger Details</h4>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"> Airline Sector</th>
                            <th scope="col">Airline PNR</th>
                            <th scope="col">E-Ticket No.</th>
                            <th scope="col">Seat</th>
                            <th scope="col">Food</th>
                            <th scope="col">Insurance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <th scope="col">
                                {{ $itinerary->DepartCityName }} to
                                {{ $itinerary->ArrivalCityName }}
                            </th>
                            <th scope="col">
                                {{ $bookings->airline_pnr }}
                            </th>
                            <th scope="col">
                                {{ $passenger->TicketNumber }}
                            </th>
                            <th scope="col">
                                {{ $itinerary->AvailableSeats }}
                            </th>
                            <th scope="col">
                                NA
                            </th>
                            <th scope="col">
                                NA
                            </th>
                        </tr>

                    </tbody>
                </table>
                <table class="table border">
                    <h4 class="font-weight-bold">Contact Details:</h4>

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
                <table class="table border">
                    <h4 class="font-weight-bold">Fare Details:</h4>
                    <tbody>
                        <?php $fare = json_decode($bookings->fare); ?>
                        <tr>
                            <td>Total Base Fare</td>
                            {{-- previous varibale $fare->TotalBaseFare --}}
                            {{-- @php dd($fare); @endphp --}}
                            <td class="text-right">Rs: {{ $fare[0]->PaxBaseFare }}</td>
                        </tr>
                        <tr>
                            <td>Total Other Tax</td>
                            {{-- previous varibale $fare->TotalOtherTax --}}
                            <td class="text-right">Rs: {{ $fare[0]->PaxOtherTax }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Fare</strong></td>
                            {{-- previous varibale $fare->TotalFare --}}
                            <td class="text-right">Rs: {{ $fare[0]->PaxTotalFare }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <button onclick="display()">Click to Print</button>
    <script>
        function display() {
            window.print();
        }
    </script>
</body>

</html>
