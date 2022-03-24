<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Pendaftaran;
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
        ]);
    }

    public function showRegistrationForm()
    {
        $today = Carbon::now();
        $jadwal = Jadwal::where([['waktu_selesai', '>=', $today], ['waktu_mulai', '<=', $today]])->get();
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
        return User::create([
            'nama' => $data['name'],
            'pendaftaran_id' => $data['pendaftaran_id'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'role' => 'user',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'tgl_lahir' => $data['tgl_lahir'],
            'pend' => $data['pend'],
            'univ_id' => $data['universitas'],
            'jarak' => $data['jarak'],
        ]);
    }
}
