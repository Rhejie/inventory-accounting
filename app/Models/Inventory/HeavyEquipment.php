<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeavyEquipment extends Model
{
    use HasFactory;

    protected $table = 'heavy_equipments';
    protected $guarded = [];
    protected $casts = [
        // 'date_acquired' => "datetime:M-d-Y",
    ];

    public function category() {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id', 'id');
    }

    public function fixedAssets() {
        return $this->morphOne(FixedAsset::class, 'assetable');
    }
}
