<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        app()->setLocale($request->segment(1));
        $this->redirectTo = '/'.app()->getLocale().'/home';
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        Session::forget('admin');
        if (isset($request['admin_user']) && $request['admin_user'] == 'admin'){
            session(['admin'=>'1']);
        }
        session(['email' => $request['email']]);
        $request->validate([
            $this->username() => 'required|email',
            'password' => 'required|string',
        ]);
    }

/*    public function redirectTo(){
        return '/'.app()->getLocale().'/home';
    }*/
/*    public function redirectTo(){
        if (Auth::user()->status){
        if (Auth::user()->role == 'admin'){
            return app()->getLocale().'/admin/home';
        }else{
            return app()->getLocale().'/user/home';
        }
        } else{
                Auth::logout();
                Session::forget('admin');
                Session::forget('user');
                return app()->getLocale().'/login';
            }
    }*/
}
