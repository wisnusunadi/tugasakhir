<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

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
        if(Auth::user()->role == "admin"){
            return view('home');
        }
        else{
            return view('beranda');
        }
    }

    public function beranda(){
        return view('beranda');
    }

  

    public function jadwal_table()
    {
        $today = Carbon::now();
        $data = Pendaftaran::whereHas('Jadwal', function($q) use($today){
            $q->where('waktu_selesai', '>=', $today);
        })->get();
        return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('jadwal', function ($data) {
                    return 'Tanggal '.Carbon::parse($data->Jadwal->waktu_mulai)->format('d-m-Y')." - ".Carbon::parse($data->Jadwal->waktu_selesai)->format('d-m-Y');
                })
                ->addColumn('divisi', function ($data) {
                    return $data->Divisi->nama;
                })
                ->addColumn('jabatan', function ($data) {
                    return $data->Jabatan->nama;
                })
                ->addColumn('kuota', function ($data) {
                    return $data->kuota;
                })
                ->make(true);
    }

    public function jadwal_create()
    {
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        return view('jadwal.create', ['d' => $divisi, 'j' => $jabatan]);
    }

    public function jadwal_store(Request $r){
        $bool = true;
        $j = Jadwal::create([
            'waktu_mulai' => $r->tanggal_mulai,
            'waktu_selesai' => $r->tanggal_akhir,
            'ket' => $r->keterangan
        ]);

        if($j){
            for($i=0; $i<count($r->divisi); $i++){
                $p = Pendaftaran::create([
                    'divisi_id' => $r->divisi[$i],
                    'jabatan_id' => $r->jabatan[$i],
                    'jadwal_id' => $j->id,
                    'kuota' => $r->kuota[$i]
                ]);
                if(!$p){
                    $bool = false;
                }
            }
        }

        if ($bool == true) {
            return redirect()->back()->with('success', 'Berhasil menambahkan Jadwal');
        } else if ($bool == false) {
            return redirect()->back()->with('error', 'Gagal menambahkan Jadwal');
        }
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

    public function jabatan_data(Request $request){
        $data = Jabatan::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')->get();
        echo json_encode($data);
    }

    public function divisi_data(Request $request){
        $data = Divisi::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')->get();
        echo json_encode($data);
    }
}
