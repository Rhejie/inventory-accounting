<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAsset extends Model
{
    use HasFactory;


    protected $table = 'vehicle_assets';
    protected $guarded = [];
    protected $casts = [
        'date_acquired' => "datetime:M-d-Y",
    ];

    public function fixedAssets() {
        return $this->morphOne(FixedAsset::class, 'assetable');
    }
}
