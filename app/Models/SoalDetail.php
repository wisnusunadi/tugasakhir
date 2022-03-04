<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalDetail extends Model
{
    use HasFactory;
    protected $table = 'soal_detail';
    protected $fillable = [
        'soal_id',
        'deskripsi',
        'bobot'
    ];
    
    public function Soal(){
        return $this->belongsTo(Soal::class,'soal_id');
    }
    public function Jawaban(){
        return $this->hasMany(Jawaban::class);
    }

  

}
