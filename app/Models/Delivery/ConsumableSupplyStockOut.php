<?php

namespace App\Models\Delivery;

use App\Models\RequestMaterialForm;
use App\Models\RequestMaterialFormConsumableItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableSupplyStockOut extends Model
{
    use HasFactory;

    protected $table = 'request_material_form_consumable_supplies_stock_outs';

    protected $casts = [
        'is_delivered' => 'boolean'
    ];

    public function consumableItem() {
        return $this->belongsTo(RequestMaterialFormConsumableItem::class, 'request_materials_form_consumable_item_id', 'id');
    }
    
    public function requestMaterial() {
        return $this->belongsTo(RequestMaterialForm::class, 'request_material_id', 'id');
    }
}
