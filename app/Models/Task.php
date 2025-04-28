<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function subtask() {
        return $this->hasMany(Subtask::class);
    }
    public function subtasks() {
        return $this->hasMany(Subtask::class);
    }

    public function taskWorker() {
        return $this->hasMany(TaskWorker::class);
    }
    public function taskWorkers() {
        return $this->hasMany(TaskWorker::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
