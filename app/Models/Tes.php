<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function tesSiswa() {
        return $this->hasMany(TesSiswa::class);
    }
    public function soals() {
        return $this->hasMany(Soal::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
