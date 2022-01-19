<?php

namespace App\Repositories\TruckVehicle;

use App\Models\Inventory\FixedAsset;
use App\Models\Inventory\LocationHistory;
use App\Models\Inventory\TruckVehicleDocument;
use App\Models\Inventory\VehicleAsset;
use App\Repositories\Repository;
use Carbon\Carbon;

class TruckVehicleRepository extends Repository
{
    public function __construct(VehicleAsset $model)
    {
        parent::__construct($model);
    }

    public function getTrucksVehicles($params) {

        if($params->search) {
            $truckVehicles = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('brand_name', 'LIKE', "%$params->search%");
                $query->orWhere('plate_number', 'LIKE', "%$params->search%");
                $query->orWhere('body_type', 'LIKE', "%$params->search%");
                $query->orWhere('date_acquired', 'LIKE', "%$params->search%");
                $query->orWhere('assigned_to', 'LIKE', "%$params->search%");
                $query->orWhere('cost', 'LIKE', "%$params->search%");
                $query->orWhere('photo', 'LIKE', "%$params->search%");
            })->with(['fixedAssets' => function($query) { $query->with('location');}])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $truckVehicles;
        }

        $truckVehicles = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $truckVehicles;

    }

    public function storeTruckVehicle($request) {

        $data = new $this->model();
        $data->brand_name = $request->brand_name;
        $data->asset_category_id = $request->asset_category_id;
        $data->plate_number = $request->plate_number;
        $data->body_type = $request->body_type;
        $data->date_acquired = $request->date_acquired;
        $data->cost = $request->cost;
        $data->assigned_to = $request->assigned_to;
        $data->status = $request->status;

        if($request->hasFile('photo')) {

            $folder = "/truck_vehicle/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');
            $data->photo = $name;

            if($data->save()) {

                $inserted_id = $data->id;

                if($inserted_id){

                    $data = new FixedAsset();
                    $data->assetable_type = 'App\Models\Inventory\VehicleAsset';
                    $data->assetable_id = $inserted_id;
                    $data->status = 'new';
                    $data->description = $request->description;
                    $data->date = Carbon::today();
                    $data->type = 'Truck / Vehicle';
                    $data->save();

                    $truckVehicle = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($inserted_id);

                    return $truckVehicle;

                }
            }

        }
        if($data->save()) {
            $inserted_id = $data->id;

            if($inserted_id){

                $data = new FixedAsset();
                $data->assetable_type = 'App\Models\Inventory\VehicleAsset';
                $data->assetable_id = $inserted_id;
                $data->status = 'new';
                $data->description = $request->description;
                $data->date = Carbon::today();
                $data->type = 'Truck / Vehicle';
                $data->save();

                $truckVehicle = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($inserted_id);

                return $truckVehicle;

            }
        }
    }

    public function updateTruckVehicle($id, $request)
    {
        $data = $this->model()->find($request->id);
        $data->brand_name = $request->brand_name;
        $data->asset_category_id = $request->asset_category_id;
        $data->plate_number = $request->plate_number;
        $data->body_type = $request->body_type;
        $data->date_acquired = $request->date_acquired;
        $data->cost = $request->cost;
        $data->assigned_to = $request->assigned_to;
        $data->status = $request->status;

        if($request->hasFile('photo')) {
            $folder = "/truck_vehicle/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->photo = $name;

            if($data->save()) {
                $editedInfo = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($request->id);
                return $editedInfo;
            }
        }

        if($data->save()) {
            $editedInfo = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($request->id);
            return $editedInfo;
        }
    }

    public function getTruckVehicleInfo($id)
    {
        $info = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($id);

        return $info;
    }

    public function deleteTruckVehicle($id)
    {

        $data = $this->model()->find($id);

        $fixedAssets = FixedAsset::where('assetable_type', 'App\Models\Inventory\VehicleAsset')->where('assetable_id', $data->id)->first();
        if($fixedAssets) {
            $fixedAssets->delete();
        }

        $file = TruckVehicleDocument::where('truck_vehicle_id', $data->id)->first();
        if($file) {
            \Storage::disk('public')->delete('/truck_vehicle/documents/'. $file->attached_file);
        }

        \Storage::disk('public')->delete('/truck_vehicle/photo/'. $data->photo);

        $data->delete();

        return 'Successfully Deleted';

    }

    public function getLocationHistory($id, $params)
    {

        if($params->search) {
            $history = LocationHistory::where(function ($query) use ($id) {
                $query->whereHas('fixedAsset', function ($query) use ($id) {
                    $query->where('assetable_type', 'App\Models\Inventory\OtherAsset');
                    $query->where('assetable_id', $id);
                    $query->with('location');
                });
            })->where(function($query) use ($params) {
                $query->orWhere('project_name', 'LIKE', "%$params->search%");
                $query->orWhere('location', 'LIKE', "%$params->search%");
                $query->orWhereHas('project', function ($query2) use ($params) {
                    $query2->where('name', 'LIKE', "%$params->search%");
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $history;
        }

        $history = LocationHistory::where(function ($query) use ($id) {
            $query->whereHas('fixedAsset', function ($query) use ($id) {
                $query->where('assetable_type', 'App\Models\Inventory\VehicleAsset');
                $query->where('assetable_id', $id);
            });
        })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $history;

    }
}
