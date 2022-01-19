<?php

namespace App\Models\JobOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckJobOrder extends Model
{
    use HasFactory;

    public function jobOrdertype() {
        return $this->belongsTo(JobOrderType::class, 'job_order_type_id', 'id');
    }
}
