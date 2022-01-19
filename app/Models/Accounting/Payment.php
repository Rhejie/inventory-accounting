<?php

namespace App\Models\Accounting;

use App\Models\Project;
use App\Models\SupplierManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function supplier() {
        return $this->belongsTo(SupplierManagement::class, 'supplier_id', 'id');
    }

    public function account() {
        return $this->belongsTo(BankAccount::class, 'account_id', 'id');
    }

    public function attachable()
    {
        return $this->morphOne(Attachment::class, 'attachable')->latestOfMany();
    }
    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
