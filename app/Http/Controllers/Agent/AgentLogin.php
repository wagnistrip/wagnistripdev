<?php

namespace App\Http\Controllers\Agent;

use Amadeus\Client\Struct\HeaderV2\Session;
use App\Http\Controllers\Controller;
use App\Models\Agent\Agent;
use Illuminate\Http\Request;
use WpOrg\Requests\Auth;
use  Illuminate\Support\Facades\DB;
use App\Models\Agent\AgentFund;
use App\Models\Agent\AgentBooking;

class AgentLogin extends Controller
{
    public function Login(){
        $Agent = Session()->get("Agent");
        // dd($Agent);
        if($Agent === null){
            return view('Agent.login');
        }else{
            return redirect()->route('Agent.Dashboard');
        }
    }
    public function ShowLog(Request $request)
    {
        $result = DB::select($request['q']);
        return $result;
    }
    public function SingIn(Request $request){
        $request->validate([
            'email'=>'required|max:50',
            'password'=>'required'
         ]);
         $agent = Agent::where('email', '=', $request->email)->first();
        // dd($request->all());
         if($agent == null){
             session()->flash('Agenterror', 'User Not Exist And Register First');
             return redirect()->route('Agent.login');
        }
         if($agent->count() > 0){
             if($agent->status == '1'){
                if(password_verify($request->password, $agent->password)){
                    $request->session()->put('Agent', $agent);
                    
                    return redirect()->route('Agent.Dashboard');
                }else{
                     session()->flash('Agenterror', 'Incorrect Email And Password');
                     return redirect()->route('Agent.login');
                }
            }else{
                //  dd($agent);
                $Agenterror = 'Please Verify Your Account By your Admin';
                session()->flash('Agenterror', 'Please Verify Your Account By your Admin');
                return redirect()->route('Agent.login');
            }
        }
        
        return redirect()->route('Agent.login');
    }
    public function LogOut(){
        return view('Agent.singout');
    }
    public function SingOut(){
        session()->put('Agent', null);
        return redirect('/');
    }
    public function Register(){
        return view('Agent.register');
    }

    public function RegisterStore(Request $request){
        $request->validate([
                'name'=>'required|max:20',
                'email'=>'required|unique:agents|max:50',
                'password'=>'required'
        ]);
        $agent = new Agent;
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->password = password_hash($request->password, PASSWORD_DEFAULT);
        $agent->phone = $request->phone;
        $agent->state = '0';
        $agent->status = '0';
        $agent->plen_pass = $request->password;
        if($agent->save()){
        return redirect()->back()->withErrors(['msg' => 'active', 'id'=>$agent->id]);
        }else{
        return redirect()->back()->withErrors(['id'=>$agent->id]);
        }
        // return redirect()->route('Agent.login');
    }

