<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Pendaftaran extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "pendaftaran";
    protected $fillable = ['jadwal_id','jabatan_id','divisi_id','kuota'];

    public function Jabatan(){
        return $this->belongsTo(Jabatan::class,'jabatan_id');
    }
    public function Divisi(){
        return $this->belongsTo(Divisi::class,'divisi_id');
    }
    public function Jadwal(){
        return $this->belongsTo(Jadwal::class,'jadwal_id');
    }
    public function User(){
        return $this->hasMany(User::class);
    }
    public function Kriteria(){
        return $this->hasMany(Kriteria::class);
    }
    public function KriteriaStatus($status){
        $id = $this->id;
        $res = "";
        if($status == "usia"){
            $res = KriteriaUsia::whereHas('Kriteria', function($q) use($id){
                $q->where('pendaftaran_id', $id);
            })->get();
        }else if($status == "pendidikan"){
            $res = KriteriaPendidikan::whereHas('Kriteria', function($q) use($id){
                $q->where('pendaftaran_id', $id);
            })->get();
        }else if($status == "jarak"){
            $res = KriteriaJarak::whereHas('Kriteria', function($q) use($id){
                $q->where('pendaftaran_id', $id);
            })->get();
        }else if($status == "soal"){
            $res = KriteriaSoal::whereHas('Kriteria', function($q) use($id){
                $q->where('pendaftaran_id', $id);
            })->get();
        }
        return $res;
    }

    public function DaftarSoal(){
        $jab_id = $this->jabatan_id;
        $div_id = $this->divisi_id;

        $res = Soal::whereHas('Divisi', function($q) use($div_id){
            $q->where('id', $div_id);
        })->whereHas('Jabatan', function($q) use($jab_id){
            $q->where('id', $jab_id);
        })->get();
        return $res;
    }
}
