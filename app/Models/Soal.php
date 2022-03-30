<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $table = 'soal';
    public $timestamps = false;
    protected $fillable = [
        'kode_soal',
        'nama',
        'waktu'
    ];

    public function SoalDetail()
    {
        return $this->hasMany(SoalDetail::class);
    }
    public function KriteriaSoal()
    {
        return $this->hasMany(KriteriaSoal::class);
    }
    public function Divisi()
    {
        return $this->belongsToMany(Divisi::class, 'soal_divisi', 'soal_id', 'divisi_id');
    }
    public function Jabatan()
    {
        return $this->belongsToMany(Jabatan::class, 'soal_jabatan');
    }

    public function getJumlahSoal()
    {
        $id = $this->id;
        $s = SoalDetail::whereHas('Soal', function ($q) use ($id) {
            $q->where('id', $id);
        })->get();
        $jumlah = 0;
        foreach ($s as $i) {
            $jumlah++;
        }
        return $jumlah;
    }

    public function getAllNilaiBenar()
    {
        $id = $this->id;
        $s = Jawaban::whereHas('SoalDetail.Soal', function ($q) use ($id) {
            $q->where('id', $id);
        })->whereNotNull('status')->get();
        $jumlah = 0;
        foreach ($s as $i) {
            $jumlah = $jumlah + $i->status;
        }
        return $jumlah;
    }
}
