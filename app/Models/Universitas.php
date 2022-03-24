<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universitas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "universitas";
    protected $fillable = ['nama','peringkat'];

    public function User(){
        return $this->hasMany(User::class, 'univ_id');
    }
}
