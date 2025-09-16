<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'title',
        'description',
        'date',
        'time',
        'user_id',
    ];

        protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i', // Cast time ke format waktu
    ];

        public function task()
        {
            return $this->belongsTo(Task::class);
        }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
