<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
    use HasFactory;

    public function item(){
        return $this->belongsTo(BillOfMaterialItem::class, 'bill_of_material_item_id', 'id');
    }

    public function description() {
        return $this->belongsTo(BillOfMaterialDescription::class, 'bill_of_material_description_id', 'id');
    }
}
