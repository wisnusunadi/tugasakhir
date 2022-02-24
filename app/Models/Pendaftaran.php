<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $fillable = [
        'jadwal_id',
        'jabatan_id',
        'divisi_id',
        'kuota',
    ];

    public function Jadwal(){
        return $this->belongsTo(Jadwal::class);
    }

    public function Jabatan(){
        return $this->belongsTo(Jabatan::class);
    }

    public function Divisi(){
        return $this->belongsTo(Divisi::class);
    }
}
