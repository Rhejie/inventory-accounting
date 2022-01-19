<?php

namespace App\Repositories\Purchase;

use App\Models\ConsumableSupplies;
use App\Models\ConsumableSuppliesStockIn;
use App\Models\Purchase\PurchaseOrderForm;
use App\Repositories\Repository;
use Carbon\Carbon;

class PurchaseOrderRepository extends Repository
{
    private $purchaseOrderItemRepository;
    public function __construct(PurchaseOrderForm $model, PurchaseOrderItemRepository $purchaseOrderItemRepository)
    {
        $this->purchaseOrderItemRepository = $purchaseOrderItemRepository;
        parent::__construct($model);
    }

    public function getOrders($params) {

        if($params->search) {
            $orders = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('address', 'LIKE', "%$params->search%");
                $query->orWhere('contact_person', 'LIKE', "%$params->search%");
                $query->orWhere('quote_reference_no', 'LIKE', "%$params->search%");
                $query->orWhere('material_reference_no', 'LIKE', "%$params->search%");
                $query->orWhere('date_needed', 'LIKE', "%$params->search%");
                $query->orWhere('purchase_order_reference_no', 'LIKE', "%$params->search%");
                $query->orWhere('push_order_date', 'LIKE', "%$params->search%");
                $query->orWhere('project', 'LIKE', "%$params->search%");
                $query->orWhere('location', 'LIKE', "%$params->search%");
                $query->orWhere('requested_by', 'LIKE', "%$params->search%");
                $query->orWhere('date_created', 'LIKE', "%$params->search%");
                $query->orWhere('terms_of_payment', 'LIKE', "%$params->search%");
                $query->orWhere('mode_of_payment', 'LIKE', "%$params->search%");
                $query->orWhere('remarks', 'LIKE', "%$params->search%");
                $query->orWhere('subtotal', 'LIKE', "%$params->search%");
                $query->orWhere('subtotal_net', 'LIKE', "%$params->search%");
                $query->orWhere('vat', 'LIKE', "%$params->search%");
                $query->orWhere('discount', 'LIKE', "%$params->search%");
                $query->orWhere('others', 'LIKE', "%$params->search%");
                $query->orWhere('total_net', 'LIKE', "%$params->search%");
                $query->orWhere('prepared_by', 'LIKE', "%$params->search%");
                $query->orWhere('noted_by', 'LIKE', "%$params->search%");
                $query->orWhere('checked_by', 'LIKE', "%$params->search%");
                $query->orWhere('approved_by', 'LIKE', "%$params->search%");
                $query->orWhereHas('supplier', function ($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('name', 'LIKE', "%$params->search%");
                    });
                });
            })->with(['supplier','purchaseReceived', 'purchaseOrderFormItem' , 'project'])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $orders;
        }

        $orders = $this->model()
                    ->with(['supplier',
                        'project',
                        'purchaseReceived',
                        'purchaseOrderFormItem'])
                    ->orderBy('id', 'desc')
                    ->paginate($params->count, ['*'], 'page', $params->page);

        return $orders;

    }

    public function storeOrder($request)
    {

        $data = new $this->model();
        $data->supplier_id = $request->supplier_id;
        $data->address = $request->address;
        $data->contact_person = $request->contact_person;
        $data->quote_reference_no = $request->quote_reference_no;
        $data->material_reference_no = $request->material_reference_no;
        $data->date_needed = $request->date_needed;
        $data->purchase_order_reference_no = $request->purchase_order_reference_no;
        $data->push_order_date = $request->push_order_date;
        $data->project_id = $request->project_id;
        $data->location = $request->location;
        $data->requested_by = $request->requested_by;
        $data->date_created = Carbon::now();
        $data->terms_of_payment = $request->terms_of_payment;
        $data->mode_of_payment = $request->mode_of_payment;
        $data->remarks = $request->remarks;
        $data->subtotal = $request->subtotal;
        $data->vat = $request->vat;
        $data->discount = $request->discount;
        $data->subtotal_net = $request->subtotal_net;
        $data->others = $request->others;
        $data->total_net = $request->total_net;
        $data->prepared_by = $request->prepared_by;
        $data->noted_by = $request->noted_by;
        $data->checked_by = $request->checked_by;
        $data->approved_by = $request->approved_by;

        if($data->save()) {
            $order = $this->model()->with(['supplier', 'project'])->find($data->id);
            return $order;
        }


    }

    public function updateOrder($id, $request)
    {
        if($request->suppiler_id_value){

            $supplier_id = $request->suppiler_id_value;
        }
        else {
            $supplier_id = $request->supplier_id;
        }

        if($request->project_id_project) {

            $project_id = $request->project_id_project;
        }
        else {
            $project_id = $request->project_id;
        }
        $data = $this->model()->find($id);
        $data->supplier_id = $supplier_id;
        $data->address = $request->address;
        $data->contact_person = $request->contact_person;
        $data->quote_reference_no = $request->quote_reference_no;
        $data->material_reference_no = $request->material_reference_no;
        $data->date_needed = $request->date_needed;
        $data->purchase_order_reference_no = $request->purchase_order_reference_no;
        $data->push_order_date = $request->push_order_date;
        $data->project_id = $project_id;
        $data->location = $request->location;
        $data->requested_by = $request->requested_by;
        $data->date_created = Carbon::now();
        $data->terms_of_payment = $request->terms_of_payment;
        $data->mode_of_payment = $request->mode_of_payment;
        $data->remarks = $request->remarks;
        $data->prepared_by = $request->prepared_by;
        $data->noted_by = $request->noted_by;
        $data->checked_by = $request->checked_by;
        $data->approved_by = $request->approved_by;

        if($data->save()) {

            $params = [
                'consumable_items' => $request->consumableItems,
                'purchase_order_id' => $id,
                'supplier_id' => $supplier_id
            ];

            // $this->purchaseOrderItemRepository->storeConsumableItem(json_decode(json_encode($params)));

            $order = $this->model()->with(['supplier', 'project'])->find($data->id);
            return $order;
        }
    }

    public function deleteOrder($id)
    {

        $delete = $this->model()->find($id);

        if($delete) {

            $delete->delete();
            return;

        }

    }

    public function getNumber() {

        $number = $this->model()->orderBy('id', 'desc')->first();
        $name = 'PO';
        if(!empty($number)) {
            $purchaseOrderNumber = $number->purchase_order_reference_no;
            foreach(explode('-', $purchaseOrderNumber) as $data) {
                $form_id = (int)$data + 1;
            }
        }
        else {
            $form_id = 1;
        }

        return $name.'-'.str_pad($form_id, 6, '0', STR_PAD_LEFT);
    }

    public function getPurchaseOrderData($id)
    {
        $data = $this->model()->with(['supplier', 'project'])->find($id);

        return $data;
    }


    public function getPurhcaseOrderForms($params)
    {

        if($params->search)
        {

            $forms = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('quote_reference_no', 'LIKE', "%$params->search%");
                $query->orWhere('material_reference_no', 'LIKE', "%$params->search%");
                $query->orWhere('purchase_order_reference_no', 'LIKE', "%$params->search%");
            })->limit(20)->get();

            return $forms;

        }

    }

    public function addVat($id, $params)
    {

        $vat = $this->model()->find($id);

        $others = $vat->others ? $vat->others : 0;
        $subtotal = $vat->subtotal ? $vat->subtotal : 0;
        $discount = $vat->discount ? $vat->discount : 0;
        $vat_computation = $params->vat / 100;

        $vat->subtotal_net =  ($subtotal + ($subtotal * $vat_computation)) - $discount;
        $vat->total_net = ($subtotal + ($subtotal * $vat_computation)) - $discount + $others;
        $vat->vat = $params->vat;

        if($vat->save()) {
            $vatData =$this->model()->find($vat->id);
            return ['vat' => $vatData->vat, 'subtotal' => $vatData->subtotal, 'subtotal_net' => $vatData->subtotal_net, 'total_net' => $vatData->total_net, 'others' => $vatData->others, 'discount' => $vatData->discount,];
        }

    }

    public function addDiscount($id, $params)
    {

        $data = $this->model()->find($id);

        $others = $data->others ? $data->others : 0;
        $subtotal = $data->subtotal ? $data->subtotal : 0;
        $discount = $params->discount ? $params->discount : 0;
        $vat_computation = $data->vat / 100;

        $data->subtotal_net =  ($subtotal + ($subtotal * $vat_computation)) - $discount;
        $data->total_net = ($subtotal + ($subtotal * $vat_computation)) - $discount + $others;
        $data->discount = $discount;

        if($data->save()) {

            return ['vat' => $data->vat, 'subtotal' => $data->subtotal, 'subtotal_net' => $data->subtotal_net,'discount' => $data->discount, 'total_net' => $data->total_net, 'others' => $data->others];
        }

    }

    public function addOthers($id, $params)
    {

        $data = $this->model()->find($id);

        $others = $params->others ? $params->others : 0;
        $subtotal = $data->subtotal ? $data->subtotal : 0;
        $discount = $data->discount ? $data->discount : 0;
        $vat_computation = $data->vat / 100;

        $data->subtotal_net =  ($subtotal + ($subtotal * $vat_computation)) - $discount;
        $data->total_net = ($subtotal + ($subtotal * $vat_computation)) - $discount + $others;
        $data->others = $others;

        if($data->save()) {
            return ['vat' => $data->vat, 'subtotal' => $data->subtotal, 'subtotal_net' => $data->subtotal_net,'discount' => $data->discount, 'total_net' => $data->total_net, 'others' => $data->others];
        }

    }

    public function hasSupply($project_id, $params)
    {

        if($params->consumable_item) {

            $consumableSupply = ConsumableSupplies::where('project_id', $project_id)->where('item_name', $params->consumable_item)->first();

            return $consumableSupply;

        }

    }

    public function getPurchaseOrders($id)
    {

        $orders = $this->model()->with(['project'])->where('supplier_id', $id)->doesntHave('billItem')->get();

        return $orders;

    }

    public function getPurchaseOrdersUpdate($id)
    {

        $orders = $this->model()->with(['project'])->where('supplier_id', $id)->get();

        return $orders;

    }

    public function getPurchaseOrderByNumber($params) {

        if($params->search) {

            $forms = $this->model()->with(['project'])->where(function ($query) use ($params) {
                $query->orWhere('purchase_order_reference_no', 'LIKE', "%$params->search%");
            })->doesntHave('billItem')->limit(20)->get();

            return $forms;

        }
    }

}
