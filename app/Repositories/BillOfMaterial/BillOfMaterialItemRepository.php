<?php

namespace App\Repositories\BillOfMaterial;

use App\Models\Project\BillOfMaterialItem;
use App\Repositories\Repository;

class BillOfMaterialItemRepository extends Repository
{

    public function __construct(BillOfMaterialItem $model)
    {

        parent::__construct($model);

    }

    public function getBillOfMaterials($id) {

        // $materials = $this->model()->with(['billOfMaterials' => function ($query) {
        //     $query->with(['description']);
        // }])->whereHas('billOfMaterials')->where(function($query) use ($id) {
        //     $query->whereHas('billOfMaterials', function ($query2) use ($id) {
        //         return $query2->where('project_id', $id);
        //     });
        // })->get();
        $materials = $this->model()->with(['billOfMaterials' => function ($query) use ($id) {
                $query->with(['description'])->where('project_id', $id);
            }])->whereHas('billOfMaterials', function($query) use ($id) {
                $query->where('project_id', $id);
            })->get();

        return $materials;

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
        $data->description = $request->description;
        if($data->save()) {
            return $data;
        }

    }

    public function updateMaterial($id, $request)
    {

        $data = $this->model()->find($id);
        $data->name = $request->name;
        $data->description = $request->description;
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

    public function getItemsData()
    {

        $data = $this->model()->get();

        return $data;

    }

}
