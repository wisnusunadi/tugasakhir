<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function beranda(){
        return view('beranda');
    }

  

    public function soal_tes_show(){
        if(!Auth::user()){

        }else{
            return view('soal.tes.show');
        }
    }

    public function peserta_show(){
        return view('peserta.show');
    }

    public function hasil_show(){
        return view('peserta.hasil.show');
    }

    public function draft_soal_show(){
        return view('soal.draft.show');
    }
}
