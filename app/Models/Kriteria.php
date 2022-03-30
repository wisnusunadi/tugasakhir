<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriteria';
    public $timestamps = false;
    protected $fillable = [
        'pendaftaran_id',
        'nama',
        'bobot'
    ];

    public function Pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function KriteriaUsia()
    {
        return $this->hasMany(KriteriaUsia::class);
    }

    public function KriteriaPendidikan()
    {
        return $this->hasMany(KriteriaPendidikan::class);
    }

    public function KriteriaJarak()
    {
        return $this->hasMany(KriteriaJarak::class);
    }

    public function KriteriaSoal()
    {
        return $this->hasMany(KriteriaSoal::class);
    }
}
