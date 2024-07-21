<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>gal-ticket-mail-new</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  .containing {
    z-index: 5;
    position: relative;
  }

  .containing::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    background-image: url(images/logo.png);
    background-size: 1000px;
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    opacity: .1;
    z-index: 2;
  }

  body {
    overflow-x: hidden;
  }

  html {
    overflow-x: hidden;
  }


  /***** Media Query Start *****/
  @media only screen and (max-width: 1582px) {
    .containing {
      padding: 15px 250px !important;
    }

    .e-ticket-details {
      width: 180px !important;
    }

    .flight-one {
      width: 150px !important;
    }

    .non-stop-one {
      width: 150px !important;
    }

    .flight-two {
      width: 150px !important;
    }

    .arrival .status {
      color: #8ee30a !important;
      border: 1px solid !important;
      outline: none !important;
      height: 28px !important;
      border-radius: 5px !important;
      width: 130px !important;
      position: relative !important;
      right: 70px !important;
      top: 4px !important;
    }

    .arrival {
      padding: 0px 25px !important;
    }

    .departure {
      padding: 0px 25px !important;
    }

    .flight-three {
      width: 150px !important;
    }

    .non-stop-two {
      width: 150px !important;
    }

    .flight-four {
      width: 150px !important;
    }

    .departure .status {
      color: #8ee30a !important;
      border: 1px solid !important;
      outline: none !important;
      height: 28px !important;
      border-radius: 5px !important;
      width: 130px !important;
      position: relative !important;
      right: 70px !important;
      top: 4px !important;
    }

    .reference {
      width: 235px !important;
    }

    .pnr {
      width: 235px !important;
      position: relative !important;
      right: 123px !important;
    }

    .seat-number-one {
      position: relative !important;
      right: 50px !important;
    }

    .seat-number-two {
      position: relative !important;
      right: 50px !important;
    }
  }

  @media only screen and (max-width: 1460px) {
    .containing {
      padding: 15px 200px !important;
    }
  }

  @media only screen and (max-width: 1360px) {
    .containing {
      padding: 15px 150px !important;
    }
  }

  @media only screen and (max-width: 1260px) {
    .containing {
      padding: 15px 100px !important;
    }
  }

  @media only screen and (max-width: 1160px) {
    .containing {
      padding: 15px 50px !important;
    }
  }

  @media only screen and (max-width: 1060px) {
    .containing {
      padding: 15px 0px !important;
    }
  }

  @media only screen and (max-width: 960px) {
    .grid-1 {
      gap: 50% !important;
    }

    html {
      font-size: 12px !important;
    }

    .arrival .grid {
      gap: 9% !important;
    }

    .departure .grid {
      gap: 9% !important;
    }
  }

  @media only screen and (max-width: 960px) {
    .arrival .grid {
      gap: 8% !important;
    }

    .departure .grid {
      gap: 8% !important;
    }
    .containing::before{
      background-size: 850px !important;
    }
  }

  @media only screen and (max-width: 856px) {
    .arrival .grid {
      gap: 7% !important;
    }

    .departure .grid {
      gap: 7% !important;
    }
    .containing::before{
      background-size: 800px !important;
    }
  }

  @media only screen and (max-width: 815px) {
    .arrival .grid {
      gap: 6% !important;
    }

    .departure .grid {
      gap: 6% !important;
    }
  }

  @media only screen and (max-width: 775px) {
    html {
      font-size: 11px !important;
    }

    .arrival .grid {
      gap: 4% !important;
    }

    .departure .grid {
      gap: 4% !important;
    }

    .containing::before {
      background-size: 700px !important;
    }
  }

  @media only screen and (max-width: 705px) {
    .arrival .grid {
      gap: 3% !important;
    }

    .departure .grid {
      gap: 3% !important;
    }

    .non-stop-one {
      margin-top: 20px !important;
    }

    .non-stop-two {
      margin-top: 20px !important;
    }

    .flight-two {
      width: 101px !important;
    }

    .flight-four {
      width: 101px !important;
    }

    .arrival .status,
    .departure .status {
      right: 12px !important;
    }
  }

  @media only screen and (max-width: 687px) {
    html {
      font-size: 10px !important;
    }

    .arrival .status,
    .departure .status {
      width: 100px !important;
    }

    .arrival .grid,
    .departure .grid {
      grid-template-columns: repeat(3, 1fr) !important;
    }

    .non-stop-one {
      margin-top: 16px !important;
    }

    .grid-1 {
      gap: 35% !important;
    }

    .seat-number-one {
      position: relative !important;
      right: 100px !important;
    }
    .containing::before {
      background-size: 580px !important;
    }
  }

  @media only screen and (max-width: 570px) {
    .grid-1 {
      gap: 25% !important;
    }

    .grid-2 {
      gap: 45% !important;
    }
    .containing::before {
      background-size: 450px !important;
    }
  }

  @media only screen and (max-width: 460px) {
    .grid-1 {
      gap: 0% !important;
    }

    .grid-2 {
      gap: 25% !important;
    }
    .containing::before {
      background-size: 370px !important;
    }
  }

  @media only screen and (max-width: 386px) {

    .arrival .grid,
    .departure .grid {
      grid-template-columns: repeat(2, 1fr) !important;
    }

    .arrival .status,
    .departure .status {
      top: -15px !important;
    }
    .containing::before {
      background-size: 300px !important;
    }
  }

  @media only screen and (max-width: 352px) {

    .arrival .grid,
    .departure .grid {
      grid-template-columns: repeat(1, 1fr) !important;
    }

    .arrival {
      height: 55vh !important;
    }

    .departure {
      height: 57vh !important;
    }

    .arrival-name,
    .departure-name {
      margin-left: 100px !important;
    }

    .flight-one,
    .flight-three {
      margin-left: 50px !important;
    }

    .non-stop-one,
    .non-stop-two {
      margin-left: 95px !important;
    }

    .flight-two,
    .flight-four {
      margin-left: 80px !important;
    }

    .arrival .status,
    .departure .status {
      margin-left: 86px !important;
      top: -5px !important;
    }

    .grid-1 {
      grid-template-columns: repeat(1, 1fr) !important;
    }
    .containing::before {
      background-size: 280px !important;
    }
  }


  /***** Media Query End   *****/
