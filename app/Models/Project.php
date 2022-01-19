<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'status_id'];

    protected $casts = [
        // 'date_start' => "datetime:M-d-Y",
        // 'date_end' => "datetime:M-d-Y",
    ];

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id', 'id');
    }
}
