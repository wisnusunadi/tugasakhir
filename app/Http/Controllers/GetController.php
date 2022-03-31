<?php

namespace App\Http\Controllers;

use App\Models\DetailUserJawaban;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\Soal;
use App\Models\SoalDetail;
use App\Models\Universitas;
use App\Models\Kriteria;
use App\Models\KriteriaUsia;
use App\Models\KriteriaPendidikan;
use App\Models\KriteriaJarak;
use App\Models\KriteriaSoal;
use App\Models\UserJawaban;
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

    public function peserta_hasil_table()
    {
        $data = User::where([['role', '=', 'user']])->has('Pendaftaran.Kriteria')->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('pendaftaran', function ($data) {
                return $data->Pendaftaran->Jabatan->nama . ' ' . $data->Pendaftaran->Divisi->nama;
            })
            ->addColumn('tanggal_daftar', function ($data) {
                return Carbon::parse($data->created_at)->format('d-m-Y');
            })
            ->addColumn('nama', function ($data) {
                return $data->nama;
            })
            ->addColumn('usia', function ($data) {
                return $this->bobot_usia_peserta($data->id).'<br><small class="text-muted"><i>Rerata: '.$this->count_usia_peserta($data->id).'</i></small>';
            })
            ->addColumn('pendidikan', function ($data) {
                return $this->bobot_pend_peserta($data->id).'<br><small class="text-muted"><i>Rerata: '.$this->count_pend_peserta($data->id).'</i></small>';
            })
            ->addColumn('jarak', function ($data) {
                return $this->bobot_jarak_peserta($data->id).'<br><small class="text-muted"><i>Rerata: '.$this->count_jarak_peserta($data->id).'</i></small>';
            })
            ->addColumn('soal', function ($data) {
                return $this->sum_soal_peserta($data->id).'<br><small class="text-muted"><i>Rerata: '.$this->count_soal_peserta($data->id).'</i></small>';
            })
            ->addColumn('rerata', function ($data) {
                return $this->count_all_bobot($data->id);
            })
            ->addColumn('keputusan', function ($data) {
                $bool = $this->get_keputusan_rekruitmen($data->id);
                if($bool == true){
                    return '<small class="badge badge-success"> Diterima </small>';
                }else{
                    return '<small class="badge badge-danger"> Tidak Diterima </small>';
                }
            })
            ->rawColumns(['usia', 'pendidikan', 'jarak', 'soal', 'keputusan'])
            ->make(true);
    }

    public function soal_get_select($jabatan, $divisi, Request $request){
        $data = Soal::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->whereHas('Divisi', function($q) use($divisi){
                $q->where('id', $divisi);
            })->whereHas('Jabatan', function($q) use($jabatan){
                $q->where('id', $jabatan);
            })
            ->orderby('nama', 'ASC')->get();
        echo json_encode($data);
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

    public function bobot_usia_peserta($user_id){
        $bobot = "";
        $u = User::find($user_id);
        $daftar_id = $u->pendaftaran_id;
        $usia = Carbon::parse($u->tgl_lahir)->age;

        $k = Kriteria::where([['nama', '=', 'usia'], ['pendaftaran_id', '=', $daftar_id]])->first();
        $k_usia = KriteriaUsia::where('kriteria_id', $k->id)->get();
        foreach($k_usia as $i){
                if($usia > $i->range_min && $usia <= $i->range_max){
                    $bobot = $i->nilai;
                }
        }

        if($bobot == ""){
            $bobot = "0";
        }
        return $bobot;
    }

    public function bobot_pend_peserta($user_id){
        $bobot = "";
        $u = User::find($user_id);
        $pend = $u->pend;
        $akreditasi = "";
        if($u->univ_id){
            $akreditasi = $u->Universitas->peringkat;
        }
        $daftar_id = $u->pendaftaran_id;

        $k = Kriteria::where([['nama', '=', 'pendidikan'], ['pendaftaran_id', '=', $daftar_id]])->first();
        $k_pend = KriteriaPendidikan::where('kriteria_id', $k->id)->get();
        foreach($k_pend as $i){
                if($pend == "smak" && $i->pendidikan == "smak"){
                    $bobot = $i->nilai;
                }else{
                    if($pend == $i->pendidikan && $akreditasi == $i->peringkat){
                        $bobot = $i->nilai;
                    }
                }
        }

        if($bobot == ""){
            $bobot = "0";
        }
        return $bobot;
    }

    public function bobot_jarak_peserta($user_id){
        $bobot = "";
        $u = User::find($user_id);
        $jarak = $u->jarak;
        $daftar_id = $u->pendaftaran_id;

        $k = Kriteria::where([['nama', '=', 'jarak'], ['pendaftaran_id', '=', $daftar_id]])->first();
        $k_jarak = KriteriaJarak::where('kriteria_id', $k->id)->get();
        foreach($k_jarak as $i){
                if($jarak > $i->range_min && $jarak <= $i->range_max){
                    $bobot = $i->nilai;
                }
        }

        if($bobot == ""){
            $bobot = "0";
        }
        return $bobot;
    }

    public function bobot_soal_peserta($soal, $nilai, $daftar_id){
        $bobot = "";
        $k = Kriteria::where([['nama', '=', 'soal'], ['pendaftaran_id', '=', $daftar_id]])->first();
        $k_soal = KriteriaSoal::where('kriteria_id', $k->id)->get();
        foreach($k_soal as $i){
            if($soal == $i->soal_id){
                $allbenar = $i->Soal->getAllNilaiBenar();
                $bobotsoal = $i->nilai;

                $bobot = ($bobotsoal * ($nilai / $allbenar));
            }
        }

        if($bobot == ""){
            $bobot = "0";
        }
        return $bobot;
    }

    public function sum_soal_peserta($user_id){
        $user = User::find($user_id);
        $user_jwb = UserJawaban::where('user_id', $user_id)->get();
        $bobotall = 0;
        foreach($user_jwb as $i){
            $jwb_id = "";
            if(isset($i->DetailUserJawaban[0])){
                $jwb_id = $i->DetailUserJawaban[0]->jawaban_id;
            }
            $soal = SoalDetail::whereHas('Jawaban', function($q) use($jwb_id){
                           $q->where('id', $jwb_id);
                       })->first();
            $soal_id = $soal->soal_id;
            $nilai = 0;
            $duj = DetailUserJawaban::where('user_jawaban_id', $i->id)->get();
            foreach($duj as $j){
                $nilai = $nilai + $j->Jawaban->status;
            }
            $bobots = $this->bobot_soal_peserta($soal_id, $nilai, $user->pendaftaran_id);

            $bobotall = $bobotall + $bobots;
        }
        return $bobotall;
    }

    public function count_usia_peserta($id_user){
        $user = User::find($id_user);
        $daftar_id = $user->pendaftaran_id;
        $bobot = $this->bobot_usia_peserta($user->id);

        $alluser = user::where('pendaftaran_id', $daftar_id)->get();
        $arrayusia = [];
        foreach ($alluser as $i){
            $arrayusia[] = $this->bobot_usia_peserta($i->id);
        }

        $maxusia = max($arrayusia);
        if($maxusia == "0"){
            $maxusia = 1;
        }
        $res = round(($bobot / $maxusia), 3);
        return $res;
    }

    public function count_pend_peserta($id_user){
        $user = User::find($id_user);
        $daftar_id = $user->pendaftaran_id;
        $bobot = $this->bobot_pend_peserta($user->id);

        $alluser = User::where('pendaftaran_id', $daftar_id)->get();
        $arraypend = [];
        foreach ($alluser as $i){
            $arraypend[] = $this->bobot_pend_peserta($i->id);
        }

        $maxpend = max($arraypend);
        if($maxpend == "0"){
            $maxpend = 1;
        }
        $res = round(($bobot / $maxpend), 3);
        return $res;
    }

    public function count_jarak_peserta($id_user){
        $user = User::find($id_user);
        $daftar_id = $user->pendaftaran_id;
        $bobot = $this->bobot_jarak_peserta($user->id);

        $alluser = user::where('pendaftaran_id', $daftar_id)->get();
        $arrayjarak = [];
        foreach ($alluser as $i){
            $arrayjarak[] = $this->bobot_jarak_peserta($i->id);
        }

        $maxjarak = max($arrayjarak);
        if($maxjarak == "0"){
            $maxjarak = 1;
        }
        $res = round(($bobot / $maxjarak), 3);
        return $res;
    }

    public function count_soal_peserta($id_user){
        $user = User::find($id_user);
        $daftar_id = $user->pendaftaran_id;
        $alluser = user::where('pendaftaran_id', $daftar_id)->get();
        $bobot = $this->sum_soal_peserta($id_user);
        $arraysoal = [];
        foreach ($alluser as $i){
            $arraysoal[] = $this->sum_soal_peserta($i->id);
        }

        $maxsoal = max($arraysoal);
        if($maxsoal == "0"){
            $maxsoal = 1;
        }
        $res = round(($bobot / $maxsoal), 3);
        return $res;
    }

    public function count_all_bobot($id_user){
        $user = User::find($id_user);
        $k = Kriteria::where('pendaftaran_id', $user->pendaftaran_id)->get();
        $rerata = 0;
        foreach($k as $i){
            if($i->nama == "usia"){
                if($user->tgl_lahir){
                    $res = $this->count_usia_peserta($id_user);
                    $rerata = $rerata + ($res * $i->bobot);
                }
            }else
            if($i->nama == "pendidikan"){
                if($user->pend){
                    $res = $this->count_pend_peserta($id_user);
                    $rerata = $rerata + ($res * $i->bobot);
                }
            }else if($i->nama == "jarak"){
                if($user->jarak){
                    $res = $this->count_jarak_peserta($id_user);
                    $rerata = $rerata + ($res * $i->bobot);
                }
            }else if($i->nama == "soal"){
                if($user->UserJawaban){
                    $res = $this->count_soal_peserta($id_user);
                    $rerata = $rerata + ($res * $i->bobot);
                }
            }
        }
        return $rerata;
    }

    public function get_keputusan_rekruitmen($user_id){
        $user = User::find($user_id);
        $daftar_id = $user->pendaftaran_id;
        $kuota = $user->Pendaftaran->kuota;
        $bobot = $this->count_all_bobot($user_id);

        $alluser = User::where('pendaftaran_id', $daftar_id)->get();
        $arraybobot = [];
        foreach ($alluser as $i){
            $arraybobot[] = $this->count_all_bobot($i->id);
        }

        rsort($arraybobot);
        $data = [];
        for($i = 0; $i < $kuota; $i++){
            if(isset($arraybobot[$i])){
                $data[] = $arraybobot[$i];
            }
        }

        if(in_array($bobot, $data)){
            return true;
        }else{
            return false;
        }
    }


}
