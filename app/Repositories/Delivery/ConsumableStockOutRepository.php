<?php
namespace App\Repositories\Delivery;

use App\Models\ConsumableSupplies;
use App\Models\Delivery\ConsumableSupplyStockOut;
use App\Repositories\Repository;

class ConsumableStockOutRepository extends Repository
{

    public function __construct(ConsumableSupplyStockOut $model)
    {

        parent::__construct($model);

    }

    public function getConsumableSupplies($params)
    {

        if($params->search) {

            $getStockOuts = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('remarks', 'LIKE', "%$params->search%");
                $query->orWhere('date_delivered', 'LIKE', "%$params->search%");
                $query->orWhere('actual_quantity_delivered', 'LIKE', "%$params->search%");
                $query->orWhereHas('consumableItem', function ($query2) use ($params) {
                    $query2->whereHas('consumableSupply', function ($query3) use ($params) {
                        $query3->where(function ($query4) use ($params) {
                            $query4->orWhere('item_name', 'LIKE', "%$params->search%");
                        });
                    });
                });
            })->with(['requestMaterial','consumableItem' => function ($query) {
                $query->with('consumableSupply');
                $query->with(['requestMaterial' => function ($query) {
                    $query->with('project');
                }]);
            }])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $getStockOuts;
        }

        $getStockOuts = $this->model()->with(['requestMaterial','consumableItem' => function ($query) {
            $query->with('consumableSupply');
            $query->with(['requestMaterial' => function ($query) {
                $query->with('project');
            }]);
        }])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $getStockOuts;
    }

    public function store($request)
    {
        $response = [];
        foreach ($request->consumable_items as $key => $item) {
            if(isset($item['actual_quantity_delivered'])) {
                $data = new $this->model();
                $data->request_materials_form_consumable_item_id = $item['id'];
                $data->actual_quantity_delivered = $item['actual_quantity_delivered'];
                $data->date_delivered = $request->date_delivered;
                $data->request_material_id = $request->request_material_code;
                $data->remarks = $request->remarks;

                if($data->save()) {

                    $consumableSupplies = ConsumableSupplies::find($item['consumable_supply']['id']);
                    $consumableSupplies->stock_on_hand = $consumableSupplies->stock_on_hand - $item['actual_quantity_delivered'];
                    $consumableSupplies->save();

                    $items = $this->model()->with(['requestMaterial','consumableItem' => function ($query) {
                                $query->with('consumableSupply');
                                $query->with(['requestMaterial' => function ($query) {
                                    $query->with('project');
                                }]);
                            }])->find($data->id);
                      array_push($response, $items);
                }
            }
        }

        return $response;

    }

    public function update($id, $request)
    {

        $requestConsumableSUpply = $request->request_materials_form_consumable_item_id_id ? $request->request_materials_form_consumable_item_id_id : $request->request_materials_form_consumable_item_id;

        $data = $this->model()->find($id);
        $previousStockOutQuantity = $data->actual_quantity_delivered;
        $this->updateConsumableStockOut($previousStockOutQuantity, $request);

        $data->request_materials_form_consumable_item_id = $requestConsumableSUpply;
        $data->actual_quantity_delivered = $request->actual_quantity_delivered;
        $data->date_delivered = $request->date_delivered;
        $data->remarks = $request->remarks;

        if($data->save()) {
            return $this->model()->with(['requestMaterial','consumableItem' => function ($query) {
                $query->with('consumableSupply');
                $query->with(['requestMaterial' => function ($query) {
                    $query->with('project');
                }]);
            }])->find($data->id);
        }

    }

    public function deleteStockOut($id, $params)
    {

        $data = $this->model()->find($id);
        if($data) {
            $this->updateConsumableStockOut(null, $params);
            $data->delete();

            return 'deleted';
        }

        return 'no';
    }

    public function isDelivered($id, $params)
    {

        $data = $this->model()->find($id);

        $data->is_delivered = $params->is_delivered;

        if($data->save()) {
            return 'Yes';
        }

    }

    private function updateConsumableStockOut($previousStockOutQuantity = null, $request)
    {

        if($previousStockOutQuantity) {
            if($previousStockOutQuantity > $request->actual_quantity_delivered) {
                $actual_delivered = $previousStockOutQuantity - $request->actual_quantity_delivered;
                $consumableSupplies = ConsumableSupplies::where('project_id', $request->project_id)->where('item_name', $request->request_materials_form_consumable_item_id)->first();
                $consumableSupplies->stock_on_hand = $consumableSupplies->stock_on_hand +  $actual_delivered;
                $consumableSupplies->save();
            }
            else {
                $actual_delivered = $request->actual_quantity_delivered - $previousStockOutQuantity ;
                $consumableSupplies = ConsumableSupplies::where('project_id', $request->project_id)->where('item_name', $request->request_materials_form_consumable_item_id)->first();
                $consumableSupplies->stock_on_hand = $consumableSupplies->stock_on_hand - $actual_delivered;
                $consumableSupplies->save();
            }
        }
        else {
            $consumableSupplies = ConsumableSupplies::where('project_id', $request->consumable_item->consumable_supply->project_id)->where('item_name', $request->consumable_item->consumable_supply->item_name)->first();
            $consumableSupplies->stock_on_hand = $consumableSupplies->stock_on_hand + $request->actual_quantity_delivered;
            $consumableSupplies->save();
        }
    }

}