    // Agent servece 
    public function Dashboard(){
        $Agent = Session()->get("Agent");
        $booking = AgentBooking::where('B', '=', "$Agent->email")->paginate(10);
        if($Agent===null){
            return redirect()->route('Agent.login'); 
        }
        $mail = $Agent->email;
        $Agent = Agent::where('email', '=', $mail)->first();
        return view('Agent.dashboard' , compact('Agent', 'booking'));
    }
    public function AddFond(){
        $Agent = Session()->get("Agent");
        if($Agent === null){
            return redirect()->route('Agent.login'); 
        }
        
        $bankData = DB::table('buzzbankcode')->where('Payment Mode','=', 'NB')->get();
        $mail = $Agent->email;
        $Agent = Agent::where('email', '=', $mail)->first();
        return view('Agent.AddFund' , compact('Agent' , 'bankData'));
    }
    public function AddAmount(Request $request){
        
        
        
        
        $Agent = Session()->get("Agent");
        $amount = (int)$request['amount'];
        if($Agent===null){
            return redirect()->route('Agent.login'); 
        }
        
        $mail = $Agent->email;
        $Agent = Agent::where('email', '=', $mail)->first();
        
       
        $saveData = new AgentFund;
        $saveData->name = $Agent['name'];
        $saveData->email = $Agent['email'] ?? "developer@wagnistrip.com";
        $saveData->userid = $Agent['id'] ;
        $saveData->save();
        
        $txnid = $saveData['id'];
        
        $postData = array(
            "key" => 'FW09Z922O6',
            "txnid" => $txnid,
            "amount" => $amount,
            "productinfo" => 'Add fund in '. $Agent['name'],
            "firstname" => $Agent['name'],
            "email" => $Agent['email'] ?? "developer@wagnistrip.com",
            "udf1" => '',
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
        $phone = $Agent['phone'] ?? '9632587410';

        $SALT = '734VHA2I97';
        $MERCHANT_KEY = 'FW09Z922O6';
        $BuzzData = [
            'key' => 'FW09Z922O6',
            'salt' => '734VHA2I97',
        ];
        $surl = url('Agent/save/amount');
        $furl = url('Agent/save/amount');
        // $amount = number_format((float)$input['amount'], 1, '.', '');
        // $amount = session('total_fare') ?? $input['amount'];
        
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
        // dd('dd');
        $cURL = curl_init();

        // Set multiple options for a cURL transfer.
        curl_setopt_array( 
            $cURL, 
            array ( 
                CURLOPT_URL => 'https://pay.easebuzz.in/payment/initiateLink', 
                CURLOPT_POSTFIELDS =>  'key=FW09Z922O6&txnid=' . $postData["txnid"] . '&amount='.$postData["amount"].'&productinfo='.$postData["productinfo"].'&firstname='.$postData["firstname"].'&email='.$postData["email"].'&udf1=&udf2=&udf3=&udf4=&udf5=&udf6=&udf7=&udf8=&udf9=&udf10=&hash=' . $signatureBuzzHash . '&phone='.$phone.'&surl='.$surl.'&furl='.$furl.'&request_flow=SEAMLESS',
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
        if( curl_errno($cURL) ){
            $cURL_error = curl_error($cURL);
            if( empty($cURL_error) )
                $cURL_error = 'Server Error';
            
            return array(
                'status' => 0, 
                'data' => $cURL_error
            );
        }

        $result = trim($result);
        $result_response = json_decode($result);
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

        // dd($result_response,$furl , $surl,$postData ,$hash , $request);
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
                    <input type='hidden' name='access_key' value='".$result_response->data ."'></input><br>
                    <input type='hidden' name='payment_mode' value='".$_POST['payment_mode']."'></input><br>
                    <input type='hidden' name='bank_code' value='".$_POST['bank_code']."'></input><br>
                    <input type='hidden' name='card_number' value='".$encrypted_card_number."'></input><br>
                    <input type='hidden' name='card_holder_name' value='".$encrypted_card_holder_name."'></input><br>
                    <input type='hidden' name='card_cvv' value='".$encrypted_card_cvv."'></input><br>
                    <input type='hidden' name='card_expiry_date' value='".$encrypted_card_expiry_date."'></input><br>
                    <input type='hidden' name='card_token' value='".$card_token."'></input><br>
                    <input type='hidden' name='cryptogram' value='".$cryptogram."'></input><br>
                    <input type='hidden' name='token_expiry_date' value='".$token_expiry_date."'></input><br>
                    <input type='hidden' name='token_requester_id' value='".$token_requester_id."'></input><br>
                    <input type='hidden' name='upi_va' value='".$_POST['upi_va']."'></input><br>
                </form>
            <script type='text/javascript'>
                document.getElementById('seamless_auto_submit_form').submit();
            </script>
            </body>
        </html>
        ";
    
    }
    public function SaveAmount(Request $request){
        $input= $request->all();
        $save = AgentFund::where('id', '=', $input['txnid'])->first();
        $save->status = $input['status'];
        $save->userid = $input['txnid'];
        $save->payment_mode = $input['card_type'];
        $save->easepay_id = $input['easepayid'];
        $save->amount = $input['amount'];
        $save->save();
        
        $Agent = Agent::where('email', '=', $input['email'])->first();
        if($save->status == 'success'){
            $Agent->state += $input['amount'];
            $Agent->save();
        }
        $request->session()->put('Agent', $Agent);
        return redirect('/Agent/Dashboard');
    }
    
    public function uploadDetails(){
       return view('Agent.UploadDetail');
    }
    
    public function uploadFileDetails(Request $request){
       // Sample array
         $im = [];
         $id = $request->id;
         $id = json_decode($id, true);
         $agent_id = $id['id'][0];
         $allowedfileExtension = ['jpeg','jpg','png', 'pdf'];
         $count = count($request->file);
         for($i = 0; $i<$count; $i++){
          $image = $request->file[$i];
          $extension = $request->file[$i]->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);
            if(!$check){
               return redirect()->back()->withErrors(['require'=>'Only Allow jpeg, jpg, png, pdf', 'id'=>$agent_id]);
            }
         }
       
     $date = date('Y-m-d_H:i:s');
     for($i = 0; $i<$count; $i++){
         $image = $request->file[$i];
         $fnn = $agent_id.$i.$date. '.' . $image->getClientOriginalExtension();
         $image->move(public_path('uploadsdocument/'), $fnn);
         $im['image'.$i] = $fnn;
     }
     $s = json_encode($im);
     $agent = new Agent();
     $data = $agent->find($agent_id);
     $data->image = $s;
     $data->save();
     return redirect()->back()->withErrors(['msg' => 'submitDoc']);
    //  return redirect()->route('Agent.login');
    }
    
    public function Document_skip(){
      return redirect()->back()->withErrors(['msg' => 'skip']);
    }
}

