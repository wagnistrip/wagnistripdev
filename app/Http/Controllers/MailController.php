<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use PDF;

class MailController extends Controller {
   public static function bassendToCus($maildata) {
      $resultsellRetriveRepeat = $maildata['resultsellRetriveRepeat'];
      $postvalue =$maildata['postvalue'];
      $data = $maildata['data'];
      $pdf = PDF::loadView('mail/ticket', [
         'resultsellRetriveRepeat' => $maildata['resultsellRetriveRepeat'],
         'postvalue' => $maildata['postvalue'],
         'data' => $maildata['data'],
      ]);
      try{
          
          Mail::send('mail.ticket', $maildata, function($message) use ($resultsellRetriveRepeat , $postvalue , $data ,$pdf) {
             $message->to('developer@maketruetrip.com', 'Wagnistrip.com [No Reply]')->subject
             ('test perpose');
             $message->from('noreply@wagnishtrip.com','Wagnistrip.com [No Reply]');
          });
      }catch(Exception  $e){
          return('/');
      }
   }
   public static function bassendToOff($maildata) {
      $resultsellRetriveRepeat = $maildata['resultsellRetriveRepeat'];
      $postvalue =$maildata['postvalue'];
      $data = $maildata['data'];
      $email = $maildata['email'];
      $id = $maildata['id'];
      try{
          
      Mail::send('mail.ticket', $maildata, function($message) use ($resultsellRetriveRepeat , $postvalue , $data ,$email , $id) {
         $message->to($email, 'for clint')->subject
         ('Ticket id '. $id);
         $message->from('noreply@wagnishtrip.com','Wagnistrip.com [No Reply]');
      });
      }catch(Exception  $e){
          return('/');
      }
   }
   public function sendToOffice($maildata) {
      $data = array('name'=>"Wagnistrip.com [No Reply]");
      try{
          
      Mail::send('hotel-pages.ticket', $maildata, function($message) {
         $message->to('developer@wagnistrip.com', 'for office')->subject
            ('This is a ticket mail by Wagnistrip.com');
         $message->from('noreply@wagnishtrip.com','Wagnistrip.com [No Reply]');
      });
      }catch(Exception  $e){
          return('/');
      }
   }




   ///////////////////////////////////////////////////////////////////////////////
   //////////////////////////// test //////////////////////////////////////////////
   ///////////////////////////////////////////////////////////////////////////////
   public function attachment_email() {
      $data = array('name'=>"Team Dev");
      Mail::send('mail', $data, function($message) {
         $message->to('customercare@wagnistrip.com', 'Test Mail')->subject
            ('Wagnish Trip Testing Mail with Hotel Ticket');
        //  $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
        //  $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('noreply@wagnishtrip.com','Team Dev');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
}