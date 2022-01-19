<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{

    use HasFactory;

    protected $table = "asset_categories";

    public function assetTypes()
    {
        return $this->belongsTo(AssetType::class, 'type_id', 'id');
    }
}
