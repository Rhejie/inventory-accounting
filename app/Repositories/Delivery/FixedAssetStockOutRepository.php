<?php

namespace App\Repositories\Delivery;

use App\Models\Delivery\FixedAssetStockOut;
use App\Models\Inventory\LocationHistory;
use App\Repositories\Project\ProjectFixedAssetRepository;
use App\Repositories\Repository;

class FixedAssetStockOutRepository extends Repository
{

    private $projectFixedAssetRepository;

    public function __construct(FixedAssetStockOut $model, ProjectFixedAssetRepository $projectFixedAssetRepository)
    {
        $this->projectFixedAssetRepository = $projectFixedAssetRepository;
        parent::__construct($model);

    }

    public function getFixedAssets($params) {

        if($params->search) {

            $fixedAssets = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('date_delivered', 'LIKE', "%$params->search%");
                $query->orWhere('remarks', 'LIKE', "%$params->search%");
                $query->orWhereHas('requestMaterialsFixedAsset', function ($query2) use ($params) {
                    $query2->whereHas('fixedAsset', function ($query3) use ($params) {
                        $query3->whereHas('assetable', function ($query4) use ($params) {
                            $query4->where(function ($query5) use ($params) {
                                $query5->where('brand_name', 'LIKE', "%$params->search%");
                            });
                        });
                    });
                });
            })->with(['requestMaterialsFixedAsset' => function ($query) {
                $query->with(['fixedAsset' => function ($query){
                    $query->with('assetable');
                    $query->with('location');
                }]);
                $query->with(['requestMaterial' => function ($query) {
                    $query->with('project');
                }]);
            }])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $fixedAssets;

        }

        $fixedAssets = $this->model()->with(['requestMaterialsFixedAsset' => function ($query) {
            $query->with(['fixedAsset' => function ($query){
                $query->with('assetable');
                $query->with('location');
            }]);
            $query->with(['requestMaterial' => function ($query) {
                $query->with('project');
            }]);
        }])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $fixedAssets;
    }

    public function store($request)
    {

        $data = new $this->model();
        $data->request_materials_form_fixed_asset_items_id = $request->request_materials_form_fixed_asset_items_id;
        $data->date_delivered = $request->date_delivered;
        $data->request_material_id = $request->request_material_id;
        $data->remarks = $request->remarks;

        if($data->save()) {

            $fixedAsset = $this->model()->with(['requestMaterialsFixedAsset' => function ($query) {
                $query->with(['fixedAsset' => function ($query){
                    $query->with('assetable');
                    $query->with('location');
                }]);
                $query->with(['requestMaterial' => function ($query) {
                    $query->with('project');
                }]);
            }])->find($data->id);



            $request_project_fixed_asset = [
                'released_to' => $fixedAsset->requestMaterialsFixedAsset->requestMaterial->project->name,
                'project_id' => $request->request_form_from_project_id,
                'fixed_asset_id' => $request->fixed_asset_id,
                'delivered_from' => $request->delivered_from,
                'asset_id' => $request->asset_id,
                'date_delivered' => $request->date_delivered,
            ];

            $this->projectFixedAssetRepository->updateFixedAssetRelease(json_decode(json_encode($request_project_fixed_asset)));

            return $fixedAsset;
        }

    }

    public function update($id, $request)
    {

        $request_material_from_fixed_asset_item_id = $request->request_materials_form_fixed_asset_items_id_id ? $request->request_materials_form_fixed_asset_items_id_id : $request->request_materials_form_fixed_asset_items_id;

        $data = $this->model()->find($id);
        $data->request_materials_form_fixed_asset_items_id = $request_material_from_fixed_asset_item_id;
        $data->date_delivered = $request->date_delivered;
        $data->remarks = $request->remarks;

        if($data->save()) {
            return $this->model()->with(['requestMaterialsFixedAsset' => function ($query) {
                $query->with(['fixedAsset' => function ($query){
                    $query->with('assetable');
                    $query->with('location');
                }]);
                $query->with(['requestMaterial' => function ($query) {
                    $query->with('project');
                }]);
            }])->find($data->id);
        }

    }

    public function isDelivered($id, $params)
    {

        $data = $this->model()->find($id);

        $data->is_delivered = $params->is_delivered;

        if($data->save()) {
            return 'Yes';
        }

    }

    public function delete($id)
    {

        $delete = $this->model()->find($id);

        if($delete) {
            $delete->delete();

            return 'deleted';
        }

    }
}
