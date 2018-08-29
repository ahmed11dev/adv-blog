<?php

namespace App\Http\Controllers\auth;


use Sentinel;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailActivationController extends Controller
{
    public function activateUser($email,$token)
    {
        if ($user =User::whereEmail($email)->first()) {
            $user =Sentinel::findById($user->id);
            if (Activation::exists($user)->code === $token){
                if (Activation::complete($user,$token)){
                    Activation::removeExpired();

                    if(Sentinel::login($user,true)){
                        return redirect()->home()->with('success','you are active now');

                    }
                }
            }else{
                return redirect()->route('login')->with('error','token not found');
            }
        }else{
            return redirect()->route('login')->with('error','invalid email');
        }
    }
}
