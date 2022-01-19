<?php

namespace App\Repositories\Maintenance;

use App\Models\Maintenance\MaintenanceType;
use App\Repositories\Repository;

class MaintenanceTypeRepository extends Repository
{

    public function __construct(MaintenanceType $model)
    {

        parent::__construct($model);

    }

    public function getTypes($params)
    {

        if($params->search) {

            $data = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('type', 'LIKE', "%$params->search%");
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $data;
        }

        return $this->model()->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

    }

    public function storeType($request)
    {

        $data = new $this->model();
        $data->type = $request->type;
        if($data->save()) {
            return $data;
        }

    }

    public function updateType($id, $request)
    {
        $data = $this->model()->find($id);
        $data->type = $request->type;
        if($data->save()) {
            return $data;
        }
    }

    public function deleteType($id)
    {

        $data = $this->model()->find($id);
        if($data) {
            $data->delete();
        }

    }

    public function getTypesData()
    {

        return $this->model()->get();

    }
}
