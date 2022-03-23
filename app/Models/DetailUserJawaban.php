<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUserJawaban extends Model
{
    use HasFactory;
    protected $table = 'detail_user_jawaban';
    public $timestamps = false;
    protected $fillable = [
        'user_jawaban_id',
        'jawaban_id',
    ];

    public function UserJawaban()
    {
        return $this->belongsTo(UserJawaban::class, 'user_jawaban_id');
    }

    public function Jawaban()
    {
        return $this->belongsTo(Jawaban::class, 'jawaban_id');
    }
}
