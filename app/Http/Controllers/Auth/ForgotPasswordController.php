<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPwd;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    use SendsPasswordResetEmails;

    public function showForgetPasswordForm()
    {
        return view('auth.reset');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $data = User::where('email', $request->email)->count();

        if ($data > 0) {
            $j = PasswordReset::create([
                'email' => $request->email,
                'token' =>  sha1(time()),
                'created_at' => Carbon::now()
            ]);



            Mail::to($request->email)->send(new ResetPwd($j->token));


            return redirect()->back()->with('success', 'Verifikasi telah berhasil dikirim, cek email anda');
        } else {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.resetpwd', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {

        $cek = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$cek) {
            return redirect()->back()->with('error', 'Verifikasi ulang, Kode verifikasi tidak ditemukan');
        } else {
            $update = User::where("email", $request->email)->update(["password" => Hash::make($request->password)]);
            $password = PasswordReset::where(['email' => $request->email])->delete();
            return redirect('/login')->with('success', 'Reset password berhasil');
        }
    }
}
