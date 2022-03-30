<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPendidikan extends Model
{
    use HasFactory;
    protected $table = 'kriteria_pendidikan';
    public $timestamps = false;
    protected $fillable = [
        'kriteria_id',
        'pendidikan',
        'peringkat',
        'nilai'
    ];

    public function Kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
