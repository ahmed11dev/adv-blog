<?php

namespace App\Http\Controllers\auth;

use Mail;
use App\Mail\activation as UserActivation;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function getRegister()
    {
        return view('auth.register');
    }
    public function postRegister()
    {
        \request()->validate([
            'email' => 'required|unique:users,email|email',
            'username' => 'required|min:3|max:16|alpha_dash|unique:users,username',
            'first_name' => 'required|min:3|max:16|alpha',
            'last_name' => 'required|min:3|max:16|alpha',
            'location' => ['regex:/^[a-zA-Z0-9-_. ]*$/','required','min:3','max:40'],
            'password' => 'required|string|min:3|max:15|confirmed',
            'security_question'=>'required|in:where_are_you_from,how_are_you',
            'security_answer' => 'required|min:3|max:16',
            'dob' => 'required|date|before_or_equal:2018-12-10|date_format:Y-m-d',
        ]);

        //ممكن استخدام ميثود ريجيستر ( لعمل ريجيستر بدون اكتيفيشن
        $user = Sentinel::register([
            'email' => request('email'),
            'username' => request('username'),
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'location' => request('location'),
            'password' => request('password'),
            'security_question' =>request('security_question'),
            'security_answer' =>request('security_answer'),
            'dob' => request('dob'),
        ]);

        $token = Activation::create($user); // make active code in activation table to this user
        // ---------- sending mail after register
      //  Mail::to($user)->send(new UserActivation($user,$token));

        //---------- attach role to user
        $role = Sentinel::findRoleBySlug('user');
        $role->users()->attach($user);

           return redirect()->route('login')->with('success','you are registered successfuly ahmed beh');
    }




}
