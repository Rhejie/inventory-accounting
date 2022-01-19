<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    use HasFactory;

    protected $table = 'fixed_assets';

    public function assetable()
    {
        return $this->morphTo('assetable');
    }


    public function location() {
        return $this->hasMany(LocationHistory::class, 'fixed_asset_id', 'id')->orderBy('id', 'DESC');
    }

    public function location2() {
        return $this->hasMany(LocationHistory::class, 'id', 'assetable_id')->orderBy('id', 'DESC');
    }
}
