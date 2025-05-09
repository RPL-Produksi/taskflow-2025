<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function soal() {
        return $this->belongsTo(Soal::class);
    }
}
