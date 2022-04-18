<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Models\Jadwal;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\VerifyUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    // protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'pendaftaran_id' => ['required'],
            'captcha' => ['required', 'captcha'],
        ]);
    }

    public function showRegistrationForm()
    {
        $today = Carbon::now();
        $jadwal = Jadwal::where([['waktu_selesai', '>=', $today], ['waktu_mulai', '<=', $today]])->has('Pendaftaran')->get();
        // $p = Pendaftaran::whereHas('Jadwal', function ($q) use ($today) {
        //     $q->where([['waktu_selesai', '>=', $today], ['waktu_mulai', '<=', $today]]);
        // })->get();
        return view('auth.register', compact('jadwal'));
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $univ = "";
        if ($data['pend'] == 'smak') {
            $univ = NULL;
        } else {
            $univ = $data['universitas'];
        }
        $user =  User::create([
            'nama' => $data['name'],
            'pendaftaran_id' => $data['pendaftaran_id'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'role' => 'user',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'tgl_lahir' => $data['tgl_lahir'],
            'pend' => $data['pend'],
            'univ_id' => $univ,
            'jarak' => $data['jarak'],
            'email_hasil' => '0',
        ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);
        \Mail::to($user->email)->send(new VerifyMail($user));

        if ($user) {
            return $user;
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan Jadwal');
        }
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Selamat Email sudah terverifikasi, Silahkan login";
            } else {
                $status = "Email sudah terverifikasi, Silahkan login";
            }
        } else {
            return redirect('/login')->with('warning', "Email tidak ditemukan.");
        }
        return redirect('/login')->with('status', $status);
    }
}
