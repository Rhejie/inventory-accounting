<?php

namespace App\Repositories\SupplierManagement;

use App\Models\Supplier\ConsumableItem;
use App\Repositories\Repository;

class ConsumableItemRepository extends Repository
{

    public function __construct(ConsumableItem $model)
    {
        parent::__construct($model);
    }

    public function getItems($id, $params)
    {
        if($params->search) {
            $items = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('item', 'LIKE', "%$params->search%");
                $query->orWhere('unit_price', 'LIKE', "%$params->search%");
            })->where('supplier_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $items;
        }

        $items = $this->model()->where('supplier_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $items;
    }

    public function storeItem($id, $request)
    {
        $data = new $this->model();
        $data->supplier_id = $id;
        $data->item = $request->item;
        $data->unit = $request->unit;
        $data->unit_price = $request->unit_price;

        if($data->save()) {
            return $data;
        }
    }

    public function updateItem($id, $request)
    {

        $data = $this->model()->find($id);
        $data->item = $request->item;
        $data->unit = $request->unit;
        $data->unit_price = $request->unit_price;

        if($data->save()) {
            return $data;
        }

    }

    public function deleteItem($id)
    {

        $data = $this->model()->find($id);
        $data->delete();

        return 'successfully deleted';

    }

    public function getConsumableItems($params)
    {
        if($params->search) {
            $items = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('item', 'LIKE', "%$params->search%");
                $query->orWhere('unit_price', 'LIKE', "%$params->search%");
                $query->orWhereHas('suppliers', function ($query2) use ($params){
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('name', 'LIKE', "%$params->search%");
                        $query3->orWhere('delivery_time', 'LIKE', "%$params->search%");
                    });
                });
            })->has('suppliers')->with('suppliers')->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $items;
        }

        $items = $this->model()->has('suppliers')->with('suppliers')->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $items;
    }

    public function getSupplierItems($id, $params)
    {

        if($params->search)  {

            $items = $this->model->where(function ($query) use ($params) {
                $query->orWhere('item', 'LIKE', "%$params->search%");
            })->where('supplier_id', $id)->limit(10)->get();

            return $items;
        }

    }

    public function checkItem($request)
    {
        $newItem = [];

        $consumbaleItem = $request->consumable_items ;
        dd($consumbaleItem);
        foreach ($consumbaleItem as $key => $value) {
            $data = $this->model()->where('supplier_id', $request->supplier_id)->where('item', $value->consumable_supply['item_name'])->first();
            if(!empty($data)) {
                $new = [
                    'isNew' => false,
                    'consumable_item' => ['item' => $data->item],
                    'quantity' => $value->quantity,
                    'unit_price' => $data->unit_price,
                    'unit' => $data->unit
                ];

                array_push($newItem, $new);
            }

            $new = [
                'isNew' => true,
                'consumable_item' => ['item' => $value['consumable_item']['item']],
                'quantity' => $value->quantity,
                'unit_price' => '',
                'unit' => $value->unit
            ];
        }

        return $newItem;

    }

}
