<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pendaftaran_id',
        'username',
        'nama',
        'email',
        'password',
        'tgl_lahir',
        'jenis_kelamin',
        'pend',
        'jarak',
        'role',
        'pendaftaran_id',
        'univ_id',
        'email_hasil'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function Universitas()
    {
        return $this->belongsTo(Universitas::class, 'univ_id');
    }

    public function UserJawaban()
    {
        return $this->hasMany(UserJawaban::class);
    }

    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }

    // public function bobot_usia_peserta($user_id){
    //     $bobot = "";
    //     $u = User::find($user_id);
    //     $daftar_id = $u->pendaftaran_id;
    //     $usia = Carbon::parse($u->tgl_lahir)->age;

    //     $k = Kriteria::where([['nama', '=', 'usia'], ['pendaftaran_id', '=', $daftar_id]])->first();
    //     $k_usia = KriteriaUsia::where('kriteria_id', $k->id)->get();
    //     foreach($k_usia as $i){
    //             if($usia > $i->range_min && $usia <= $i->range_max){
    //                 $bobot = $i->nilai;
    //             }
    //     }

    //     if ($bobot == "") {
    //         $bobot = 0;
    //     }
    //     return $bobot;
    // }

    // public function bobot_pend_peserta($user_id){
    //     $bobot = "";
    //     $u = User::find($user_id);
    //     $pend = $u->pend;
    //     $akreditasi = "";
    //     if($u->univ_id){
    //         $akreditasi = $u->Universitas->peringkat;
    //     }
    //     $daftar_id = $u->pendaftaran_id;

    //     $k = Kriteria::where([['nama', '=', 'pendidikan'], ['pendaftaran_id', '=', $daftar_id]])->first();
    //     $k_pend = KriteriaPendidikan::where('kriteria_id', $k->id)->get();
    //     foreach($k_pend as $i){
    //             if($pend == "smak" && $i->pendidikan == "smak"){
    //                 $bobot = $i->nilai;
    //             } else {
    //                 if ($pend == $i->pendidikan && $akreditasi == $i->peringkat) {
    //                     $bobot = $i->nilai;
    //                 }
    //             }
    //     }

    //     if ($bobot == "") {
    //         $bobot = 0;
    //     }
    //     return $bobot;
    // }

    // public function bobot_jarak_peserta($user_id){
    //     $bobot = "";
    //     $u = User::find($user_id);
    //     $jarak = $u->jarak;
    //     $daftar_id = $u->pendaftaran_id;

    //     $k = Kriteria::where([['nama', '=', 'jarak'], ['pendaftaran_id', '=', $daftar_id]])->first();
    //     $k_jarak = KriteriaJarak::where('kriteria_id', $k->id)->get();
    //     foreach($k_jarak as $i){
    //             if($jarak > $i->range_min && $jarak <= $i->range_max){
    //                 $bobot = $i->nilai;
    //             }
    //     }

    //     if($bobot == ""){
    //         $bobot = 0;
    //     }
    //     return $bobot;
    // }

    // public function bobot_soal_peserta($soal, $nilai, $daftar_id){
    //     $bobot = "";
    //     $k = Kriteria::where([['nama', '=', 'soal'], ['pendaftaran_id', '=', $daftar_id]])->first();
    //     $k_soal = KriteriaSoal::where('kriteria_id', $k->id)->get();
    //     foreach($k_soal as $i){
    //         if($soal == $i->soal_id){
    //             $allbenar = $i->Soal->getAllNilaiBenar();
    //             $bobotsoal = $i->nilai;

    //             $bobot = ($bobotsoal * ($nilai / $allbenar));
    //         }
    //     }

    //     if ($bobot == "") {
    //         $bobot = 0;
    //     }
    //     return $bobot;
    // }

    // public function sum_soal_peserta($user_id){
    //     $user = User::find($user_id);
    //     $user_jwb = UserJawaban::where('user_id', $user_id)->get();
    //     $bobotall = 0;
    //     foreach($user_jwb as $i){
    //         $jwb_id = "";
    //         if(isset($i->DetailUserJawaban[0])){
    //             $jwb_id = $i->DetailUserJawaban[0]->jawaban_id;
    //         }
    //         $soal = SoalDetail::whereHas('Jawaban', function($q) use($jwb_id){
    //                        $q->where('id', $jwb_id);
    //                    })->first();
    //         $soal_id = $soal->soal_id;
    //         $nilai = 0;
    //         $duj = DetailUserJawaban::where('user_jawaban_id', $i->id)->get();
    //         foreach($duj as $j){
    //             $nilai = $nilai + $j->Jawaban->status;
    //         }
    //         $bobots = $this->bobot_soal_peserta($soal_id, $nilai, $user->pendaftaran_id);

    //         $bobotall = $bobotall + $bobots;
    //     }
    //     return $bobotall;
    // }

    // public function count_usia_peserta($user_id){
    //     $user = User::find($user_id);
    //     $daftar_id = $user->pendaftaran_id;
    //     $bobot = $this->bobot_usia_peserta($user->id);

    //     $alluser = User::where('pendaftaran_id', $daftar_id)->get();
    //     $arrayusia = [];
    //     foreach ($alluser as $i){
    //         $arrayusia[] = $this->bobot_usia_peserta($i->id);
    //     }

    //     $maxusia = max($arrayusia);
    //     if($maxusia == "0"){
    //         $maxusia = 1;
    //     }
    //     $res = round(($bobot / $maxusia), 3);
    //     return $res;
    // }

    // public function count_pend_peserta($user_id){
    //     $user = User::find($user_id);
    //     $daftar_id = $user->pendaftaran_id;
    //     $bobot = $this->bobot_pend_peserta($user->id);

    //     $alluser = User::where('pendaftaran_id', $daftar_id)->get();
    //     $arraypend = [];
    //     foreach ($alluser as $i){
    //         $arraypend[] = $this->bobot_pend_peserta($i->id);
    //     }

    //     $maxpend = max($arraypend);
    //     if($maxpend == "0"){
    //         $maxpend = 1;
    //     }
    //     $res = round(($bobot / $maxpend), 3);
    //     return $res;
    // }

    // public function count_jarak_peserta($user_id){
    //     $user = User::find($user_id);
    //     $daftar_id = $user->pendaftaran_id;
    //     $bobot = $this->bobot_jarak_peserta($user->id);

    //     $alluser = user::where('pendaftaran_id', $daftar_id)->get();
    //     $arrayjarak = [];
    //     foreach ($alluser as $i){
    //         $arrayjarak[] = $this->bobot_jarak_peserta($i->id);
    //     }

    //     $maxjarak = max($arrayjarak);
    //     if($maxjarak == "0"){
    //         $maxjarak = 1;
    //     }
    //     $res = round(($bobot / $maxjarak), 3);
    //     return $res;
    // }

    // public function count_soal_peserta($user_id){
    //     $user = User::find($user_id);
    //     $daftar_id = $user->pendaftaran_id;
    //     $alluser = user::where('pendaftaran_id', $daftar_id)->get();
    //     $bobot = $this->sum_soal_peserta($user->id);
    //     $arraysoal = [];
    //     foreach ($alluser as $i){
    //         $arraysoal[] = $this->sum_soal_peserta($i->id);
    //     }

    //     $maxsoal = max($arraysoal);
    //     if($maxsoal == "0"){
    //         $maxsoal = 1;
    //     }

    //     $res = round(($bobot / $maxsoal), 3);
    //     return $res;
    // }

    // public function count_all_bobot($user_id){
    //     $user = User::find($user_id);
    //     $k = Kriteria::where('pendaftaran_id', $user->pendaftaran_id)->get();
    //     $rerata = 0;
    //     foreach($k as $i){
    //         if($i->nama == "usia"){
    //             if($user->tgl_lahir){
    //                 $res = $this->count_usia_peserta($user->id);
    //                 $rerata = $rerata + ($res * $i->bobot);
    //             }
    //         }else
    //         if($i->nama == "pendidikan"){
    //             if($user->pend){
    //                 $res = $this->count_pend_peserta($user->id);
    //                 $rerata = $rerata + ($res * $i->bobot);
    //             }
    //         }else if($i->nama == "jarak"){
    //             if($user->jarak){
    //                 $res = $this->count_jarak_peserta($user->id);
    //                 $rerata = $rerata + ($res * $i->bobot);
    //             }
    //         }else if($i->nama == "soal"){
    //             if($user->UserJawaban){
    //                 $res = $this->count_soal_peserta();
    //                 $rerata = $rerata + ($res * $i->bobot);
    //             }
    //         }
    //     }
    //     return $rerata;
    // }

    // public function get_keputusan_rekruitmen(){
    //     $user = User::find($this->id);
    //     $daftar_id = $user->pendaftaran_id;
    //     $kuota = $user->Pendaftaran->kuota;
    //     $bobot = $this->count_all_bobot();

    //     $alluser = User::where('pendaftaran_id', $daftar_id)->get();
    //     $arraybobot = [];
    //     foreach ($alluser as $i){
    //         $arraybobot[] = $this->count_all_bobot($i->id);
    //     }

    //     rsort($arraybobot);
    //     $data = [];
    //     for($i = 0; $i < $kuota; $i++){
    //         if(isset($arraybobot[$i])){
    //             $data[] = $arraybobot[$i];
    //         }
    //     }

    //     if(in_array($bobot, $data)){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }
}
