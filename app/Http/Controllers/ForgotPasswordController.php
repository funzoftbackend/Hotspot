<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    public function showforgotpassword()
    {
        return view('forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $code = mt_rand(1000, 9999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'code' => $code]
        );
        $url = url(route('web.showverify.code',['email' => $user->email]));
        $email = $request->email;
        Mail::to($user->email)->send(new ResetPasswordMail($code,$email,$url));
        return redirect()->route('web.showverify.code',['email' => $email])->with(['success' => 'Code sent to your email']);
    }

    public function resendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('email')) {
                return redirect()->back()->with('error', $errors->first('email'));
            }
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $code = mt_rand(1000, 9999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'code' => $code]
        );
        Mail::to($user->email)->send(new ResetPasswordMail($code));
        
       return redirect()->route('web.showverify.code',['email' => $email])->with(['success' => 'New Code sent to your email']);
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|digits:4',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('email')) {
                return redirect()->back()->with('error', $errors->first('email'));
            }
            if ($errors->has('code')) {
                  return redirect()->back()->with('error', $errors->first('code'));
            }
        }
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$reset) {
            return redirect()->back()->with('error', 'Invalid code');
        }

        return redirect()->route('web.showreset.password',['email' => $request->email])->with(['code' => $request->code, 'success' => 'Code Verified Successfully']);
    }
     public function showverifyCode(Request $request)
    {
        return view('verifycode');
    }
}
