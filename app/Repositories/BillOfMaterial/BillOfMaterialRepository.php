<?php

namespace App\Repositories\BillOfMaterial;

use App\Models\Project\BillOfMaterial;
use App\Repositories\Repository;

class BillOfMaterialRepository extends Repository
{

    public function __construct(BillOfMaterial $model)
    {

        parent::__construct($model);

    }

    public function getBillOfMaterials()
    {
        $materials = $this->model()->with(['item', 'description'])->get();

        // $materials = collect($materials);

        // $materials = $materials->groupBy('bill_of_material_item_id');
        $result = $materials->groupBy(['skill', function ($item) {
            return $item['item']['name'];
        }], $preserveKeys = true);

        return $result;

    }

    public function storeMaterial($request)
    {

        $data = new $this->model();
        $data->project_id = $request->project_id;
        $data->bill_of_material_item_id = $request->bill_of_material_item_id;
        $data->bill_of_material_description_id = $request->bill_of_material_description_id;
        $data->unit = $request->unit;
        $data->quantity = $request->quantity;
        $data->unit_cost = $request->unit_cost;
        $data->amount = $request->amount;

        if($data->save()) {

            return $this->model()->with(['item', 'description'])->find($data->id);

        }

    }

    public function updateMaterial($id, $request)
    {

        $data = $this->model()->find($id);
        $data->bill_of_material_description_id = $request->bill_of_material_description_id;
        $data->unit = $request->unit;
        $data->quantity = $request->quantity;
        $data->unit_cost = $request->unit_cost;
        $data->amount = $request->amount;
        if($data->save()) {
            return $this->model()->with(['item', 'description'])->find($id);
        }

    }

    public function deleteMaterial($id)
    {

        $data = $this->model()->find($id);
        if(!empty($data)) {
            $data->delete();
            return 'Deleted Successfully';
        }

        return '';

    }

    public function updateBillOfMaterialProject($id, $request)
    {

        $data = $this->model()->find($id);
        $data->unit = $request->unit;
        $data->quantity = $request->quantity;
        $data->unit_cost = $request->unit_cost;
        $data->amount = $request->amount;
        $data->save();

    }

}
