<?php

namespace App\Http\Controllers\auth;

use Hash;
use Sentinel;


use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    function getChangePassword()
    {
        return view('auth.change-password');
    }

    function postChangePassword()
    {
        if (Sentinel::check())
        {
            $user = \App\User::whereEmail(Sentinel::getUser()->email)->first();
            if($user)
            {
                request()->validate([
                    'current_password' => 'required|string',
                    'password' => 'required|confirmed',
                ]);
                if(Hash::check(request('current_password'),Sentinel::getUser()->password))
                {
                    $user->password = Hash::make(request('password'));
                    $user->save();
                    if (Sentinel::hasAnyAccess('admin.*'))
                    {
                        return redirect()->route('admin.dashbord')->with('success','password has been change');
                    }
                }else{
                    return redirect()->back()->with('error','password wrong');
                }
            }else{
                return redirect()->route('login')->with('error','must login first');
            }
        }
    }
}
