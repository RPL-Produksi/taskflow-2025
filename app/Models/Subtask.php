<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function task() {
        return $this->belongsTo(Task::class);
    }

    public function subtaskWorker() {
        return $this->hasMany(SubtaskWorker::class);
    }

    public function subtaskWorkerS() {
        return $this->hasMany(SubtaskWorker::class);
    }
}
