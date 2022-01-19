<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $casts = [
        'issue_date' => 'datetime:Y-M-d',
        'due_date' => 'datetime:Y-M-d',
        'created_at' => 'datetime:Y-M-d',
    ];

    protected $appends = array(
                'total_credit',
                'total_due',
                'status',
                'total_paid');

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function items() {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    public function invoicePayment() {
        return $this->hasMany(InvoicePayment::class, 'invoice_id', 'id');
    }

    public function getTotalCreditAttribute() {
        return $this->creditNote();
    }

    public function getTotalDueAttribute() {
        return $this->dueAmount();
    }

    public function getTotalPaidAttribute() {
        return $this->totalPaid();
    }

    public function getStatusAttribute() {
        return $this->status();
    }

    public function creditNote() {

        $credits = $this->hasMany(CreditNote::class, 'invoice_id', 'id')->get();

        $total = 0;
        if(!empty($credits)) {
            foreach ($credits as $credit) {
                $total+= $credit->amount;
            }
        }

        return $total;
    }

    public function dueAmount() {

        $items = InvoiceItem::with(['service' => function ($query) {
            $query->with(['tax']);
        }])->where('invoice_id', $this->id)->get();

        $creditNote = $this->creditNote();
        $payments = $this->totalPaid();

        $totalDue = 0;
        $subTotal = 0;
        $tax = 0;
        $discount = 0;

        foreach($items as $item) {

            $subTotal += $item->price;
            $discount += $item->discount;

            if($item->tax_rate) {

                $tax += $item->price * ($item->tax_rate / 100);

            }

        }

        $totalDue = ((($subTotal + $tax) - $discount) - $creditNote) - $payments;

        return round($totalDue, 2);
    }

    public function totalPaid() {
        $payments = InvoicePayment::where('invoice_id', '=', $this->id)->get();
        $total = 0;
        foreach ($payments as $payment) {
            $total += $payment->amount;
        }

        return $total;
    }

    public function status() {
        $due_amount = $this->dueAmount();
        $total_paid = $this->totalPaid();
        $toal_credit = $this->creditNote();

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
