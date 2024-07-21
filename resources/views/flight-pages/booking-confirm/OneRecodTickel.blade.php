<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wagnistrip Flight Ticket</title>
</head>
 @php
    use App\Http\Controllers\Airline\AirportiatacodesController;
    $itinerarys = json_decode($bookings->itinerary);
@endphp 
<body style="overflow-x: hidden;">
    <main>
        <section class="section" style=" padding: 90px 0px;">
            <div class="containing"
                style=" max-width: 650px;margin: 0px auto;border: 1px solid black;padding: 10px 20px;">
                <div class="logoAndBookingId">
                    <div class="grid grid-two-column"
                        style="display: grid;gap: 8%;grid-template-columns: repeat(2, 1fr);">
                        <div class="wagnistrip-logo">
                            <img style="width: 120px;" src="{{ asset('assets/images/logo.png') }}" alt="WagnisTrip">
                        </div>
                        <div class="bookingId">
                            <p style="font-size: 12px;">Booking ID: {{ $bookings->booking_id }}</p>
                            <!--<p style="font-size: 12px;">{{ $bookings->booking_id }}</p>-->
                        </div>
                    </div>
                </div>
                @foreach (json_decode($bookings->itinerary) as $itinerary)
                @endforeach
                @php
                    $fristcity = json_decode($bookings->itinerary)[0]->DepartCityName ?? json_decode($bookings->itinerary)->DepartCityName ?? '';
                    $lastcity = json_decode($bookings->itinerary)[count(json_decode($bookings->itinerary))-1]->ArrivalCityName ?? json_decode($bookings->itinerary)->ArrivalCityName ?? '';
                @endphp
                <div class="thanks" style="background-color: #18a160;padding: 5px 18px;border-top-left-radius: 10px;border-top-right-radius: 10px;margin-top: 10px;">
                    <div class="grid grid-two-column" style="display: grid;grid-template-columns: repeat(2, 1fr);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon"
                            style="width: 18.166016em;;height: 2.5em;padding: 10px;vertical-align: middle;fill: currentColor;overflow: hidden;margin-top: 10px;"
                            viewBox="0 0 1194 1024" version="1.1">
                            <path
                                d="M1186.572355 129.16578c-52.8882-85.303548-242.262077-5.971248-436.754167 116.865861L537.412354 135.137028l5.971248-5.971248c11.089461-5.971248 17.06071-17.913745 5.971248-29.003207S531.441105 85.66097 519.498608 94.191325l-29.856241 17.060709L277.236532 6.32867a40.945703 40.945703 0 0 0-58.859449 17.06071c-11.942497 17.913745-5.971248 35.82749 17.913745 52.8882l283.20778 327.565625c-117.718896 85.303548-218.377083 170.607096-271.265283 210.699764h-5.971248L52.8882 561.654769a41.798739 41.798739 0 0 0-52.8882 29.856242 975.872591 975.872591 0 0 1 117.718896 139.897819 801.853353 801.853353 0 0 1 59.712484 163.782812 42.651774 42.651774 0 0 0 52.8882-29.003206L255.910645 743.351326a22.178923 22.178923 0 0 1 17.913745-5.971248s165.488883-69.94891 359.980973-170.607096l136.485677 415.428279c5.118213 29.003206 17.06071 40.945703 40.945703 40.945704a40.092668 40.092668 0 0 0 40.945703-40.945704l11.942497-210.699764 23.884994-17.060709c11.942497-5.971248 17.913745-17.913745 5.971248-29.856242a17.913745 17.913745 0 0 0-29.856242-5.971248l-2.559106-267.853142c195.345125-128.808358 371.92347-245.674219 325.006518-321.594376z"
                                fill="#FCA800" />
                        </svg>
                        <div class="flight-details" style="position: relative;right: 120px;">
                            <p style="font-size: 14px;color: white;">Thank you for booking with us …</p>
                            <p style="font-size: 18px;color: white;">{{ AirportiatacodesController::getCity($fristcity) }} - {{ AirportiatacodesController::getCity($lastcity) }} flight is confirmed</p>
                        </div>
                    </div>
                </div>
                <p style="text-align: center;color: #647a97;font-weight: 900;">Web check-in is mandatory & can be done in 2-steps with us.</p>
                <div class="check-inAndBooking">
                    <div class="grid grid-two-column"
                        style="justify-content: space-around;align-content: stretch;justify-items: end;display: flex;flex-direction: row;flex-wrap: wrap;gap: 10px;">
                        <a href="#" style="background-color: rgb(255, 109, 56);text-decoration: none;color: #fff;padding: 12px 30px;width:200px;
                        border-radius: 8px;white-space: nowrap;text-align: center;">Web Check-in</a>
                        <a href="#" style="background-color: rgb(255, 109, 56);text-decoration: none;color: #fff;padding: 12px 30px;width:200px;
                        border-radius: 8px;white-space: nowrap;text-align: center;">Manage Booking In App</a>
                    </div>
                </div>
                <div  style="background: #1951b5;line-height: 15px;width: 100%;border-radius: 12px;margin-top: 25px;">
                    <div style="display: flex;flex-direction: row;justify-content: space-around;">
                        <div>
                            <p style="color: #fff;text-align: center;">WED, 09 DEC '20</p>
                        </div>
                        <div  style="width:230px">
                            <p style="color: #fff;text-align: center;">{{ AirportiatacodesController::getCity($fristcity) }} TO {{ AirportiatacodesController::getCity($lastcity) }}</p>
                        </div>
                        <div>
                            <p style="color: #fff;text-align: center;">2h 30m</p>
                        </div>
                    </div>
                </div>
                <div>
                    
                    @php
                            $itinerarys = json_decode($bookings->itinerary);
                    @endphp 
                    @foreach (json_decode($bookings->itinerary) as $itinerary)
                    
                    <div style=" display: grid;grid-template-columns: repeat(4, 1fr);">
                        <div style="margin-top: 20px;">
                            <img style="width:30px" src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode) }}.png" alt="{{ $itinerary->AirLineCode }}">
                            <p style="font-size: 12px;">{{ $itinerary->AirLineName }}</p>
                            <p style="font-size: 12px;position: relative;bottom: 10px;">{{ $itinerary->AirLineCode . '-' . $itinerary->FlightNumber }}</p>
                        </div>
                        <div  style="margin-right: 45px;">
                            <h2 style="font-weight: bold;color: #eb6125;text-align: center;">{{$itinerary->DepartCityName}}</h2>
                            <p style="font-size: 11px;position: relative;bottom: 18px;text-align: center;">{{  AirportiatacodesController::getCity($itinerary->DepartCityName) }}</p>
                            <p style="color: #141823;background: #fef8e5;font-weight: bold;text-align: center;position: relative;
                        bottom: 25px;">{{  getDate_fn($itinerary->DepartDate) ?? date('d-m-Y', strtotime($itinerary->DepartDate)) }} |{{ date('H:i', strtotime($itinerary->DepartDateTime)) }}</p>
                            <p style="text-align: center;font-size: 12px;position: relative;bottom: 35px;">{{ $itinerary->DepartAirportName }}</p>
                        </div>
                        <div style="margin-top: 35px;position: relative;left: 30px;">
                            <img style="width:16px;margin-left: 15px;" src="{{asset('assets/Images/watch.png')}}" alt="time">
                            <p style="color: #9b9b9b;position: relative;bottom: 12px;"> {{ $itinerary->Duration }}</p>
                            <hr style="color: #9b9b9b;width: 50px;margin-right: 110px;position: relative;bottom: 20px;">
                            <p style="color: #9b9b9b;position: relative;bottom: 30px;">Economy {{ $itinerary->TravelClass }}</p>
                        </div>
                        <div>
                            <h2 style="font-weight: bold;color: #eb6125;text-align: center;">{{ $itinerary->ArrivalCityName }}</h2>
                            <p style="font-size: 11px;position: relative;bottom: 18px;text-align: center;">{{ AirportiatacodesController::getCity($itinerary->ArrivalCityName) }}</p>
                            <p style="color: #141823;background: #fef8e5;font-weight: bold;text-align: center;position: relative;
                        bottom: 25px;">{{ getDate_fn($itinerary->ArrivalDate)??date('d-m-Y', strtotime($itinerary->ArrivalDate)) }} | {{ date('H:i', strtotime($itinerary->ArrivalDateTime)) }}</p>
                            <p style="text-align: center;font-size: 12px;position: relative;bottom: 35px;">{{ $itinerary->ArrivalAirportName }}</p>
                        </div>
                    </div>
                    
                    @endforeach
                    
                </div>
                <divstyle="padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;">
                    <div style=" display: grid;grid-template-columns: repeat(4, 1fr);">
                        <p>PASSENGER NAME</p>
                        <p style="text-align: center;">PNR</p>
                        <p style="text-align: center;">E-TICKET NO.</p>
                        <p style="text-align: center;">SEAT</p>
                    </div>
                </div>
                <tr>
                    <td style="padding:20px 10px">
                        <table align="center"
                            style="border-collapse:collapse;border-spacing:0;width:100%;border:1px solid #f4f4f4;margin-top:20px;">
                            <tbody>
                                
                                 @php
                                    $itinerarys = json_decode($bookings->itinerary);
                                    $numberOfTra = 0;
                                @endphp

                                @foreach (json_decode($bookings->passenger) as $passenger)
                                @php
                                    $numberOfTra++;
                                @endphp
                        
                                <tr>
                                    <td style="padding: 10px 5px;vertical-align: top;font-family: arial;text-align: center;font-size: 12px;
                                        border-right: solid 1px #f4f4f4;color: #4a4a4a;width: 25%;">
                                        1. {{ $passenger->Title . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }} , ({{ $passenger->PaxTypeCode }})</td>
                                    <td style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                                         {{ $bookings->airline_pnr }}</td>
                                    <td style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                                         {{ $bookings->airline_pnr }}</td>
                                    <td style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;color:#4a4a4a">
                                        - </td>
                                </tr>
                                
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                
                <div 
                    style="padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;">
                    <p>IMPORTANT INFORMATION</p>
                </div>
                <ul>
                    <li style="font-size: 12px;padding: 0px 5px;"><strong>Web Check-in :</strong> Web Check-in is now a
                        mandatory step for your air travel. For a hassle-free Web Check-in on WagnisTrip, please <a
                            href="">click Here</a></li>
                    <li style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>Check-in Time :</strong>
                        Passenger to report 2 hours before departure. Check-in procedure and baggage drop will close 1
                        hour before departure.</li>
                    <li style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>Valid ID proof needed
                            :</strong> Please carry a valid Passport and Visa (mandatory for international travel).
                        Passport should have at least 6 months of validity at the time of travel</li>
                    <li style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>DGCA passenger charter
                            :</strong> Please refer to passenger charter by <a href="">click Here</a></li>
                    <li style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>Gosafe-certified Airport Cabs
                            :</strong> We enjoy smooth airport transfers in sanitized cabs with trained drivers. No
                        waiting and no surge pricing! Book : <a href="">here</a></li>
                    <li style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>Beware of fraudsters
                            :</strong> Please do not share your personal banking and security details like passwords,
                        CVV, etc. with any third person or party claiming to represent WagnisTrip. For any query, please
                        reach out to WagnisTrip on our official customer care number.</li>
                </ul>
                <div class="baggage-info"
                    style="padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;">
                    <p>BAGGAGE INFORMATION</p>
                </div>
                <tr>
                    <td style="padding:20px 10px">
                        <table align="center"
                            style="border-collapse:collapse;border-spacing:0;width:100%;border:1px solid #f4f4f4;margin-top:20px;">
                            <tbody>
                                <tr>
                                    <td
                                        style="padding:6px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:25%;text-align:center;font-size:12px;background:#eef4fd;font-weight:bold;color:#153d6c">
                                        Type</td>
                                    <td
                                        style="padding:6px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:25%;font-size:12px;text-align:centeR;background:#eef4fd;font-weight:bold;color:#153d6c">
                                        Sector</td>
                                    <td
                                        style="padding:6px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:25%;text-align:center;font-size:12px;background:#eef4fd;font-weight:bold;color:#153d6c">
                                        Cabin</td>
                                    <td
                                        style="padding:6px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:25%;font-size:12px;text-align:center;background:#eef4fd;font-weight:bold;color:#153d6c">
                                        Check-in</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                                        Adult</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                                        {{$fristcity}}-{{$lastcity}}</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                                        7 Kgs</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;color:#4a4a4a">
                                        15 Kgs</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <div class="payment-info"
                    style="padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;">
                    <p>PAYMENT INFORMATION</p>
                </div>
                <ul>
                    <li>You have Paid INR 4,161 | For Fare Breakup <a href="">Get Invoice</a></li>
                </ul>
                {{-- <div class="cancellation"
                    style="padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 50px;">
                    <p>CANCELLATION AND DATE CHANGE CHARGES</p>
                </div>
                <p style="margin-left: 15px;">All charges below are per Pax and per Segment in INR</p>
                <div class="cancellation-info">
                    <div class="grid grid-two-column" style=" display: grid;grid-template-columns: repeat(2, 1fr);">
                        <table align="left"
                            style="border-collapse:collapse;border-spacing:0;width:90%;border:1px solid #f4f4f4;margin-bottom:10px;margin-left: 5px;">
                            <tbody>
                                <tr style="background:#eef4fd;font-weight:bold">
                                    <td colspan="2"
                                        style="padding:5px 10px;vertical-align:top;font-family:arial;text-align:left;border-bottom:1px solid #f4f4f4;font-size:11px;line-height:12px">
                                        {{$fristcity}}-{{$lastcity}}</td>
                                    <td colspan="2"
                                        style="padding:5px 5px 5px 0px;vertical-align:top;font-family:arial;text-align:right;border-bottom:1px solid #f4f4f4;font-size:11px">
                                        Cancellation Charges</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:20%;border-right:1px solid #f4f4f4;text-align:center;font-size:11px">
                                        Type</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                                        Condition</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                                        Airline</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:19%;font-size:11px">
                                        WagnisTrip</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;width:20%;border-right:1px solid #f4f4f4;text-align:center;font-size:11px">
                                        Adult</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                                        3 days - 365 days</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                                        3000</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:19%;text-align:center;font-size:11px">
                                        300</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 5px;width:20%;border-right:1px solid #f4f4f4"></td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                                        2 hrs - 3 days</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                                        3500</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:19%;text-align:center;font-size:11px">
                                        300</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 5px;width:20%;border-right:1px solid #f4f4f4"></td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                                        0 hrs - 2 hrs</td>
                                    <td colspan="2"
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                                        Non-Refundable</td>
                                </tr>
                                <tr></tr>
                            </tbody>
                        </table>
                        <table align="right"
                            style="border-collapse:collapse;border-spacing:0;width:90%;border:1px solid #f4f4f4;margin-bottom:0px;margin-left: 30px;">
                            <tbody>
                                <tr style="background:#eef4fd;font-weight:bold">
                                    <td colspan="2"
                                        style="padding:5px 10px;vertical-align:top;font-family:arial;text-align:left;border-bottom:1px solid #f4f4f4;font-size:11px;line-height:12px">
                                        {{$fristcity}}-{{$lastcity}}</td>
                                    <td colspan="2"
                                        style="padding:5px 5px 5px 0px;vertical-align:top;font-family:arial;text-align:right;border-bottom:1px solid #f4f4f4;font-size:11px">
                                        Date Change Charges</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:20%;border-right:1px solid #f4f4f4;text-align:center;font-size:11px">
                                        Type</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                                        Condition</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                                        Airline</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:19%;font-size:11px">
                                        WagnisTrip</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;width:20%;border-right:1px solid #f4f4f4;text-align:center;font-size:11px">
                                        Adult</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                                        3 days - 365 days</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                                        2500</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:19%;text-align:center;font-size:11px">
                                        300</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 5px;width:20%;border-right:1px solid #f4f4f4"></td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                                        2 hrs - 3 days</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                                        3000</td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:19%;text-align:center;font-size:11px">
                                        300</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 5px;width:20%;border-right:1px solid #f4f4f4"></td>
                                    <td
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                                        0 hrs - 2 hrs</td>
                                    <td colspan="2"
                                        style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                                        Non-Changeable</td>
                                </tr>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                <div class="customer-support"
                    style="padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;">
                    <p>24x7 CUSTOMER SUPPORT</p>
                </div>
                <div class="support" style="margin-top: 20px;">
                    <div class="grid grid-two-column" style=" display: grid;grid-template-columns: repeat(2, 1fr);">
                        <table align="left"
                            style="border-collapse:collapse;border-spacing:0;width:90%;float:left;border:1px solid #f4f4f4;padding:5px">
                            <tbody>
                                <tr>
                                    <td style="padding:5px 0px 5px 10px;vertical-align:top;font-family:arial;background:#eef4fd;font-weight:bold;line-height:12px;font-size:12px;color:#1951b5">
                                        WagnisTrip Support </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:5px 0px 10px 10px;vertical-align:top;font-family:arial;height:95px;box-sizing:border-box">
                                        <table style="border-collapse:collapse;border-spacing:0;width:100%">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="padding:0px;vertical-align:top;font-family:arial;width:45px;font-size:12px;font-weight:bold;color:#4a4a4a">
                                                        Tel </td>
                                                    <td
                                                        style="padding:0px;vertical-align:top;font-family:arial;width:220px">
                                                        <p style="margin:0px 0px 5px;line-height:15px;font-size:12px;color:#4a4a4a">
                                                           +91 8069145571</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="right"
                            style="margin-left: 33px;border-collapse:collapse;border-spacing:0;width:90%;float:right;border:1px solid #f4f4f4;padding:5px;margin-bottom:0px">
                            <tbody>
                                <tr>
                                    <td
                                        style="padding:5px 0px 5px 10px;vertical-align:top;font-family:arial;background:#eef4fd;font-weight:bold;line-height:12px;font-size:12px;color:#1951b5">
                                        Airline Support</td>
                                </tr>
                                <tr>
                                    <td style="padding:5px 0px 10px 10px;vertical-align:top;font-family:arial;height:95px;box-sizing:border-box">
                                        <table style="border-collapse:collapse;border-spacing:0;width:100%">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="padding:0px;vertical-align:top;font-family:arial;width:160px;font-size:12px;font-weight:bold;color:#4a4a4a">
                                                        Indigo Airlines</td>
                                                    <td
                                                        style="padding-left:10px;vertical-align:top;font-family:arial;width:100px">
                                                        <p
                                                            style="margin:0px 0px 5px;line-height:15px;font-size:12px;color:#4a4a4a">
                                                            9910383838</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>