<?php

namespace App\Repositories\LocationHistory;

use App\Models\Inventory\LocationHistory;
use App\Repositories\Repository;

class FixedAssetLocationHistoryRepository extends Repository
{


    public function __construct(LocationHistory $model)
    {

        parent::__construct($model);

    }


    public function store($request)
    {
        $isExist = $this->model()
                    ->where('fixed_asset_id', $request->fixed_asset_id)
                    ->where('project_id', $request->project_id)
                    ->where('status', $request->status)
                    ->where('date', $request->date)
                    ->first();
        if(!$isExist) {
            $data = new $this->model();
            $data->fixed_asset_id = $request->fixed_asset_id;
            $data->project_id = $request->project_id;
            $data->project_name = $request->project_name;
            $data->location = $request->location;
            $data->status = $request->status.' from '.$request->delivered_from;
            $data->date = $request->date;
            if($data->save()) {
                return $data;
            }
        }
    }

    public function storeFromUpdate($request)
    {

        $isExist = $this->model()
                    ->where('fixed_asset_id', $request->fixed_asset_id)
                    ->where('project_name', $request->project_name)
                    ->where('status', $request->status)
                    ->where('date', $request->date)
                    ->first();
        if(!$isExist) {
            $data = new $this->model();
            $data->fixed_asset_id = $request->fixed_asset_id;
            $data->project_name = $request->project_name;
            $data->location = $request->location;
            $data->status = $request->status;
            $data->date = $request->date;
            if($data->save()) {
                return $data;
            }
        }

    }

}
