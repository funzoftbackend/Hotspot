<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $code = mt_rand(1000, 9999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'code' => $code]
        );
        return response()->json(['code' => $code,'message' => 'Code Generated Successfully']);
    }
    public function verify_phone_code(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:4',
        ]);
        $reset = DB::table('password_reset_tokens')
            ->where('code', $request->code)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid code'], 422);
        }

        return response()->json(['message' => 'Code verified']);
    }
}

