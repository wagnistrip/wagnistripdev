@extends('layouts.master')
@section('title', 'Wagnistrip GAL')
@section('body')
<style>
    .card-elem{
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border-radius: 0.25rem;
    }
    .card-elem label{
        cursor:pointer;
    }
    .bank-selector {
      /*  max-height: 140px;  set a fixed height for the container */
       /* overflow-y: auto;  add a scrollbar when content overflows */
    }
    
    .bank-selector label.hide {
        display: none;
        margin-bottom: 10px;
        margin-left: -5rem;
        margin-top: 10px;
    }
    .bank-selector label.show {
        display: flex;
        margin-bottom: 10px;
        margin-left: -5rem;
        margin-top: 10px;
    }
    
    .bank-selector img {
        width: 8%;
        float: left;
        margin-top: -6px;
        margin-left: -4rem;
        border-radius: 10px;
    }
    .bank-selector input[type="radio"]{
        float: left;
    }
    .bankName{
        float: left;
    }
    
    
    
    .card-not-active{
        display: none;
    }
    
    
    .upicss{
    font-size: 1.2rem;
    text-align: left;
}
.smalltextupi{
    margin-left: 7rem;
    font-size: 1rem;
}
.card-upi-class{
    margin-top: 0.7rem;
    border-radius: 10px;
    text-align: center;
    width: 100%;
    padding: 10px;
    border: 2px solid #ddd;
}
.upiNote{
    display: flex;
    flex-direction: column;
    text-align: left;
    padding-left: 18px;
    margin: 6px 0 0 0 !important;
    font-size: 14px;
    width:100% !important;
}

.smallNote{
    border: 1px solid #0164a3;
    background: #0164a3d1;
    color: #fff;
}

/*hotel payment css*/
.hotel-payment-css{
    height: 37rem !important;
    margin-top: 8px;
}
    
    
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

.inputClasscss{
    outline: none;
    border: none;
    display: inline-block;
}

.spanClasscss{
    text-transform: uppercase;
    display: inline-block;
    font-size: 12px;
}
/*'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.*/
.card-number-css{
    display:flex;
    align-items: center;
    flex-direction: column;
}
.card-number-css span{
    /*margin-right: 292px;*/
    margin-bottom: 5px;
}
.card-number-css input{
    border-radius: 50px;
    padding: 5px 15px;
    /*width: 25vw;*/
    border-right-color: black;
    border-bottom-color: black;
}
.card-holder-css{
    display: flex;
    flex-direction: column;
    align-items: center;
}
.card-holder-css span{
    /*margin-right: 292px;*/
    margin-bottom: 5px;
}
.card-holder-css input{
    border-radius: 50px;
    padding: 5px 15px;
    /*width: 25vw;*/
    border-right-color: black;
    border-bottom-color: black;
}
.expire-css{
    display: flex;
}
.expire-css span{
    font-size: 10px;
    margin-left: 12px;
}
.expire-css select{
    border-radius: 50px;
    padding: 0px 5px;
    border: 2px solid black;
}
.cvv-no-css input{
    width: 50%;
    height: 4vh;
    border-radius: 50px;
    border-right-color: black;
    border-bottom-color: black;
    text-align: center;
}
.flexing{
     display: flex;
}
/*'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.'.*/



/****** Payment Form Validation Styling Starts *******/
.containing {
    /*min-height: 100vh;*/
    /*background: #eee;*/
    display: flex;
    align-items: center;
    justify-content: center;
    flex-flow: column;
    padding-bottom: 60px;
}

.containing form {
    background: #fff;
    border-radius: 5px;
    box-shadow: 0px 10px 15px rgba(0, 0, 0, .1);
    width: 600px;
    padding-top: 160px;
}

.containing form .inputBox {
    margin: 20px;
}

.containing form .inputBox span {
    color: #999;
    padding-bottom: 5px;
}

.containing form .inputBox input,
.containing form .inputBox select {
    width: 100% !important;
    padding: 10px !important;
    border-radius: 10px !important;
    border: 1px solid rgba(0, 0, 0, .3) !important;
    color: #444 !important;
}

.containing form .flexing {
    display: flex;
    gap: 15px;
}

.containing form .flexing .inputBox {
    flex: 1 1 150px;
}

.containing form .submit-btn {
    width: 94% !important;
    background: linear-gradient(45deg, blueviolet, deeppink) !important;
    padding: 10px !important;
    font-size: 20px !important;
    color: #fff !important;
    cursor: pointer !important;
    transition: .2s linear !important;
    margin: 20px !important;
    border-radius: 10px !important;
}

.containing form .submit-btn:hover {
    letter-spacing: 2px !important;
    opacity: .8 !important;;
}

.containing .card-containing {
    position: relative;
    height: 150px;
    width: 270px;
    margin-bottom: 20px;
}

.containing .card-containing .front {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    background: linear-gradient(45deg, blueviolet, deeppink);
    border-radius: 5px;
    backface-visibility: hidden;
    box-shadow: 0px 15px 25px rgba(0, 0, 0, .2);
    padding: 20px;
    transform: perspective(1000px) rotateY(0deg);
    transition: transform .4s ease-out;
}

.containing .card-containing .front .image {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
}

.containing .card-containing .front .image img {
    height: 25px;
}

.containing .card-containing .front .card-number-box {
    padding: 30px 0px;
    font-size: 15px;
    color: #fff;
}

.containing .card-containing .front .flexing {
    display: flex;
    margin-top: -25px;
}

.containing .card-containing .front .flexing .box:nth-child(1) {
    margin-right: auto;
}

.containing .card-containing .front .flexing .box {
    font-size: 15px;
    color: #fff;
}

.containing .card-containing .front .flexing .box .card-holder-name {
    text-transform: uppercase;
    font-size: 12px;
}

.containing .card-containing .back {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: linear-gradient(45deg, blueviolet, deeppink);
    border-radius: 5px;
    padding: 20px 0px;
    text-align: right;
    backface-visibility: hidden;
    transform: perspective(1000px) rotateY(180deg);
    transition: transform .4s ease-out;
    box-shadow: 0px 15px 25px rgba(0, 0, 0, .2);
}

.containing .card-containing .back .stripe {
    background: #000;
    width: 100%;
    margin: 10px 0px;
    height: 50px;
}

.containing .card-containing .back .box {
    padding: 0px 20px;
}

.containing .card-containing .back .box span {
    color: #fff;
    font-size: 15px;
}

.containing .card-containing .back .box .cvv-box {
    height: 50px;
    padding: 10px;
    margin-top: 5px;
    color: #333;
    background: #fff;
    border-radius: 5px;
    width: 100%;
}

.containing .card-containing .back .box img {
    margin-top: 30px;
    height: 30px;
}

.inputBox:nth-child(1),.inputBox:nth-child(2),.inputBox:nth-child(3){
    margin-bottom: 15px;
}

.cvv-box{
    height: 27px !important;
}

.mybuttonstyle{
    margin-top: 10px;
    border: none;
    outline: none;
    background: none;
    color: #00b8ff;
    float: inherit;
    cursor:pointer;
    position:absolute;
    top: 0;
    right: 0;
}

