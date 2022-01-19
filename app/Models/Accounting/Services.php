<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    public function unit() {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function tax() {
        return $this->belongsTo(Taxes::class, 'tax_id', 'id');
    }
}
