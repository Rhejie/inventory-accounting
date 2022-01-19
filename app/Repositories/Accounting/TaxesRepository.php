<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Taxes;
use App\Repositories\Repository;

class TaxesRepository extends Repository
{

    public function __construct(Taxes $model)
    {

        parent::__construct($model);

    }

    public function getTaxes($params)
    {

        $taxes = $this->model();

        if($params->search) {

            $taxes = $taxes->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
                $query->orWhere('rate', 'LIKE', "%$params->search%");
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $taxes;

        }

        $taxes = $taxes->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $taxes;

    }

    public function storeTax($request)
    {

        $data = new $this->model();
        $data->name = $request->name;
        $data->rate = $request->rate;
        if($data->save()) {
            return $data;
        }

    }

    public function updateTax($id, $request)
    {

        $data = $this->model()->find($id);
        $data->name = $request->name;
        $data->rate = $request->rate;
        if($data->save()) {
            return $data;
        }

    }

    public function deleteTax($id)
    {

        $data = $this->model()->find($id);
        $data->delete();

    }

    public function selectTax($params)
    {

        if($params->search) {

            $taxes = $this->model()->where('name', 'LIKE', "%$params->search%")->limit(20)->get();

            return $taxes;

        }

    }
}
