<?php

namespace App\Models\Accounting;

use App\Models\Project;
use App\Models\SupplierManagement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-M-d',
        'send_date' => 'datetime:Y-M-d',
    ];

    protected $appends = array(
        'total_debit',
        'total_paid',
        'status',
        'total_due');

    public function getTotalDebitAttribute() {
        return $this->debitNote();
    }

    public function getTotalPaidAttribute() {
        return $this->totalPaid();
    }

    public function getTotalDueAttribute() {
        return $this->dueAmount();
    }

    public function getStatusAttribute() {
        return $this->status();
    }

    public function supplier() {
        return $this->belongsTo(SupplierManagement::class, 'supplier_id', 'id');
    }

    public function billItem() {
        return $this->hasMany(BillItem::class, 'bill_id', 'id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }



    public function debitNote() {

        $notes = $this->hasMany(DebitNote::class, 'bill_id', 'id')->get();

        $total = 0;
        if(!empty($notes)) {
            foreach ($notes as $note) {
                $total+= $note->amount;
            }
        }

        return $total;
    }

    public function totalPaid() {
        $paids = BillPayment::where('bill_id', $this->id)->get();

        $total = 0 ;
        if(!empty($paids)) {
            foreach ($paids as $paid) {
                $total += $paid->amount;
            }
        }

        return $total;
    }

    public function dueAmount() {
        $items = BillItem::where('bill_id', '=', $this->id)->get();

        $total = 0;

        if(!empty($items)) {
            foreach($items as $item) {
                $total += $item->amount;
            }
        }

        $total -= $this->totalPaid();
        $total -= $this->debitNote();

        return round($total, 2);
    }

    public function status() {
        $due_amount = $this->dueAmount();
        $total_paid = $this->totalPaid();

        $date_now = Carbon::now();

        if($this->due_date < $date_now) {
            if($total_paid != 0 && $due_amount != 0) {
                return 'Due';
            }
            else if(empty($this->send_date)) {
                return 'Due';
            }
            else if($total_paid != 0 && $due_amount == 0) {
                return 'Paid';
            }
        }
        if(empty($this->send_date)) {
            return 'Draft';
        }
        else if($total_paid != 0 && $due_amount != 0) {
            return 'Partaily Paid';
        }
        else if($total_paid != 0 && $due_amount == 0) {
            return 'Paid';
        }
        else  {
            return 'Sent';
        }
    }
}
