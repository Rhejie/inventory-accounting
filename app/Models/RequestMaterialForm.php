<?php

namespace App\Models;

use App\Models\Delivery\ConsumableSupplyStockOut;
use App\Models\Delivery\FixedAssetStockOut;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMaterialForm extends Model
{
    use HasFactory;

    protected $table = 'request_material_forms';

    protected $fillable = ['date_request', 'request_material_code', 'project_id', 'requested_by', 'approved_by'];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function requestMaterialFixedAsset() {
        return $this->hasMany(RequestMaterialFormFixedAssetItem::class, 'request_materials_form_id', 'id');
    }

    public function requestMaterialStockOut() {
        return $this->hasMany(FixedAssetStockOut::class, 'request_material_id', 'id');
    }

    public function requestMaterialFixedAssetItem() {
        return $this->hasMany(RequestMaterialFormFixedAssetItem::class, 'request_materials_form_id', 'id');
    }

    public function requestMaterialConsumableStock() {
        return $this->hasMany(ConsumableSupplyStockOut::class, 'request_material_id', 'id');
    }

    public function requestMaterialConsumableItem() {
        return $this->hasMany(RequestMaterialFormConsumableItem::class, 'r_m_form_id', 'id');
    }
}
