<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\Universitas;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class GetController extends Controller
{
    public function peserta_table()
    {
        $data = User::where('role', 'user')->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('pendaftaran', function ($data) {
                return $data->Pendaftaran->Jabatan->nama . ' ' . $data->Pendaftaran->Divisi->nama;
            })
            ->addColumn('tanggal_daftar', function ($data) {
                return Carbon::parse($data->created_at)->format('d-m-Y');
            })
            ->addColumn('nama', function ($data) {
                return $data->nama . '<br><small class="text-muted"><i>' . Carbon::parse($data->tgl_lahir)->age . ' Tahun</small>';
            })
            ->addColumn('email', function ($data) {
                return $data->email;
            })
            ->addColumn('jenis_kelamin', function ($data) {
                if ($data->jenis_kelamin == 'l') {
                    return 'Laki laki';
                } else {
                    return 'Perempuan';
                }
            })
            ->addColumn('aksi', function ($data) {
                return '<i class="fas fa-eye"></i>';
            })
            ->rawColumns(['aksi', 'nama'])
            ->make(true);
    }

    public function jabatan_select(Request $request)
    {
        $data = Jabatan::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')->get();
        echo json_encode($data);
    }

    public function universitas_select(Request $request)
    {
        $data = Universitas::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')->get();
        echo json_encode($data);
    }

    public function divisi_select(Request $request)
    {
        $data = Divisi::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')->get();
        echo json_encode($data);
    }

    public function bobot_usia_peserta($usia){
        $bobot = 0;
        if($usia >= 18 && $usia <= 25){
            $bobot = 80;
        }else{
            $bobot = 60;
        }
        return $bobot;
    }

    public function bobot_pend_peserta($pend, $akreditasi){
        $bobot = 0;
        if($pend == "smak"){
            $bobot = 20;
        }else if($pend == "d3"){
            if($akreditasi == 'A'){
                $bobot = '50';
            }
            else if($akreditasi == 'B'){
                $bobot = '45';
            }
            else if($akreditasi == 'C'){
                $bobot = '40';
            }
            else{
                $bobot = '25';
            }
        }else if($pend == "s1d4"){
            if($akreditasi == 'A'){
                $bobot = '70';
            }
            else if($akreditasi == 'B'){
                $bobot = '65';
            }
            else if($akreditasi == 'C'){
                $bobot = '60';
            }
            else{
                $bobot = '35';
            }
        }
        return $bobot;
    }

    public function count_usia_peserta($id_user){
        $user = user::find($id_user);
        $usia = Carbon::parse($data->tgl_lahir)->age;
        $alluser = user::where('pendaftaran_id', $user->pendaftaran_id)->get();
        $bobot = bobot_usia_peserta($usia);
        $arrayusia = [];
        foreach ($alluser as $i){
            $arrayusia[] = bobot_usia_peserta(Carbon::parse($data->tgl_lahir)->age);
        }

        $maxusia = max($arrayusia);
        return $bobot / $maxusia;
    }

    public function count_pend_peserta($id_user){
        $user = user::find($id_user);
        $pend = $user->pend;
        $akreditasi = "";
        if($user->univ_id){
            $akreditasi = $user->Universitas->peringkat;
        }
        $alluser = user::where('pendaftaran_id', $user->pendaftaran_id)->get();
        $bobot = bobot_pend_peserta($pend, $akreditasi);
        $arrayupend = [];
        foreach ($alluser as $i){
            $akreditasi_i = "";
            if($i->univ_id){
                $akreditasi_i = $i->Universitas->peringkat;
            }
            $arraypend[] = bobot_pend_peserta($i->pend, $akreditasi_i);
        }

        $maxpend = max($arraypend);
        return $bobot / $maxpend;
    }

    
}
