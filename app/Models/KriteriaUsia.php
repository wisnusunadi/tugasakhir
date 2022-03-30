<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaUsia extends Model
{
    use HasFactory;
    protected $table = 'kriteria_usia';
    public $timestamps = false;
    protected $fillable = [
        'kriteria_id',
        'range_min',
        'range_max',
        'nilai'
    ];

    public function Kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
