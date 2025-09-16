<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'frequency',
        'days',
        'weeks',
        'months',
        'start_time',
        'end_time',
    ];


public function getFrequencyLabelAttribute()
{
    switch ($this->frequency) {
        case 'daily': return 'Harian';
        case 'weekly': return 'Mingguan';
        case 'monthly': return 'Bulanan';
        default: return ucfirst($this->frequency);
    }
}


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
