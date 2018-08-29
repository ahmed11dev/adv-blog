<?php

namespace App\Http\Controllers;

use Sentinel;
use Illuminate\Http\Request;

class adminController extends Controller
{
    //
    function index()
    {
        $user =Sentinel::getUser();
        return view('admin.dashbord',compact('user'));
    }
}
