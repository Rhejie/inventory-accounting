<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    public function account() {
        return $this->belongsTo(BankAccount::class, 'account_id', 'id');
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    public function attachable()
    {
        return $this->morphOne(Attachment::class, 'attachable')->latestOfMany();
    }
}
