<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Mail\customMail;

class  Sendmail extends Controller {

    public function sendMail(Request $request){
        $email = $request->email;
        Mail::to($email)->send(new customMail());
        
        if( count(Mail::failures()) > 0 ){
            session::flash('message','There seems to be a problem. Please try again in a while'); 
        return redirect()->back(); 
        }else{                      
            session::flash('message','Thanks for your message. Please check your mail for more details!'); 
            return redirect()->back();  
        }
    }
}
