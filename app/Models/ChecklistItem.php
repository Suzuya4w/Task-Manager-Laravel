<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'name',
        'completed',
        'file_path',
        'notes'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Accessor untuk file URL
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}