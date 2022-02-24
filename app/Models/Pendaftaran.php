<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Pendaftaran extends Model
{
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
}
