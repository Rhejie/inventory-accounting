<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Unit;
use App\Repositories\Repository;

class UnitRepository extends Repository
{

    public function __construct(Unit $model)
    {

        parent::__construct($model);

    }

    public function getUnits($params)
    {

        $units = $this->model();

        if($params->search) {

            $units = $units->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $units;

        }

        $units = $units->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $units;

    }

    public function storeUnit($request)
    {

        $data = new $this->model();
        $data->name = $request->name;
        if($data->save()) {
            return $data;
        }

    }

    public function updateUnit($id, $request)
    {

        $data = $this->model()->find($id);
        $data->name = $request->name;
        if($data->save()) {
            return $data;
        }

    }

    public function deleteUnit($id)
    {

        $data = $this->model()->find($id);
        $data->delete();

    }

    public function selectUnit($params)
    {

        if($params->search) {

            $taxes = $this->model()->where('name', 'LIKE', "%$params->search%")->limit(20)->get();

            return $taxes;

        }

    }
}
