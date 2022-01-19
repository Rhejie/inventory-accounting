<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    use HasFactory;

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function attachable()
    {
        return $this->morphOne(Attachment::class, 'attachable')->latestOfMany();
    }
}
