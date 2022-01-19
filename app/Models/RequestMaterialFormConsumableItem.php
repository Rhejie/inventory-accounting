<?php

namespace App\Models;

use App\Models\Delivery\ConsumableSupplyStockOut;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMaterialFormConsumableItem extends Model
{
    use HasFactory;

    protected $table = 'request_materials_form_consumable_items';

    protected $fillable = ['r_m_form_id', 'c_s_id', 'date_requested', 'material_request', 'quantity'];

    public function consumableSupply() {
        return $this->belongsTo(ConsumableSupplies::class, 'c_s_id', 'id');
    }

    public function requestMaterial()
    {

        return $this->belongsTo(RequestMaterialForm::class, 'r_m_form_id', 'id');

    }

    public function consumableStockOut() {
        return $this->hasMany(ConsumableSupplyStockOut::class, 'request_materials_form_consumable_item_id' , 'id');
    }

}
