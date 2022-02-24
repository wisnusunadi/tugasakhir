<?php

namespace App\Http\Controllers;


use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class JadwalController extends Controller
{
    public function jadwal_show()
    {
        return view('jadwal.show');
    }

    public function get_data_jadwal(){
        $data = Pendaftaran::all();
        return DataTables()->of($data)
        ->addColumn('tanggal', function ($data) {
            $mulai = Carbon::parse($data->Jadwal->waktu_mulai)->isoFormat('D MMMM Y');
            $selesai = Carbon::parse($data->Jadwal->waktu_selesai)->isoFormat('D MMMM Y');
            return  $data->Jadwal->ket.' ('.$mulai.' - '. $selesai. ')';
        })
        ->addColumn('jabatan', function ($data) {
            return $data->Jabatan->nama .' '. $data->Divisi->nama;
        })
    
        ->make(true);
    }
}


