<?php

namespace App\Models\Sale;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function setDateAttribute($value)
    {
        return $this->attributes['date'] = Carbon::parse($value)->toDateString();
    }

}
