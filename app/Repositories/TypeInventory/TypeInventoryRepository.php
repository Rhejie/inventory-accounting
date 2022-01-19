<?php

namespace App\Repositories\TypeInventory;

use App\Models\Inventory\AssetType;
use App\Repositories\Repository;

class TypeInventoryRepository extends Repository
{

    public function __construct(AssetType $model)
    {
        parent::__construct($model);
    }

    public function getTypes($params)
    {
        if($params->search) {
            $types = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
                $query->orWhere('resource_type', 'LIKE', "%$params->search%");
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $types;
        }

        $types = $this->model()->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $types;
    }

    public function storeType($request)
    {
        $data = new $this->model();
        $data->name = $request->name;
        $data->resource_type = $request->resource_type;

        if($data->save()){
            $type = $this->model()->find($data->id);
            return $type;
        }
    }

    public function updateType($id, $request)
    {
        $data = $this->model()->find($id);
        $data->name = $request->name;
        $data->resource_type = $request->resource_type;

        if($data->save()){
            $type = $this->model()->find($id);
            return $type;
        }
    }

    public function deleteType($id)
    {
        $data = $this->model()->find($id);
        $data->delete();

        return 'Successfully Deleted';
    }

    public function getTypesForSelect()
    {

        $types = $this->model()->get();

        return $types;

    }

}
