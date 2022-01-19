<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherMaintenance extends Model
{
    use HasFactory;


    public function maintenanceType() {
        return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id', 'id');
    }
}
