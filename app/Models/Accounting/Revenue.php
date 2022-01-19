<?php

namespace App\Models\Accounting;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    public function account() {
        return $this->belongsTo(BankAccount::class, 'account_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function attachable()
    {
        return $this->morphOne(Attachment::class, 'attachable')->latestOfMany();
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
