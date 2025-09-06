<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'path',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
        public function getSizeAttribute()
    {
        try {
            return Storage::size($this->path);
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getFormattedSizeAttribute()
    {
        $size = $this->size;
        
        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' bytes';
        }
    }
}
