<?php

namespace App\Repositories\HeavyEquipment;

use App\Models\Inventory\EquipmentDocument;
use App\Models\Inventory\FixedAsset;
use App\Models\Inventory\HeavyEquipment;
use App\Models\Inventory\LocationHistory;
use App\Models\Project\ProjectFixedAsset;
use App\Repositories\Repository;
use Carbon\Carbon;

class HeavyEquipmentRepository extends Repository
{

    public function __construct(HeavyEquipment $model)
    {
        parent::__construct($model);
    }

    public function getEquipments($params)
    {
        if ($params->search) {
            $equipments = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('control_number', 'LIKE', "%$params->search%");
                $query->orWhere('model', 'LIKE', "%$params->search%");
                $query->orWhere('brand_name', 'LIKE', "%$params->search%");
                $query->orWhere('serial_number', 'LIKE', "%$params->search%");
                $query->orWhere('reference_number', 'LIKE', "%$params->search%");
                $query->orWhere('date_acquired', 'LIKE', "%$params->search%");
            })->with(['category', 'fixedAssets' => function($query) { $query->with('location');}])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $equipments;
        }

        $equipments = $this->model()->with(['category', 'fixedAssets' => function($query) { $query->with('location');}])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $equipments;
    }

    public function storeEquipment($request)
    {
        $data = new $this->model();
        $data->control_number = $request->control_number;
        $data->asset_category_id = $request->asset_category_id;
        $data->brand_name = $request->brand_name;
        $data->model = $request->model;
        $data->engine_model = $request->engine_model;
        $data->engine_number = $request->engine_number;
        $data->serial_number = $request->serial_number;
        $data->reference_number = $request->reference_number;
        $data->capacity = $request->capacity;
        $data->description = $request->description;
        $data->date_acquired = $request->date_acquired;
        $data->cost = $request->cost;
        $data->status = $request->status;
        $data->assigned_to = $request->assigned_to;

        if($request->hasFile('photo')) {

            $folder = "/heavy_equipments/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->photo = $name;

            if($data->save()) {
                $inserted_id = $data->id;

                if($inserted_id){

                    $data = new FixedAsset();
                    $data->assetable_type = 'App\Models\Inventory\HeavyEquipment';
                    $data->assetable_id = $inserted_id;
                    $data->status = 'new';
                    $data->description = $request->description;
                    $data->date = Carbon::today();
                    $data->type = 'Heavy Equipment';
                    $data->save();
                }

                $equipment = $this->model()->with(['category', 'fixedAssets' => function($query) { $query->with('location');}])->find($inserted_id);

                return $equipment;
            }

        }

        if($data->save()) {
            $inserted_id = $data->id;

            if($inserted_id){

                $data = new FixedAsset();
                $data->assetable_type = 'App\Models\Inventory\HeavyEquipment';
                $data->assetable_id = $inserted_id;
                $data->status = 'new';
                $data->description = $request->description;
                $data->date = Carbon::today();
                $data->type = 'Heavy Equipment';
                $data->save();
            }

            $equipment = $this->model()->with(['category', 'fixedAssets' => function($query) { $query->with('location');}])->find($inserted_id);

            return $equipment;
        }

    }

    public function updateEquipment($id, $request) {

        $data = $this->model()->find($id);
        $data->control_number = $request->control_number;
        $data->asset_category_id = $request->asset_category_id;
        $data->brand_name = $request->brand_name;
        $data->model = $request->model;
        $data->engine_model = $request->engine_model;
        $data->engine_number = $request->engine_number;
        $data->serial_number = $request->serial_number;
        $data->reference_number = $request->reference_number;
        $data->capacity = $request->capacity;
        $data->description = $request->description;
        $data->date_acquired = $request->date_acquired;
        $data->cost = $request->cost;
        $data->status = $request->status;
        $data->assigned_to = $request->assigned_to;

        if($request->hasFile('photo')) {

            \Storage::disk('public')->delete('/heavy_equipments/photo/'. $data->photo);

            $folder = "/heavy_equipments/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->photo = $name;
            if($data->save()) {
                $equipment = $this->model()->with(['category', 'fixedAssets' => function($query) { $query->with('location');}])->find($id);
                return $equipment;
            }
        }
        else {
            if($data->save()) {
                $equipment = $this->model()->with(['category', 'fixedAssets' => function($query) { $query->with('location');}])->find($id);
                return $equipment;
            }
        }
    }

    public function getEquipmentInfo($id)
    {
        $equipment = $this->model()->with(['category', 'fixedAssets' => function($query) { $query->with('location');}])->find($id);

        return $equipment;
    }

    public function storeEquipmentDocument($id, $request)
    {

        if($request->hasFile('attached_file')) {
            $folder = "/heavy_equipments/documents";
            $media = $request->file('attached_file');
            $name =  $id . "_" . time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $document = new EquipmentDocument();
            $document->file_type = $request->file_type;
            $document->attached_file = $name;
            $document->file_name = $request->file_name;
            $document->equipment_id = $id;

            if($document->save()) {
                return $document;
            }
        }

    }

    public function getEquipmentDocuments($id, $params) {

        if($params->search) {
            $documents = EquipmentDocument::where(function ($query) use ($params) {
                $query->orWhere('attached_file', 'LIKE', "%$params->search%");
                $query->orWhere('file_type', 'LIKE', "%$params->search%");
                $query->orWhere('file_name', 'LIKE', "%$params->search%");
            })->where('equipment_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $documents;
        }

        $documents = EquipmentDocument::where('equipment_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $documents;
    }

    public function updateDocument($id, $request)
    {
        $data = EquipmentDocument::find($id);

        $data->file_type = $request->file_type;

        if($request->hasFile('attached_file')) {
            \Storage::disk('public')->delete('/heavy_equipments/documents/'. $data->attached_file);
            $folder = "/heavy_equipments/documents";
            $media = $request->file('attached_file');
            $name = $id . '_' . time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');


            $data->attached_file = $name;
            $data->file_name = $request->file_name;

            if($data->save()) {
                return $data;
            }
        }

        if($data->save()) {
            return $data;
        }

        return 'error';
    }

    public function deleteDocument($id) {

        $data = EquipmentDocument::find($id);
        \Storage::disk('public')->delete('/heavy_equipments/documents/'. $data->attached_file);
        $data->delete();

        return 'successfully deleted';
    }

    public function deleteEquipment($id)
    {

        $data = $this->model()->find($id);

        $fixedAssets = FixedAsset::where('assetable_type', 'App\Models\Inventory\HeavyEquipment')->where('assetable_id', $data->id)->first();
        if($fixedAssets) {
            $fixedAssets->delete();
        }

        $file = EquipmentDocument::where('equipment_id', $data->id)->first();
        if($file) {
            \Storage::disk('public')->delete('/heavy_equipments/documents/'. $file->attached_file);
            $file->delete();
        }
        \Storage::disk('public')->delete('/heavy_equipments/photo/'. $data->photo);
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
                $query->where('assetable_type', 'App\Models\Inventory\HeavyEquipment');
                $query->where('assetable_id', $id);
            });
        })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $history;
    }

    public function returnToWarehouse($request)
    {

        $checkAssetLastLocation = LocationHistory::where('fixed_asset_id', $request->fixed_asset_id)->orderBy('id', 'desc')->first();

        $project_name = null;
        if(!empty($checkAssetLastLocation)) {
            $projectFixedAsset = ProjectFixedAsset::where('project_id', $checkAssetLastLocation->project_id)->where('fixed_asset_id', $request->fixed_asset_id)->first();
            $projectFixedAsset->date_released = $request->date;
            $projectFixedAsset->save();
        }

        $data = new LocationHistory();
        $data->fixed_asset_id = $request->fixed_asset_id;
        $data->project_name = $request->project_name;
        $data->location = $request->location;
        $data->date = $request->date;
        $data->status = $request->status;
        if($data->save()) {
            return $data;
        }
    }

}
