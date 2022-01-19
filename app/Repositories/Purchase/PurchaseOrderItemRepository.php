<?php

namespace App\Repositories\Purchase;

use App\Models\Purchase\PurchaseOrder;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\PurchaseOrderForm;
use App\Models\Supplier\ConsumableItem;
use App\Repositories\Repository;
use App\Repositories\SupplierManagement\ConsumableItemRepository;
use Illuminate\Support\Facades\DB;

class PurchaseOrderItemRepository extends Repository
{
    private $consumableItemRepository;
    public function __construct(PurchaseOrderItem $model, ConsumableItemRepository $consumableItemRepository)
    {
        $this->consumableItemRepository = $consumableItemRepository;
        parent::__construct($model);

    }

    public function getItems($id)
    {

        $items = $this->model()->with('consumableItem')->where('po_form_id', $id)->get();

        return $items;
    }

    public function newItem($id, $supplier_id , $request)
    {

        if(is_string($request->item_id))  {

            $newItem = $this->isStringNewItem($supplier_id , $request);

            $data = new $this->model();
            $data->item_id = $newItem->id;
            $data->description = $request->description;
            $data->quantity = $request->quantity;
            $data->unit = $newItem->unit;
            $data->unit_price = $newItem->unit_price;
            $data->amount = $request->quantity * $newItem->unit_price;
            $data->po_form_id = $id;

            if($data->save()) {
                $po_subtotal = $this->subTotalPO($id, $data->amount, 'create');
                $po_item = $this->model()->with('consumableItem')->find($data->id);

                return ['vat' => $po_subtotal['vat'],
                    'subtotal' => $po_subtotal['subtotal'],
                    'subtotal_net' => $po_subtotal['subtotal_net'],
                    'discount' => $po_subtotal['discount'],
                    'total_net' => $po_subtotal['total_net'],
                    'po_item' => $po_item,
                    'others' => $po_subtotal['others'],
                ];
            }
        }
        else {
            $data = new $this->model();
            $data->item_id = $request->item_id;
            $data->description = $request->description;
            $data->quantity = $request->quantity;
            $data->unit = $request->unit;
            $data->unit_price = $request->unit_price;
            $data->amount = $request->quantity * $request->unit_price;
            $data->po_form_id = $id;

            if($data->save()) {
                $po_subtotal = $this->subTotalPO($id, $data->amount, 'create');
                $po_item = $this->model()->with('consumableItem')->find($data->id);

                return ['vat' => $po_subtotal['vat'],
                    'subtotal' => $po_subtotal['subtotal'],
                    'subtotal_net' => $po_subtotal['subtotal_net'],
                    'discount' => $po_subtotal['discount'],
                    'total_net' => $po_subtotal['total_net'],
                    'po_item' => $po_item,
                    'others' => $po_subtotal['others'],
                ];
            }
        }

    }

    public function updateItem($id, $request)
    {

        $item_id = $request->item_id_id ? $request->item_id_id : $request->item_id;

        $data = $this->model()->find($id);
        $data->item_id = $item_id;
        $data->description = $request->description;
        $data->quantity = $request->quantity;
        $data->unit = $request->unit;
        $data->unit_price = $request->unit_price;
        $data->amount = $request->quantity * $request->unit_price;

        if($data->save()) {

            $POItemSubtotal = $this->model()->where('po_form_id', $data->po_form_id)->sum('amount');

            $purchaseOrder = PurchaseOrderForm::where('id', $data->po_form_id)->first();

            $discount = $purchaseOrder->discount ? $purchaseOrder->discount : 0;

            $others = $purchaseOrder->others ? $purchaseOrder->others : 0;

            $vat = $purchaseOrder->vat ? $purchaseOrder->vat : 0;

            $vat_computation = $vat / 100;

            $subtotal = $POItemSubtotal;
            $subtotal_net =  ($subtotal + ($subtotal * $vat_computation)) - $discount;
            $total_net = ($subtotal + ($subtotal * $vat_computation)) - $discount + $others;

            $updated = $this->model()->with('consumableItem')->find($data->id);

            return ['po_item' => $updated, 'vat' => $vat, 'subtotal' => $subtotal, 'subtotal_net' => $subtotal_net, 'discount' => $discount, 'total_net' => $total_net, 'others' => $others];

        }

    }

