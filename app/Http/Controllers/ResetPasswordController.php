<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class ResetPasswordController extends Controller
{
     public function showresetPassword(Request $request)
    {
        return view('reset-password');
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|digits:4',
            'password' => 'required',
        ]);
         if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('email')) {
                return response()->json(['message' => $errors->first('email')], 422);
                return redirect()->back()->with('error', $errors->first('email'));
            }
            if ($errors->has('code')) {
                  return redirect()->back()->with('error', $errors->first('code'));
            }
            if ($errors->has('password')) {
                  return redirect()->back()->with('error', $errors->first('password'));
            }
        }
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid code'], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
              return redirect()->back()->with('error', 'User not found');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/')->with('status', 'Password reset successfully');
    }
}
