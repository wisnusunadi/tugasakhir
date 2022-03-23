<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;
    protected $table = 'jawaban';
    public $timestamps = false;
    protected $fillable = [
        'soal_detail_id',
        'jawaban',
        'status'
    ];

    public function SoalDetail()
    {
        return $this->belongsTo(SoalDetail::class, 'soal_detail_id');
    }

    public function DetailUserJawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
