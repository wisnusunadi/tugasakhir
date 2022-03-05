<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'divisi';
    protected $fillable = [
        'nama',
    ];

    public function Pendaftaran(){
        return $this->hasMany(Pendaftaran::class);
    }
    public function Soal(){
        return $this->belongsToMany(Soal::class,'soal_divisi');
    }
}
