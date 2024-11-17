<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });

    }
    function index()
    {
        return view('user.home');
    }

    function product()
    {
        return view('user.home');
    }

    public function user_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/'.app()->getLocale().'/login');
    }
}
