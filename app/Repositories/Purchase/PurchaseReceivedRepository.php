<?php

namespace App\Repositories\Purchase;

use App\Models\ConsumableSupplies;
use App\Models\ConsumableSuppliesStockIn;
use App\Models\Purchase\PurchaseOrderForm as AppPurchaseOrderForm;
use App\Models\Purchase\PurchaseOrderFormItem;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\PurchaseOrderForm;
use App\Repositories\Repository;
use App\Repositories\SupplierManagement\ConsumableSupplyRepository;

class PurchaseReceivedRepository extends Repository
{
    private $consumableSupplyRepository;

    public function __construct(ConsumableSuppliesStockIn $model, ConsumableSupplyRepository $consumableSupplyRepository)
    {
        $this->consumableSupplyRepository = $consumableSupplyRepository;

        parent::__construct($model);

    }

    public function getReceived($params)
    {

        if($params->search) {
            $received = $this->model()
                    ->select('purchase_order_form_id', \DB::raw('sum(received_quantity) as quantity'), \DB::raw('sum(remaining_quantity_to_receive) as remaining'))
                    ->groupBy('purchase_order_form_id')
                    ->with(['purchaseOrderForm'])
                    ->where(function ($query) use ($params) {
                        $query->orWhereHas('purchaseOrderForm', function ($query2) use ($params) {
                            $query2->where(function($query3) use ($params) {
                                $query3->orWhere('quote_reference_no', 'LIKE', "%$params->search%");
                                $query3->orWhere('material_reference_no', 'LIKE', "%$params->search%");
                                $query3->orWhere('purchase_order_reference_no', 'LIKE', "%$params->search%");
                            });
                        });
                    })
                    ->paginate($params->count, ['*'], 'page', $params->page);
            return $received;
        }


        // $received = $this->model()->with(['purchaseOrderForm', 'purchaseOrderItem' => function ($query) { $query->with('ConsumableItem');}])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        $received = $this->model()
                    ->select('purchase_order_form_id',
                        \DB::raw('sum(received_quantity) as quantity'),
                        \DB::raw('sum(remaining_quantity_to_receive) as remaining'))
                    ->groupBy('purchase_order_form_id')
                    ->with(['purchaseOrderForm', 'purchaseOrderItems'])->paginate($params->count, ['*'], 'page', $params->page);
        return $received;

    }

    public function storeReceived($request)
    {
        $response = [];
        // if($request['receivedItems']) {
            foreach ($request->receivedItems as $key => $value) {
                if(isset($value['received_quantity']) &&
                    isset($value['remaining_quantity_to_receive'])) {

                    $data = new $this->model();
                    $data->purchase_order_form_id = $request->purchase_order_form_id;
                    $data->date_received = $request->date_received;
                    $data->purchase_order_form_item_id = $value['id'];
                    $data->received_quantity = $value['received_quantity'];
                    $data->remaining_quantity_to_receive = $value['remaining_quantity_to_receive'];

                    if($data->save()) {

                        $purchaseOrderItem = PurchaseOrderItem::with(['purchaseOrderForm', 'consumableItem'])
                                ->where('id', $value['id'])->first();

                        $storeConsumableSupply = [
                            'supplier_id' => $purchaseOrderItem->purchaseOrderForm->supplier_id,
                            'project_id' => $purchaseOrderItem->purchaseOrderForm->project_id,
                            'item_name' => $purchaseOrderItem->consumableItem->item,
                            'item_code' => null,
                            'bar_code' => null,
                            'lot_number' => null,
                            'unit_of_measure' => null,
                            'description' => null,
                            'stock_on_hand' => $value['received_quantity'],
                            'reorder_point' => null,
                            'status' => 'purchase_received'
                        ];

                        $this->consumableSupplyRepository->storeSupply(json_decode(json_encode($storeConsumableSupply)));

                        // $storeReceievd = $this->model()->with(['purchaseOrderForm', 'purchaseOrderItem' => function ($query) { $query->with('ConsumableItem');}])->find($data->id);
                        // array_push($response, $storeReceievd);
                    }
                }
            // }
        }

        $storeReceievd = $this->model()
                            ->select('purchase_order_form_id', \DB::raw('sum(received_quantity) as quantity'),)
                            ->groupBy('purchase_order_form_id')
                            ->with(['purchaseOrderForm'])->where('purchase_order_form_id', $request->purchase_order_form_id)->first();

        return $storeReceievd;

    }

    public function storeReceivedItem($request)
    {

        $response = [];
        // if($request['receivedItems']) {
            foreach ($request->receivedItems as $key => $value) {
                if(isset($value['received_quantity']) &&
                    isset($value['remaining_quantity_to_receive'])) {
                        $data = new $this->model();
                        $data->purchase_order_form_id = $request->purchase_order_form_id;
                        $data->date_received = $request->date_received;
                        $data->purchase_order_form_item_id = $value['id'];
                        $data->received_quantity = $value['received_quantity'];
                        $data->remaining_quantity_to_receive = $value['remaining_quantity_to_receive'];

                        if($data->save()) {

                            $purchaseOrderItem = PurchaseOrderItem::with(['purchaseOrderForm', 'consumableItem'])
                                    ->where('id', $value['id'])->first();

                            $storeConsumableSupply = [
                                'supplier_id' => $purchaseOrderItem->purchaseOrderForm->supplier_id,
                                'project_id' => $purchaseOrderItem->purchaseOrderForm->project_id,
                                'item_name' => $purchaseOrderItem->consumableItem->item,
                                'item_code' => null,
                                'bar_code' => null,
                                'lot_number' => null,
                                'unit_of_measure' => null,
                                'description' => null,
                                'stock_on_hand' => $value['received_quantity'],
                                'reorder_point' => null,
                                'status' => 'purchase_received'
                            ];

                            $this->consumableSupplyRepository->storeSupply(json_decode(json_encode($storeConsumableSupply)));

                            $storeReceievd = $this->model()->with(['purchaseOrderForm', 'purchaseOrderItem' => function ($query) { $query->with('ConsumableItem');}])->find($data->id);
                            array_push($response, $storeReceievd);

                    }
                }
            // }
        }

        return $response;

    }

