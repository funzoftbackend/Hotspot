<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Company;
class LoginController extends Controller
{
    public function login(Request $request)
    {
    
    return view('login');
    }
    public function signup(Request $request)
    {
    
    return view('signup');
    }
    public function forgot_password(Request $request)
    {
    
    return view('forgot-password');
    }
    public function error()
    {
    
        return response()->json(['success' => 'false','message' => 'Invalid Token or unauthorized request'], 422);
    }
    public function post_signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile_no' => 'required',
            // 'passport_one_img' => 'required',
            // 'passport_two_img' => 'required',

        ]);
         if ($validator->fails()) {
             return response()->json(['success' => 'false','message' => $validator->errors()->first()], 422);
        }
        $user = new User();
        $password = Str::random(8);
        $user->name = $request->name;
        $user->mobile_no = $request->mobile_no;
        $user->email = $request->email;
        $user->user_role = $request->user_role;
        $user->password = bcrypt($password);
        $user->save();
        Mail::to($user->email)->send(new UserEmail($user->email, $password, url('login')));
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([ 'success' => 'true','message' => 'User Saved Successfully','token' => $token]);
    }
    public function post_login(Request $request)
{
    // Validate the request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        // Authentication was successful
        return redirect()->route('dashboard')->with('success', 'Login Successful');
    } else {
        // Authentication failed
        return redirect('login')->with('error', 'Invalid credentials')->withInput($request->except('password'));
    }
}

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('login');
    }
   
}
