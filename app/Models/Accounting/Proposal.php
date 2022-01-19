<?php

namespace App\Models\Accounting;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $casts = [
        'issue_date' => 'datetime:Y-M-d',
        'created_at' => 'datetime:Y-M-d',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function items() {
        return $this->hasMany(ProposalItem::class, 'proposal_id', 'id');
    }

    public function invoice() {

        return $this->belongsTo(Invoice::class, 'id', 'proposal_id');

    }

    public static $statues = [
        'Draft',
        //0
        'Open',
        //1
        'Accepted',
        //2
        'Declined',
        //3
        'Close',
        //4
    ];
}
