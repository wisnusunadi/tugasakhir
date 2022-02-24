<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';
    protected $fillable = [
        'waktu_mulai',
        'waktu_akhir',
        'ket',
    ];

    public function Pendaftaran(){
        return $this->hasMany(Pendaftaran::class);
    }
}
