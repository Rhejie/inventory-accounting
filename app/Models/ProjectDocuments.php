<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDocuments extends Model
{
    use HasFactory;

    protected $table = 'project_documents';
    protected $guarded = [];
    protected $casts = [
        'created_at' => "datetime:M-d-Y",
    ];
    // public static $dates = ['created_at'];
    
    // public function getCreatedAtAttribute()
    // {
    //      return $this->created_at->format('Y-m-d');
    // }

    //     public function getUpdatedAtAttribute($date)
    // {
    //      return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }

  
}
