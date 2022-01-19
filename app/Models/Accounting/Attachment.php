<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-M-d',
    ];

    public function attachable()
    {
        return $this->morphTo('attachable');
    }
}
