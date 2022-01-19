<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
    use HasFactory;

    public function fromAccount() {
        return $this->belongsTo(BankAccount::class, 'from_account', 'id');
    }

    public function toAccount() {
        return $this->belongsTo(BankAccount::class, 'to_account', 'id');
    }

    public function attachable()
    {
        return $this->morphOne(Attachment::class, 'attachable')->latestOfMany();
    }
}
