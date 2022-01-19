<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableSupplies extends Model
{
    use HasFactory;

    protected $fillable = ['item_code', 'item_name', 'bar_code', 'lot_number', 'description', 'unit_of_measure', 'quantity', 'stock_on_hand', 'reorder_point'];


    public function project() {

        return $this->belongsTo(Project::class, 'project_id', 'id');

    }
}
