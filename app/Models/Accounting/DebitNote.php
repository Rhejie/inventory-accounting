<?php

namespace App\Models\Accounting;

use App\Models\SupplierManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{
    use HasFactory;

    public function bill() {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }

    public function supplier() {
        return $this->belongsTo(SupplierManagement::class, 'supplier_id', 'id');
    }

    public function attachable()
    {
        return $this->morphOne(Attachment::class, 'attachable')->latestOfMany();
    }
}