    public function deleteItem($id, $po_form_id)
    {

        $data = $this->model()->find($id);
        if($data)
        {
            $po_form = PurchaseOrderForm::find($po_form_id);


            $others = $po_form->others ? $po_form->others : 0;
            $subtotal = $po_form->subtotal ? $po_form->subtotal : 0;
            $discount = $po_form->discount ? $po_form->discount : 0;
            $vat_computation = $po_form->vat / 100;

            $subtotal = $subtotal - $data->amount;

            $po_form->subtotal = $subtotal;
            $po_form->subtotal_net =  ($subtotal + ($subtotal * $vat_computation)) - $discount;
            $po_form->total_net = ($subtotal + ($subtotal * $vat_computation)) - $discount + $others;
            $po_form->vat = $po_form->vat;

            $data->delete();

            $new_po = $this->model()->where('po_form_id', $po_form_id)->get();

            if(empty($new_po)) {

                $po_form->subtotal = 0;
                $po_form->subtotal_net =  0;
                $po_form->total_net = 0;
                $po_form->vat = 0;
                $po_form->discount = 0;
                $po_form->others = 0;
                $po_form->total_net = 0;

            }

            if($po_form->save()) {

                return ['vat' => $po_form->vat, 'subtotal' => $po_form->subtotal, 'subtotal_net' => $po_form->subtotal_net,'discount' => $po_form->discount, 'total_net' => $po_form->total_net, 'others' => $po_form->others];

            }


        }

        return;
    }

    public function getPurchaseOrderItems($id, $params)
    {

        if($params->search) {
            $items = $this->model()->where(function ($query) use ($params) {
                $query->orWhereHas('consumableItem', function ($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('item', "LIKE", "%$params->search%");
                    });
                });
            })->with('consumableItem')->where('po_form_id', $id)->limit(20)->get();

            return $items;
        }

    }

    private function isStringNewItem($id, $data)
    {
        $request = [
            'item' => $data->item_id,
            'unit' => $data->unit,
            'unit_price' => $data->unit_price,
        ];

        $data = $this->consumableItemRepository->storeItem($id, json_decode(json_encode($request)));

        return $data;
    }

    private function subTotalPO($id, $amount, $status)
    {
        if($status == 'create') {
            $purchaseOrderForm = PurchaseOrderForm::find($id);
            $poAmount = $purchaseOrderForm->subtotal  ? $purchaseOrderForm->subtotal : 0;
            $total = $poAmount + $amount;
            $purchaseOrderForm->subtotal = $total;

            $others = $purchaseOrderForm->others ? $purchaseOrderForm->others : 0;
            $subtotal = $total;
            $discount = $purchaseOrderForm->discount ? $purchaseOrderForm->discount : 0;
            $vat_computation = $purchaseOrderForm->vat / 100;

            $purchaseOrderForm->subtotal_net =  ($subtotal + ($subtotal * $vat_computation)) - $discount;
            $purchaseOrderForm->total_net = ($subtotal + ($subtotal * $vat_computation)) - $discount + $others;

            if($purchaseOrderForm->save()) {
                $data = PurchaseOrderForm::find($id);
                return ['vat' => $data->vat, 'subtotal' => $data->subtotal, 'subtotal_net' => $data->subtotal_net,'discount' => $data->discount, 'total_net' => $data->total_net, 'others' => $data->others];
            }
        }

    }

    public function storeConsumableItem($request)
    {
        $consumableItem = [];
        foreach($request->consumable_items as $item) {

            $checkIfSupplierHasitem = ConsumableItem::where('supplier_id', $request->supplier_id)->where('item', $item->consumable_item->item)->first();
            if(!empty($checkIfSupplierHasitem)) {
                $data = new $this->model();
                $data->item_id = $checkIfSupplierHasitem->id;
                $data->quantity = $item->quantity;
                $data->unit = $item->unit;
                $data->unit_price = $checkIfSupplierHasitem->unit_price;
                $data->amount = $item->quantity * $checkIfSupplierHasitem->unit_price;
                $data->po_form_id = $request->purchase_order_id;
                if($data->save()) {
                    array_push($consumableItem, $data);
                }
            }
            $params = [
                'supplier_id' => $request->supplier_id,
                'item' => $item->consumable_item->item,
                'unit' => $item->unit,
                'unit_price' => $item->unit_price,
            ];

            $newItem = $this->createNewItemSupplier(json_decode(json_encode($params)));

            $data = new $this->model();
            $data->item_id = $newItem->id;
            $data->quantity = $item->quantity;
            $data->unit = $item->unit;
            $data->unit_price = $item->unit_price;
            $data->amount = $item->quantity * $item->unit_price;
            $data->po_form_id = $request->purchase_order_id;
            if($data->save()) {
                array_push($consumableItem, $data);
            }
        }
    }

    public function createNewItemSupplier($request)
    {

        $data = new ConsumableItem();
        $data->supplier_id = $request->supplier_id;
        $data->item = $request->item;
        $data->unit_price = $request->unit_price;
        $data->unit = $request->unit;
        if($data->save()) {

            return $data;

        }

    }





}
