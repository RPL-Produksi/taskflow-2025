<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubtaskWorker extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function subtask() {
        return $this->belongsTo(Subtask::class);
    }
    public function subtasks() {
        return $this->belongsTo(Subtask::class);
    }
}
