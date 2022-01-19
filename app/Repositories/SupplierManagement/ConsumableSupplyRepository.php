<?php

namespace App\Repositories\SupplierManagement;

use App\Models\ConsumableSupplies;
use App\Repositories\Repository;

class ConsumableSupplyRepository extends Repository
{

    public function __construct(ConsumableSupplies $model)
    {
        parent::__construct($model);
    }

    public function getSupplies($params)
    {
        if($params->search) {
            $supplies = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('item_code', 'LIKE', "%$params->search%");
                $query->orWhere('item_name', 'LIKE', "%$params->search%");
                $query->orWhere('bar_code', 'LIKE', "%$params->search%");
                $query->orWhere('lot_number', 'LIKE', "%$params->search%");
                $query->orWhere('description', 'LIKE', "%$params->search%");
                $query->orWhere('unit_of_measure', 'LIKE', "%$params->search%");
                $query->orWhere('quantity', 'LIKE', "%$params->search%");
                $query->orWhere('stock_on_hand', 'LIKE', "%$params->search%");
                $query->orWhere('reorder_point', 'LIKE', "%$params->search%");
                $query->orWhereHas('project', function ($query2) use ($params) {
                    $query2->where(function ($query3) use ($params)  {
                        $query3->orWhere('name', 'LIKE', "%$params->search%");
                    });
                });
            })->with('project')->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $supplies;
        }

        $supplies = $this->model()->with('project')->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $supplies;
    }

    public function storeSupply($request)
    {
        if(isset($request->status)) {
            $data = $this->model()->where('project_id', $request->project_id)->where('item_name', $request->item_name)->first();
            if(!empty($data)) {
                $updateData = $this->model()->find($data->id);
                $updateData->stock_on_hand = $updateData->stock_on_hand + $request->stock_on_hand;
                if($updateData->save()) {
                    return;
                }
            }
        }

        $data = new $this->model();
        $data->project_id = $request->project_id;
        $data->item_code = $request->item_code;
        $data->item_name = $request->item_name;
        $data->bar_code = $request->bar_code;
        $data->lot_number = $request->lot_number;
        $data->description = $request->description;
        $data->unit_of_measure = $request->unit_of_measure;
        $data->stock_on_hand = $request->stock_on_hand;
        $data->reorder_point = $request->reorder_point;

        if($data->save()) {
            return $this->model()->with('project')->find($data->id);
        }
    }

    public function updateSupply($id, $request)
    {
        $projectID = $request->project_id_id ? $request->project_id_id : $request->project_id;
        $data = $this->model()->find($id);
        $data->project_id = $projectID;
        $data->item_code = $request->item_code;
        $data->item_name = $request->item_name;
        $data->bar_code = $request->bar_code;
        $data->lot_number = $request->lot_number;
        $data->description = $request->description;
        $data->unit_of_measure = $request->unit_of_measure;
        $data->quantity = $request->quantity;
        $data->stock_on_hand = $request->stock_on_hand;
        $data->reorder_point = $request->reorder_point;

        if($data->save()) {
            return $this->model()->with('project')->find($id);
        }

    }

    public function deleteSupply($id)
    {

        $data = $this->model()->find($id);

        $data->delete();

        return 'Successfully Deleted';

    }

}
