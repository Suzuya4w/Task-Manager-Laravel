<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


public function getPriorityLabelAttribute()
{
    switch ($this->priority) {
        case 'low':
            return 'Rendah';
        case 'medium':
            return 'Sedang';
        case 'high':
            return 'Tinggi';
        default:
            return 'Tidak Diketahui';
    }
}

public function getPriorityColorAttribute()
{
    switch ($this->priority) {
        case 'low':
            return 'success'; // hijau
        case 'medium':
            return 'warning'; // kuning
        case 'high':
            return 'danger';  // merah
        default:
            return 'secondary';
    }
}



public function getStatusLabelAttribute()
{
    switch ($this->status) {
        case 'to_do':
            return 'Belum Dikerjakan';
        case 'in_progress':
            return 'Sedang Dikerjakan';
        case 'completed':
            return 'Selesai';
        default:
            return 'Tidak Diketahui';
    }
}

public function getStatusColorAttribute()
{
    switch ($this->status) {
        case 'to_do':
            return 'secondary';
        case 'in_progress':
            return 'warning';
        case 'completed':
            return 'success';
        default:
            return 'dark';
    }
}

    public function checklistItems()
    {
        return $this->hasMany(ChecklistItem::class);
    }
}
