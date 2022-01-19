<?php

namespace App\Models;

use App\Models\Purchase\PurchaseOrderForm;
use App\Models\Purchase\PurchaseOrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableSuppliesStockIn extends Model
{
    use HasFactory;

    protected $table = 'consumable_supplies_stock_ins';

    protected $fillable = ['purchase_order_form_id', 'purchase_order_form_item_id', 'date_received', 'received_quantity', 'remaining_quantity_to_receive'];

    public function purchaseOrderForm(){
        return $this->belongsTo(PurchaseOrderForm::class, 'purchase_order_form_id', 'id');
    }

    public function purchaseOrderItem() {
        return $this->belongsTo(PurchaseOrderItem::class, 'purchase_order_form_item_id', 'id');
    }

    public function purchaseOrderItems() {
        return $this->hasMany(PurchaseOrderItem::class, 'po_form_id', 'purchase_order_form_id');
    }

    
}

