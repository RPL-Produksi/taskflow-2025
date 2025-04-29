<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function tes() {
        return $this->belongsTo(Tes::class);
    }

    public function pilihan() {
        return $this->hasMany(Pilihan::class);
    }
}
