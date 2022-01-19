<?php

namespace App\Repositories\Project;

use App\Models\Inventory\LocationHistory;
use App\Models\Project;
use App\Models\Project\ProjectFixedAsset;
use App\Repositories\LocationHistory\FixedAssetLocationHistoryRepository;
use App\Repositories\Repository;

class ProjectFixedAssetRepository extends Repository {

    private $fixedAssetLocationHistoryRepository;

    public function __construct(ProjectFixedAsset $model, FixedAssetLocationHistoryRepository $fixedAssetLocationHistoryRepository) {

        $this->fixedAssetLocationHistoryRepository = $fixedAssetLocationHistoryRepository;
        parent::__construct($model);

    }

    public function store($request) {

        $isExist = $this->model()
                        ->where('fixed_asset_id', $request->fixed_asset_id)
                        ->where('project_id', $request->project_id)
                        ->where('date_delivered', $request->date_delivered)
                        ->first();
        if(!$isExist) {
            $data = new $this->model();
            $data->project_id = $request->project_id;
            $data->fixed_asset_id = $request->fixed_asset_id;
            $data->date_delivered = $request->date_delivered;
            $data->remarks = $request->remarks;
            if($data->save()) {
                $checkAssetLastLocation = LocationHistory::where('fixed_asset_id', $request->fixed_asset_id)->orderBy('id', 'desc')->first();

                $project_name = null;
                if(!empty($checkAssetLastLocation) && $checkAssetLastLocation->project_name == 'Warehouse') {
                    $project_name = "Warehouse";
                } else {
                    $project_name = $request->delivered_from;
                }
                $params = [
                    'project_name' => $request->project_name,
                    'project_id' => $request->project_id,
                    'location' => $request->location,
                    'fixed_asset_id' => $data->fixed_asset_id,
                    'delivered_from' => $project_name,
                    'status' => 'Delivered',
                    'date' => $data->date_delivered,
                ];

                $this->fixedAssetLocationHistoryRepository->store(json_decode(json_encode($params)));

                return $data;

            }

        }
    }

    public function updateFixedAssetRelease($request)
    {
        $checkAsset = $this->model()->where('fixed_asset_id', $request->fixed_asset_id)->first();
        if($checkAsset) {
            $checkAsset->date_released = $request->date_delivered;
            if($checkAsset->save()) {
                $project = Project::find($checkAsset->project_id);
                $checkAssetLastLocation = LocationHistory::where('fixed_asset_id', $request->fixed_asset_id)->orderBy('id', 'desc')->first();

                $project_name = null;
                if(!empty($checkAssetLastLocation) && $checkAssetLastLocation->project_name == 'Warehouse') {
                    $project_name = "Warehouse";
                    $project_location = 'Warehouse';
                } else {
                    $project_name = $project->name;
                    $project_location = $project->location;
                }
                $params = [
                    'project_name' => $project_name,
                    'location' => $project_location,
                    'fixed_asset_id' => $request->fixed_asset_id,
                    'status' => 'Released To '.$request->released_to,
                    'date' => $request->date_delivered,
                ];

                $this->fixedAssetLocationHistoryRepository->storeFromUpdate(json_decode(json_encode($params)));
                return $checkAsset;
            }
        }

        return;
    }

    public function getFixedAssets($id, $params)
    {

        $fixedAssets = $this->model()->with(['fixedAsset' => function ($query) {
            $query->with('assetable');
        }])->where('project_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $fixedAssets;

    }

    public function deleteFixedAsset($request)
    {

        $fixedAsset = $this->model()->where('fixed_asset_id', $request->fixed_asset_id)->where('project_id', $request->project_id)->first();
        if($fixedAsset) {
            $fixedAsset->delete();
            return 'deleted';
        }

    }

}