    public function updateReceived($id, $request)
    {
        if($request->purchase_order_form_id_id) {
            $order_form_id = $request->purchase_order_form_id_id;
        }
        else {
            $order_form_id = $request->purchase_order_form_id;
        }
        if($request->purchase_order_form_item_id_id) {
            $order_item_id = $request->purchase_order_form_item_id_id;
        }
        else {
            $order_item_id = $request->purchase_order_form_item_id;
        }

        $data = $this->model()->find($id);
        $data->purchase_order_form_id = $order_form_id;
        $data->purchase_order_form_item_id = $order_item_id;
        $data->date_received = $request->date_received;
        $data->received_quantity = $request->received_quantity;
        $data->remaining_quantity_to_receive = $request->remaining_quantity_to_receive;

        if($data->save())  {
            $consumableSupplies = ConsumableSupplies::where('project_id', $request->project_id)->where('item_name', $request->item_name)->first();
            if($request->previous_received < $request->received_quantity) {
                $stock = $request->received_quantity - $request->previous_received;
                $consumableSupplies->stock_on_hand = $consumableSupplies->stock_on_hand + $stock;
                $consumableSupplies->save();
            }
            else {
                $stock = $request->previous_received - $request->received_quantity;
                $consumableSupplies->stock_on_hand = $consumableSupplies->stock_on_hand - $stock;
                $consumableSupplies->save();
            }

            $update = $this->model()->with(['purchaseOrderForm', 'purchaseOrderItem' => function ($query) { $query->with('ConsumableItem');}])->find($data->id);
            return  $update;

        }
    }

    public function deleteReceived($id)
    {

        $data = $this->model()->with(['purchaseOrderForm', 'purchaseOrderItem' => function ($query) { $query->with('ConsumableItem');}])->find($id);
        $consumableSupplies = ConsumableSupplies::where('project_id', $data->purchaseOrderForm->project_id)->where('item_name', $data->purchaseOrderItem->consumableItem->item)->first();
        $supply = $consumableSupplies->stock_on_hand - $data->received_quantity < 0 ? 0 : $consumableSupplies->stock_on_hand - $data->received_quantity;
        $consumableSupplies->stock_on_hand = $supply;
        if($consumableSupplies->save()) {
            if($data)  {
                $data->delete();
            }
        }


    }

    public function getDetails($id)
    {

        $received = $this->model()->select('purchase_order_form_id')
                        ->groupBy('purchase_order_form_id')
                        ->with(['purchaseOrderForm' => function ($query) {
                            $query->with('project');
                        }, 'purchaseOrderItem' => function ($query) {
                                $query->with('ConsumableItem');
                            }])
                        ->where('purchase_order_form_id', $id)
                        ->first();
        return $received;

    }

    public function getItems($id, $params)
    {
        if($params->search){

            $received = $this->model()->where(function ($query) use ($params) {
                $query->orWhereHas('purchaseOrderItem', function ($query2) use ($params) {
                    $query2->whereHas('consumableItem', function($query3) use ($params) {
                        $query3->where('item', 'LIKE', "%$params->search%");
                    });
                });
                $query->orWhere('date_received', 'LIKE', "%$params->search%");
            })->with([
                'purchaseOrderForm',
                'purchaseOrderItem' => function ($query) {
                        $query->with('ConsumableItem');
                }])->orderBy('id', 'desc')
                ->where('purchase_order_form_id', $id)
                ->paginate($params->count, ['*'], 'page', $params->page);

            return $received;

        }
        $received = $this->model()->with([
                        'purchaseOrderForm',
                        'purchaseOrderItem' => function ($query) {
                                $query->with('ConsumableItem');
                        }])->orderBy('id', 'desc')
                        ->where('purchase_order_form_id', $id)
                        ->paginate($params->count, ['*'], 'page', $params->page);

        return $received;

    }

    public function getItemReceivedQunatity($id)
    {

        // $receivedQuantity = $this->model()
        //     ->select('purchase_order_form_item_id', \DB::raw('sum(received_quantity) as received_quantity'))
        //     ->groupBy('purchase_order_form_item_id')
        //     ->where('purchase_order_form_item_id', $id)->first();
        $receivedQuantity = $this->model()
            ->select('purchase_order_form_item_id', \DB::raw('sum(received_quantity) as received_quantity'))
            ->groupBy('purchase_order_form_item_id')
            ->where('purchase_order_form_id', $id)->get();

        return $receivedQuantity;

    }

    public function getItemReceivedQunatityItem($id)
    {
        $receivedQuantity = $this->model()
            ->select('purchase_order_form_item_id', \DB::raw('sum(received_quantity) as received_quantity'))
            ->groupBy('purchase_order_form_item_id')
            ->where('purchase_order_form_item_id', $id)->first();
        return $receivedQuantity;
    }

    public function getTransactions($id)
    {

        $transactions = $this->model()->with(['purchaseOrderItem' => function ($query) {
                $query->with('consumableItem');
            }])
            ->select('purchase_order_form_item_id', \DB::raw('SUM(received_quantity) as received_quantity'))
            ->groupBy('purchase_order_form_item_id')
            ->where('purchase_order_form_id', $id)->get();

        return $transactions;

    }
}
