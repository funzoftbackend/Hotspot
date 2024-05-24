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
    
    return view('register');
    }
    public function forgot_password(Request $request)
    {
    
    return view('forgot-password');
    }
    public function error()
    {
    
        return redirect('login')->with([ 'success' => 'false','message' => 'Logged In First']);
    }
    public function post_signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required',
        ]);
         if ($validator->fails()) {
             return redirect()->back()->with(['success' => 'false','message' => $validator->errors()->first()], 422);
        }
        $user = new User();
        $password = $request->password;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = bcrypt($password);
        $user->save();
        $token = $user->createToken('authToken')->plainTextToken;
       return redirect('login')->with([ 'success' => 'true','message' => 'User Saved Successfully','token' => $token]);
    }
    public function post_login(Request $request)
{
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
