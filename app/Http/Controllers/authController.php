<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Validator;
use Session;

class authController extends Controller
{
    //登入控制器-start
    public function loginView()
    {
        $binding = [
            'title' => '網站登入',
        ];
        return view('auth.login', $binding);
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $token=bcrypt(Str::random(15));
            User::where('email', Auth::user()->email)
                    ->update(['remember_token' => $token]);
            $user = Auth::user();
            return dd($user->remember_token);
        } else {
            return dd('no');
        }
    }
    //登入控制器-end

    //註冊控制器-start
    public function registerView()
    {
        $binding = [
            'title' => '網站註冊',
        ];
        return view('auth.register', $binding);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string','between:6, 12'],
            'email' => 'required|email|unique:users',
            'password' => ['required','string','between:6, 12'],
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()]);
        } else {
            $input=$request->all();

            $input["password"]=bcrypt($input["password"]);

            $user = User::create($input);

            return response()->json(['success'=>'註冊成功'], 200);
        }
    }
    //註冊控制器-end
}
