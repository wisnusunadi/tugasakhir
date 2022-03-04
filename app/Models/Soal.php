<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $table = 'soal';
    protected $fillable = [
        'kode_soal',
        'nama',
        'waktu'
    ];

    public function SoalDetail(){
        return $this->hasMany(SoalDetail::class);
    }
    public function Divisi(){
        return $this->belongsToMany(Divisi::class,'soal_divisi');
    }
    public function Jabatan(){
        return $this->belongsToMany(Jabatan::class,'soal_jabatan');
    }

    public function getJumlahSoal()
    {
        $id = $this->id;
        $s = SoalDetail::whereHas('Soal',function ($q) use ($id){
            $q->where('id',$id);
        })->get();
        $jumlah = 0;
        foreach ($s as $i) {
                $jumlah++;
        }
        return $jumlah;
    }
}
