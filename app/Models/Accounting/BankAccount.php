<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;


    public function attachable()
    {
        return $this->morphOne(Attachment::class, 'attachable')->latestOfMany();
    }
}