</style>

<body>
  <main>
    <section>
      <div class="containing" style="padding: 15px 300px;">
        <div class="grid-1" style="display: grid;grid-template-columns: repeat(2,1fr);gap: 63%;">
          <div class="logo-img">
            <img style="width: 150px;" src="{{ asset('assets/images/images/logo.png') }}" alt="WagnisTrip Logo">
            
          </div>
          <div class="e-ticket-details">
            <p style="color: darkblue;font-weight: 900;font-size: 25px;text-align: right;">eTicket / Receipt</p>
            <p style="font-weight: 500;">Issued Date: Monday, March 3, 2023</p>
          </div>
        </div>
        <div style="border: 2px solid red;" class="hr-style"></div>
        <div class="grid-2" style="display: grid;grid-template-columns: repeat(2,1fr);gap: 63%;">
          <div class="reference">
            <p>Booking reference no: hgjhjhkfjhkjg</p>
          </div>
          <div class="pnr">
            <p style="font-weight: 900;">PNR Number: yiyyiy</p>
          </div>
        </div>
        <h2 style="color: darkblue;">Passenger Details</h2>
        <table>
          <tr>
            <th style="text-align: center;">Passenger Name</th>
            <th style="text-align: center;">eTicket Number</th>
            <th style="text-align: center;">Passenger Type</th>
          </tr>
          <tr>
            <td style="text-align: center;">Alfreds Futterkiste</td>
            <td style="text-align: center;">Maria Anders</td>
            <td style="text-align: center;">Germany</td>
          </tr>
        </table>
        <h2 style="color: darkblue;">Itenary Details</h2>
        <span style="color: grey;">Departure</span> <span style="color: grey;margin-left: 10px;">Flight</span>
        <div class="arrival"
          style="background-color: #f5f1f1;border: 1px solid #efeaea;border-radius: 10px;padding: 10px 25px;margin-top: 15px;margin-bottom: 30px;">
          <div class="grid" style="display: grid; grid-template-columns: repeat(5,1fr);gap: 10%;">
            <div class="arrival-name">
              <p style="font-weight: 900;">Flight: AI 333</p>
              <img src="{{ asset('assets/images/images/AI.png') }}" alt="Air India">
            </div>
            <div class="flight-one" style="line-height: 1;">
              <p style="font-weight: 900;text-align: center;">DMK</p>
              <p style="color: grey;font-weight: 500;text-align: center;">Bangkok, Thailand</p>
              <p style="color: grey;font-weight: 500;text-align: center;">05/04/2023, 12:44</p>
              <p style="font-weight: 700;text-align: center;">Don Mueang International Airport</p>
              <p>Terminal-1</p>
            </div>
            <div class="non-stop-one" style="margin-top: 40px;">
              <p>Class: Promo (V)</p>
              <i class="fa-solid fa-plane" style="color:darkblue;margin-left: 40px;"></i>
              <p>4h 35m non-stop</p>
            </div>
            <div class="flight-two">
              <p style="font-weight: 900;text-align: center;">DEL</p>
              <p style="color: grey;font-weight: 500;text-align: center;">New Delhi Airport</p>
              <p style="color: grey;font-weight: 500;text-align: center;">05/04/2023, 12:44</p>
              <p style="font-weight: 700;text-align: center;">Indira Gandhi International Airport</p>
              <p style="text-align: center;">Terminal-2</p>
            </div>
            <div class="status" style="color: #8ee30a;border: 1px solid;outline: none;height: 30px;border-radius: 5px;">
              <p style="text-align: center;margin-top: 6px;">Status: Confirmed</p>
            </div>
          </div>
        </div>
        <span style="color: grey;">Return</span> <span style="color: grey;margin-left: 10px;">Flight</span>
        <div class="departure"
          style="background-color: #f5f1f1;border: 1px solid #efeaea;border-radius: 10px;padding: 10px 25px;margin-top: 15px;margin-bottom: 30px;">
          <div class="grid" style="display: grid; grid-template-columns: repeat(5,1fr);gap: 10%;">
            <div class="departure-name">
              <p style="font-weight: 900;">Flight: AI 332</p>
              <img src="{{asset('assets/images/images/AI.png')}}" alt="Air India">
            </div>
            <div class="flight-three">
              <p style="font-weight: 900;text-align: center;">DEL</p>
              <p style="color: grey;font-weight: 500;text-align: center;">New Delhi Airport</p>
              <p style="color: grey;font-weight: 500;text-align: center;">05/04/2023, 12:44</p>
              <p style="font-weight: 700;text-align: center;">Indira Gandhi International Airport</p>
              <p style="text-align: center;">Terminal-1</p>
            </div>
            <div class="non-stop-two" style="margin-top: 40px;">
              <p>Class: Promo (V)</p>
              <i class="fa-solid fa-plane" style="color:darkblue;margin-left: 40px;"></i>
              <p>4h 35m non-stop</p>
            </div>
            <div class="flight-four" style="line-height: 1;">
              <p style="font-weight: 900;text-align: center;">DMK</p>
              <p style="color: grey;font-weight: 500;text-align: center;">Bangkok, Thailand</p>
              <p style="color: grey;font-weight: 500;text-align: center;">05/04/2023, 12:44</p>
              <p style="font-weight: 700;text-align: center;">Don Mueang International Airport</p>
              <p style="text-align: center;">Terminal-2</p>
            </div>
            <div class="status" style="color: #8ee30a;border: 1px solid;outline: none;height: 30px;border-radius: 5px;">
              <p style="text-align: center;margin-top: 6px;">Status: Confirmed</p>
            </div>
          </div>
        </div>
        <h2 style="color: darkblue;">Booking Summary</h2>
        <table style="margin-bottom: 30px;">
          <tr>
            <td>Flight:</td>
            <td style="text-align: right;">INR 24870</td>
          </tr>
          <tr>
            <td>Seat:</td>
            <td style="text-align: right;">INR 822.00</td>
          </tr>
          <tr>
            <td>Total Taxes:</td>
            <td style="text-align: right;">INR 9969.00</td>
          </tr>
          <tr>
            <td style="color: darkblue;font-weight: 900;">Total Paid:</td>
            <td style="color: darkblue;text-align: right;font-weight: 900;">INR 35,661.00</td>
          </tr>
        </table>
        <p style="margin-bottom: 30px;text-align: center;">This is an eTicket itinerary issued by
          <strong>Wagnistrip.</strong> To check-in, you must present this document along with an official
          government-issued photo identification such
          as a passport or identity card.</p>
        <table style="margin-bottom: 30px;">
          <tr>
            <td>Fare Rules</td>
          </tr>
          <tr>
            <td><strong>Booking Class:</strong> Ticket Refund and Exhanges are permitted with payment of fee and fare
              difference (if any) and within a defined deadline, Name change is not permitted.</td>
          </tr>
        </table>
        <h2 style="color: darkblue;">In-Flight Service</h2>
        <table style="margin-bottom: 30px;">
          <tr>
            <td style="text-align: center;">Guest</td>
            <td style="text-align: center;">DMK-DEL</td>
            <td style="text-align: center;">DEL-DMK</td>
          </tr>
          <tr>
            <td style="text-align: center;">Mr Himanshu Mehra</td>
            <td style="line-height: 1.5;" class="seat-number-one">
              <ul style="position: relative;
            left: 100px;">
                <li>Seat Number: 4A,</li>
                <li>Free Baggage Allowance: 25KG</li>
              </ul>
            </td>
            <td style="line-height: 1.5;" class="seat-number-one">
              <ul style="position: relative;
          left: 100px;">
                <li>Seat Number: 4A,</li>
                <li>Free Baggage Allowance: 25KG</li>
              </ul>
            </td>
          </tr>
        </table>
        <h2 style="color: darkblue;margin-bottom: 30px;">Important Notes</h2>
        <ul>
          <li>Please arrive at the airport 3 hours before the flight departure.</li>
          <li>Please be at the boarding gate 45 minutes before departure time. For all flights from China, The counters
            close 1 hour 30 minutes before the scheduled
            flight departure time.</li>
        </ul>
      </div>
    </section>
  </main>
</body>

</html>