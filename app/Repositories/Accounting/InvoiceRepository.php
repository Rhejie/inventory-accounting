<?php

namespace App\Repositories\Accounting;

use App\Mail\InvoiceMail;
use App\Models\Accounting\Customer;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\InvoiceItem;
use App\Notifications\SendInvoiceEmailNotification;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use PDF;

class InvoiceRepository extends Repository
{

    public function __construct(Invoice $model)
    {

        parent::__construct($model);

    }

    public function getInvoices($params)
    {

        $invoices = $this->model();

        if($params->search) {

            $invoices = $invoices->with(['customer', 'project', 'items' => function($query) {
                $query->with(['service' => function ($query2) {
                    $query2->with(['unit', 'tax']);
                }]);
            }])->where(function($query) use ($params) {
                $query->orWhere('ref_number', 'like', "%$params->search%");
                $query->orWhere('issue_date', 'like', "%$params->search%");
                $query->orWhere('due_date', 'like', "%$params->search%");
                $query->orWhere('send_date', 'like', "%$params->search%");
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

            return $invoices;
        }

        $invoices = $invoices->with(['customer', 'project', 'items' => function($query) {
            $query->with(['service' => function ($query2) {
                $query2->with(['unit', 'tax']);
            }]);
        }])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $invoices;

    }

    public function getNumber()
    {

        $number = $this->model()->orderBy('id', 'desc')->first();
        $name = 'INV';
        if(!empty($number)) {
            $invoiceNumber = $number->ref_number;
            foreach(explode('-', $invoiceNumber) as $data) {
                $form_id = (int)$data + 1;
            }
        }
        else {
            $form_id = 1;
        }

        return $name.'-'.str_pad($form_id, 6, '0', STR_PAD_LEFT);
    }

    public function storeInvoice($request)
    {

        $data = new $this->model();
        $data->ref_number = $request->ref_number;
        $data->issue_date = $request->issue_date;
        $data->due_date = $request->due_date;
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
                $item = new InvoiceItem();
                $item->invoice_id = $data->id;
                $item->product_id = $service->product_id;
                $item->quantity = $service->quantity;
                $item->tax_rate = $tax;
                $item->unit = $unit;
                $item->name = $service->name;
                $item->service_fee = $service->service_fee;
                $item->discount = $service->discount;
                $item->price = $service->amount;
                $item->save();
            }

        }

    }

    public function findInvoiceByID($id)
    {

        $proposal = $this->model()->with(['customer', 'project', 'items' => function($query) {
            $query->with(['service' => function ($query2) {
                $query2->with(['unit', 'tax']);
            }]);
        }])->find($id);

        return $proposal;

    }