.upiNote {
    font-size: 1rem;
    margin: 3px 95px auto;
    width: 80%;
}

/****** Payment Form Validation Styling Ends   *******/




/*New Changes*/

.smalltextupiNew{
        margin: 0;
    font-size: 20px;
    padding-bottom: 11px;
    display: inline-block;
}

.smalltextupiNew i{
    font-size: 30px;
    vertical-align: bottom;    
}


.verifyBrnNew{
    width: 100%;
    font-size: 17px;
    border-radius: 10px;
    box-shadow: unset;
    padding: 8px 39px;
}

.payNow.verifyBrnNew{
    width: 86%;
    margin:-73px auto 0 auto;
}

.noteTextDiv{
    margin-top:15px;
}

.noteTextDiv .smallNote {
    border: 0;
    background: transparent;
    color: #000;
    padding: 0px;
    border-radius: 8px;
    display: block;
    text-align: left;
}


.UpiFlexDivMain{
    margin-bottom:35px;
}


.UpiHeading{
    font-size:18px;
}


.leftUpitext{
        margin-top: 6px;
        font-size: 13px;
        font-weight: 500;
}


.InputBoxes{
    width: 86%;
    margin: 0 auto;
}


.CardSpanText{
    display:block;
    text-align:left;
    width:100%;
}

/*.PayFieldsMaiCard{}*/



.SelectExpiryFields{
    width: 86%;
    margin: 0 auto;
    flex-wrap: wrap;
}


.SelectExpiryFields .inputBox{
    display:block;
    width:100%;
}

.SelectExpiryFields .expirySelect{
    width: 49%;
    padding: 10px;
    border-radius: 10px;
}


.cvv-number-input{
    width: 100% !important;
    padding: 18px !important;
    border-radius: 10px !important;
}

.SelectExpiryFields .CardSpanText{
    font-size:16px;
    margin:0 0 8px 0;
}


.activePay.activeRemover{
    border:0;
    background-color: transparent !important;
}


.payCard, .inputFileds {
    border-radius: 6px!important;
    border: 1px solid #0164a3;
    box-shadow: 1px 1px 4px 0px gray;
    text-align: left;
    width: 86%;
    padding: 10px !important;
    height: auto;
    margin-bottom: 10px;
    border-color: #000;
}

.inputFileds {
    width: 100%;
}


.bank-selector #bank_search{
        padding: 6px 10px;
        width: 100%;
        border-radius: 6px;
        border: 2px solid #0164a3;
        padding-left:32px;
}

.bank-selector #bank_search::placeholder {
  color:#000;
}
.bank-selector .searchBank{
    position:relative;
}

.bank-selector .searchBank i{
    position: absolute;
    top: 50%;
    transform: translate(9px, -65%);
}



.topAddBox{
    padding:40px;
    position: sticky;
    top: 30px;
}

/*end New Changes*/




@media only screen and (min-device-width: 275px) and (max-device-width: 576px) {
    .paybuton {
        margin-bottom: 34px;
        padding:25px 63px 25px 42px;
    }
    .paybuton .onwfnt-11{
        font-size: 47px;
    }
    
    .smalltextupiNew{
            font-size: 55px;
    }
    
    .payCard, .inputFileds{
        width: 94%;
        padding: 31px !important;
        height: auto !important;
        font-size: 58px;
    }
    .InputBoxes {
       width: 94%;
    }
    
    .card-number-css input{
        WIDTH: 100%;
        PADDING: 27PX 36PX !IMPORTANT;
        HEIGHT: AUTO !IMPORTANT;
    }
    
    .card-upi-class {
            height: auto !important;
            width: 96%;
            padding: 21px;
            margin-bottom: 46px;
            border-color: #000;
    }
    
    .moods .card{
        border:0;
    }
    
    .upiNote{
        margin-left: 40px !important;
    }
    
    .verifyBrnNew {
        font-size: 64px;
        padding: 19px 39px;
    }
    
    .CardSpanText{
        font-size:52px;
        text-transform: capitalize;
    }
    
    .card-holder-css input{
            width: 100%;
            padding: 30px 53px !important;
            height: auto !important;
    }
    .cvv-number-input{
            height: auto !important;
    }
    .SelectExpiryFields{
        width: 100%;
    }
    .SelectExpiryFields .expirySelect{
        width: 94%;
        padding: 29px;
        border-radius: 10px;
        height: auto !important;
        margin: 0 auto 27px auto;
        text-transform: capitalize;
    }
    .SelectExpiryFields .CardSpanText {
        font-size: 52px;
        margin: 0 0 8px 29px;
    }
    .cvv-no-css input{
        width: 94% !important;
        height: auto !important;
        border-color: #000 !important;
    }
    
    .bank-selector img{
        margin-left: 0rem;
    }
    .bank-selector input[type="radio"]{
            margin-left: -6%;
    }
    .bank-selector .card-elem .bankName{
            font-size: 47px;
            margin-left: 37px;
    }
    .payNow.verifyBrnNew{
        width: 94%;
    }
    
    
    .bank-selector #bank_search{
            width: 96%;
            padding: 30px 20px 30px 81px;
    }
    .bank-selector .searchBank i {
        transform: translate(29px, -65%);
    }
}






</style>
@php
    use App\Http\Controllers\Airline\AirportiatacodesController;
    use App\Models\Agent\Agent;
    $code = !empty($code) ? $code : 'INR';
    $cvalue = !empty($cvalue) ? $cvalue : 1;

        $icon = __('common.'.$code); 
