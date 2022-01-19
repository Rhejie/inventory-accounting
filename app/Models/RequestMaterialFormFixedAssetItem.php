<?php

namespace App\Models;

use App\Models\Delivery\FixedAssetStockOut;
use App\Models\Inventory\FixedAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMaterialFormFixedAssetItem extends Model
{
    use HasFactory;

    protected $table = 'request_material_form_fixed_asset_items';

    public function fixedAsset()
    {
        return $this->belongsTo(FixedAsset::class, 'type_id', 'id');
    }

    public function requestMaterial()
    {

        return $this->belongsTo(RequestMaterialForm::class, 'request_materials_form_id', 'id');

    }

    public function requestMaterialStockOut(){
        return $this->belongsTo(FixedAssetStockOut::class, 'id', 'request_materials_form_fixed_asset_items_id');
    }
}