    public function updateInvoice($id, $request)
    {

        $project_id = $request->project_id_id ? $request->project_id_id : $request->project_id;

        $data = $this->model()->find($id);
        $data->ref_number = $request->ref_number;
        $data->issue_date = $request->issue_date;
        $data->due_date = $request->due_date;
        $data->customer_id = $request->customer_id;
        $data->project_id = $project_id;

        if($data->save()) {

            foreach($request->services as $service) {

                if($service->id) {
                    $item = InvoiceItem::find($service->id);
                    if(!empty($item)) {
                        $item->invoice_id = $id;
                        $item->product_id = $service->product_id;
                        $item->quantity = $service->quantity;
                        $item->discount = $service->discount;
                        $item->name = $service->name;
                        $item->service_fee = $service->service_fee;
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
                    $addedItem = new InvoiceItem();
                    $addedItem->invoice_id = $id;
                    $addedItem->product_id = $service->product_id;
                    $addedItem->quantity = $service->quantity;
                    $addedItem->price = $service->amount;
                    $addedItem->name = $service->name;
                    $addedItem->tax_rate = $tax;
                    $addedItem->unit = $unit;
                    $addedItem->service_fee = $service->service_fee;
                    $addedItem->discount = $service->discount;
                    $addedItem->save();
                }
            }

            foreach($request->remove_items as $item) {

                $item = InvoiceItem::find($item);
                if(!empty($item)) {
                    $item->delete();
                }
            }

        }

    }

    public function convertFromProposal($request)
    {

        $invoice = $this->model()->where('proposal_id', $request->id)->first();
        if(!empty($invoice)) {
            return 'converted';
        }

        $data = new $this->model();
        $data->ref_number = $this->getNumber();
        $data->issue_date = $request->issue_date;
        $data->due_date = $request->issue_date;
        $data->customer_id = $request->customer_id;
        $data->proposal_id = $request->id;
        $data->project_id = $request->project_id;

        if($data->save()) {

            foreach($request->items as $service) {
                $discount = $service->discount ? $service->discount : 0;
                $item = new InvoiceItem();
                $item->invoice_id = $data->id;
                $item->product_id = $service->product_id;
                $item->name = $service->name;
                $item->service_fee = $service->service_fee;
                $item->quantity = $service->quantity;
                $item->discount = $discount;
                $item->tax_rate = $service->tax_rate;
                $item->unit = $service->unit;
                $item->price = $service->price;
                $item->save();
            }


            return 'convert';

        }

    }

    public function searchInvoice($params)
    {

        if($params->search) {

            $invoices = $this->model()->with(['customer', 'project', 'items' => function($query) {
                $query->with(['service' => function ($query2) {
                    $query2->with(['unit', 'tax']);
                }]);
            }])->where('ref_number', 'LIKE', "%$params->search%")->limit(20)->get();

            return $invoices;
        }

    }

    public function sendInvoice($id) {

        $date = Carbon::now();

        $invoice = $this->model()->with(['customer','project', 'items' => function($query) {
            $query->with(['service' => function ($query2) {
                $query2->with(['unit', 'tax']);
            }]);
        }])->find($id);
        $invoice->send_date = $date;
        if($invoice->save()) {

            $customer = Customer::find($invoice->customer->id);


            $tax_total = 0 ;
            $discount_total = 0 ;
            $subtotal = 0 ;
            $total_amount = 0;

            foreach($invoice->items as $item) {
                if($item->tax_rate) {
                    $taxTotal = ($item->service_fee * $item->quantity) * ($item->tax_rate / 100);
                    $tax_total += $taxTotal;
                }

                $discount_total += $item->discount;

                $subtotal += ($item->service_fee * $item->quantity);

            }

            $total_amount = ($subtotal + $tax_total) - $discount_total;

            $inv = $invoice->items->map(function($item) {
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

            $invoice->issue_date = (new Carbon($invoice->issue_date))->format('Y-m-d');
            $invoice->date_issue = (new Carbon($invoice->issue_date))->format('M-d-Y');
            $invoice->date_due = (new Carbon($invoice->due_date))->format('M-d-Y');

            $invoice->items = $inv;
            $invoice->total_tax = "P ".number_format(round($tax_total, 2), 2, '.', ',');
            $invoice->total_discount = "P ".number_format(round($discount_total, 2), 2, '.', ',');
            $invoice->subtotal = "P ".number_format(round($subtotal, 2), 2, '.', ',');
            $invoice->total_amount = "P ".number_format(round($total_amount, 2), 2, '.', ',');

            $data = [
                'invoice' => $invoice,
                'id' => $invoice->id
            ];

            $pdf = PDF::loadView('invoice-pdf-file', $data);

            $pdf_content = $pdf->download()->getOriginalContent();

            $folder = '/invoice/sent/';

            \Storage::put('public/invoice/sent/'.$invoice->ref_number.'.pdf',$pdf_content) ;

            $name = $invoice->ref_number.'.pdf';

            $details = [
                'greeting' => 'New Invoice Has Been Created',
                'body_1' => $invoice->ref_number,
                'body_2' => $invoice->issue_date,
                'body_3' => $invoice->due_date,
                'info' => $invoice,
                'file' => $folder.$name,
                'action_text' => 'View Invoice',
                'action_url' => 'http://127.0.0.1:8000/accounting/income/invoice#/iview/'.$invoice->id,
                'last_line' => 'Note: Login first before you click the url'
            ];

            // Notification::send($invoice->customer, new SendEmailNotification($details));
            // Notification::send($customer, new SendInvoiceEmailNotification($details));
            // Notification::send($customer, new InvoiceMail($details));
            Mail::to($customer->email)->send(new InvoiceMail(json_decode(json_encode($details))));

            \Storage::disk('public')->delete($folder. $name);
            return $date->format('Y-M-d');
        }



    }

    public function deleteInvoice($id) {
        $data = $this->model()->find($id);
        $data->delete();
    }
}
