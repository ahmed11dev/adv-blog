<?php

namespace App\Http\Controllers\auth;
use Sentinel;
use Cartalyst\Sentinel\Checkpoints\{NotActivatedException,ThrottlingException};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }
    public function postLogin()
    {

        \request()->validate([
            'email' => new \App\Rules\usernameOrEmail,
            'password' => 'required|string|min:3|max:20',
            'remember' => 'in:on,null'
        ],['remember.in'=> ' the value is not on']); // if the value of remember button not on

        $remember =false;
        if (\request('remember') === 'on'){
            $remember = true;
        }

            try{
                //يمكن استخدام مثود forceAuthanticate علشان تعمل login بدون عمل اوثانتيكيت
                    $user =Sentinel::authenticate([
                        'login' => request('email'),  // you can use 'email' or 'username'
                        'password' => request('password'),
                    ],$remember);

                    if (Sentinel::check() && $user->hasAnyAccess(['admin.*','moderator.*'])){
                        return redirect()->route('admin.dashbord')->with('info','welcome admin');

                    }elseif (Sentinel::check() && $user->hasAccess('user.*'))
                    {
                        return redirect()->route('user.dashbord')->with('info','welcome user');

                    }
                    return redirect()->back()->with('error','user name or password wrong');
            }catch (NotActivatedException $e){
                return redirect('login')->with('error','you must activate your account');
            }catch (ThrottlingException $e){
                return redirect('login')->with('error',$e->getMessage());
            }



    }



    public function logout()
    {
        Sentinel::logout();
        return redirect()->route('login')->with('info','loged out successfuly'); // or route('home');

    }
}
