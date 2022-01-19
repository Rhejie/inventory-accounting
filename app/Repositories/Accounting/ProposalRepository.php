<?php

namespace App\Repositories\Accounting;

use App\Mail\ProposalMail;
use App\Models\Accounting\Customer;
use App\Models\Accounting\Proposal;
use App\Models\Accounting\ProposalItem;
use App\Notifications\ProposalNotification;
use App\Notifications\SendEmailNotification;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use PDF;

class ProposalRepository extends Repository
{

    private $invoiceRepository;
    public function __construct(Proposal $model, InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        parent::__construct($model);

    }

    public function getProposals($params)
    {

        $proposals = $this->model();

        if($params->search) {

            $proposals = $proposals->with(['customer','invoice', 'project', 'items' => function($query) {
                $query->with(['service' => function ($query2) {
                    $query2->with(['unit', 'tax']);
                }]);
            }])->where(function ($query) use ($params) {
                $query->orWhere('proposal_number', 'LIKE', "%$params->search%");
                $query->orWhere('issue_date', 'LIKE', "%$params->search%");
                $query->orWhere('send_date', 'LIKE', "%$params->search%");
                $query->orWhere('status', 'LIKE', "%$params->search%");
                $query->orWhereHas('project', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
                $query->orWhereHas('customer', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $proposals;
        }

        $proposals = $proposals->with(['customer','invoice', 'project', 'items' => function($query) {
            $query->with(['service' => function ($query2) {
                $query2->with(['unit', 'tax']);
            }]);
        }])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $proposals;

    }

    public function getNumber()
    {

        $number = $this->model()->orderBy('id', 'desc')->first();
        $name = 'PRO';
        if(!empty($number)) {
            $propasalNumber = $number->proposal_number;
            foreach(explode('-', $propasalNumber) as $data) {
                $form_id = (int)$data + 1;
            }
        }
        else {
            $form_id = 1;
        }

        return $name.'-'.str_pad($form_id, 6, '0', STR_PAD_LEFT);
    }

    public function storeProposal($request)
    {

        $data = new $this->model();
        $data->proposal_number = $request->proposal_number;
        $data->issue_date = $request->issue_date;
        $data->customer_id = $request->customer_id;
        $data->project_id = $request->project_id;

        if($data->save()) {

            foreach($request->services as $service) {
                $tax = null;
                $unit = null;
                if($service->tax) {
                    $tax = $service->tax->rate;
                }

                if($service->unit) {
                    $unit = $service->unit->name;
                }

                $item = new ProposalItem();
                $item->proposal_id = $data->id;
                $item->product_id = $service->product_id;
                $item->service_fee = $service->service_fee;
                $item->tax_rate = $tax;
                $item->unit = $unit;
                $item->name = $service->name;
                $item->quantity = $service->quantity;
                $item->discount = $service->discount;
                $item->price = $service->amount;
                $item->save();
            }

        }

    }

    public function findProposalByID($id)
    {

        $proposal = $this->model()->with(['customer','invoice', 'project', 'items' => function($query) {
            $query->with(['service' => function ($query2) {
                $query2->with(['unit', 'tax']);
            }]);
        }])->find($id);

        return $proposal;

    }

    public function updateProposal($id, $request)
    {

        $project_id = $request->project_id_id ? $request->project_id_id : $request->project_id;

        $data = $this->model()->find($id);
        $data->proposal_number = $request->proposal_number;
        $data->issue_date = $request->issue_date;
        $data->customer_id = $request->customer_id;
        $data->project_id = $project_id;

        if($data->save()) {

            foreach($request->services as $service) {

                if($service->id) {
                    $item = ProposalItem::find($service->id);
                    if(!empty($item)) {
                        $item->proposal_id = $id;
                        $item->product_id = $service->product_id;
                        $item->quantity = $service->quantity;
                        $item->service_fee = $service->service_fee;
                        $item->name = $service->name;
                        $item->discount = $service->discount;
                        $item->price = $service->amount;
                        $item->save();
                    }
                }
                else {
                    $tax = null;
                    $unit = null;
                    if($service->tax) {
                        $tax = $service->tax->rate;
                    }

                    if($service->unit) {
                        $unit = $service->unit->name;
                    }
                    $addedItem = new ProposalItem();
                    $addedItem->proposal_id = $id;
                    $addedItem->product_id = $service->product_id;
                    $addedItem->quantity = $service->quantity;
                    $addedItem->service_fee = $service->service_fee;
                    $addedItem->name = $service->name;
                    $addedItem->tax_rate = $tax;
                    $addedItem->unit = $unit;
                    $addedItem->discount = $service->discount;
                    $addedItem->price = $service->amount;
                    $addedItem->save();
                }
            }

            foreach($request->remove_items as $item) {

                $item = ProposalItem::find($item);
                if(!empty($item)) {
                    $item->delete();
                }
            }

        }

    }

    public function deleteProposal($id)
    {

        $propal = $this->model()->find($id);
        if($propal) {
            $items = ProposalItem::where('proposal_id', $id)->get();
            if($items) {
                foreach($items as $item) {
                    $item->delete();
                }
            }
            $propal->delete();
        }

    }

    public function convertInvoice($id)
    {

        $proposal = $this->model()->with('items')->find($id);
        $proposal->is_converted = true;
        if($proposal->save()) {
            $invoice = $this->invoiceRepository->convertFromProposal(json_decode(json_encode($proposal)));
            return $invoice;
        }

    }

    public function sendProposal($id)
    {

        $date = Carbon::now();

        $proposal = $this->model()->with(['customer','project', 'items' => function($query) {
            $query->with(['service' => function ($query2) {
                $query2->with(['unit', 'tax']);
            }]);
        }])->find($id);

        $proposal->send_date = $date;

        if($proposal->save()) {
            $customer = Customer::find($proposal->customer->id);

            $tax_total = 0 ;
            $discount_total = 0 ;
            $subtotal = 0 ;
            $total_amount = 0;

            foreach($proposal->items as $item) {
                if($item->tax_rate) {
                    $taxTotal = ($item->service_fee * $item->quantity) * ($item->tax_rate / 100);
                    $tax_total += $taxTotal;
                }

                $discount_total += $item->discount;

                $subtotal += ($item->service_fee * $item->quantity);

            }

            $total_amount = ($subtotal + $tax_total) - $discount_total;

            $inv = $proposal->items->map(function($item) {
                $tax_total = ($item->service_fee * $item->quantity) * ($item->tax_rate / 100);
                if(!$item->tax_rate) {
                    $item->tax_rate = '-';
                }
                else {
                    $item->tax_rate = $item->tax_rate."% (P ".number_format(round($tax_total, 2), 2, '.', ',').")";
                }
                $item->price = "P ".number_format(round($item->price, 2), 2, '.', ',');
                $item->service_fee = "P ".number_format(round($item->service_fee, 2), 2, '.', ',');

                return $item;
            });

            $proposal->issue_date = (new Carbon($proposal->issue_date))->format('Y-m-d');
            $proposal->date_issue = (new Carbon($proposal->issue_date))->format('M-d-Y');

            $proposal->date = 'Sent on '.Carbon::now()->format('Y-M-d');
            $proposal->items = $inv;
            $proposal->total_tax = "P ".number_format(round($tax_total, 2), 2, '.', ',');
            $proposal->total_discount = "P ".number_format(round($discount_total, 2), 2, '.', ',');
            $proposal->subtotal = "P ".number_format(round($subtotal, 2), 2, '.', ',');
            $proposal->total_amount = "P ".number_format(round($total_amount, 2), 2, '.', ',');

            $data = [
                'proposal' => $proposal,
                'id' => $proposal->id
            ];

            $pdf = PDF::loadView('my-pdf-file', $data);

            $pdf_content = $pdf->download()->getOriginalContent();

            $folder = '/proposal/sent/';

            \Storage::put('public/proposal/sent/'.$proposal->proposal_number.'.pdf',$pdf_content) ;

            $name = $proposal->proposal_number.'.pdf';

            $details = [
                'greeting' => 'New Proposal Has Been Created',
                'body_1' => $proposal->proposal_number,
                'body_2' => $proposal->issue_date,
                'info' => $proposal,
                'file' => $folder.$name,
                'action_text' => 'View Proposal',
                'action_url' => 'http://127.0.0.1:8000/accounting/proposal#/pview/'.$proposal->id,
                'last_line' => 'Note: Login first before you click the url'
            ];

            // Notification::send($proposal->customer, new SendEmailNotification($details));
            Mail::to($customer->email)->send(new ProposalMail(json_decode(json_encode($details))));



            \Storage::disk('public')->delete($folder. $name);

            return $date->format('Y-M-d');
        }




    }

    public function status()
    {

        return $this->model::$statues;

    }

    public function changeStatus($id, $status)
    {

        $proposal = $this->model()->find($id);
        $proposal->status = $status;
        $proposal->save();

        return 'success';
    }

}
