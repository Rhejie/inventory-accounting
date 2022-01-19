<?php

namespace App\Models\Purchase;

use App\Models\ConsumableSuppliesStockIn;
use App\Models\Supplier\ConsumableItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_form_items';

    public function consumableItem() {
        return $this->belongsTo(ConsumableItem::class, 'item_id', 'id');
    }

    public function purchaseOrderForm() {
        return $this->belongsTo(PurchaseOrderForm::class, 'po_form_id', 'id');
    }

    public function purchaseReceive() {
        return $this->hasMany(ConsumableSuppliesStockIn::class, 'purchase_order_form_id' ,'po_form_id');
    }
}
