<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    use HasFactory;

    public function account() {
        return $this->belongsTo(BankAccount::class, 'account_id', 'id');
    }

    public function bill() {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }
    public function attachable()
    {
        return $this->morphOne(Attachment::class, 'attachable')->latestOfMany();
    }
}
