<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (Auth::user() && Auth::user()->status){
            $admin = Session::get('admin');

            if (Auth::user()->role != 'user' && $admin == '1') {

                return redirect()->route('admin.home',['locale'=>app()->getLocale()]);
            }
            if (Auth::user()->role == 'user' && $admin == null){
                return redirect()->route('user.home',['locale'=>app()->getLocale()]);
//                return redirect(app()->getLocale().'/user/home');
            }

            else{
                Auth::logout();
                Session::forget('admin');
                Session::forget('user');
                Session::forget('email');
                return redirect()->route('login',['locale'=>app()->getLocale()])->withErrors(['block'=>'An error has occurred']);
            }
        }
        else{
            Auth::logout();
            Session::forget('admin');
            Session::forget('user');
            Session::forget('email');
            return redirect()->route('login',['locale'=>app()->getLocale()])->withErrors(['block'=>'An error has occurred, please contact management.']);
        }
    }
}
