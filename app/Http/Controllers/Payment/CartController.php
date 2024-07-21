<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\DB;
use App\Http\Controllers\Airline\Galileo\AuthenticateController;
use App\Models\Agent\Agent;
use App\Http\Controllers\Agent\Booking\Amadues\PNR_AddMultiElementsController;
use App\Http\Controllers\Agent\Booking\Galelio\TicketingController;
use App\Http\Controllers\Agent\Booking\Mix\BookingController;
use App\Http\Controllers\Agent\Booking\Amadues\DomesticPnrAddMultiElementsController;
// use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Session;
use App\Models\CheckTime;
use App\Models\VisitorGeolocation;
use App\Models\PaymentSaveGalelioRoundTrip;
use App\Models\PaypalRedirector;
// use Srmklive\PayPal\Services\ExpressCheckout;
// use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function paymentSave(Request $request)
    {
        $input = $request->all();

        $amount_orignal =  session('total_fare');
        $amount = CheckTime::checktimeandpricing($amount_orignal);
        $input['fare'] = $amount;
        // if($input['Chari'] != "no"){
        //     $input['fare']+=10;
        // }
        // if($input['textDis'] != "no"){
        //     $input['fare']-=50;
        // }
        // dd($amount, $input);
        $otherInformations = json_decode($request['otherInformations'], true);

        $flightdata = [
            'marketingCompany_1' => $otherInformations['marketingCompany_1'] ?? $otherInformations['otherInfoOutbound']['marketingCompany_1'] ?? $otherInformations['otherInfoInbound']['marketingCompany_1'] ?? null,
            'marketingCompany_2' => $otherInformations['marketingCompany_2'] ?? $otherInformations['otherInfoOutbound']['marketingCompany_2'] ?? null,
            'marketingCompany_3' => $otherInformations['marketingCompany_3'] ?? $otherInformations['otherInfoOutbound']['marketingCompany_3'] ?? null,
        ];
        // dd($request->all());
        $travller = [
            'adults' => [
                'title' => $request['adultTitle'] ?? null,
                'fistName' => $request['adultFirstName'],
                'lastName' => $request['adultLastName'],
                'adultNationality' => $request['adultNationality'] ?? null,
                'adultDOB' => $request['adultDOB'] ?? null,
                'adultPassportNo' => $request['adultPassportNo'] ?? null,
            ],
            'childs' => [
                'title' => $request['childTitle'] ?? null,
                'fistName' => $request['childFirstName'] ?? null,
                'lastName' => $request['childLastName'] ?? null,
                'childNationality' => $request['childNationality'] ?? null,
                'childDOB' => $request['childDOB'] ?? null,
                'childPassportNo' => $request['childPassportNo'] ?? null,
            ],
            'infants' => [
                'title' => $request['infantTitle'] ?? null,
                'fistName' => $request['infantFirstName'] ?? null,
                'lastName' => $request['infantLastName'] ?? null,
                'infantDOB' => $request['infantDOB'] ?? null,
                'infantNationality' => $request['infantNationality'] ?? null,
                'infantPassportNo' => $request['infantPassportNo'] ?? null,
            ],
        ];

        $getsessions = json_decode($request->getsessions, true);
        if (isset($getsessions['sessionOutbound'])) {
            $newSession = $getsessions['sessionOutbound']['sessionId'];
        } else {
            $newSession = $getsessions['sessionId'];
        }
        $uniqueid = "WTAMD" . $newSession;
        $trip = $request['trip'];
        $data = ['uniqueid' => $uniqueid, 'fare' => $input['fare']];
        $sDetail = new Cart;
        $sDetail->travellerquantity = json_encode(['travellers'], true);
        $sDetail->getsession = $request->getsessions;
        $sDetail->otherInformation = $request->otherInformations;
        $sDetail->fare = $amount_orignal;
        $sDetail->timefare  = $amount;
        $sDetail->travllername = json_encode($travller, true);
        $sDetail->phonenumber = $request->phoneNumber;
        $sDetail->email = $request->email;
        $sDetail->uniqueid = $uniqueid;
        $sDetail->save();
        $bankData = DB::table('buzzbankcode')->get();
        // dd($data ,  $trip);
        // $requsData = ['adultFirstName' =>[
        //     $request['email'],
        //         ],
        //      ];
        //   dd($request['email'], $sDetail['email']);
        $url = [
            'furl' => 'flight/payment',
            'surl' => 'flight/payment',
        ];
        //   dd($flightdata ,$input  ,$otherInformations);
        $pricing = VisitorGeolocation::geolocationInfo();
        $cvalue = !empty($pricing['value']) ? $pricing['value'] : 1;    // conversion rate
        $code = !empty($pricing['code'][0]) ? $pricing['code'][0] : 'INR';

        $payment_option = DB::table('payment_gateway_options')
            ->where('status', 1)
            ->first();
        if (!empty($payment_option)) {
            if ($payment_option->name == 'Paypal') {
                if ($trip == 'DomesticRoundTrip') {
                    $payment_url = PaypalRedirector::getredirection($data['fare'], $data['uniqueid'], 'DomesticRoundTripAmedeus');
                } elseif ($trip == 'Oneway') {
                    $payment_url = PaypalRedirector::getredirection($data['fare'], $data['uniqueid'], 'onewayAmedeus');
                } else {
                    $payment_url = '';
                }
                if (!empty($payment_url)) {
                    $redirect = $payment_url;
                    return view('payment', compact('data', 'trip', 'travller', 'sDetail', 'flightdata', 'input', 'url', 'bankData', 'otherInformations', 'redirect', 'code', 'cvalue'));
                    // return redirect($payment_url);
                } else {
                    return view('payment', compact('data', 'trip', 'travller', 'sDetail', 'flightdata', 'input', 'url', 'bankData', 'otherInformations', 'code', 'cvalue'));
                }
            } else {
                return view('payment', compact('data', 'trip', 'travller', 'sDetail', 'flightdata', 'input', 'url', 'bankData', 'otherInformations', 'code', 'cvalue'));
            }
        } else {
            return view('payment', compact('data', 'trip', 'travller', 'sDetail', 'flightdata', 'input', 'url', 'bankData', 'otherInformations', 'code', 'cvalue'));
        }
    }

    public function paymentStatus()
    {
        return view('payment');
    }


    public function BuzzSaveGalelioRoundTrip(Request $request)
    {
        $input = $request->all();
        $data =  session('total_fare');
        $data_new = CheckTime::checktimeandpricing($data);
        if (isset($input['showprice'])) {
            $showprice = $input['showprice'];
        } else {
            $showprice = "unchecked";
        }
        $DcAmount = $CcAmount = '';
        if ($input['payment_mode'] == "DC") {
            $DcAmount = (($data * 1) / 100);
            $data += $DcAmount;
        } elseif ($input['payment_mode'] == "CC") {
            $CcAmount = (($data * 2) / 100);
            $data += $CcAmount;
        }

        $postData = array(
            "key" => 'FW09Z922O6',
            "txnid" => $input['txnid'],
            "amount" => $data_new,
            "productinfo" => 'flight ticket',
            "firstname" => $request['customerName'],
            "email" => $request['customerEmail'],
            "udf1" => $request['udf1'],
            "udf2" => '',
            "udf3" => '',
            "udf4" => '',
            "udf5" => '',
            "udf6" => '',
            "udf7" => '',
            "udf8" => '',
            "udf9" => '',
            "udf10" => '',
            'request_flow' => 'SEAMLESS',
        );
        $phone = $request['customerPhone'];

        $SALT = '734VHA2I97';
        $MERCHANT_KEY = 'FW09Z922O6';
        $BuzzData = [
            'key' => 'FW09Z922O6',
            'salt' => '734VHA2I97',
        ];
        $surl = url($input['surl']);
        $furl = url($input['furl']);

        // $amount = number_format((float)$input['amount'], 1, '.', '');
        $amount_orignal = session('total_fare') ?? $input['amount'];
        $amount = CheckTime::checktimeandpricing($amount_orignal);
        $hash_sequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

        // make an array or split into array base on pipe sign.
        $hash_sequence_array = explode('|', $hash_sequence);
        $hash = null;
        // prepare a string based on hash sequence from the $params array.
        foreach ($hash_sequence_array as $value) {
            $hash .= isset($postData[$value]) ? $postData[$value] : '';
            $hash .= '|';
        }
        $hash .= '734VHA2I97';
        $signatureBuzzHash = strtolower(hash('sha512', $hash));
        //////////////////////////////////////////////////////
        //////////////////////////////////////////////////////
        $cURL = curl_init();

        // Set multiple options for a cURL transfer.
        curl_setopt_array(
            $cURL,
            array(
                CURLOPT_URL => 'https://pay.easebuzz.in/payment/initiateLink',
                CURLOPT_POSTFIELDS =>  'key=FW09Z922O6&txnid=' . $postData["txnid"] . '&amount=' . $postData["amount"] . '&productinfo=' . $postData["productinfo"] . '&firstname=' . $postData["firstname"] . '&email=' . $postData["email"] . '&udf1=' . $request['udf1'] . '&udf2=&udf3=&udf4=&udf5=&udf6=&udf7=&udf8=&udf9=&udf10=&hash=' . $signatureBuzzHash . '&phone=' . $phone . '&surl=' . $surl . '&furl=' . $furl . '&request_flow=SEAMLESS',
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36',
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            )
        );

        // Perform a cURL session
        $result = curl_exec($cURL);

        // check there is any error or not in curl execution.
        if (curl_errno($cURL)) {
            $cURL_error = curl_error($cURL);
            if (empty($cURL_error))
                $cURL_error = 'Server Error';

            return array(
                'status' => 0,
                'data' => $cURL_error
            );
        }

        $result = trim($result);
        $result_response = json_decode($result);
        // dd($result_response,$furl , $surl,$postData,$input ,$hash);
        ///////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////
        $method = "aes-256-cbc";
        $key = substr(hash('sha256', $MERCHANT_KEY), 0, 32);
        $iv = substr(hash('sha256', $SALT), 0, 16);

        $encrypted_card_number = "";
        if (!empty($_POST['card_number'])) {
            $encrypted_card_number = $_POST['card_number'];
            $encrypted_card_number = openssl_encrypt($encrypted_card_number, $method, $key, 0, $iv);
        }

        $encrypted_card_holder_name = "";
        if (!empty($_POST['card_holder_name'])) {
            $encrypted_card_holder_name = $_POST['card_holder_name'];
            $encrypted_card_holder_name = openssl_encrypt($encrypted_card_holder_name, $method, $key, 0, $iv);
        }

        $encrypted_card_cvv = "";
        if (!empty($_POST['card_cvv'])) {
            $encrypted_card_cvv = $_POST['card_cvv'];
            $encrypted_card_cvv = openssl_encrypt($_POST['card_cvv'], $method, $key, 0, $iv);
        }

        $encrypted_card_expiry_date = "";
        if (!empty($_POST['card_expiry_date'])) {
            $encrypted_card_expiry_date = $_POST['card_expiry_date'];
            $encrypted_card_expiry_date = openssl_encrypt($_POST['card_expiry_date'], $method, $key, 0, $iv);
        }

        $card_token = "";
        if (!empty($_POST['card_token'])) {
            $card_token = $_POST['card_token'];
            $card_token = openssl_encrypt($_POST['card_token'], $method, $key, 0, $iv);
        }

        $cryptogram = "";
        if (!empty($_POST['cryptogram'])) {
            $cryptogram = $_POST['cryptogram'];
            $cryptogram = openssl_encrypt($_POST['cryptogram'], $method, $key, 0, $iv);
        }

        $token_expiry_date = "";
        if (!empty($_POST['token_expiry_date'])) {
            $token_expiry_date = $_POST['token_expiry_date'];
            $token_expiry_date = openssl_encrypt($_POST['token_expiry_date'], $method, $key, 0, $iv);
        }
        $token_requester_id = "";
        if (!empty($_POST['token_requester_id'])) {
            $token_requester_id = $_POST['token_requester_id'];
        }

        // dd($data ,$_POST['payment_mode'] , $_POST['bank_code'] , $encrypted_card_number , $encrypted_card_holder_name , $encrypted_card_cvv ,$encrypted_card_expiry_date , $card_token , $cryptogram , $token_expiry_date , $token_expiry_date , $_POST['upi_va'] ,$input);
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta http-equiv='X-UA-Compatible' content='ie=edge'>
            <style>
                input, button {
                    width: 35%;
                    padding: 5px;
                    margin: 5px;
                }
            </style>
        </head>
        <body>
            <form id='seamless_auto_submit_form' method='POST' action='https://pay.easebuzz.in/initiate_seamless_payment/'>
                    <input type='hidden' name='access_key' value='" . $result_response->data . "'></input><br>
                    <input type='hidden' name='payment_mode' value='" . $_POST['payment_mode'] . "'></input><br>
                    <input type='hidden' name='bank_code' value='" . $_POST['bank_code'] . "'></input><br>
                    <input type='hidden' name='card_number' value='" . $encrypted_card_number . "'></input><br>
                    <input type='hidden' name='card_holder_name' value='" . $encrypted_card_holder_name . "'></input><br>
                    <input type='hidden' name='card_cvv' value='" . $encrypted_card_cvv . "'></input><br>
                    <input type='hidden' name='card_expiry_date' value='" . $encrypted_card_expiry_date . "'></input><br>
                    <input type='hidden' name='card_token' value='" . $card_token . "'></input><br>
                    <input type='hidden' name='cryptogram' value='" . $cryptogram . "'></input><br>
                    <input type='hidden' name='token_expiry_date' value='" . $token_expiry_date . "'></input><br>
                    <input type='hidden' name='token_requester_id' value='" . $token_requester_id . "'></input><br>
                    <input type='hidden' name='upi_va' value='" . $_POST['upi_va'] . "'></input><br>
                </form>
            <script type='text/javascript'>
                document.getElementById('seamless_auto_submit_form').submit();
            </script>
            </body>
        </html>
        ";
    }
    public function roundIntpay(Request $request)
    {
        // IMP Function for Inter round trip by udd
        $input = $request->all();
        // $amount =  ;
        if (isset($input['showprice'])) {
            $showprice = $input['showprice'];
        } else {
            $showprice = "unchecked";
        }


        $amount_orignal = session('totalAmount') ?? session('total_fare');
        $amount = CheckTime::checktimeandpricing($amount_orignal);
        if (isset($input['IsAgent'])) {
            if ($input['agent'] == 'agent') {
                $Agent = Session()->get("Agent");
                if ($Agent != null) {
                    $mail = $Agent->email;
                    $Agent = Agent::where('email', '=', $mail)->first();
                    if ($amount <= $Agent->state) {

                        if ($input['surl'] == 'booking/bookings') {
                            // dd($input);
                            $Agent->state =  $Agent->state - $amount;
                            $Agent->save();
                            $tnxid = $input['txnid'];
                            $tnxid1 = $input['txnid1'];
                            $cratePnr = new BookingController;
                            $both = $cratePnr->Bookings($tnxid, $tnxid1, $showprice);

                            return view('flight-pages/booking-confirm/Mix-Dom-Round', compact('both'));
                        }
                        $Agent->state =  $Agent->state - $amount;
                        $Agent->save();
                        $tnxid = $input['txnid'];
                        $cratePnr = new PNR_AddMultiElementsController;
                        $saveBooking = $cratePnr->PNR_AddMultiElements($tnxid, $showprice);
                        // dd($saveBooking);
                        return view('flight-pages.booking-confirm.oneway-amd-flight-booking-confirm')->with('bookings', $saveBooking);
                        // die('.');
                    } else {
                        dd("Add Amount");
                    }
                }
            } else {
                return back();
            }
        }

        // dd($input , $amount);
        $DcAmount = $CcAmount = '';
        if ($input['payment_mode'] == "DC") {
            $DcAmount = (($amount * 1) / 100);
            $amount += $DcAmount;
        } elseif ($input['payment_mode'] == "CC") {
            $CcAmount = (($amount * 2) / 100);
            $amount += $CcAmount;
        }
        $postData = array(
            "key" => 'FW09Z922O6',
            "txnid" => $input['txnid'],
            "amount" => $amount ?? $input['amount'],
            "productinfo" => 'Hotel Booking',
            "firstname" => $input['customerName'],
            "email" => $input['customerEmail'],
            "udf1" => $request['udf1'],
            "udf2" => '',
            "udf3" => '',
            "udf4" => '',
            "udf5" => '',
            "udf6" => '',
            "udf7" => '',
            "udf8" => '',
            "udf9" => '',
            "udf10" => '',
            'request_flow' => 'SEAMLESS',
        );

        $SALT = '734VHA2I97';
        $MERCHANT_KEY = 'FW09Z922O6';
        $BuzzData = [
            'key' => 'FW09Z922O6',
            'salt' => '734VHA2I97',
        ];
        // url for round trip inter change it .
        // $surl = url('flight/payment');
        // $furl = url('flight/payment');

        $surl = url($input['surl']);
        $furl = url($input['furl']);
        // $amount = number_format((float)$input['amount'], 1, '.', '');
        $amount =  $postData['amount'];

        $hash_sequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

        // make an array or split into array base on pipe sign.
        $hash_sequence_array = explode('|', $hash_sequence);
        $hash = null;

        // prepare a string based on hash sequence from the $params array.
        foreach ($hash_sequence_array as $value) {
            $hash .= isset($postData[$value]) ? $postData[$value] : '';
            $hash .= '|';
        }

        $hash .= '734VHA2I97';


        $signatureBuzzHash = strtolower(hash('sha512', $hash));
        //////////////////////////////////////////////////////
        //////////////////////////////////////////////////////
        $cURL = curl_init();

        // Set multiple options for a cURL transfer.
        curl_setopt_array(
            $cURL,
            array(
                CURLOPT_URL => 'https://pay.easebuzz.in/payment/initiateLink',
                CURLOPT_POSTFIELDS =>  'key=FW09Z922O6&txnid=' . $postData["txnid"] . '&amount=' . $postData["amount"] . '&productinfo=' . $postData["productinfo"] . '&firstname=' . $postData["firstname"] . '&email=' . $postData["email"] . '&udf1=' . $request['udf1'] . '&udf2=&udf3=&udf4=&udf5=&udf6=&udf7=&udf8=&udf9=&udf10=&hash=' . $signatureBuzzHash . '&phone=9632587410&surl=' . $surl . '&furl=' . $furl . '&request_flow=SEAMLESS',
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36',
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            )
        );

        // Perform a cURL session
        $result = curl_exec($cURL);

        // check there is any error or not in curl execution.
        if (curl_errno($cURL)) {
            $cURL_error = curl_error($cURL);
            if (empty($cURL_error))
                $cURL_error = 'Server Error';

            return array(
                'status' => 0,
                'data' => $cURL_error
            );
        }

        $result = trim($result);
        $result_response = json_decode($result);
        ///////////////////////////////////////////////////////////////////
        $method = "aes-256-cbc";
        $key = substr(hash('sha256', $MERCHANT_KEY), 0, 32);
        $iv = substr(hash('sha256', $SALT), 0, 16);

        $encrypted_card_number = "";
        if (!empty($_POST['card_number'])) {
            $encrypted_card_number = $_POST['card_number'];
            $encrypted_card_number = openssl_encrypt($encrypted_card_number, $method, $key, 0, $iv);
        }

        $encrypted_card_holder_name = "";
        if (!empty($_POST['card_holder_name'])) {
            $encrypted_card_holder_name = $_POST['card_holder_name'];
            $encrypted_card_holder_name = openssl_encrypt($encrypted_card_holder_name, $method, $key, 0, $iv);
        }

        $encrypted_card_cvv = "";
        if (!empty($_POST['card_cvv'])) {
            $encrypted_card_cvv = $_POST['card_cvv'];
            $encrypted_card_cvv = openssl_encrypt($_POST['card_cvv'], $method, $key, 0, $iv);
        }

        $encrypted_card_expiry_date = "";
        if (!empty($_POST['card_expiry_date'])) {
            $encrypted_card_expiry_date = $_POST['card_expiry_date'];
            $encrypted_card_expiry_date = openssl_encrypt($_POST['card_expiry_date'], $method, $key, 0, $iv);
        }

        $card_token = "";
        if (!empty($_POST['card_token'])) {
            $card_token = $_POST['card_token'];
            $card_token = openssl_encrypt($_POST['card_token'], $method, $key, 0, $iv);
        }

        $cryptogram = "";
        if (!empty($_POST['cryptogram'])) {
            $cryptogram = $_POST['cryptogram'];
            $cryptogram = openssl_encrypt($_POST['cryptogram'], $method, $key, 0, $iv);
        }

        $token_expiry_date = "";
        if (!empty($_POST['token_expiry_date'])) {
            $token_expiry_date = $_POST['token_expiry_date'];
            $token_expiry_date = openssl_encrypt($_POST['token_expiry_date'], $method, $key, 0, $iv);
        }
        $token_requester_id = "";
        if (!empty($_POST['token_requester_id'])) {
            $token_requester_id = $_POST['token_requester_id'];
        }

        // dd($data ,$_POST['payment_mode'] , $_POST['bank_code'] , $encrypted_card_number , $encrypted_card_holder_name , $encrypted_card_cvv ,$encrypted_card_expiry_date , $card_token , $cryptogram , $token_expiry_date , $token_expiry_date , $_POST['upi_va'] ,$input);
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta http-equiv='X-UA-Compatible' content='ie=edge'>
            <style>
                input, button {
                    width: 35%;
                    padding: 5px;
                    margin: 5px;
                }
            </style>
        </head>
        <body>
        <form id='seamless_auto_submit_form' method='POST' action='https://pay.easebuzz.in/initiate_seamless_payment//'>
        <h2>Click on Submit if not redirecting</h2>
                        <input type='hidden' name='access_key' value='" . $result_response->data . "'></input><br>
                        <input type='hidden' name='payment_mode' value='" . $_POST['payment_mode'] . "'></input><br>
                        <input type='hidden' name='bank_code' value='" . $_POST['bank_code'] . "'></input><br>
                        <input type='hidden' name='card_number' value='" . $encrypted_card_number . "'></input><br>
                        <input type='hidden' name='card_holder_name' value='" . $encrypted_card_holder_name . "'></input><br>
                        <input type='hidden' name='card_cvv' value='" . $encrypted_card_cvv . "'></input><br>
                        <input type='hidden' name='card_expiry_date' value='" . $encrypted_card_expiry_date . "'></input><br>
                        <input type='hidden' name='card_token' value='" . $card_token . "'></input><br>
                        <input type='hidden' name='cryptogram' value='" . $cryptogram . "'></input><br>
                        <input type='hidden' name='token_expiry_date' value='" . $token_expiry_date . "'></input><br>
                        <input type='hidden' name='token_requester_id' value='" . $token_requester_id . "'></input><br>
                        <input type='hidden' name='upi_va' value='" . $_POST['upi_va'] . "'></input><br>

                        </form>
                        <script type='text/javascript'>
                          document.getElementById('seamless_auto_submit_form').submit();
                        </script>
                </body>
        </html>
        ";
    }
    public function PaymentSaveGalelio(Request $request)
    {
        $input = $request->all();
        $data_orignal =  session('total_fare');
        $data =  session('total_fare_time');
        $input['fare'] =  $data ?? $input['fare'];
        if ($input['Chari'] != "no") {
            $input['fare'] += 10;
        }
        if ($input['textDis'] != "no") {
            $input['fare'] -= 50;
        }
        $flightdata = [
            'marketingCompany_1' => $request['otherInformations'] ?? null,
        ];
        // dd($request->all());
        $passengers = json_decode($request['travellers'], true);

        $travellerDetails = [];


        if ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] === 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adultDOB = "";
                $adultPED = "";
                if (!empty($request['adultDOB'][$i])) {
                    $adultDOB = \DateTime::createFromFormat("Y-m-d", $request['adultDOB'][$i]);
                    $adultDOB = $adultDOB->format("d/m/Y");
                    $adultPED = \DateTime::createFromFormat("Y-m-d", $request['adultPED'][$i]);
                    $adultPED = $adultPED->format("d/m/Y");
                }

                $adult = [

                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $adultDOB ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $adultPED ?? ""
                ];

                array_push($travellerDetails, $adult);
            }
        } elseif ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] != 0 && (int) $passengers['noOfInfants'] === 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adultDOB = "";
                $adultPED = "";
                if (!empty($request['adultDOB'][$i])) {
                    $adultDOB = \DateTime::createFromFormat("Y-m-d", $request['adultDOB'][$i]);
                    $adultDOB = $adultDOB->format("d/m/Y");
                    $adultPED = \DateTime::createFromFormat("Y-m-d", $request['adultPED'][$i]);
                    $adultPED = $adultPED->format("d/m/Y");
                }

                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $adultDOB,
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $adultPED ?? ""
                ];

                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
                $chdDob = \DateTime::createFromFormat("Y-m-d", $request['childDOB'][$i]);
                $chdDob = $chdDob->format("d/m/Y");
                $childPED = "";
                if (!empty($request['childPED'][$i])) {
                    $childPED = \DateTime::createFromFormat("Y-m-d", $request['childPED'][$i]);
                    $childPED = $childPED->format("d/m/Y");
                }
                $child = [
                    "Title" => $request['childTitle'][$i],
                    "Gender" => $request['childGender'][$i],
                    "FirstName" => $request['childFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['childLastName'][$i],
                    "DateOfBirth" => $chdDob,
                    "PaxType" => "CHD",
                    "PassportNumber" =>  $request['childPassportNo'][$i] ?? "",
                    "Nationality" => $request['childNationality'][$i] ?? "",
                    "IssuingCountry" => $request['childIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $childPED ?? ""
                ];

                array_push($travellerDetails, $child);
            }
        } elseif ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] != 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adultDOB = "";
                $adultPED = "";
                if (!empty($request['adultDOB'][$i])) {
                    $adultDOB = \DateTime::createFromFormat("Y-m-d", $request['adultDOB'][$i]);
                    $adultDOB = $adultDOB->format("d/m/Y");
                    $adultPED = \DateTime::createFromFormat("Y-m-d", $request['adultPED'][$i]);
                    $adultPED = $adultPED->format("d/m/Y");
                }

                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $adultDOB,
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $adultPED ?? ""
                ];
                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfInfants']; $i++) {

                $infantPED = "";
                $infDob = \DateTime::createFromFormat("Y-m-d", $request['infantDOB'][$i]);
                $infDob = $infDob->format("d/m/Y");
                if (!empty($request['infantPED'][$i])) {
                    $infantPED = \DateTime::createFromFormat("Y-m-d", $request['infantPED'][$i]);
                    $infantPED = $infantPED->format("d/m/Y");
                }
                $infant = [
                    "Title" => $request['infantTitle'][$i],
                    "Gender" => $request['infantGender'][$i],
                    "FirstName" => $request['infantFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['infantLastName'][$i],
                    "DateOfBirth" => $infDob,
                    "PaxType" => "INF",
                    "PassportNumber" => $request['infantPassportNo'][$i] ?? "",
                    "Nationality" => $request['infantNationality'][$i] ?? "",
                    "IssuingCountry" => $request['infantIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $infantPED ?? ""
                ];



                array_push($travellerDetails, $infant);
            }
        } elseif ((int) $passengers['noOfAdults'] > 0 && (int) $passengers['noOfChilds'] > 0 && (int) $passengers['noOfInfants'] > 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adultDOB = "";
                $adultPED = "";
                if (!empty($request['adultDOB'][$i])) {
                    $adultDOB = \DateTime::createFromFormat("Y-m-d", $request['adultDOB'][$i]);
                    $adultDOB = $adultDOB->format("d/m/Y");
                    $adultPED = \DateTime::createFromFormat("Y-m-d", $request['adultPED'][$i]);
                    $adultPED = $adultPED->format("d/m/Y");
                }

                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $adultDOB,
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $adultPED ?? ""
                ];

                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
                $chdDob = \DateTime::createFromFormat("Y-m-d", $request['childDOB'][$i]);
                $chdDob = $chdDob->format("d/m/Y");
                $childPED = "";
                if (!empty($request['childPED'][$i])) {
                    $childPED = \DateTime::createFromFormat("Y-m-d", $request['childPED'][$i]);
                    $childPED = $childPED->format("d/m/Y");
                }
                $child = [
                    "Title" => $request['childTitle'][$i],
                    "Gender" => $request['childGender'][$i],
                    "FirstName" => $request['childFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['childLastName'][$i],
                    "DateOfBirth" => $chdDob,
                    "PaxType" => "CHD",
                    "PassportNumber" =>  $request['childPassportNo'][$i] ?? "",
                    "Nationality" => $request['childNationality'][$i] ?? "",
                    "IssuingCountry" => $request['childIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $childPED ?? ""
                ];

                array_push($travellerDetails, $child);
            }

            for ($i = 0; $i < $passengers['noOfInfants']; $i++) {

                $infantPED = "";
                $infDob = \DateTime::createFromFormat("Y-m-d", $request['infantDOB'][$i]);
                $infDob = $infDob->format("d/m/Y");
                if (!empty($request['infantPED'][$i])) {
                    $infantPED = \DateTime::createFromFormat("Y-m-d", $request['infantPED'][$i]);
                    $infantPED = $infantPED->format("d/m/Y");
                }
                $infant = [
                    "Title" => $request['infantTitle'][$i],
                    "Gender" => $request['infantGender'][$i],
                    "FirstName" => $request['infantFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['infantLastName'][$i],
                    "DateOfBirth" => $infDob,
                    "PaxType" => "INF",
                    "PassportNumber" => $request['infantPassportNo'][$i] ?? "",
                    "Nationality" => $request['infantNationality'][$i] ?? "",
                    "IssuingCountry" => $request['infantIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $infantPED ?? ""
                ];

                array_push($travellerDetails, $infant);
            }
        }

        $getsession = [
            'SessionID' => $request['SessionID'],
            'ReferenceNo' => $request['ReferenceNo'],
            'Provider' =>  $request['Provider'],
            'Key'      => $request['Key'],
        ];
        if ($request['Code'] == "WTAIM001") {
            // $fare = 1.1;
            $fare = $data_orignal;
        } else {
            $fare = $data_orignal;
        }

        $uniqueid = "WT" . $getsession['ReferenceNo'] . rand(999, 99999) . $getsession['ReferenceNo'];
        $save = new Cart;
        $save->travellerquantity = $request['travellers'];
        $save->getsession = json_encode($getsession, true);
        $save->otherInformation = $request['trip'];
        $save->fare = $fare;
        $save->timefare = !empty($data) ? $data : NULL;
        $save->travllername = json_encode($travellerDetails, true);
        $save->phonenumber = $request['phoneNumber'];
        $save->email = $request['email'];
        $save->uniqueid = $uniqueid;
        $save->save();
        $data = $save;
        // $dummy="test";
        // $AddPassengerDetails = AuthenticateController::callApiWithHeadersGal("AddPassengerDetails", $AddPassengerDetailsBody);

        $BookingBody = [
            "ClientCode" => "MakeTrueTrip",
            "SessionID" => $getsession['SessionID'],
            "Key" => $getsession['Key'],
            "ReferenceNo" => $getsession['ReferenceNo'],
            "Provider" => $getsession['Provider'],
        ];
        $Booking = AuthenticateController::callApiWithHeadersGal("Booking", $BookingBody);
        $bankData = DB::table('buzzbankcode')->get();

        $BookingBody = [
            "ClientCode" => "MakeTrueTrip",
            "SessionID" => $getsession['SessionID'],
            "Key" => $getsession['Key'],
            "ReferenceNo" => $getsession['ReferenceNo'],
            "Provider" => $getsession['Provider'],
        ];
        $Booking = AuthenticateController::callApiWithHeadersGal("Booking", $BookingBody);

        //  dd($Booking , $data);
        $cashfree = [
            'testMode' => env('TEST_MODE', '1'),
            'appID' => env('APP_ID', '1661862c982a09f6d5f1d93900681661'),
            'secretKey' => env('SECRET_KEY', '781827d26290a6ea98559e65ec895029923b5fa7'),
            'orderCurrency' => env('ORDER_CURRENCY', 'INR'),
            'orderPrefix' => env('ORDER_PREFIX', 'MCG-6'),
        ];
        $action = ($cashfree['testMode']) ?
            'https://test.cashfree.com/billpay/checkout/post/submit' :
            'https://www.cashfree.com/checkout/post/submit';

        $appID = $cashfree['appID'];
        $secretKey = $cashfree['secretKey'];
        $orderCurrency = $cashfree['orderCurrency'];
        $returnUrl = url('/Galileo/returnurl');
        $notifyUrl = url('/Galileo/returnurl');
        $customerName = $request['adultFirstName0'] . $request['adultLastName0'];
        $orderCurrency = "INR";
        $trip = $request['trip'];
        // $namelen = count($request->adultFirstName);

        $postData = [
            'appId' => '1661862c982a09f6d5f1d93900681661',
            'orderId' => $uniqueid,
            'orderAmount' => $request->fare,
            'orderCurrency' => 'INR',
            'orderNote' => "WTAMD" . json_encode($getsession, true),
            'customerName' => $request['adultFirstName0'] . ' ' . $request['adultLastName0'],
            'customerEmail' => $request->email,
            'customerPhone' => $request->phoneNumber,
            'returnUrl' => url('/Galileo/returnurl'),
            'notifyUrl' => url('/Galileo/returnurl'),
        ];
        ksort($postData);

        $signatureData = "";
        foreach ($postData as $key => $value) {
            $signatureData .= $key . $value;
        }
        $signature = hash_hmac('sha256', $signatureData, $secretKey, true);
        $signature = base64_encode($signature);
        $travller = $travellerDetails;
        $payment_option = DB::table('payment_gateway_options')
            ->where('status', 1)
            ->first();
        $pricing = VisitorGeolocation::geolocationInfo();
        $cvalue = !empty($pricing['value']) ? $pricing['value'] : 1;    // conversion rate
        $code = !empty($pricing['code'][0]) ? $pricing['code'][0] : 'INR';
        if ($input['trip'] == 'Internation-Roundtrip') {
            $bankData = DB::table('buzzbankcode')->get();
            $sDetail = $data;
            $url = [
                'furl' => 'Galileo/booking',
                'surl' => 'Galileo/booking',
            ];
            $requsData = $request->all();
            if (!empty($payment_option)) {
                if ($payment_option->name == 'Paypal') {
                    $redirect = PaypalRedirector::getredirection($data->fare, $data->uniqueid, 'GailRoundtripInterNational');
                    if (!empty($redirect)) {
                        return view('payment', compact('sDetail', 'data', 'trip', 'travller', 'requsData', 'flightdata', 'input', 'postData', 'signature', 'bankData', 'url', 'redirect', 'code', 'cvalue'));
                    } else {
                        return view('payment', compact('sDetail', 'data', 'trip', 'travller', 'requsData', 'flightdata', 'input', 'postData', 'signature', 'bankData', 'url', 'code', 'cvalue'));
                    }
                } else {
                    return view('payment', compact('sDetail', 'data', 'trip', 'travller', 'requsData', 'flightdata', 'input', 'postData', 'signature', 'bankData', 'url', 'code', 'cvalue'));
                }
            }
            return view('payment', compact('sDetail', 'data', 'trip', 'travller', 'requsData', 'flightdata', 'input', 'postData', 'signature', 'bankData', 'url', 'code', 'cvalue'));
        }
        if (!empty($payment_option)) {
            if ($payment_option->name == 'Paypal') {
                $redirect = PaypalRedirector::getredirection($data->fare, $data->uniqueid, 'onewayGL');
                if (!empty($redirect)) {
                    // return view('flight-pages.oneway-flight-pages.payment', compact('data','flightdata','input' ,'bankData'));
                    return view('flight-pages.oneway-flight-pages.payment', compact('data', 'flightdata', 'input', 'bankData', 'redirect', 'cvalue', 'code', 'cvalue'));
                } else {
                    return view('flight-pages.oneway-flight-pages.payment', compact('data', 'flightdata', 'input', 'bankData', 'code', 'cvalue'));
                }
            } else {
                return view('flight-pages.oneway-flight-pages.payment', compact('data', 'flightdata', 'input', 'bankData', 'code', 'cvalue'));
            }
        }
        return view('flight-pages.oneway-flight-pages.payment', compact('data', 'flightdata', 'input', 'bankData', 'code', 'cvalue'));
    }

    public function PaymentSaveGalelioRoundTrip(Request $request)
    {
        $input =  $request->all();
        $data =  session('total_fare');
        $data = CheckTime::checktimeandpricing($data);
        $request['fare'] =  session('total_fare') ?? $input['fare'];
        if ($input['Chari'] != "no") {
            $request['fare'] += 10;
        }
        if ($input['textDis'] != "no") {
            $request['fare'] -= 50;
        }
        //   dd($input , $request , $data);
        //     $validate = Validator::make($input ,[
        //         'adultTitle.*' => 'required',
        //         'adultFirstName.*' => 'required',
        //         'adultLastName.*' => 'required',
        //         'countryCode2' => 'required',
        //         'email' => 'required|email',
        //         'phoneNumber' => 'required',
        //     ]);
        //     if ($validate->fails()) {
        //         return back()->withErrors($validate->errors())->withInput();
        //     }

        $flightdata = [
            'marketingCompany_1' => $request['otherInformations'] ?? null,
        ];

        $passengers = json_decode($request['travellers'], true);
        $travellerDetails = [];

        // dd($input,$flightdata,$passengers,$travellerDetails);
        // dd($passengers,$travellerDetails);
        if ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] === 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" =>  $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $adult);
            }
        } elseif ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] != 0 && (int) $passengers['noOfInfants'] === 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" =>  $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }



            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
                $chdDob = \DateTime::createFromFormat("Y-m-d", $request['childDOB'][$i]);
                $chdDob = $chdDob->format("d/m/Y");
                $child = [
                    "Title" => $request['childTitle'][$i],
                    "Gender" => $request['childGender'][$i],
                    "FirstName" => $request['childFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['childLastName'][$i],
                    "DateOfBirth" => $chdDob,
                    "PaxType" => "CHD",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $child);
            }
        } elseif ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] != 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfInfants']; $i++) {

                $infDob = \DateTime::createFromFormat("Y-m-d", $request['infantDOB'][$i]);
                $infDob = $infDob->format("d/m/Y");
                $infant = [
                    "Title" => $request['infantTitle'][$i],
                    "Gender" => $request['infantGender'][$i],
                    "FirstName" => $request['infantFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['infantLastName'][$i],
                    "DateOfBirth" => $infDob,
                    "PaxType" => "INF",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $infant);
            }
        } elseif ((int) $passengers['noOfAdults'] > 0 && (int) $passengers['noOfChilds'] > 0 && (int) $passengers['noOfInfants'] > 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'],
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
                $chdDob = \DateTime::createFromFormat("Y-m-d", $request['childDOB'][$i]);
                $chdDob = $chdDob->format("d/m/Y");
                $child = [
                    "Title" => $request['childTitle'][$i],
                    "Gender" => $request['childGender'][$i],
                    "FirstName" => $request['childFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['childLastName'][$i],
                    "DateOfBirth" => $chdDob,
                    "PaxType" => "CHD",
                    "PassportNumber" => $request['childPassportNo'][$i] ?? "",
                    "Nationality" => $request['childNationality'][$i] ?? "",
                    "IssuingCountry" => $request['childIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['childPED'] ?? ""
                ];

                array_push($travellerDetails, $child);
            }

            for ($i = 0; $i < $passengers['noOfInfants']; $i++) {

                $infDob = \DateTime::createFromFormat("Y-m-d", $request['infantDOB'][$i]);
                $infDob = $infDob->format("d/m/Y");
                $infant = [
                    "Title" => $request['infantTitle'][$i],
                    "Gender" => $request['infantGender'][$i],
                    "FirstName" => $request['infantFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['infantLastName'][$i],
                    "DateOfBirth" => $infDob,
                    "PaxType" => "INF",
                    "PassportNumber" => $request['infantPassportNo'][$i] ?? "",
                    "Nationality" => $request['infantNationality'][$i] ?? "",
                    "IssuingCountry" => $request['infantIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => ""
                ];
                array_push($travellerDetails, $infant);
            }
        }

        $getsession = [
            'SessionID' => json_decode($request['SessionID'], true),
            'ReferenceNo' => json_decode($request['ReferenceNo'], true),
            'Provider' =>  json_decode($request['Provider'], true),
            'Key'      => json_decode($request['Key'], true),
        ];

        //dd($getsession);
        // if($request['Code']=="WTAIM001"){
        //     $fare = 1.1;
        // }else{
        // }
        $fare = $request['fare'];

        $uniqueid = "WT" . $getsession['ReferenceNo']['Outbound'] . rand(999, 99999) . $getsession['ReferenceNo']['Inbound'];
        //$uniqueid = "WT" .$getsession['ReferenceNo']. rand(999, 99999).$getsession['ReferenceNo'];
        $save = new Cart;
        $save->travellerquantity = $request['travellers'];
        $save->getsession = json_encode($getsession, true);
        $save->otherInformation = $request['trip'];
        $save->fare = $fare;
        $save->timefare = $data;
        $save->travllername = json_encode($travellerDetails, true);
        $save->phonenumber = $request['phoneNumber'];
        $save->email = $request['email'];
        $save->uniqueid = $uniqueid;
        $save->save();
        $data = $save;
        //   dd($data, $uniqueid,$getsession,$passengers);
        //   dd($flightdata,$input,$data);

        $bankData = DB::table('buzzbankcode')->get();
        $payment_option = DB::table('payment_gateway_options')
            ->where('status', 1)
            ->first();

        $pricing = VisitorGeolocation::geolocationInfo();
        $cvalue = !empty($pricing['value']) ? $pricing['value'] : 1;    // conversion rate
        $code = !empty($pricing['code'][0]) ? $pricing['code'][0] : 'INR';

        if (!empty($payment_option)) {
            if ($payment_option->name == 'Paypal') {
                $payment_link = PaypalRedirector::getredirection($data->fare, $data->uniqueid, 'GalileoRoundtripDomestic');
                if (!empty($payment_link)) {
                    $redirect = $payment_link;
                    return view('flight-pages.roundtrip-flight-pages.domestic-flight-pages.gl-payment', compact('input', 'data', 'bankData', 'redirect', 'code', 'cvalue'));
                    // return redirect($payment_link);
                } else {
                    return view('flight-pages.roundtrip-flight-pages.domestic-flight-pages.gl-payment', compact('input', 'data', 'bankData', 'code', 'cvalue'));
                }
            } else {
                return view('flight-pages.roundtrip-flight-pages.domestic-flight-pages.gl-payment', compact('input', 'data', 'bankData', 'code', 'cvalue'));
            }
        } else {
            // return redirect($payment_link);
            return view('flight-pages.roundtrip-flight-pages.domestic-flight-pages.gl-payment', compact('input', 'data', 'bankData', 'code', 'cvalue'));
        }
    }


    public function MixRoundDom(Request $request)
    {
        $input = $request->all();

        $otherInformations = json_decode($request['otherInformations'], true);
        // AMD ////////////////////////////////
        $totalAmount_orignal = session()->get('totalAmount');
        $totalAmount = CheckTime::checktimeandpricing($totalAmount_orignal);
        // dd($request->all() , $totalAmount);
        $flightdata = [
            'marketingCompany_1' => $otherInformations['marketingCompany_1'] ?? $otherInformations['marketingCompany'] ?? null,
            'marketingCompany_2' => $otherInformations['marketingCompany_2'] ?? null,
            'marketingCompany_3' => $otherInformations['marketingCompany_3'] ?? null,
        ];
        $travller = [
            'adults' => [
                'title' => $request['adultTitle'] ?? null,
                'fistName' => $request['adultFirstName'],
                'lastName' => $request['adultLastName'],
                'adultNationality' => $request['adultNationality'] ?? null,
                'adultDOB' => $request['adultDOB'] ?? null,
                'adultPassportNo' => $request['adultPassportNo'] ?? null,
            ],
            'childs' => [
                'title' => $request['childTitle'] ?? null,
                'fistName' => $request['childFirstName'] ?? null,
                'lastName' => $request['childLastName'] ?? null,
                'childNationality' => $request['childNationality'] ?? null,
                'childDOB' => $request['childDOB'] ?? null,
                'childPassportNo' => $request['childPassportNo'] ?? null,
            ],
            'infants' => [
                'title' => $request['infantTitle'] ?? null,
                'fistName' => $request['infantFirstName'] ?? null,
                'lastName' => $request['infantLastName'] ?? null,
                'infantDOB' => $request['infantDOB'] ?? null,
                'infantNationality' => $request['infantNationality'] ?? null,
                'infantPassportNo' => $request['infantPassportNo'] ?? null,
            ],

        ];

        $getsessions = json_decode($request->getsession, true);
        if (isset($getsessions['sessionOutbound'])) {
            $newSession = $getsessions['sessionOutbound']['sessionId'];
        } else {
            $newSession = $getsessions['sessionId'];
        }
        $uniqueid = "WTAMD" . $newSession;
        $uniqueidamd = $uniqueid;
        $trip = $request['trip'];
        $data = ['uniqueid' => $uniqueid, 'fare' => $request->fare];
        $sDetail = new Cart;
        $sDetail->travellerquantity = $request->travellers;
        $sDetail->getsession = $request->getsession;
        $sDetail->otherInformation = $request->otherInformations;
        $sDetail->timefare = $totalAmount;
        $sDetail->fare = $totalAmount_orignal ?? $request->fare;
        $sDetail->travllername = json_encode($travller, true);
        $sDetail->phonenumber = $request->phoneNumber;
        $sDetail->email = $request->email;
        $sDetail->uniqueid = $uniqueid;
        $sDetail->save();













        // Gal START  //////////////////////////////////////////////////////////////


        $input =  $request->all();
        $flightdata = [
            'marketingCompany_1' => $request['otherInformations'] ?? null,
        ];

        $passengers = json_decode($request['travellers'], true);
        $travellerDetails = [];

        // dd($input,$flightdata,$passengers,$travellerDetails);
        // dd($passengers,$travellerDetails);
        if ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] === 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" =>  $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $adult);
            }
        } elseif ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] != 0 && (int) $passengers['noOfInfants'] === 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" =>  $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }



            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
                $chdDob = \DateTime::createFromFormat("Y-m-d", $request['childDOB'][$i]);
                $chdDob = $chdDob->format("d/m/Y");
                $child = [
                    "Title" => $request['childTitle'][$i],
                    "Gender" => $request['childGender'][$i],
                    "FirstName" => $request['childFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['childLastName'][$i],
                    "DateOfBirth" => $chdDob,
                    "PaxType" => "CHD",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $child);
            }
        } elseif ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] != 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfInfants']; $i++) {

                $infDob = \DateTime::createFromFormat("Y-m-d", $request['infantDOB'][$i]);
                $infDob = $infDob->format("d/m/Y");
                $infant = [
                    "Title" => $request['infantTitle'][$i],
                    "Gender" => $request['infantGender'][$i],
                    "FirstName" => $request['infantFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['infantLastName'][$i],
                    "DateOfBirth" => $infDob,
                    "PaxType" => "INF",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $infant);
            }
        } elseif ((int) $passengers['noOfAdults'] > 0 && (int) $passengers['noOfChilds'] > 0 && (int) $passengers['noOfInfants'] > 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'],
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
                $chdDob = \DateTime::createFromFormat("Y-m-d", $request['childDOB'][$i]);
                $chdDob = $chdDob->format("d/m/Y");
                $child = [
                    "Title" => $request['childTitle'][$i],
                    "Gender" => $request['childGender'][$i],
                    "FirstName" => $request['childFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['childLastName'][$i],
                    "DateOfBirth" => $chdDob,
                    "PaxType" => "CHD",
                    "PassportNumber" => $request['childPassportNo'][$i] ?? "",
                    "Nationality" => $request['childNationality'][$i] ?? "",
                    "IssuingCountry" => $request['childIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['childPED'] ?? ""
                ];

                array_push($travellerDetails, $child);
            }

            for ($i = 0; $i < $passengers['noOfInfants']; $i++) {

                $infDob = \DateTime::createFromFormat("Y-m-d", $request['infantDOB'][$i]);
                $infDob = $infDob->format("d/m/Y");
                $infant = [
                    "Title" => $request['infantTitle'][$i],
                    "Gender" => $request['infantGender'][$i],
                    "FirstName" => $request['infantFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['infantLastName'][$i],
                    "DateOfBirth" => $infDob,
                    "PaxType" => "INF",
                    "PassportNumber" => $request['infantPassportNo'][$i] ?? "",
                    "Nationality" => $request['infantNationality'][$i] ?? "",
                    "IssuingCountry" => $request['infantIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => ""
                ];
                array_push($travellerDetails, $infant);
            }
        }

        $getsession = [
            'SessionID' => $request['SessionID'],
            'ReferenceNo' => $request['ReferenceNo'],
            'Provider' =>  $request['GalProvider'],
            'Key'      => $request['Key'],
        ];

        //dd($getsession);
        //dd($getsession['ReferenceNo']['Outbound']);

        //$uniqueid = "WT" .$getsession['ReferenceNo']['Outbound']. rand(999, 99999).$getsession['ReferenceNo']['Inbound'];
        $uniqueid = "WTG" . $getsession['ReferenceNo'] . rand(999, 99999) . $getsession['ReferenceNo'];
        $uniqueidgal = $uniqueid;
        $save = new Cart;
        $save->travellerquantity = $request['travellers'];
        $save->getsession = json_encode($getsession, true);
        $save->otherInformation = $request['trip'];
        $save->fare = $totalAmount_orignal ?? $request['fare'];
        $save->timefare = $totalAmount;
        $save->travllername = json_encode($travellerDetails, true);
        $save->phonenumber = $request['phoneNumber'];
        $save->email = $request['email'];
        $save->uniqueid = $uniqueid;
        $save->save();
        $data = $save;
        $trip = "MixDomRou";
        $url = [
            'furl' => 'booking/bookings',
            'surl' => 'booking/bookings',
        ];
        $bankData = DB::table('buzzbankcode')->get();

        $Tfare = $request['fare'];
        $payment_option = DB::table('payment_gateway_options')
            ->where('status', 1)
            ->first();
        if (!empty($payment_option)) {
            if ($payment_option->name == 'Paypal') {
                $payment_link = PaypalRedirector::getredirection($data->fare, $uniqueidamd, 'MixDom', $uniqueidgal);
                if (!empty($payment_link)) {
                    $redirect = $payment_link;
                    return view('payment', compact('sDetail', 'data', 'trip', 'travller', 'Tfare', 'flightdata', 'input', 'bankData', 'url', 'redirect'));
                    // return redirect($payment_link);
                } else {
                    return view('payment', compact('sDetail', 'data', 'trip', 'travller', 'Tfare', 'flightdata', 'input', 'bankData', 'url'));
                }
            } else {
                return view('payment', compact('sDetail', 'data', 'trip', 'travller', 'Tfare', 'flightdata', 'input', 'bankData', 'url'));
            }
        } else {
            // ////////////////////////////
            // dd( $sDetail , $input , $data , $getsession);
            // return view ('payment', compact('sDetail' , 'input' , 'data'  ,  'getsession'));
            // dd(compact('sDetail','data', 'trip', 'travller','totalfare' , 'flightdata','input',   'bankData', 'url'));
            // $details = [$sDetail,$data, $trip, $travller,$totalfare, $flightdata,$input, $bankData, $url];
            return view('payment', compact('sDetail', 'data', 'trip', 'travller', 'Tfare', 'flightdata', 'input', 'bankData', 'url'));
        }
        ///////////////////////////
    }


    public function PaymentSaveGaleliointerRoundTrip(Request $request)
    {

        $input =  $request->all();

        $flightdata = [
            'marketingCompany_1' => $request['otherInformations'] ?? null,
        ];

        $passengers = json_decode($request['travellers'], true);
        $travellerDetails = [];

        // dd($input,$flightdata,$passengers,$travellerDetails);
        // dd($passengers,$travellerDetails);
        if ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] === 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" =>  $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $adult);
            }
        } elseif ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] != 0 && (int) $passengers['noOfInfants'] === 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" =>  $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }



            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
                $chdDob = \DateTime::createFromFormat("Y-m-d", $request['childDOB'][$i]);
                $chdDob = $chdDob->format("d/m/Y");
                $child = [
                    "Title" => $request['childTitle'][$i],
                    "Gender" => $request['childGender'][$i],
                    "FirstName" => $request['childFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['childLastName'][$i],
                    "DateOfBirth" => $chdDob,
                    "PaxType" => "CHD",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $child);
            }
        } elseif ((int) $passengers['noOfAdults'] != 0 && (int) $passengers['noOfChilds'] === 0 && (int) $passengers['noOfInfants'] != 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'] ?? "",
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfInfants']; $i++) {

                $infDob = \DateTime::createFromFormat("Y-m-d", $request['infantDOB'][$i]);
                $infDob = $infDob->format("d/m/Y");
                $infant = [
                    "Title" => $request['infantTitle'][$i],
                    "Gender" => $request['infantGender'][$i],
                    "FirstName" => $request['infantFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['infantLastName'][$i],
                    "DateOfBirth" => $infDob,
                    "PaxType" => "INF",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "MealType" => "",
                    "MealCode" => "",
                    "FFNo" => "",
                    "InfAssPaxName" => "",
                    "TicketNo" => "",
                    "Status" => "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];
                array_push($travellerDetails, $infant);
            }
        } elseif ((int) $passengers['noOfAdults'] > 0 && (int) $passengers['noOfChilds'] > 0 && (int) $passengers['noOfInfants'] > 0) {

            for ($i = 0; $i < $passengers['noOfAdults']; $i++) {
                $adult = [
                    "Title" => $request['adultTitle'][$i],
                    "Gender" => $request['adultGender'][$i],
                    "FirstName" => $request['adultFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['adultLastName'][$i],
                    "DateOfBirth" => $request['adultDOB'],
                    "PaxType" => "ADT",
                    "PassportNumber" => $request['adultPassportNo'][$i] ?? "",
                    "Nationality" => $request['adultNationality'][$i] ?? "",
                    "IssuingCountry" => $request['adultIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['adultPED'] ?? ""
                ];

                array_push($travellerDetails, $adult);
            }

            for ($i = 0; $i < $passengers['noOfChilds']; $i++) {
                $chdDob = \DateTime::createFromFormat("Y-m-d", $request['childDOB'][$i]);
                $chdDob = $chdDob->format("d/m/Y");
                $child = [
                    "Title" => $request['childTitle'][$i],
                    "Gender" => $request['childGender'][$i],
                    "FirstName" => $request['childFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['childLastName'][$i],
                    "DateOfBirth" => $chdDob,
                    "PaxType" => "CHD",
                    "PassportNumber" => $request['childPassportNo'][$i] ?? "",
                    "Nationality" => $request['childNationality'][$i] ?? "",
                    "IssuingCountry" => $request['childIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => $request['childPED'] ?? ""
                ];

                array_push($travellerDetails, $child);
            }

            for ($i = 0; $i < $passengers['noOfInfants']; $i++) {

                $infDob = \DateTime::createFromFormat("Y-m-d", $request['infantDOB'][$i]);
                $infDob = $infDob->format("d/m/Y");
                $infant = [
                    "Title" => $request['infantTitle'][$i],
                    "Gender" => $request['infantGender'][$i],
                    "FirstName" => $request['infantFirstName'][$i],
                    "MiddleName" => "",
                    "LastName" => $request['infantLastName'][$i],
                    "DateOfBirth" => $infDob,
                    "PaxType" => "INF",
                    "PassportNumber" => $request['infantPassportNo'][$i] ?? "",
                    "Nationality" => $request['infantNationality'][$i] ?? "",
                    "IssuingCountry" => $request['infantIssuingCountry'][$i] ?? "",
                    "ExpiryDate" => ""
                ];
                array_push($travellerDetails, $infant);
            }
        }

        $getsession = [
            'SessionID' => json_decode($request['SessionID'], true),
            'ReferenceNo' => json_decode($request['ReferenceNo'], true),
            'Provider' =>  json_decode($request['Provider'], true),
            'Key'      => json_decode($request['Key'], true),
        ];

        //dd($getsession);

        //dd($getsession['ReferenceNo']['Outbound']);

        //$uniqueid = "WT" .$getsession['ReferenceNo']['Outbound']. rand(999, 99999).$getsession['ReferenceNo']['Inbound'];
        $uniqueid = "WT" . $getsession['ReferenceNo'] . rand(999, 99999) . $getsession['ReferenceNo'];
        $save = new Cart;
        $save->travellerquantity = $request['travellers'];
        $save->getsession = json_encode($getsession, true);
        $save->otherInformation = $request['trip'];
        $save->fare = $request['fare'];
        $save->travllername = json_encode($travellerDetails, true);
        $save->phonenumber = $request['phoneNumber'];
        $save->email = $request['email'];
        $save->uniqueid = $uniqueid;
        $save->save();
        $data = $save;
        // dd($data, $uniqueid,$getsession,$passengers);
        // dd($flightdata,$input,$data);

        return view('flight-pages.roundtrip-flight-pages.internation-flight-pages.gl-payment', compact('input', 'data'));
    }
}
