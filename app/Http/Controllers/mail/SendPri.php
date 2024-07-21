<?php

namespace App\Http\Controllers\mail;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\UserQuery;
use Config;
// use Mail;

class SendPri extends Controller {
    public static function SendSave(Request $request) {

        $i = 0;
        $image = [];
        $names = [];
        if(!empty($request->avatar)){
            foreach($request->file('avatar') as $image)
            {
                $destinationPath = 'public/uploads/';
                $filename = $image->getClientOriginalName();
                $image->move($destinationPath, $filename);
                array_push($names, $filename);          
        
            }
        }
        $data = $request->all();
        $UserQuery = new UserQuery;
        $UserQuery->tital=$data['title'] ;
        $UserQuery->Query = json_encode( $data , true) ;
        $UserQuery->save();
        
      
        if($data['email'] != null){
            try{
                $mail = Mail::send('MailPri.events', $data, function($message)use($data) {
                    $message->to($data['email'])
                        ->subject( 'Visa Query');
                    $message->from('noreply@wagnistrip.com', 'Wagnis Trip');
                        // ->attachData($files->output(), $bookings['title'].".pdf");
                       
                });
                }catch(Exception $e){
                return ('/');
            }
        }
          
        $dataOff = ['data'=>$data];
        try{
            Mail::send('MailPri.office', $dataOff, function($message) use($dataOff) {
                $message->to('customercare@wagnistrip.com')
                ->subject($dataOff['data']['title']);
                $message->from('noreply@wagnistrip.com', 'Wagnis Trip');
            });
        }catch(Exception $e){
            return Redirect::back()->with('mess' , 'Oops! Check your Email id');
        }
        
            return Redirect::back()->with('mess' , 'Check your Email id');
        
        
        //  \Mail::send('MailPri.events', $data, function($message)use($data) {
        //             $message->to("developer@wagnistrip.com")
        //                 ->subject( 'Visa Query');
        //                 // ->attachData($files->output(), $bookings['title'].".pdf");
        //     });
            
        // \Mail::send('MailPri.events', $data, function($message) use($data) {
        //     $message->to($data['email'])
        //     ->subject($data['title']);
        // });
        
        // \Mail::send('flight-pages.booking-confirm.amd-email_content', $both, function($message)use($both ,$files) {
        //     $message->to($both['email'])
        //             ->subject( $both['title'])
        //             ->attachData($files->output(), $both['title'].".pdf");
          
        // });
        
    }
    
    
    public static function Sendfile(Request $request) {
        $data = $request->all();
        
        $UserQuery = new UserQuery;
        $UserQuery->tital=$data['title'] ;
        $UserQuery->Query = json_encode( $data , true) ;
        $UserQuery->save();

        // return Redirect::back()->with('mess' , 'Your Query has been submitted');
        $files = $request->file('ffileno');
        // dd($data);
        try{
            
            Mail::send('MailPri.events', $data, function($message) use($data) {
                $message->to($data['email'], 'for clint')->subject($data['title']);
                $message->from('noreply@wagnistrip.com','Wagnistrip');
            });
            $dataOff = ['data'=>$data , 'file'=>$files];
            // dd($dataOff);
            Mail::send('MailPri.office', $dataOff, function($message) use($dataOff) {
                $message->to('developer@maketruetrip.com', 'for office')->subject($dataOff['data']['title']);
                $message->from('noreply@wagnistrip.com','Wagnistrip');
                // $message->attach($dataOff['file']);
            });
            return Redirect::back();
        }catch(Exception $e){
            return Redirect::back();
            
        }
    }
}
