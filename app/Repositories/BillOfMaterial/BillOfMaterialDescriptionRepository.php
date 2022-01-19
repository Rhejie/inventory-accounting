<?php

namespace App\Repositories\BillOfMaterial;

use App\Models\Project\BillOfMaterialDescription;
use App\Repositories\Repository;

class BillOfMaterialDescriptionRepository extends Repository
{

    public function __construct(BillOfMaterialDescription $model)
    {

        parent::__construct($model);

    }

    public function getMaterials($params)
    {

        if($params->search) {

            $materials =  $this->model()->where('name', 'LIKE', "%$params->search%")->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $materials;
        }

        $materials = $this->model()->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $materials;
    }

    public function storeMaterial($request)
    {

        $data = new $this->model();
        $data->name = $request->name;
        if($data->save()) {
            return $data;
        }

    }

    public function updateMaterial($id, $request)
    {

        $data = $this->model()->find($id);
        $data->name = $request->name;
        if($data->save()) {
            return $data;
        }

    }

    public function deleteMaterial($id)
    {

        $data = $this->model()->find($id);
        if($data) {
            $data->delete();
        }

    }

    public function getDescriptionsData($search)
    {

        if($search) {
            $data = $this->model()->where('name', 'LIKE', "%$search%")->limit(20)->get();
            return $data;
        }

    }
}
