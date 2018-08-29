<?php

namespace App\Http\Controllers;

use Hash;
use Sentinel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function getProfile($username)
    {
        $user =\App\User::whereUsername($username)->first();
        if($user)
        {
            return view('user.profile')->with('user',$user);
        }
        if(Sentinel::hasAnyAccess(['admin.*','moderator.*']))
        {
            return redirect()->route('admin.dashbord')->with('error','no user with this name');
        }
        return redirect()->route('user.dashbord')->with('error','no user with this name');

    }

    function postProfile()
    {
        /**
         *"email" => "k@k.com"
        "password" => "000"
        "first_name" => "ahmed"
        "last_name" => "koko"
        "location" => "egypt"
         */
        $user = Sentinel::getUser();
        request()->validate([
            'email' => "nullable|email|unique:users,email,$user->id",//ignore to this email if is in database
            'first_name' => 'nullable|min:3|max:16|alpha',
            'last_name' => 'nullable|min:3|max:16|alpha',
            'location' => ['regex:/^[a-zA-Z0-9-_. ]*$/','nullable','min:3','max:40'],
            'password' => 'required|string|min:3|max:15',
            'profile_picture' => 'nullable|max:1999|image|mimes:jpg,jpeg,png',

        ]);
        if(\Hash::check(request('password'),$user->password)){
            if (request()->hasFile('profile_picture')){
                $file_ext = \request()->file('profile_picture')->getClientOriginalExtension();
                $file_name_new =str_random(10) . time() . '.' . $file_ext;
                $file_path = \request()->file('profile_picture')->move(public_path().'/profile_picture/',$file_name_new);
            }
            $user->email= request('email') ?? $user->email;
            $user->first_name= request('first_name') ?? $user->first_name;
            $user->last_name= request('last_name') ?? $user->last_name;
            $user->location= request('location') ?? $user->location;
            $user->profile_picture= $file_name_new ?? $user->profile_picture;
            $user->save();
            return redirect()->route('admin.dashbord')->with('success','updated successfully');

        }else{
            return redirect()->back()->with('error','invalid password');
        }


    }
}
