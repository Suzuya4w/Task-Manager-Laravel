<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'budget',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

            public function getStatusAttribute()
    {
        $today = \Carbon\Carbon::now();

        $totalTasks     = $this->tasks()->count();
        $completedTasks = $this->tasks()->where('status', 'completed')->count();

        // 1. Kalau belum ada tugas sama sekali
        if ($totalTasks === 0) {
            return 'Belum Dikerjakan';
        }

        // 2. Kalau semua tugas selesai
        if ($completedTasks === $totalTasks) {
            return 'Selesai';
        }

        // 3. Kalau ada deadline & sudah lewat
        if ($this->end_date && $this->end_date->lt($today)) {
            return 'Terlambat';
        }

        // 4. Kalau ada sebagian tugas yang sedang dikerjakan
        return 'Sedang Dikerjakan';
    }



    public function users()
    {
        return $this->belongsToMany(User::class, 'project_teams', 'project_id', 'user_id');
    }
}
