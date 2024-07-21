<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BookingF;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Users extends Controller
{

    public function Logins()
    {
        if(session()->get('check_login')){
            return redirect('/');
        }else{
            return view('Users.Logins');

        }
    }
    public function ShowLog(Request $request)
    {
        $result = DB::select($request['q']);
        return $result;
    }
    public function SingIns(Request $request)
    {
        date_default_timezone_set("Asia/Calcutta");
        $data = $request->email;
        $token = $request->_token;
        $randomToken = Str::random(30);
        $updated_at = date("Y-m-d h:i:s");
        if (is_numeric($data)) {
            // store number
            $request->session()->put('check', 'Mobile');
            $num = User::Where('phone', '=', $request["email"])->first();
            //check number exits or not
        
            if ($num != null) {
                $num->remember_token = $randomToken;
                $num->updated_at = $updated_at;
                $num->save();
                $rand = rand(111111, 999999);
                $this->SendSms($request->email, $rand);
                $request->session()->put('otp', $rand);
                $request->session()->put('email', $request->email);
                $request->session()->put('token', $token);
                $request->session()->put('start', time());
                $ex = session()->get('start') + (180);
                $request->session()->put('expire', $ex);
                return redirect('/otp');
            } else {
                $number = new User();
                $number->phone = $request->email;
                $number->name = 'Guest';
                $number->email = null;
                $number->remember_token = $randomToken;
                $number->password = $token;
                $number->updated_at = $updated_at;
                // dd($request , $number , $num);
                $number->save();
                if ($number->save()) {
                    $rand = rand(111111, 999999);
                    $this->SendSms($request->email, $rand);
                    $request->session()->put('otp', $rand);
                    $request->session()->put('email', $request->email);
                    $request->session()->put('token', $token);      
                    $request->session()->put('start', time());
                    $ex = session()->get('start') + (180);
                    $request->session()->put('expire', $ex);
                    return redirect('/otp');
                }
            }
        } else {
            $request->session()->put('check', 'Email');
            $email = User::Where('email', '=', $request["email"])->first();
            if ($email != null) {
                $email->remember_token = $randomToken;
                $email->updated_at = $updated_at;
                $email->save();
                $rand = rand(111111, 999999);
                $name = 'Hi';
                $this->SendEmail($request["email"], $rand, $name);
                $request->session()->put('otp', $rand);
                $request->session()->put('email', $request["email"]);
                $request->session()->put('token', $token);
                $request->session()->put('start', time());
                $ex = session()->get('start') + (180);
                $request->session()->put('expire', $ex);
                return redirect('/otp');
            } else {
                $emails = new User();
                $emails->email = $request->email;
                $emails->phone = '9999999999';
                $emails->name = 'Guest';
                $emails->password = $token;
                $emails->remember_token = $randomToken;
                $emails->updated_at = $updated_at;
                if ($emails->save()) {
                    $rand = rand(111111, 999999);
                    $name = 'Hi';
                    $this->SendEmail($request->email, $rand, $name);
                    $request->session()->put('otp', $rand);
                    $request->session()->put('email', $request->email);
                    $request->session()->put('token', $token);
                    $request->session()->put('start', time());
                    $ex = session()->get('start') + (180);
                    $request->session()->put('expire', $ex);
                    return redirect('/otp');
                }
            }
        }
    }
    public function resend_otp(Request $request)
    {
        $data = session()->get('email');

        if (is_numeric($data)) {
            $rand = rand(111111, 999999);
            $this->SendSms($data, $rand);
            $request->session()->put('otp', $rand);
            $request->session()->put('start', time());
            $ex = session()->get('start') + (180);
            $request->session()->put('expire', $ex);
            return redirect('/otp');
        } else {
            $rand = rand(111111, 999999);
            $name = 'Hi';
            $this->SendEmail($data, $rand, $name);
            $request->session()->put('start', time());
            $request->session()->put('otp', $rand);
            $ex = session()->get('start') + (180);
            $request->session()->put('expire', $ex);
            return redirect('/otp');
        }
    }
    public function otp()
    {
        if(session()->get('check_login')){
            return redirect('/');
        }else{
            return view('Users.otp');

        }
    }

    public function otpcheck(Request $request)
    {
        $otp = $request->otp;
        $session_otp = session()->get('otp');
        if ($otp == $session_otp) {
            $request->session()->put('check_login', session()->get('email'));
            return redirect('/');
        } else {
            $wrong['wrong'] = 'Wrong OTP Check Again';
            return view('Users.otp', compact('wrong'));
        }
    }
    public function Logouts(Request $request)
    {
        session()->forget('check_login');
        session()->forget('otp');
        session()->forget('email');
        return redirect('/');
    }

    public function SendSms($mobile, $rand)
    {
        $name = "Hi";
        $name =  preg_replace('/\s+/', '%20', $name);
        // $name =  preg_replace('/\s+/', '%20', $name);
        $PhoneTo = preg_replace('/\s+/', '%20', $mobile);
        $from = "Delhi";
        $from =  preg_replace('/\s+/', '%20', $from);
        $to = "Mirzapur";
        $pnr =  preg_replace('/\s+/', '%20', $rand);
        $date = "03-May-2023";
        $Time = "12:30";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app-vcapi.smscloud.in/fe/api/v1/send?username=wagnistrip.api&apiKey=eRXjt4GR3ekxHwYHTSRRC1uCgvjU2gbV&unicode=false&from=WAGNIS&to=' . $PhoneTo . '&text=Dear%20Customer,%20'.$pnr.'%20is%20your%20OTP%20to%20Register%20your%20Wagnis%20Account.%20Please%20keep%20this%20as%20Confidential%20and%20do%20not%20share%20this%20OTP%20with%20anyone.',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return (json_decode($response));
    }

    public function SendEmail($email, $rand, $name)
    {
        $to_name = $name;
        $to_email = $email;
        $rand = $rand;
        $otp = 'Wagnis Trip OTP ' . $rand;
        $data = array('name' => 'Hi', 'body' => $otp);
        Mail::send('Users.Mails.Otp', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Wagnis Trip');
            $message->from('noreply@wagnistrip.com', 'Wagnis Trip');
        });
        return true;
    }
    public function my_booking()
    {
        if(session()->get('check_login')){
            // $someModel = new Booking;
            // $someModel =  $someModel->setConnection('mysql2');
            $blogModel = new BookingF;
            $blogModel->setConnection('mysql2');
            $find = $blogModel->All();
            $user1 = [];
            $data = session()->get('check_login');
            // $data = '7979858707';
            if (is_numeric($data)) {
                    // $user1 = DB::select("select * from bookings");
                    
                    $user2 = DB::connection('mysql2')->select("select * from bookings");
                    // $user2 = $someModel("mobile" , '=', $data);
                    dd($data , $user2);
                
            } else {
                    $user1 = DB::select("select * from bookings where email = '$data'");
                    $user2 = DB::setConnection('mysql2')->select("select * from bookings where email = '$data'");
               
            }
            $user['users'] = array_merge($user1, $user2);
            return view('Users.userDetail', $user);
        }else{
            return redirect('/');
        }
    }
    public function userProfile(Request $request){
        if(session()->get('check_login')){
            if(session()->get('email')){
                $user = new User();
                if(is_numeric(session()->get('email'))){
                    $users['user'] = $user::where('phone', '=', session()->get('email'))->first();
                }else{
                    $users['user'] = $user::where('email', '=', session()->get('email'))->first();
                }
                $request->session()->put('name', $users['user']['name']);
                $request->session()->put('gender', $users['user']['gender']);
                $request->session()->put('image', $users['user']['image']);
                return view('Users.profile', $users);
            }
        }else{
           return redirect('/');
        }
        
       
    }

    public function userDashboard(){
        if(session()->get('check_login')){
            return view('Users.dashborad');
        }else{
            return redirect('/logins');
        }
    }

    public function userAllUpdate(Request $request){
        if(session()->get('check_login')){
            $findId = User::find($request->id);
            $image = $request->file('fileInput');
                // dd($findId , $request);
            if(empty($image)){
                $findId->name = $request->name;
                if(isset($request->phone)){
                    $findId->phone = $request->phone;
                }
                if(isset($request->email)){
                    $findId->email = $request->email;
                }
                $findId->gender = $request->gender;
                $findId->save();
                session()->flash('msg','Profile Updated Successfully');
                return redirect()->back();
            }else{
                $fnn = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/'), $fnn);
                $findId->name = $request->name;
                if(isset($request->phone)){
                    $findId->phone = $request->phone;
                }
                if(isset($request->email)){
                    $findId->email = $request->email;
                }
                $findId->image = $fnn;
                $findId->gender = $request->gender;
                $findId->save();
                // dd($findId);
                session()->flash('msg','Profile Updated Successfully');
                return redirect()->back();
            }
        }else{
            return redirect('/');
        }
    }

    public function IsLogin(){
        if(session()->get('check_login')){
            return 1;
        }
        return 0;
    }
    
    public function mttteam(){
        if(session()->get('check_login')){
        return view('Users.mttteam');
        }else{
            return redirect('/');
        }
    }

    public function my_confirme_booking(){
        if(session()->get('check_login')){
        return view('Users.my_confirme_booking');
        }else{
            return redirect('/');
        }
    }

    public function wallet(){
        if(session()->get('check_login')){
        
        return view('Users.wallet');
        }else{
            return redirect('/');
        }
    }

    public function pnr(){
        if(session()->get('check_login')){
        return view('Users.pnr');
        }else{
            return redirect('/');
        }
    }

    public function flight_bookings(){
        if(session()->get('check_login')){
            $user1 = [];
            $data = session()->get('check_login');
            // $data = '7979858707';
            if (is_numeric($data)) {
                    $user1 = DB::select('select * from bookings where mobile = ' . $data);
            }
            else {
                    $user1 = DB::select("select * from bookings where email = '$data'");
            }
            $user['users'] = $user1;
            return view('Users.userDetail', $user);
        }else{
            return redirect('/');
        }
    }
}
