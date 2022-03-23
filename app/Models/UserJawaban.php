<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJawaban extends Model
{
    use HasFactory;
    protected $table = 'user_jawaban';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'waktu',
        'tanggal'
    ];

    public function DetailUserJawaban()
    {
        return $this->hasMany(DetailUserJawaban::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
