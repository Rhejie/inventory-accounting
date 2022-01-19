<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherAssetDocument extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => "datetime:M-d-Y",
    ];
}
