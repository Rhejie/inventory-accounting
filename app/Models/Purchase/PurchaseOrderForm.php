<?php

namespace App\Models\Purchase;

use App\Models\Accounting\BillItem;
use App\Models\ConsumableSuppliesStockIn;
use App\Models\Project;
use App\Models\SupplierManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderForm extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_forms';

    public function supplier() {
        return $this->belongsTo(SupplierManagement::class, 'supplier_id', 'id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function purchaseReceived() {
        return $this->hasMany(ConsumableSuppliesStockIn::class, 'purchase_order_form_id', 'id');
    }

    public function purchaseOrderFormItem() {
        return $this->hasMany(PurchaseOrderItem::class, 'po_form_id', 'id');
    }

    public function billItem() {
        return $this->belongsTo(BillItem::class, 'id', 'purchase_order_id');
    }
}
