<?php


namespace App\Http\Traits;


use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

trait SendEmail
{
   protected function send_EmailFun($email,$text,$subject){
       $setting=Setting::first();
       $contact_company=$setting->ar_title;
       Mail::send([
           'html' => 'admin.setting.email-tem'],
           ['text' => $text,'email'=>$email,'logo'=>$setting->logo,'title'=>$contact_company],
           function($message) use ($email, $subject, $contact_company)
           {
               $message->to($email,$contact_company)->subject($subject);
           }
       );
   }//end fun

}//end trait