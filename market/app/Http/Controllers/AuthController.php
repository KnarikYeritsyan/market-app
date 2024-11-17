<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('api_auth:api', ['except' => ['login','register','refresh']]);
    }
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
            'name'  => 'required|string',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 201);
    }
    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'  => 'required|min:3',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $credentials = $request->only('email', 'password');
        try {
        if ($token = $this->guard()->attempt($credentials)) {
//            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
            $auth = true;
            $user = auth('api')->user();
            return response()->json(compact('token','user','auth'), 200)->header('Authorization', $token);
        }
        }catch (JWTException $e){
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    public function user(Request $request)
    {
//        return response()->json(auth('api')->user());
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ],200);
//        return response()->json(compact('user'),200);
    }
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['token' => $token], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['message' => 'refresh_token_error'], 401);
    }
    private function guard()
    {
        return Auth::guard('api');
    }
}