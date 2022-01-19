<?php

namespace App\Models\Project;

use App\Models\Inventory\FixedAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFixedAsset extends Model
{
    use HasFactory;

    public function fixedAsset()
    {
        return $this->belongsTo(FixedAsset::class, 'fixed_asset_id', 'id');
    }
}
