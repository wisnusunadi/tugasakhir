<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Divisi;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class GetController extends Controller
{
    public function peserta_table(){
        $data = User::where('role', 'user')->get();
        return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('pendaftaran', function ($data) {
                    return $data->Pendaftaran->Jabatan->nama.' '.$data->Pendaftaran->Divisi->nama;
                })
                ->addColumn('tanggal_daftar', function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y');
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('jenis_kelamin', function ($data) {
                    return ucfirst($data->jenis_kelamin);
                })
                ->addColumn('aksi', function ($data) {
                    return '<i class="fas fa-eye"></i>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
    }

    public function jabatan_select(Request $request){
        $data = Jabatan::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')->get();
        echo json_encode($data);
    }

    public function divisi_select(Request $request){
        $data = Divisi::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')->get();
        echo json_encode($data);
    }
}
