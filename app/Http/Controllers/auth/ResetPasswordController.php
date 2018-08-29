<?php

namespace App\Http\Controllers\auth;

use Sentinel;
use Activation;
use Reminder;
use App\User;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class ResetPasswordController extends Controller
{
    function getPasswordResetThroughEmail($email,$token){
        $user = User::whereEmail($email)->first();
        if($user){
                $user = Sentinel::findById($user->id);
                if (Reminder::exists($user)->code === $token){
                    \Session::put('user',$user);
                    \Session::put('token',$token);
                    return view('auth.reset-password');
                }else{
                    return redirect()->route('login')->with('error','invalid token');

                }
        }else{
            return redirect()->route('login')->with('error','email dos not exists');
        }
    }

    function postPasswordResetThroughEmail()
    {
        request()->validate([
            'password' => 'required|min:3|max:20|confirmed',
        ]);
        if ($reminder =Reminder::complete(\Session::get('user'),\Session::get('token'),\request('password')))
        {
            Reminder::removeExpired();
            \Session::flush();
            return redirect()->route('login')->with('success','password change successfuly');
        }else{
            return redirect()->route('login')->with('error','email or token not correct');

        }
    }

    function getPasswordResetThroughQuestion()
    {
        return view('auth.resetByQuestion');
    }
    function postPasswordResetThroughQuestion1()
    {
        request()->validate([
            'email' => 'required|email',
        ]);
        $user = \App\User::whereEmail(request('email'))->first();
        //$user =Sentinel::findById($user);
      //  if (\Activation::completed($user))// check if the account is activated
     //   {
            $user = \App\User::where('email',request('email'))->first();

            if ($user)
            {
                \Session::put('user',$user);
                return redirect()->back()->with('question',$user->security_question);

            }else{
                return redirect()->route('login')->with('error','invaled data');

            }
      //  }else{
        //    return redirect()->route('login')->with('error','this account is not activated');

     //   }
    }

    function postPasswordResetThroughQuestion2()
    {
        request()->validate([
            'security_answer' => 'required|string',
        ]);
        if (\Session::exists('user'))
        {
            $user =User::where(['security_answer' => request('security_answer') ])->first();
            if ($user)
            {

                return redirect()->back()->with(['success'=>'you no go to stage 3','stage3'=>'this is stage 3']);

            }else{
                return redirect()->back()->with('error','invaled data');

            }
        }
        \Session::flush();

    }

    function postPasswordResetThroughQuestion3()
    {
        request()->validate([
            'password' => 'required|string',
        ]);
        if (\Session::exists('user'))
        {
            $user =User::where(['email' => \Session::get('user')->email,'security_answer' => \Session::get('user')->security_answer])->first();
            if ($user){
                $user->password = bcrypt(\request('password'));
                $user->save();

                return redirect()->route('login')->with('seccess','password change successfuly');
                \Session::flush();
            }else{
                \Session::flush();
                return redirect()->route('login')->with('error','invalid data');
            }
        }
        \Session::flush();

    }


}