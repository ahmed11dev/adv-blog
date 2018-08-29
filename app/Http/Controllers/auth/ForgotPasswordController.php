<?php

namespace App\Http\Controllers\auth;

use Sentinel;
use Activation;
use Reminder;
use App\User;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
        public function postForgotPassword()
        {
            \request()->validate([
                'email' => 'required|string',
            ]);

            $user = User::whereUsernameOrEmail(request('email'),request('email'))->first();
            if (count($user) === 0){
                return redirect()->route('login')->with('info','email has been send');
            }
            $user =Sentinel::findById($user->id); // لازم نجيب اليوزر من خلال السينتينل علشان كلاس الاكتيفيشن ميعملش ايرور
            if (Activation::completed($user)){
                $reminder = Reminder::exists($user)?:Reminder::create($user);
                $this->sendEmail($user,$reminder->code);
                return redirect()->route('login')->with('success','email has been send');

            }else{
                return redirect()->route('login')->with('error','activate your account first');

            }

        }

        private function sendEmail($user,$token){

            Mail::send('emails.forgot-password',['user' => $user,'token' =>$token],function($message) use($user){
                $message->to($user->email);
                $message->subject('reset your password ahmed basha');// title el message
            });
        }
}