@endphp

    <section class="bgcolor pt-6p">
        <div class="container">
            <div class="row d-none" >
                <div class="col-sm-8">
                    <div class="boxunder topAddBox box_text12">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="fa fa-cc-visa" style="font-size:55px;color:#0164a3ed; margin-left: 15px;"></i>
                            </div>
                            <div class="col-sm-7">
                                <span class="fontsize-22">Get addit ional discounts</span><br>
                                <span class="owstitle">Login to access saved payments and discounts!</span>
                            </div>
                            <div class="col-sm-3 mt-10">
                                <a href="https://www.wagnistrip.com/user/profile">
                                    <button class="btn btn-sm btn-info fontsize-22">LOGIN NOW</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    @php
                        $Agent = Session()->get("Agent");
                    @endphp
                    @if($Agent != null)
                        @php
                            $mail = $Agent->email;
                            $Agent = Agent::where('email', '=', $mail)->first();
                        @endphp
                    {{--if Agent is Loged in --}}
                    <div class="boxunder">
                        <div class="row row_inneer">
                           
                            <div class="col-sm-7">
                                <span class="fontsize-22">Amount in you Agent Account is :  {{$Agent->state}} /-</span>
                                <!--<span class="owstitle">Login to access saved payments and discounts!</span>-->
                            </div>
                                
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                
                <div class="col-sm-8 pt-10">
                    <div class="boxunder">
                        <div class="row p-2">
                            <div class="col-sm-4 p-btns">
                                {{--if Agent is Loged in --}}
                                    @if($Agent != null)
                                    @php
                                        $mail = $Agent->email;
                                        $Agent = Agent::where('email', '=', $mail)->first();
                                    @endphp
                   
                                    <div class="paybuton  p-btn" id="AGENT" data-btn-num="1">
                                        <span class="fonts-16 "> <i class="fa fa-credit-card"></i> Hi {{$Agent->name}} </span>
                                        <div class="onwfnt-11 pl30-mt-7 ">Pay Directly From Your Agent Account</div>
                                    </div>
                                    @endif
                                {{--End if Agent is Loged in --}}
                                <div class="paybuton activePay p-btn" id="UPIS" data-btn-num="2">
                                    <span class="fonts-16 " > <img src="{{ asset('assets/images/upi.png') }}" alt=""
                                            width="25"> UPI </span>
                                    <div class="onwfnt-11 pl30-mt-7">Pay Directly From Your Bank Account</div>
                                </div>
                                <div class="paybuton p-btn" id="CREADITATM(disable)" data-btn-num="3">
                                    <span class="fonts-16 "> <i class="fa fa-credit-card"></i> Credit/Debit/ATM
                                        Card </span>
                                    <div class="onwfnt-11 pl30-mt-7 p-btn" data-btn-num="3">Visa, MasterCard, Amex, Rupay And More</div>
                                </div>
                                <div class="paybuton p-btn" id="PAYLATERS" data-btn-num="4">
                                    <span class="fonts-16 "> <img src="{{ asset('assets/images/netb.jpg') }}" alt=""
                                            width="25"> Net Banking</span>
                                    <div class="onwfnt-11 pl30-mt-7 "> All Major Banks Available </div>
                                </div>
                                @if(!empty($redirect))
                                <div class="paybuton p-btn mt-2">
                                    <a href="{{$redirect}}">
                                    <span class="fonts-16 font_img"> <img src="{{ asset('assets/images/netb.jpg') }}" alt=""> Paypal </span>
                                    </a>
                                </div>
                                @endif                                
                            </div>
                            <div class="col-sm-8">
                                <div class="ranjepp">
                                    @php
                                        $totalfare = !empty($data['timefare']) ? $data['timefare'] : $data['fare'];
                                        $fare = $totalfare;
                                        $Adult = json_decode($data->travllername);
                                    @endphp
                                            @if($Agent != null)
                                            <div id="AGENT" class="card-c1 p-btn--1 card-not-active activeRemover">
                                                @if($totalfare <= $Agent->state)
                                                    <form action="{{url('payment/cashfree-process-round') }}" method="post">
                                                    @csrf
                                                    <div class="col-md-12 mt-3">
                                                    <label for="showprice">    
                                                    <input type="checkbox" id="showprice" name="showprice" class="text-18" style="width: 25px;height: 20px;" value="checked" />
                                                    Are You show price On Ticket Form</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="hidden" name="furl" value="flight/booking-roundtrip-domestic">
                                                        <input type="hidden" name="surl" value="flight/booking-roundtrip-domestic">
                                                        <input type="hidden" name="txnid" value="{{$data['uniqueid']}}">
                                                        <input type="hidden" name="IsAgent" value="yes">
                                                        <input class="form-check-input" type="checkbox" name="agent" value="agent" id="flexCheckIndeterminate">
                                                        <label class="form-check-label" for="flexCheckIndeterminate">
                                                            Use My Agent Amount.
                                                        </label>
                                                        <button type="submit" id="Agent" class="searchbtn btn btn-lg verifyBrnNew">VERIFY & PAY</button><br/><br/>
                                                        <h6 class="upicss">
                                                                  If you click on this checkbox, your money will be deducted from your agent's account.
                                                        </h6>
                                                    </div>  
                                                </form>
                                                @else
                                                <form action="{{url('/Agent/add/amount')}}" method="get">
                                                    @csrf
                                                    <div class="form-check">
                                                        <h6 class="upicss">
                                                           It shows there is not enough money in your account so
                                                           add funds to your account or use a different mode of payment to book it
                                                        </h6>
                                                    </div>
                                                    <button type="submit" id="Agent" class="searchbtn btn btn-lg verifyBrnNew">VERIFY & PAY</button>
                                                    
                                                </form>   
                                                @endif
                                            </div>
                                            @endif
                                            <div id="UPI" class="moods card-c1 p-btn--2 activeRemover">
                                                <span class="onwfnt-11 smalltextupiNew"> <i class="fa fa-mobile"> </i> Keep your phone handy ! </span>
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                    <form action="{{ url('payment/cashfree-process-round') }}" method="post">
                                                        {!! csrf_field() !!} 
                                                        @csrf
                                                        <h4 class="upicss">Enter UPI ID</h4>
                                                        <input type="hidden" name="uniqueid" value="{{$data['uniqueid']}}"/>
                                                        <input type="hidden" name="key" value="KEY"/>
                                                            <input type="hidden" name="amount" value="{{!empty($data['timefare']) ? $data['timefare'] : $data['fare']}}"/>
                                                            
                                                            <input type="hidden" name="email" value="{{$data['email']}}"/>
                                                            <input type="hidden" name="phone" value="{{$data['phonenumber']}}"/>
                                                            <input type="hidden" name="customerEmail" value="{{$data['email']}}"/>
                                                            <input type="hidden" name="customerName" value="{{$Adult[0]->FirstName}}"/>
                                                            <input type="hidden" name="payment_mode" value="UPI"/>
                                                            <input type="hidden" name="bank_code" value=""/>
                                                            <input type="text" name="upi_va" id="upi_va" class="card-upi-class" placeholder="mobileNumber@upi" required>
                                                            <!--<label for="upi_qr">upi_qr</label>-->
                                                            <input type="hidden" name="upi_qr" id="upi_qr" class="card-upi-qr-class" placeholder="Enter upi qr" required>
                                                            <!--<label for="pay_later_app">pay_later_app</label>-->
                                                            <input type="hidden" name="pay_later_app" id="pay_later_app" class="pay-later-class"  placeholder="Enter pay later" required>
                                                            
                                                            <input type="hidden" name="request_mode" id="request_mode" value="SUVA"><br>
                                                            <!--<label for="txnid">txnid</label>-->
                                                            <input type="hidden" name="txnid" id="txnid" value="{{$data['uniqueid']}}"><br>
                                                            <!--<label for="token_requester_id">token_requester_id</label>-->
                                                            <input type="hidden" name="token_requester_id" id="token_requester_id" class="token-requester-class" placeholder="Enter token requester id" required>
                                                            


                                                        <button type="submit" class="searchbtn btn btn-lg verifyBrnNew">VERIFY & PAY</button>
                                                            <div class="border" style="margin-top: 1rem;"></div>
                                                            <div class="noteTextDiv">
                                                                <small class="smallNote">NOTE </small>
                                                                <ul class="upiNote">
                                                                    <li>Enter your registered VPA</li>
                                                                    <li>Receive payment request on bank app</li>
                                                                    <li>Authorize payment request</li>
                                                                </ul>
                                                            </div>
                                                            
                                                        </form>
                                                    </form>
                                                    <div class="text-center pt-20 tex_img">
                                                        <img src="{{ asset('assets/images/alupi.png') }}" alt="" class="imgonewayw-70per">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="CREADITATM" class="moods card-c1 p-btn--3 card-not-active activeRemover">
                                                <span class="onwfnt-11 smalltextupiNew"> <i class="fa fa-mobile"> </i> Keep your phone handy ! </span>
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                @php
                                                    $totalfare = !empty($data['timefare']) ? $data['timefare'] : $data['fare'];
                                                    $fare = $totalfare;
                                                    $Adult = json_decode($data->travllername);
                                                @endphp
                                                {{--<div class="fontsize-22 pb-20"> <i class="fa fa-inr"></i>
                                                    {{ number_format($totalfare) }} DUE NOW</div>--}}
                                                    {{-- <form action="{{ url('payment/cashfree-process-round') }}" method="post">
                                                        {!! csrf_field() !!} --}}
                                                          {{-- THIS IS FOR CASH FREE (UN COMMENT)  --}}
                                                        {{-- <input type="hidden" name="uniqueid" value="{{$data['uniqueid']}}">
                                                        <input type="hidden" name="data-key" value="781827d26290a6ea98559e65ec895029923b5fa7"> 
                                                        <input type="hidden" name="data-amount" value="{{ $fare }}">
                                                        <button type="submit" class="btn btn-primary btn-block"
                                                        value="data-buttontext">VERIFY & PAY</button>
                                                        <input type="hidden" name="data-name"
                                                        value="WAGNISTRIP (OPC) PVT.LTD.">
                                                        <input type="hidden" name="data-description" value="Flight Booking">
                                                        <input type="hidden" name="data-image"  value="https://www.wagnistrip.com/logo.jpg">
                                                        <input type="hidden" name="data-prefill.name" value="Wagnistrip">
                                                        <input type="hidden" name="customerName" value="{{ $Adult[0]->FirstName.' '.$Adult[0]->LastName }}">
                                                        <input type="hidden" name="customerEmail" value="{{ $data['email'] }}"> 
                                                        <input type="hidden" name="customerPhone" value="{{ $data['phonenumber'] }}">   
                                                        
                                                    </form> --}}

                                                    {{-- ///////////////////////////////////////////////// --}}
                                                    {{-- ///////////////////////////////////////////////// --}}
                                                    {{-- ///////////////////////////////////////////////// --}}
                                                    
                                                    {{-- SEAM LESS GETWAY FOR  CC / DC  BY UDD --}}
                                                    <form action="{{ url('payment/cashfree-process-round') }}" method="post">
                                                        {!! csrf_field() !!} 
                                                        @csrf
                                                        
                                                        <input type="hidden" name="uniqueid" value="{{$data['uniqueid']}}"/>
                                                        <input type="hidden" name="key" value="KEY"/>
                                                            <input type="hidden" name="amount" value="{{!empty($data['timefare']) ? $data['timefare'] : $data['fare'] }}"/>
                                                            <input type="hidden" name="email" value="{{$data['email']}}"/>
                                                            <input type="hidden" name="phone" value="{{$data['phonenumber']}}"/>
                                                            <input type="hidden" name="customerEmail" value="{{$data['email']}}"/>
                                                            <input type="hidden" name="customerName" value="{{$Adult[0]->FirstName}}"/>
                                                            <input type="hidden" name="bank_code" value=""/>
                                                            <select name="payment_mode" id="payment_mode" class="payment-mode-class payCard" required>
                                                            
                                                                <option selected="Select Card">Select Card</option>
                                                                <option value="DC">Debit Card</option>
                                                                <option value="CC">Credit Card</option>
                                                            </select><br>
                                                            <div class="containing PayFieldsdiv">
                                                                    <div class="InputBoxes card-number-css">
                                                                        <span class="CardSpanText">card number</span>
                                                                        <input type="number" class="inputFileds card-number-input" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==16) return false;"
                                                                            name="card_number" id="card_number" placeholder="Enter your card no." required>
                                                                    </div>
                                                                    <div class="InputBoxes card-holder-css">
                                                                        <span class="CardSpanText">card holder</span>
                                                                        <input type="text" class="inputFileds card-holder-input" name="card_holder_name" id="card_holder_name" placeholder="Enter card holder name"
                                                                            required>
                                                                    </div>
                                                                    <div class="flexing SelectExpiryFields">
                                                                        <div class="inputBox expire-css">
                                                                            <span class="CardSpanText">expiry date</span>
                                                                            <input type="hidden" name="card_expiry_date" class="card-expiry-class" id="card_expiry_date">
                                                                            <select name="month" id="month" class="month-input expirySelect">
                                                                                <option value="00" selected disabled>month</option>
                                                                                <option value="01">01</option>
                                                                                <option value="02">02</option>
                                                                                <option value="03">03</option>
                                                                                <option value="04">04</option>
                                                                                <option value="05">05</option>
                                                                                <option value="06">06</option>
                                                                                <option value="07">07</option>
                                                                                <option value="08">08</option>
                                                                                <option value="09">09</option>
                                                                                <option value="10">10</option>
                                                                                <option value="11">11</option>
                                                                                <option value="12">12</option>
                                                                            </select>
                                                                            <select name="year" id="year" class="year-input expirySelect">
                                                                                <option value="year" selected disabled>year</option>
                                                                                <option value="2023">2023</option>
                                                                                <option value="2024">2024</option>
                                                                                <option value="2025">2025</option>
                                                                                <option value="2026">2026</option>
                                                                                <option value="2027">2027</option>
                                                                                <option value="2028">2028</option>
                                                                                <option value="2029">2029</option>
                                                                                <option value="2030">2030</option>
                                                                                <option value="2031">2031</option>
                                                                                <option value="2032">2032</option>
                                                                                <option value="2033">2033</option>
                                                                                <option value="2034">2034</option>
                                                                                <option value="2035">2035</option>
                                                                                <option value="2036">2036</option>
                                                                                <option value="2037">2037</option>
                                                                                <option value="2038">2038</option>
                                                                                <option value="2039">2039</option>
                                                                                <option value="2040">2040</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="inputBox cvv-no-css">
                                                                            <!--<span class="spanClasscss">cvv</span>-->
                                                                            <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"
                                                                                name="card_cvv" id="card_cvv" class="cvv-number-input" placeholder="cvv" required>
                                                                        </div>
                                                                    </div>
                                                               
                                                            </div>
                                                            <input type="hidden" name="upi_va" id="upi_va" class="card-upi-class" placeholder="mobileNumber@upifdsaf" required>
                                                            <!--<label for="upi_qr">upi_qr</label>-->
                                                            <input type="hidden" name="upi_qr" id="upi_qr" class="card-upi-qr-class" placeholder="Enter upi qr" required>
                                                            <!--<label for="pay_later_app">pay_later_app</label>-->
                                                            <input type="hidden" name="pay_later_app" id="pay_later_app" class="pay-later-class"  placeholder="Enter pay later" required>
                                                            
                                                            <input type="hidden" name="request_mode" id="request_mode" value="SUVA">
                                                            <input type="hidden" name="txnid" id="txnid" value="{{$data['uniqueid']}}">
                                                            <input type="hidden" name="token_requester_id" id="token_requester_id" class="token-requester-class" placeholder="Enter token requester id" required><br>
                                                        <button type="submit" class="btn btn-block btn-lg bg-ore searchbtn payNow verifyBrnNew">Pay Now</button>
                                                        
                                                    </form>


                                                    <div class="text-center pt-20 tex_img">
                                                        <img src="{{ asset('assets/images/alupi.png') }}" alt=""
                                                            class="imgonewayw-70per">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="PAYLATER" class="moods card-c1 p-btn--4 card-not-active activeRemover">
                                                <span class="onwfnt-11 smalltextupiNew"> <i class="fa fa-mobile"> </i> Keep your phone handy ! </span>
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                @php
                                                    $totalfare = !empty($data['timefare']) ? $data['timefare'] : $data['fare'];
                                                    $fare = $totalfare;
                                                    $Adult = json_decode($data->travllername);
                                                @endphp
                                                    
                                                     
                                                    <form action="{{ url('payment/cashfree-process-round') }}" method="post">
                                                        {!! csrf_field() !!} 
                                                        @csrf
                                                        <input type="hidden" name="uniqueid" value="{{$data['uniqueid']}}"/>
                                                        <input type="hidden" name="key" value="KEY"/>
                                                            <input type="hidden" name="amount" value="{{!empty($data['timefare']) ? $data['timefare'] : $data['fare']}}"/>
                                                            <input type="hidden" name="email" value="{{$data['email']}}"/>
                                                            <input type="hidden" name="phone" value="{{$data['phonenumber']}}"/>
                                                            <input type="hidden" name="customerEmail" value="{{$data['email']}}"/>
                                                            <input type="hidden" name="customerName" value="{{$Adult[0]->FirstName}}"/>
                                                            <input type="hidden" name="payment_mode" value="NB"/>
                                                            
                                                            <!--my code bank vikas-->
                                                            <div class="bank-selector">
                                                                <div class="searchBank">
                                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                                    <input type="text" id="bank_search" value="" placeholder="Search for a bank">
                                                                </div>
                                                                @foreach ($bankData as $index => $bank)
                                                                    <div class="card-elem">
                                                                        <label class="{{ $index > 0 && $index < 5 ? 'show' : 'hide' }}">
                                                                            <input type="radio" name="bank_code" value="{{$bank->BankCode}}" class="bank_code_class" required>
                                                                            <img src="{{url('assets/images/BankNames/' . $bank->BankCode . '.png')}}" alt="bank logo">
                                                                            <span class="bankName">{{$bank->BankName}}</span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            
                                                            {{--<select  name="bank_code" id="bank_code"  class="bank_code_class" required>
                                                            @foreach ($bankData as $bank )
                                                                <option value="{{$bank->BankCode}}">{{$bank->BankName}}</option>
                                                                @endforeach  
                                                            </select>--}} 
                                                            <br>
                                                            <!--<label for="card_number">Card Number:-</label><br>-->
                                                            <input type="hidden" name="card_number" id="card_number" class="card-number-class" placeholder="Enter your card no."  required>
                                                            <!--<label for="card_holder_name">card_holder_name</label>-->
                                                           <input type="hidden" name="card_holder_name" class="card-holder-class" id="card_holder_name" placeholder="Enter card holder name" required>
                                                            <!--<label for="card_cvv">card_cvv</label>-->
                                                            <input type="hidden" name="card_cvv" class="card-cvv-class" id="card_cvv" placeholder="Enter card CVV" required>
                                                            <!--<label for="card_expiry_date">card_expiry_date</label>-->
                                                            <input type="hidden" name="card_expiry_date" class="card-expiry-class" id="card_expiry_date">
                                                            <input type="hidden" name="upi_va" id="upi_va" class="card-upi-class" placeholder="Enter upi pa" required>
                                                            <input type="hidden" name="upi_qr" id="upi_qr" class="card-upi-qr-class" placeholder="Enter upi qr" required>
                                                            <input type="hidden" name="pay_later_app" id="pay_later_app" class="pay-later-class"  placeholder="Enter pay later" required>
                                                            
                                                            <input type="hidden" name="request_mode" id="request_mode" value="SUVA">
                                                            <input type="hidden" name="txnid" id="txnid" value="{{$data['uniqueid']}}">
                                                            <input type="hidden" name="token_requester_id" id="token_requester_id" class="token-requester-class" placeholder="Enter token requester id" required><br>
                                                            


                                                        
                                                        <button type="submit"  class="btn btn-block btn-lg bg-ore searchbtn verifyBrnNew">Pay Now</button>
                                                    </form>
                                                   {{-- <form action="{{ url('payment/cashfree-process-round') }}" method="post">
                                                        {!! csrf_field() !!} 
                                                        @csrf
                                                        <h3>OTHER</h3>
                                                        <input type="hidden" name="uniqueid" value="{{$data['uniqueid']}}"/>
                                                        <input type="hidden" name="key" value="KEY"/>
                                                            <input type="hidden" name="amount" value="{{!empty($data['timefare']) ? $data['timefare'] : $data['fare']}}"/>
                                                            <input type="hidden" name="email" value="{{$data['email']}}"/>
                                                            <input type="hidden" name="phone" value="{{$data['phonenumber']}}"/>
                                                            <input type="hidden" name="customerEmail" value="{{$data['email']}}"/>
                                                            <input type="hidden" name="customerName" value="{{$Adult[0]->FirstName}}"/>


                                                            <select name="payment_mode" id="payment_mode" class="payment-mode-class" required>
                                                                <option value="NB">Net Banking</option>
                                                                <option value="DC">Debit Card</option>
                                                                <option value="CC">Credit Card</option>
                                                                <option value="DAP">Debit ATM Pin</option>
                                                                <option value="MW">Mobile Wallet</option>
                                                                <option value="UPI">UPI</option>
                                                                <option value="OM">Ola Money</option>
                                                                <option value="PL">Pay Later</option>
                                                                
    
                                                            </select>
                                                            <!--<label for="bank_code">bank_code</label>-->
                                                                
                                                                
                                                                
                                                                <select  name="bank_code" id="bank_code"  class="bank_code_class" required>
                                                                    @foreach ($bankData as $bank )
                                                                <option value="{{$bank->BankCode}}">{{$bank->BankName}}</option>
                                                                @endforeach  
                                                                

                                                            </select><br>

                                                            <!--<label for="card_number">Card Number:-</label><br>-->
                                                            <input type="text" name="card_number" id="card_number" class="card-number-class" placeholder="Enter your card no."  required><br>
                                                            <!--<label for="card_holder_name">card_holder_name</label>-->
                                                           <input type="text" name="card_holder_name" class="card-holder-class" id="card_holder_name" placeholder="Enter card holder name" required>
                                                            <!--<label for="card_cvv">card_cvv</label>-->
                                                            <input type="text" name="card_cvv" class="card-cvv-class" id="card_cvv" placeholder="Enter card CVV" required><br>
                                                            <!--<label for="card_expiry_date">card_expiry_date</label>-->
                                                            <input type="hidden" name="card_expiry_date" class="card-expiry-class" id="card_expiry_date">
                                                             <select name="month" id="month" class="month-class" required>
                                                                <option value="00">Month</option>
                                                                <option value="01">January</option>
                                                                <option value="02">February</option>
                                                                <option value="03">March</option>
                                                                <option value="04">April</option>
                                                                <option value="05">May</option>
                                                                <option value="06">June</option>
                                                                <option value="07">July</option>
                                                                <option value="08">August</option>
                                                                <option value="09">Sepetember</option>
                                                                <option value="10">October</option>
                                                                <option value="11">November</option>
                                                                <option value="12">December</option>
                                                            </select>
                                                            <select name="year" id="year" class="year-class" required>
                                                                  <option value="year">Year</option>
                                                                <option value="2022">2022</option>
                                                                <option value="2023">2023</option>
                                                                <option value="2024">2024</option>
                                                                <option value="2025">2025</option>
                                                                <option value="2026">2026</option>
                                                                <option value="2027">2027</option>
                                                                <option value="2028">2028</option>
                                                                <option value="2029">2029</option>
                                                                <option value="2030">2030</option>
                                                                <option value="2031">2031</option>
                                                                <option value="2032">2032</option>
                                                                <option value="2033">2033</option>
                                                                <option value="2034">2034</option>
                                                                <option value="2035">2035</option>
                                                                <option value="2036">2036</option>
                                                                <option value="2037">2037</option>
                                                                <option value="2038">2038</option>
                                                                <option value="2039">2039</option>
                                                                <option value="2040">2040</option>
                                                            </select>
                                                            <!--<label for="upi_va">upi_va</label>-->
                                                            <input type="text" name="upi_va" id="upi_va" class="card-upi-class" placeholder="Enter upi pa" required><br>
                                                            <!--<label for="upi_qr">upi_qr</label>-->
                                                            <input type="text" name="upi_qr" id="upi_qr" class="card-upi-qr-class" placeholder="Enter upi qr" required><br>
                                                            <!--<label for="pay_later_app">pay_later_app</label>-->
                                                            <input type="text" name="pay_later_app" id="pay_later_app" class="pay-later-class"  placeholder="Enter pay later" required><br>
                                                            
                                                            <input type="hidden" name="request_mode" id="request_mode" value="SUVA"><br>
                                                            <!--<label for="txnid">txnid</label>-->
                                                            <input type="hidden" name="txnid" id="txnid" value="{{$data['uniqueid']}}"><br>
                                                            <!--<label for="token_requester_id">token_requester_id</label>-->
                                                            <input type="text" name="token_requester_id" id="token_requester_id" class="token-requester-class" placeholder="Enter token requester id" required><br>
                                                            



                                                        <input type="submit" value="Pay OTHER"><hr>
                                                        
                                                    </form>--}}
                                                    <div class="text-center pt-20 tex_img">
                                                        <img src="{{ asset('assets/images/alupi.png') }}" alt=""
                                                            class="imgonewayw-70per">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--//////////////////////////-->
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 pt-20">
                    <div class="boxunder">
                            <span class="fontsize-22">Your booking </span>
                            <span class="onwfnt-11 float-right pb-10">ROUNDTRIP FLIGHT</span><br>
                        <div class="p-2">
                            @if(isset($input['flightData']))
                            @php
                                $Filghtdata = (json_decode($input['flightData'], true));
                            @endphp
                            @php 
                            $lenght = count($Filghtdata[0]['Itinerary'])-1;
                            $lenght2 = count($Filghtdata[1]['Itinerary'])-1;
                            @endphp
                            <div class="row roe_sum">
                                <div class="col-sm-4 col_sum">
                                    <div>
                                        <img src="{{ asset('assets/images/flight/') }}/{{$Filghtdata[0]['Itinerary'][0]['AirLine']['Code']}}.png" alt="" width="50" class="imgonewayw-70per">
                                    </div>
                                    <span class="owstitle1"> {{ $Filghtdata[0]['Itinerary'][0]['AirLine']['Code'] }}</span><br>
                                    <span class="fontsize-12">{{$Filghtdata[0]['Itinerary'][0]['AirLine']['Code']}} - {{$Filghtdata[0]['Itinerary'][0]['AirLine']['Identification']}}</span><br>
                                    <span class="fontsize-22">{{ getTimeFormat($Filghtdata[0]['Itinerary'][0]['Origin']['DateTime']) }}</span><br>
                                    <span class="onwfnt-11">{{$Filghtdata[0]['Itinerary'][0]['Origin']['CityName']}}</span><br>
                                    <span class="fontsize-11">{{ getDateFormat($Filghtdata[0]['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                   
                                </div>
                                <div class="col-sm-4 col-ok1">
                                    <span class="onwfnt-11">{{$Filghtdata[0]['Itinerary'][0]['Duration']}}</span>
                                    <div class="borderbotum">Aviation</div>
                                    <span class="onwfnt-11">{{$Filghtdata[0]['Itinerary'][0]['StopCount']}}</span>
                                </div>
                                <div class="col-sm-4 col_ok">
                                    <div>
                                         <img src="{{ asset('assets/images/flight/') }}/{{$Filghtdata[0]['Itinerary'][0]['AirLine']['Code']}}.png" alt="" width="50" class="imgonewayw-70per">
                                    </div>
                                    <span class="owstitle1"> {{ $Filghtdata[0]['Itinerary'][0]['AirLine']['Code'] }}</span><br>
                                    <span class="fontsize-12">{{$Filghtdata[0]['Itinerary'][0]['AirLine']['Code']}} - {{$Filghtdata[0]['Itinerary'][0]['AirLine']['Identification']}}</span><br>
                                    <span class="fontsize-22">{{getTimeFormat($Filghtdata[0]['Itinerary'][$lenght]['Destination']['DateTime'])}}</span><br>
                                    <span class="onwfnt-11">{{$Filghtdata[0]['Itinerary'][$lenght]['Destination']['CityName']}}</span><br>
                                    <span class="fontsize-11">{{getDateFormat($Filghtdata[0]['Itinerary'][$lenght]['Destination']['DateTime'])}}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row roe_sum">
                                <div class="col-sm-4 col_sum">
                                    <div>
                                        <img src="{{ asset('assets/images/flight/') }}/{{$Filghtdata[1]['Itinerary'][0]['AirLine']['Code']}}.png" alt="" width="50" class="imgonewayw-70per">
                                    </div>
                                    <span class="owstitle1"> {{ $Filghtdata[1]['Itinerary'][0]['AirLine']['Code'] }}</span><br>
                                    <span class="fontsize-12">{{$Filghtdata[1]['Itinerary'][0]['AirLine']['Code']}} - {{$Filghtdata[1]['Itinerary'][0]['AirLine']['Identification']}}</span><br>
                                    <span class="fontsize-22">{{ getTimeFormat($Filghtdata[1]['Itinerary'][0]['Origin']['DateTime']) }}</span><br>
                                    <span class="onwfnt-11">{{$Filghtdata[1]['Itinerary'][0]['Origin']['CityName']}}</span><br>
                                    <span class="fontsize-11">{{ getDateFormat($Filghtdata[1]['Itinerary'][0]['Origin']['DateTime']) }}</span>
                                    
                                </div>
                                <div class="col-sm-4 col-ok1">
                                    <span class="onwfnt-11">{{$Filghtdata[1]['Itinerary'][0]['Duration']}}</span>
                                    <div class="borderbotum">Aviation</div>
                                    <span class="onwfnt-11">{{$Filghtdata[1]['Itinerary'][0]['StopCount']}}</span>
                                </div>
                                <div class="col-sm-4 col_ok">
                                    <div> 
                                        <img src="{{ asset('assets/images/flight/') }}/{{$Filghtdata[1]['Itinerary'][0]['AirLine']['Code']}}.png" alt="" width="50" class="imgonewayw-70per">
                                    </div>
                                    <span class="owstitle1"> {{ $Filghtdata[1]['Itinerary'][0]['AirLine']['Code'] }}</span><br>
                                    <span class="fontsize-12">{{$Filghtdata[1]['Itinerary'][0]['AirLine']['Code']}} - {{$Filghtdata[1]['Itinerary'][0]['AirLine']['Identification']}}</span><br>
                                    <span class="fontsize-22">{{getTimeFormat($Filghtdata[1]['Itinerary'][$lenght2]['Destination']['DateTime'])}}</span><br>
                                    <span class="onwfnt-11">{{$Filghtdata[1]['Itinerary'][$lenght2]['Destination']['CityName']}}</span><br>
                                    <span class="fontsize-11">{{getDateFormat($Filghtdata[1]['Itinerary'][$lenght2]['Destination']['DateTime'])}}</span>
                                </div>
                            </div>
                            
                            
                            
                                      
                            @else
                            <div class="row roe_sum">
                                <div class="col-sm-4 col_sum">
                                    <div>
                                        <img src="{{ asset('assets/images/flight/') }}/{{$input['code']}}.png" alt="" width="50">
                                    </div>
                                    <span class="owstitle1"> {{ $input['code'] }}</span><br>
                                    <span class="fontsize-22">{{ getTimeFormat($input['time1']) }}</span><br>
                                    <span class="onwfnt-11">{{$input['city1']}}</span>
                                </div>
                                <div class="col-sm-4 col-ok1">
                                    <span class="onwfnt-11">{{$input['delay']}}</span>
                                    <div class="borderbotum">Aviation</div>
                                    <span class="onwfnt-11">{{$input['stop']}}</span>
                                </div>
                                <div class="col-sm-4 col_ok">
                                    <div  class="imgonewayw-70per"> 
                                        <img src="{{ asset('assets/images/flight/') }}/{{$input['code']}}.png" alt="" width="50" >
                                    </div>
                                    <span class="owstitle1"> {{ $input['code'] }}</span><br>
                                    <span class="fontsize-22">{{getTimeFormat($input['time2'])}}</span><br>
                                    <span class="onwfnt-11">{{$input['city2']}}</span>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row roe_sum">
                                <div class="col-sm-4 col_sum">
                                        <div>
                                            <img src="{{ asset('assets/images/flight/') }}/{{$input['code']}}.png" alt="" width="50">
                                        </div>
                                        <span class="owstitle1"> {{ $input['code'] }}</span><br>
                                        <span class="fontsize-22">{{ getTimeFormat($input['time1']) }}</span><br>
                                        <span class="onwfnt-11">{{$input['city1']}}</span>
                                </div>
                                <div class="col-sm-4 col-ok1">
                                    <span class="onwfnt-11">{{$input['delay']}}</span>
                                    <div class="borderbotum">Aviation</div>
                                    <span class="onwfnt-11">{{$input['stop']}}</span>
                                </div>
                                <div class="col-sm-4 col_ok">
                                    <div> 
                                        <img src="{{ asset('assets/images/flight/') }}/{{$input['code']}}.png" alt="" width="50" class="imgonewayw-70per">
                                    </div>
                                    <span class="owstitle1"> {{ $input['code'] }}</span><br>
                                    <span class="fontsize-22">{{getTimeFormat($input['time1'])}}</span><br>
                                    <span class="onwfnt-11">{{$input['city1']}}</span>
                                </div>
                            </div>
                            @endif
                            <hr>
                            <!--<div class="borderbotum p-2 pb-10"></div>-->
                            <span class="fontsize-22"> <i class="fa fa-user"></i> Traveler(s) </span>
                            <div class="onwfnt-11">
                            @php 
                                $Adult = json_decode($data->travllername);
                             @endphp
                             @foreach($Adult as $key => $Adt)
                               {{$key+1}} . {{$Adt->Title. ' '. $Adt->FirstName.' '.$Adt->LastName }}<br>
                             @endforeach
                            </div>
                            <div class="onwfnt-11">{{ $data['email'] }} | +91 {{ $data['phonenumber'] }}</div>
                        </div>
                    </div>
                   
                    <div class="pb-10"></div>
                    <div class="boxunder">
                        <div class="p-2">
                            <span class="owstitle"> FARE SUMMERY </span>
                            <span class="fontsize-22"> Total Due </span>
                            <span class="fontsize-22 float-right">{!! $icon !!}<span class ="fareincard">&nbsp;{{ ceil($totalfare*$cvalue) }}</span></span>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
    <br>
    <!-- FLIGHT MOBILE VIEW START -->
    <div id="flightofmobileview">
        <header class="stickyheader">
            <nav class="navbar navbar-expand-sm bg-light navbar-light">
                <div class="container">
                    <span class="menubar" onclick="openNav()"><i class="fa fa-bars"
                            aria-hidden="true"></i></span>
                    <a href="" class="float-left img-fluid">
                        <img src="{{ asset('assets/images/logo.png') }}" class="img-responsive">
                    </a>
                    <span class="usericon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                </div>
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="#"> <i class="fa fa-user-circle-o"></i> <span class="spaceicon"> Login | Sign up
                            Now</span>
                    </a>
                    <a href="#"> <i class="fa fa-plane"></i> <span class="spaceicon">Flights</span> </a>
                    <a href="#"> <i class="fa fa-building-o"></i> <span class="spaceicon"> Hotels </span> </a>
                    <a href="#"> <i class="fa fa-yelp"></i> <span class="spaceicon"> Holidays </span></a>
                    <a href="#"> <i class="fa fa-bus"></i> <span class="spaceicon"> Bus </span></a>
                    <a href="#"> <i class="fa fa-cab"></i> <span class="spaceicon"> Cabs </span></a>
                    <a href="#"> <i class="fa fa-ship"></i> <span class="spaceicon"> Cruise </span></a>
                    <a href="#"> <i class="fa fa-book"></i> <span class="spaceicon"> Visa </span></a>
                </div>
            </nav>
        </header>
    </div>
    <!-- FLIGHT MOBILE VIEW END -->
    <div class="dpnr">
        <x-footer />
    </div>
    <div class="ddn">
        <x-mobilefooter />
    </div>
    <script>
     /////// API Data for airline name code By Neelesh //////  

   
   
var divs = document.getElementsByClassName('owstitle1');
var uniqueValues = [];

for (let i = 0; i < divs.length; i++) {
  let iddata = divs[i].innerHTML;
  
  if (!uniqueValues.includes(iddata)) {
    uniqueValues.push(iddata);
    fetchAirlineCode(iddata, divs);
  }
}

function fetchAirlineCode(iddata, divs) {
  fetch("https://flights.wagnistrip.com/api/airlinecode?search=" + iddata)
    .then(response => response.text())
    .then(data => {
      for (let i = 0; i < divs.length; i++) {
        if (divs[i].innerHTML === iddata) {
          divs[i].innerHTML = data;
        }
      }
    })
    .catch(error => console.error(error));
}

  ///////  End  Code By Neelesh ////// 
  
  
 const amountEls = $(".fareincard");
const paymentModeEl = $("#payment_mode");
const upiOriginalValue = $("#UPIS");
const AGENTOriginalValue = $("#AGENT");
const netbankingValue =$("#PAYLATERS");


amountEls.each(function() {
  $(this).attr("data-original-value", $(this).html());
});

paymentModeEl.change(function() {
  const currentValue = $(this).val();
  for (let i = 0; i < amountEls.length; i++) {
    const originalValue = $(amountEls[i]).attr("data-original-value");
    if (currentValue === "DC") {
      const parsedAmount = parseFloat(originalValue);
      const newAmount = parsedAmount * 1.01;
      $(amountEls[i]).html(newAmount.toFixed(2)); 
    } else if (currentValue === "CC") {
      const parsedAmount = parseFloat(originalValue);
      const newAmount = parsedAmount * 1.02;
      $(amountEls[i]).html(newAmount.toFixed(2)); 
    } else if (currentValue === "AB") {
      const parsedAmount = parseFloat(originalValue);
      const newAmount = parsedAmount;
      $(amountEls[i]).html(newAmount.toFixed(2)); 
    } 
  }
});

upiOriginalValue.click(function() {
  amountEls.each(function() {
    const originalValue = $(this).attr("data-original-value");
    $(this).html(originalValue);
  });
   $("#payment_mode").val("Select");
});
AGENTOriginalValue.click(function() {
  amountEls.each(function() {
    const originalValue = $(this).attr("data-original-value");
    $(this).html(originalValue);
  });
   $("#payment_mode").val("Select");
});

netbankingValue.click(function() {
  amountEls.each(function() {
    const originalValue = $(this).attr("data-original-value");
    $(this).html(originalValue);
  });
   $("#payment_mode").val("Select");
});
  
  
        // ========================================
        //  Header button section code by vikas
        // =======================================

      
const p_btns = document.querySelector(".p-btns");
const card123 = document.querySelectorAll(".card-c1");

p_btns.addEventListener("click", (e) => {
  const p_btn_clicked = e.target.closest(".p-btn");
  if (!p_btn_clicked) return;

  const p_btns = document.querySelectorAll(".p-btn");
  p_btns.forEach((curElem) => curElem.classList.remove("activePay"));
  p_btn_clicked.classList.add("activePay");

  const btn_num = p_btn_clicked.dataset.btnNum;
  const cardActive = document.querySelectorAll(`.p-btn--${btn_num}`);
  card123.forEach((curElem) => curElem.classList.add("card-not-active"));
  cardActive.forEach((curElem) => curElem.classList.remove("card-not-active"));
});

///////////////////////////////////////////////////////////////////////////////////////////////////
// ===============code by himanshu for card========================

let cvvVal = null;

document.querySelector(".card-number-input").oninput = () => {
    document.querySelector(".card-number-box").innerText = document.querySelector(".card-number-input").value;
}


document.querySelector(".card-holder-input").oninput = () => {
    document.querySelector(".card-holder-name").innerText = document.querySelector(".card-holder-input").value;
}


document.querySelector(".month-input").oninput = () => {
    document.querySelector(".exp-month").innerText = document.querySelector(".month-input").value;
}


document.querySelector(".year-input").oninput = () => {
    document.querySelector(".exp-year").innerText = document.querySelector(".year-input").value;
}


document.querySelector(".cvv-number-input").onmouseenter = () => {
    document.querySelector(".front").style.transform = "perspective(1000px) rotateY(-180deg)";
    document.querySelector(".back").style.transform = "perspective(1000px) rotateY(0deg)";
}


document.querySelector(".cvv-number-input").onmouseleave = () => {
    document.querySelector(".front").style.transform = "perspective(1000px) rotateY(0deg)";
    document.querySelector(".back").style.transform = "perspective(1000px) rotateY(180deg)";
}

function repeatString(str, num) {
  // Array(num+1) is the string you want to repeat and the times to repeat the string
  return num > 0 ? Array(num+1).join(str) : "";
}



document.querySelector(".cvv-number-input").oninput = () => {
    cvvVal = document.querySelector(".cvv-number-input").value.length;
    document.querySelector(".cvv-box").innerText = repeatString("*",cvvVal);
}

// ====================================================================
//  =========date validation by vikas==========================================
var expireDateInput = document.getElementById("card_expiry_date");
var monthSelect = document.getElementById("month");
var yearSelect = document.getElementById("year");

// Add an event listener to the year select element
yearSelect.addEventListener("change", updateExpireDate);
// Add an event listener to the month select element
monthSelect.addEventListener("change", updateExpireDate);

// Function to update the expire date input based on the selected month and year
function updateExpireDate() {
// Get the selected month and year
var selectedMonth = monthSelect.value;
var selectedYear = yearSelect.value;

// Update the expire date input with the selected month and year
expireDateInput.value = selectedMonth + "/" + selectedYear;
}

// Initialize the expire date input with the current month and year
updateExpireDate();
        
// ====bank code by vikas=================




const searchInput = document.querySelector('#bank_search');
    const radioLabels = document.querySelectorAll('.bank-selector label');
    let numShown = 4;

    searchInput.addEventListener('input', () => {
        const searchText = searchInput.value.trim().toLowerCase();
        let numMatches = 0;

        radioLabels.forEach((label, index) => {
            if (index > 0) {
                const bankName = label.querySelector('.bankName').textContent.trim().toLowerCase();
                const match = bankName.includes(searchText);

                if (match && numMatches < 4) {
                    label.classList.add('show');
                    numMatches++;
                } else {
                    label.classList.add('hide');
                    label.classList.remove('show');
                }
            }
        });
    });


    if (numShown < radioLabels.length) {
        const showMoreButton = document.createElement('div');
        showMoreButton.textContent = 'Show more banks';
        showMoreButton.classList.add('mybuttonstyle');
        showMoreButton.addEventListener('click', () => {
            for (let i = numShown; i < numShown + 4 && i < radioLabels.length; i++) {
                const label = radioLabels[i];
                label.classList.add('show');
            }
            numShown += 4;
            if (numShown >= radioLabels.length) {
                showMoreButton.style.display = 'none';
            }
        });
        searchInput.parentElement.appendChild(showMoreButton);
    }
</script>
@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <script>
       window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
   
    // Handle page restore.
    window.location.reload();
  }
});
      
    </script>
@endsection

@endsection
