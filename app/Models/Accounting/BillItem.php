<?php

namespace App\Models\Accounting;

use App\Models\Project;
use App\Models\Purchase\PurchaseOrderForm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    use HasFactory;

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function purchaseOrder() {
        return $this->belongsTo(PurchaseOrderForm::class, 'purchase_order_id', 'id');
    }
}
