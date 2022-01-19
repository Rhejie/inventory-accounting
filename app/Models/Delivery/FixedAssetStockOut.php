<?php

namespace App\Models\Delivery;

use App\Models\RequestMaterialForm;
use App\Models\RequestMaterialFormFixedAssetItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAssetStockOut extends Model
{
    use HasFactory;

    protected $table = 'request_material_form_fixed_asset_stock_outs';

    protected $casts = [
        'is_delivered' => 'boolean'
    ];

    public function requestMaterialsFixedAsset() {
        return $this->belongsTo(RequestMaterialFormFixedAssetItem::class, 'request_materials_form_fixed_asset_items_id', 'id');
    }
    
}
