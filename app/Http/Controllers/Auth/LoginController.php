<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    // use AuthenticatesUsers;

    // /**
    //  * Where to redirect users after login.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = RouteServiceProvider::HOME;

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    use AuthenticatesUsers;

    protected $redirectTo = 'home';

    protected $username;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->username = $this->findUsername();
    }



    public function findUsername()
    {
        $login = request()->input('email');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function authenticated(Request $request, $user)
    {
        if($user->role=='admin'){
            return redirect()->route('home');
        }elseif($user->role=='user'){
            return redirect()->route('soal_tes.preview');
        }


        if (!$user->verified) {
            auth()->logout();
            return redirect()->back()->with('error', 'E-mail belum terverifikasi, cek terlebih dahulu');
        }
        return redirect()->intended($this->redirectPath());


    }
}
