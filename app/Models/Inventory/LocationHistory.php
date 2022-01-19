<?php

namespace App\Models\Inventory;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationHistory extends Model
{
    use HasFactory;

    public function fixedAsset() {
        return $this->belongsTo(FixedAsset::class, 'fixed_asset_id', 'id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
