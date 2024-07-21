<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Content</title>
</head>

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
</style>

@php
    $bookings = $both['FristpnrRetrieve'];
    $bookings2 = $both['book'];
    $itinerary = json_decode($bookings->itinerary);
    $itinerary2 = json_decode($bookings2->itinerary);
    $baggage = json_decode($bookings->baggage);
    $baggage2 = json_decode($bookings2->baggage);
@endphp

<body style="overflow-x: hidden;">
    <main>
        <table class="vikas" style="max-width: 650px;">
            <tr>
                <td>
                    <img style="width: 120px;" src="{{ asset('assets/images/logo.png') }}" alt="WagnisTrip">
                </td>
                <td colspan="3" style="text-align: center">
                    <p style="font-size: 12px;">Booking ID: {{ $bookings->gds_pnr }} {{ $bookings2->gds_pnr }}</p>
                </td>
            </tr>
            <tr
                style="background-color: #18a160;padding: 5px 18px;border-top-left-radius: 10px;border-top-right-radius: 10px;margin-top: 10px;">
                <td colspan="4" style="border: none;">
                    <!--<svg xmlns="http://www.w3.org/2000/svg" class="svg-icon"-->
                    <!--    style="height: 2.5em;padding: 10px;vertical-align: middle;fill: currentColor;overflow: hidden;margin-top: 10px;"-->
                    <!--    viewBox="0 0 1194 1024" version="1.1">-->
                    <!--    <path-->
                    <!--        d="M1186.572355 129.16578c-52.8882-85.303548-242.262077-5.971248-436.754167 116.865861L537.412354 135.137028l5.971248-5.971248c11.089461-5.971248 17.06071-17.913745 5.971248-29.003207S531.441105 85.66097 519.498608 94.191325l-29.856241 17.060709L277.236532 6.32867a40.945703 40.945703 0 0 0-58.859449 17.06071c-11.942497 17.913745-5.971248 35.82749 17.913745 52.8882l283.20778 327.565625c-117.718896 85.303548-218.377083 170.607096-271.265283 210.699764h-5.971248L52.8882 561.654769a41.798739 41.798739 0 0 0-52.8882 29.856242 975.872591 975.872591 0 0 1 117.718896 139.897819 801.853353 801.853353 0 0 1 59.712484 163.782812 42.651774 42.651774 0 0 0 52.8882-29.003206L255.910645 743.351326a22.178923 22.178923 0 0 1 17.913745-5.971248s165.488883-69.94891 359.980973-170.607096l136.485677 415.428279c5.118213 29.003206 17.06071 40.945703 40.945703 40.945704a40.092668 40.092668 0 0 0 40.945703-40.945704l11.942497-210.699764 23.884994-17.060709c11.942497-5.971248 17.913745-17.913745 5.971248-29.856242a17.913745 17.913745 0 0 0-29.856242-5.971248l-2.559106-267.853142c195.345125-128.808358 371.92347-245.674219 325.006518-321.594376z"-->
                    <!--        fill="#FCA800" />-->
                    <!--</svg>-->
                    <!--<img src=" https://img.icons8.com/clouds/100/000000/handshake.png" width="125" height="120"-->
                        <!--style="border: 0px;" />-->
                    <!--</td>-->
                    <!--<td colspan="2" style="border: none;">-->
                    <p style="color:#fff; text-align: center; margin-right: 10px;">
                        Thank you for booking with us
                    </p>
                    <p style="color:#fff; text-align: center;margin-right: 10px;">
                        {{$itinerary[0]->DepartCityName}} - {{$itinerary[0]->ArrivalCityName}} flight is confirmed
                    </p>
                    <hr>
                    <p style="color:#fff; text-align: center;margin-right: 10px;">
                        {{$itinerary2[0]->DepartCityName}} - {{$itinerary2[0]->ArrivalCityName}} flight is confirmed
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3" text-align="center" style="color: #647a97;font-weight: 900;">
                    Web check-in is
                    mandatory & can be done
                    in 2-steps with us.
                </td>
                <td
                    style="justify-content: space-around;align-content: stretch;justify-items: end;display: flex;flex-direction: row;flex-wrap: wrap;gap: 10px;">
                    <a href="https://flights.wagnistrip.com/web-check-in"
                        style="background-color: rgb(255, 109, 56);text-decoration: none;color: #fff;padding: 12px 30px;width:200px;
                        border-radius: 8px;white-space: nowrap;text-align: center;">Web
                        Check-in</a>
                    <!-- <a href="#" style="background-color: rgb(255, 109, 56);text-decoration: none;color: #fff;padding: 12px 30px;width:200px;
                        border-radius: 8px;white-space: nowrap;text-align: center;">Manage Booking In App</a> -->
                </td>
            </tr>

            <tr style="background: #1951b5;line-height: 15px;width: 100%;border-radius: 12px;margin-top: 25px;">
                <td colspan="2" align="center">
                    WED, 09 DEC '20
                </td>
                <td colspan="2" style="text-align: center; padding-top: 10px;">
                    {{$itinerary[0]->DepartCityName}} TO {{$itinerary[0]->ArrivalCityName}}

                    <p>
                        2h 30m
                    </p>
                </td>
            </tr>
            <tr style="background: #1951b5;line-height: 15px;width: 100%;border-radius: 12px;margin-top: 25px;">
                <td colspan="2" align="center">
                    WED, 09 DEC '20
                </td>
                <td colspan="2" style="text-align: center; padding-top: 10px;">
                    {{$itinerary2[0]->DepartCityName}} TO {{$itinerary2[0]->ArrivalCityName}}

                    <p>
                        2h 30m
                    </p>
                </td>
            </tr>

            @foreach ($itinerary as $itinerary)
                <tr>
                    <td style="text-align: center;">
                        <img style="width:30px"
                            src="{{ asset('assets/images/flight/'. $itinerary->AirLineCode) }}.png"
                            alt="{{ $itinerary->AirLineCode }}">
                        <p>
                            {{$itinerary->AirLineName}}
                            {{$itinerary->AirLineCode}}
                        </p>
                    </td>
                    <td class="gorakhpur-details" style="text-align: center;">
                        <h2 style="font-weight: bold;color: #eb6125; width: 200px;">
                            {{$itinerary->DepartAirportCode}}
                        </h2>
                        <p style="font-size: 11px;position: relative;bottom: 18px;text-align: center;">
                            {{$itinerary->DepartCityName}}</p>
                        <p
                            style="color: #141823;background: #fef8e5;font-weight: bold;text-align: center;position: relative;
                    bottom: 25px;">
                            {{ getDateFormat_db($itinerary->DepartDateTime)  }} | <strong>{{  getTimeFormat_db($itinerary->DepartDateTime) }}</strong></p>
                        <p style="text-align: center;font-size: 12px;position: relative;bottom: 35px;">Airport :
                            {{$itinerary->DepartAirportName}}</p>
                    </td>
                    <td class="timing" style="margin-top: 35px;position: relative;left: 30px;">
                        {{-- <img style="width:16px;margin-left: 15px;" src="{{asset('assets/images/images/watch.png')}}"
                            alt="time">

                        <p class="timingpara" style="color: #000;position: relative;left:8px; bottom: 12px;">
                            {{ getTime_fn($itinerary->Duration) }}</p>

                        <hr
                            class="timinghr"style="color: #ddd;width: 50px;margin-right: 110px;position: relative;bottom: 20px;"> --}}

                        <p style="color: #000;position: relative;bottom: 30px;">Economy: {{$itinerary->TravelClass}}
                        </p>
                    </td>
                    <td class="hyderabad-details">
                        <h2 style="font-weight: bold;color: #eb6125;text-align: center;">
                            {{$itinerary->ArrivalAirportCode}}</h2>
                        <p style="font-size: 11px;position: relative;bottom: 18px;text-align: center;">
                            {{$itinerary->ArrivalCityName}}</p>
                        <p
                            style="color: #141823;background: #fef8e5;font-weight: bold;text-align: center;position: relative;
                    bottom: 25px;">
                            {{ getDateFormat_db($itinerary->ArrivalDateTime)  }} | 
                            {{  getTimeFormat_db($itinerary->ArrivalDateTime) }}</p>
                        <p style="text-align: center;font-size: 12px;position: relative;bottom: 35px;">Airport :
                            {{$itinerary->ArrivalAirportName}}</p>
                    </td>
                </tr>
            @endforeach

            @foreach ($itinerary2 as $itinerary2)
                <tr>
                    <td style="text-align: center;">
                        <img style="width:30px"
                            src="{{ asset('assets/images/flight/'. $itinerary2->AirLineCode) }}.png"
                            alt="{{ $itinerary2->AirLineCode }}">
                        <p>
                            {{$itinerary2->AirLineName}}
                            {{$itinerary2->AirLineCode}}
                        </p>
                    </td>
                    <td class="gorakhpur-details" style="text-align: center;">
                        <h2 style="font-weight: bold;color: #eb6125; width: 200px;">
                            {{$itinerary2->DepartAirportCode}}
                        </h2>
                        <p style="font-size: 11px;position: relative;bottom: 18px;text-align: center;">
                            {{$itinerary2->DepartCityName}}</p>
                        <p
                            style="color: #141823;background: #fef8e5;font-weight: bold;text-align: center;position: relative;
                    bottom: 25px;">
                            {{  getDate_fn($itinerary2->DepartDate)??'' ?? date('d-m-Y', strtotime($itinerary2->DepartDate))??'' }} |
                            <strong>{{ date('H:i', strtotime($itinerary2->DepartDateTime))??'' }}</strong> </p>
                        <p style="text-align: center;font-size: 12px;position: relative;bottom: 35px;">Airport :
                            {{$itinerary2->DepartAirportName}}</p>
                    </td>
                    <td class="timing" style="margin-top: 35px;position: relative;left: 30px;">
                        <img style="width:16px;margin-left: 15px;" src="{{asset('assets/images/images/watch.png')}}"
                            alt="time">

                        <p class="timingpara" style="color: #000;position: relative;left:8px; bottom: 12px;">
                            {{ getTime_fn($itinerary2->Duration) }}</p>

                        <hr
                            class="timinghr"style="color: #ddd;width: 50px;margin-right: 110px;position: relative;bottom: 20px;">

                        <p style="color: #000;position: relative;bottom: 30px;">Economy: {{$itinerary2->TravelClass}}
                        </p>
                    </td>
                    <td class="hyderabad-details">
                        <h2 style="font-weight: bold;color: #eb6125;text-align: center;">
                            {{$itinerary2->ArrivalAirportCode}}</h2>
                        <p style="font-size: 11px;position: relative;bottom: 18px;text-align: center;">
                            {{$itinerary2->ArrivalCityName}}</p>
                        <p
                            style="color: #141823;background: #fef8e5;font-weight: bold;text-align: center;position: relative;
                    bottom: 25px;">
                            {{  getDate_fn($itinerary2->ArrivalDate)??'' ?? date('d-m-Y', strtotime($itinerary2->ArrivalDate))??'' }} |
                            <strong>{{ date('H:i', strtotime($itinerary2->ArrivalDateTime))??'' }}</strong></p>
                        <p style="text-align: center;font-size: 12px;position: relative;bottom: 35px;">Airport :
                            {{$itinerary2->ArrivalAirportName}}</p>
                    </td>
                </tr>
            @endforeach

            <tr class="passenger-name" style="background: #eef4fd;border-radius: 8px;color: #1951b5;">
                <td class="" style="text-align: center;">
                    <p>PASSENGER NAME</p>
                </td>
                <td>
                    <p style="text-align: center;">PNR</p>
                </td>
                <td>
                    <p style="text-align: center;">Ailine PNR</p>
                </td>
                <td>
                    <p style="text-align: center;">SEAT</p>
                </td>
            </tr>
            @foreach (json_decode($bookings->passenger) as $key =>  $passenger)
                <tr>
                    <td
                        style="padding: 10px 5px;vertical-align: top;font-family: arial;text-align: center;font-size: 12px; border-right: solid 1px #f4f4f4;color: #4a4a4a;width: 25%;">
                        {{$key+1}}. {{ ($passenger->Title??'') . ' ' . ($passenger->FirstName) . ' ' . ($passenger->LastName) }}
                    </td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{ $bookings->gds_pnr }}
                    </td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{ $bookings->airline_pnr }}
                    </td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;color:#4a4a4a">
                        NA
                    </td>
                </tr>
                @endforeach
                @foreach (json_decode($bookings2->passenger) as $key => $passenger2)
                <tr>
                    <td
                        style="padding: 10px 5px;vertical-align: top;font-family: arial;text-align: center;font-size: 12px; border-right: solid 1px #f4f4f4;color: #4a4a4a;width: 25%;">
                        {{$key+1}}. {{ ($passenger2->Title??'') . ' ' . ($passenger2->FirstName) . ' ' . ($passenger2->LastName) }}
                    </td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{ $bookings2->gds_pnr }}
                    </td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{ $bookings2->airline_pnr }}
                    </td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;color:#4a4a4a">
                        NA
                    </td>
                </tr>
                @endforeach
            <tr>
                <td colspan="4" class="important-info"
                    style="text-align: center; padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;">
                    <p>IMPORTANT INFORMATION</p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <p style="font-size: 12px;padding: 0px 5px;"><strong>1. Web Check-in :</strong> Web Check-in is now
                        a
                        mandatory step for your air travel. For a hassle-free Web Check-in on WagnisTrip, please <a
                            href="">click Here</a></p>
                    <p style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>2. Check-in Time :</strong>
                        Passenger to report 2 hours before departure. Check-in procedure and baggage drop will close 1
                        hour before departure.</p>
                    <p style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>3. Valid ID proof needed
                            :</strong> Please carry a valid Passport and Visa (mandatory for international travel).
                        Passport should have at least 6 months of validity at the time of travel</p>
                    <p style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>4. DGCA passenger charter
                            :</strong> Please refer to passenger charter by <a href="">click Here</a></p>
                    <p style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>5. Gosafe-certified Airport
                            Cabs
                            :</strong> We enjoy smooth airport transfers in sanitized cabs with trained drivers. No
                        waiting and no surge pricing! Book : <a href="">here</a></p>
                    <p style="font-size: 12px;padding: 0px 5px;margin-top: 15px;"><strong>6. Beware of fraudsters
                            :</strong> Please do not share your personal banking and security details like passwords,
                        CVV, etc. with any third person or party claiming to represent WagnisTrip. For any query, please
                        reach out to WagnisTrip on our official customer care number.</p>
                </td>

            </tr>
            <tr class="baggage-info"
                style="text-align: center;padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;width: 93.5%;
                    margin-left: 10px;">
                <td colspan="4">
                    <p>BAGGAGE INFORMATION</p>
                </td>
            </tr>
            <tr>
                <th
                    style="padding:6px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:25%;text-align:center;font-size:12px;background:#eef4fd;font-weight:bold;color:#153d6c">
                    Type</th>
                <th
                    style="padding:6px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:25%;font-size:12px;text-align:centeR;background:#eef4fd;font-weight:bold;color:#153d6c">
                    Sector</th>
                <th
                    style="padding:6px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:25%;text-align:center;font-size:12px;background:#eef4fd;font-weight:bold;color:#153d6c">
                    Cabin</th>
                <th
                    style="padding:6px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:25%;font-size:12px;text-align:center;background:#eef4fd;font-weight:bold;color:#153d6c">
                    Check-in</th>
            </tr>
            @foreach (json_decode($bookings->passenger) as  $passenger)
                <tr>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{ $passenger->PaxTypeCode }}</td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{$itinerary->DepartAirportCode}} - {{$itinerary->ArrivalAirportCode}}</td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{$baggage[0]->CabIn??'null'}}</td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;color:#4a4a4a">
                        {{$baggage[0]->CheckIn??'null'}}</td>
                </tr>
            @endforeach
            @foreach (json_decode($bookings2->passenger) as $passenger2)
                <tr>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{ $passenger2->PaxTypeCode }}</td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{$itinerary->DepartAirportCode}} - {{$itinerary->ArrivalAirportCode}}</td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;text-align:center;font-size:12px;border-right:solid 1px #f4f4f4;color:#4a4a4a">
                        {{$baggage2[0]->CabIn??'null'}}</td>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;font-size:12px;text-align:center;color:#4a4a4a">
                        {{$baggage2[0]->CheckIn??'null'}}</td>
                </tr>
            @endforeach
            <tr class="payment-info"
                style="text-align: center; padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;width: 93.5%;
                    margin-left: 10px;">
                <th colspan="4">
                    <p>PAYMENT INFORMATION</p>
                </th>
            </tr>
            <tr style="text-align: center;">
                 <?php $fare = json_decode($bookings->fare); ?>
                 <?php $fare2 = json_decode($bookings2->fare); ?>
                <td colspan="4">
                    <p>You have Paid INR {{$fare2[0]->PaxTotalFare}} {{-- | For Fare Breakup <a href="">Get Invoice</a>--}}</p>
                </td>
            </tr>
            <tr class="cancellation"
                style="text-align: center; padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;width: 93.5%;
                    margin-left: 10px;">
                <td colspan="4">
                    <p>CANCELLATION AND DATE CHANGE CHARGES</p>
                </td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="4">
                    <p style="margin-left: 15px;">All charges below are per Pax and per Segment in INR</p>
                </td>
            </tr>
            <tr style="background:#eef4fd;font-weight:bold">
                <td colspan="2"
                    style="padding:5px 10px;vertical-align:top;font-family:arial;text-align:center;border-bottom:1px solid #f4f4f4;font-size:11px;line-height:12px">
                    {{$itinerary->DepartAirportCode}} - {{$itinerary->ArrivalAirportCode}}
                </td>
                <td colspan="2"
                    style="padding:5px 5px 5px 0px;vertical-align:top;font-family:arial;text-align:center;border-bottom:1px solid #f4f4f4;font-size:11px">
                    Cancellation Charges
                </td>
            </tr>
            <tr>
                <td style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:20%;border-right:1px solid #f4f4f4;text-align:center;font-size:11px">
                    Type</td>
                <td style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:33%;border-right:solid 1px #f4f4f4;font-size:11px">
                    Condition</td>
                <td style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:18%;border-right:solid 1px #f4f4f4;text-align:center;font-size:11px">
                    Airline</td>
                <td style="padding:10px 5px;vertical-align:top;font-family:arial;border-bottom:1px solid #f4f4f4;width:19%;font-size:11px">
                    WagnisTrip</td>
            </tr>

                <tr>
                    <td
                        style="padding:10px 5px;vertical-align:top;font-family:arial;width:20%;border-right:1px solid #f4f4f4;text-align:center;font-size:11px">
                        {{ $passenger->PaxTypeCode }}</td>
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



            <tr style="background:#eef4fd;font-weight:bold">
                <td colspan="2"
                    style="padding:5px 10px;vertical-align:top;font-family:arial;text-align:center;border-bottom:1px solid #f4f4f4;font-size:11px;line-height:12px">
                    {{$itinerary->DepartAirportCode}} - {{$itinerary->ArrivalAirportCode}}</td>
                <td colspan="2"
                    style="padding:5px 5px 5px 0px;vertical-align:top;font-family:arial;text-align:center;border-bottom:1px solid #f4f4f4;font-size:11px">
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
                        {{ $passenger->PaxTypeCode }}</td>
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


            <tr class="customer-support"
                style="text-align: center; padding: 5px 15px;background: #eef4fd;border-radius: 8px;color: #1951b5;margin-top: 20px;width: 93.5%;margin-left: 10px;">
                <td colspan="4">
                    <p>24x7 CUSTOMER SUPPORT</p>
                </td>
            </tr>
            <tr>
                <td colspan="4"
                    style="padding:5px 0px 5px 10px;vertical-align:top;font-family:arial;background:#eef4fd;font-weight:bold;line-height:12px;font-size:12px;color:#1951b5">
                    WagnisTrip Support </td>
            </tr>
            <tr>
                <td colspan="2"
                    style="padding:0px;vertical-align:top;font-family:arial;width:45px;font-size:12px;font-weight:bold;color:#4a4a4a">
                    Customer Care
                </td>
                <td colspan="2" style="padding:0px;vertical-align:top;font-family:arial;width:220px">
                    <p style="margin:0px 0px 5px;line-height:15px;font-size:12px;color:#4a4a4a">
                        +917669988012</p>
                </td>
            </tr>
           {{-- <tr style="text-align: center;">
                <td colspan="4"
                    style="padding:5px 0px 5px 10px;vertical-align:top;font-family:arial;background:#eef4fd;font-weight:bold;line-height:12px;font-size:12px;color:#1951b5">
                    Airline Support</td>
            </tr>
            <tr>
                <td colspan="2"
                    style="padding:0px;vertical-align:top;font-family:arial;width:160px;font-size:12px;font-weight:bold;color:#4a4a4a">
                    Indigo Airlines</td>
                <td colspan="2" style="padding-left:10px;vertical-align:top;font-family:arial;width:100px">
                    <p style="margin:0px 0px 5px;line-height:15px;font-size:12px;color:#4a4a4a">
                        9910383838</p>
                </td>
            </tr> --}}
        </table>
    </main>
</body>

</html>
