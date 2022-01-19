<?php

namespace App\Models\Supplier;

use App\Models\SupplierManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableItem extends Model
{
    use HasFactory;

    protected $table = 'consumable_items';

    protected $guarded = [];

    public function suppliers()
    {
        return $this->belongsTo(SupplierManagement::class, 'supplier_id', 'id');
    }
}
