<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = "jabatan";
    protected $fillable = ['nama', 'pass_grade'];

    public function Pendaftaran(){
    return $this->hasMany(Pendaftaran::class);
    }
}
