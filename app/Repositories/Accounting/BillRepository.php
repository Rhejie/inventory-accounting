<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Bill;
use App\Models\Accounting\BillItem;
use App\Models\SupplierManagement;
use App\Notifications\SendBillEmailNotification;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class BillRepository extends Repository
{

    public function __construct(Bill $model)
    {
        parent::__construct($model);

    }

    public function getBills($params)
    {

        $bills = $this->model()->with(['supplier', 'billItem', 'project', 'customer']);

        if($params->search) {

            $bills = $bills->where(function ($query) use ($params) {
                $query->orWhere('bill_number', 'LIKE', "%$params->search%");
                $query->orWhere('title', 'LIKE', "%$params->search%");
                $query->orWhere('bill_date', 'LIKE', "%$params->search%");
                $query->orWhere('due_date', 'LIKE', "%$params->search%");
                $query->orWhere('send_date', 'LIKE', "%$params->search%");
                $query->orWhereHas('supplier', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
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

            return $bills;

        }

        $bills = $bills->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $bills;

    }

    public function storeBill($request)
    {

        $data = new $this->model();
        if($request->type == 'company') {
            $data->title = $request->title;
        }
        else {
            $data->supplier_id = $request->supplier_id;
        }

        $data->bill_date = $request->bill_date;
        $data->due_date = $request->due_date;
        $data->bill_number = $request->bill_number;
        $data->type = $request->type;
        $data->project_id = $request->project_id;
        $data->customer_id = $request->customer_id;
        if($data->save()) {

            foreach($request->orders as $po) {
                $item = new BillItem();

                if($request->type == 'company') {
                    $item->name = $po->name;
                    $item->bill_id = $data->id;
                    $item->company_name = $po->company_name;
                    $item->amount = $po->total_net;
                    $item->subtotal_net = $po->subtotal_net;
                    $item->others = $po->others;
                    $item->subtotal = $po->subtotal;
                    $item->discount = $po->discount;
                    $item->vat = $po->vat;
                    $item->save();
                }
                else {
                    $item->bill_id = $data->id;
                    $item->purchase_order_id = $po->id;
                    $item->purchase_order_number = $po->purchase_order_reference_no;
                    $item->project_id = $po->project_id;
                    $item->amount = $po->total_net;
                    $item->subtotal_net = $po->subtotal_net;
                    $item->others = $po->others;
                    $item->subtotal = $po->subtotal;
                    $item->discount = $po->discount;
                    $item->vat = $po->vat;
                    $item->save();
                }
            }

            return $this->model()->with(['supplier', 'billItem',  'project', 'customer', 'customer'])->find($data->id);
        }

    }

    public function updateBill($id, $request)
    {
        $project = $request->project_id_id ? $request->project_id_id : $request->project_id;
        $customer = $request->customer_id_id ? $request->customer_id_id : $request->customer_id;
        $data = $this->model()->find($id);
        if($data->type == 'company') {
            $data->title = $request->title;
        }
        else {
            $data->supplier_id = $request->supplier_id;
        }
        $data->bill_date = $request->bill_date;
        $data->due_date = $request->due_date;
        $data->bill_number = $request->bill_number;
        $data->project_id = $project;
        $data->customer_id = $customer;
        if($data->save()) {

            foreach($request->orders as $po) {
                $billItem = BillItem::find($po->id);
                if (property_exists($po, 'status')) {
                    if($po->status == 'new') {
                        $item = new BillItem();
                        if($data->type == 'company') {
                            $item->name = $po->name;
                            $item->bill_id = $data->id;
                            $item->company_name = $po->company_name;
                            $item->amount = $po->total_net;
                            $item->subtotal_net = $po->subtotal_net;
                            $item->others = $po->others;
                            $item->subtotal = $po->subtotal;
                            $item->discount = $po->discount;
                            $item->vat = $po->vat;
                            $item->save();
                        }
                        else {
                            $item->bill_id = $id;
                            $item->purchase_order_id = $po->id;
                            $item->purchase_order_number = $po->purchase_order_reference_no;
                            $item->project_id = $po->project_id;
                            $item->amount = $po->total_net;
                            $item->subtotal_net = $po->subtotal_net;
                            $item->others = $po->others;
                            $item->subtotal = $po->subtotal;
                            $item->discount = $po->discount;
                            $item->vat = $po->vat;
                            $item->save();
                        }
                    }
                }
                else {
                    if(!empty($billItem)) {
                        if($data->type == 'company') {
                            $billItem->name = $po->name;
                            $billItem->bill_id = $id;
                            $billItem->company_name = $po->company_name;
                            $billItem->amount = $po->total_net;
                            $billItem->subtotal_net = $po->subtotal_net;
                            $billItem->others = $po->others;
                            $billItem->subtotal = $po->subtotal;
                            $billItem->discount = $po->discount;
                            $billItem->vat = $po->vat;
                            $billItem->save();
                        }
                        else {
                            $billItem->bill_id = $id;
                            $billItem->purchase_order_number = $po->purchase_order_reference_no;
                            $billItem->project_id = $po->project_id;
                            $billItem->amount = $po->total_net;
                            $billItem->subtotal_net = $po->subtotal_net;
                            $billItem->others = $po->others;
                            $billItem->subtotal = $po->subtotal;
                            $billItem->discount = $po->discount;
                            $billItem->vat = $po->vat;
                            $billItem->save();
                        }
                    }
                    else {
                        $item = new BillItem();
                        if($data->type == 'company') {
                            $item->name = $po->name;
                            $item->bill_id = $data->id;
                            $item->company_name = $po->company_name;
                            $item->amount = $po->total_net;
                            $item->subtotal_net = $po->subtotal_net;
                            $item->others = $po->others;
                            $item->subtotal = $po->subtotal;
                            $item->discount = $po->discount;
                            $item->vat = $po->vat;
                            $item->save();
                        }
                        else {
                            $item->bill_id = $id;
                            $item->purchase_order_id = $po->id;
                            $item->purchase_order_number = $po->purchase_order_reference_no;
                            $item->project_id = $po->project_id;
                            $item->amount = $po->total_net;
                            $item->subtotal_net = $po->subtotal_net;
                            $item->others = $po->others;
                            $item->subtotal = $po->subtotal;
                            $item->discount = $po->discount;
                            $item->vat = $po->vat;
                            $item->save();
                        }
                    }
                }

            }

            foreach($request->remove_items as $po) {
                $billItem = BillItem::find($po);
                if(!empty($billItem)) {
                    $billItem->delete();
                }
            }

            return $this->model()->with(['supplier', 'billItem',  'project', 'customer'])->find($id);
        }
    }

    public function deleteBill($id)
    {

        $data = $this->model()->find($id);
        if($data) {
            $item = BillItem::where('bill_id', $data->id)->get();
            if($item) {
                foreach($item as $i) {
                    $i->delete();
                }
            }
            $data->delete();
        }

    }

    public function getNumber()
    {

        $number = $this->model()->orderBy('id', 'desc')->first();
        $name = 'BILL';
        if(!empty($number)) {
            $billNumber = $number->bill_number;
            foreach(explode('-', $billNumber) as $data) {
                $form_id = (int)$data + 1;
            }
        }
        else {
            $form_id = 1;
        }

        return $name.'-'.str_pad($form_id, 6, '0', STR_PAD_LEFT);

    }

    public function getBillByID($id)
    {

        $bill = $this->model()->with(['supplier', 'billItem', 'project', 'customer'])->find($id);

        return $bill;

    }

    public function getItems($id)
    {

        $items = BillItem::with(['project'])->where('bill_id', $id)->get();

        return $items;

    }

    public function sendBill($id)
    {

        $date = Carbon::now();

        $bill = $this->model()->with(['supplier'])->find($id);
        $bill->send_date = $date;
        if($bill->save()) {

            if($bill->type == 'po') {
                $supplier = SupplierManagement::find($bill->supplier->id);

                $details = [
                    'greeting' => 'New Bill Has Been Created',
                    'body_1' => $bill->bill_number,
                    'body_2' => $bill->bill_date,
                    'body_3' => $bill->due_date,
                    'action_text' => 'View Bill',
                    'action_url' => 'http://127.0.0.1:8000/accounting/expense/bill#/bview/'.$bill->id,
                    'last_line' => 'Note: Login first before you click the url'
                ];

                // Notification::send($invoice->supplier, new SendEmailNotification($details));
                Notification::send($supplier, new SendBillEmailNotification($details));
            }

            return $date->format('Y-M-d');
        }



    }

    public function searchBill($params)
    {

        if($params->search) {

            $bill = $this->model()->with(['supplier'])->where('bill_number', 'LIKE', "%$params->search%")->limit(20)->get();

            return $bill;
        }

    }

    public function billOrders($id)
    {

        $orders = BillItem::where('bill_id', $id)->with(['purchaseOrder', 'project'])->get();

        return $orders;

    }

}
