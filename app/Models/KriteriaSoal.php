<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaSoal extends Model
{
    use HasFactory;
    protected $table = 'kriteria_soal';
    public $timestamps = false;
    protected $fillable = [
        'kriteria_id',
        'soal_id',
        'nilai'
    ];

    public function Kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function Soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id');
    }
}
