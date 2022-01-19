<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BillOfMaterialItem extends Model
{
    use HasFactory;

    public function billOfMaterials() {
        return $this->hasMany(BillOfMaterial::class, 'bill_of_material_item_id', 'id');
    }
}
