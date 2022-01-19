<?php

namespace App\Repositories\OtherInventory;

use App\Models\Inventory\FixedAsset;
use App\Models\Inventory\LocationHistory;
use App\Models\Inventory\OtherAsset;
use App\Models\Inventory\OtherAssetDocument;
use App\Repositories\Repository;
use Carbon\Carbon;

class OtherInventoryRepository extends Repository
{
    public function __construct(OtherAsset $model)
    {
        parent::__construct($model);
    }

    public function getOtherInventory($params)
    {

        if($params->search) {
            $others = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('brand_name', 'LIKE', "%$params->search%");
                $query->orWhere('description', 'LIKE', "%$params->search%");
                $query->orWhere('cost', 'LIKE', "%$params->search%");
                $query->orWhere('date_acquired', 'LIKE', "%$params->search%");
                $query->orWhere('photo', 'LIKE', "%$params->search%");
            })->with(['fixedAssets' => function($query) { $query->with('location');}])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $others;
        }

        $others = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $others;

    }

    public function getInfo($id) {

        $info = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($id);

        return $info;
    }

    public function store($request)
    {

        $data = new $this->model();
        $data->brand_name = $request->brand_name;
        $data->description = $request->description;
        $data->date_acquired = $request->date_acquired;
        $data->cost = $request->cost;
        $data->status = $request->status;

        if($request->hasFile('photo')) {

            $folder = "/other_inventory/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');
            $data->photo = $name;

            if($data->save()) {

                $inserted_id = $data->id;

                if($inserted_id){

                    $data = new FixedAsset();
                    $data->assetable_type = 'App\Models\Inventory\OtherAsset';
                    $data->assetable_id = $inserted_id;
                    $data->status = 'new';
                    $data->description = $request->description;
                    $data->date = Carbon::today();
                    $data->type = 'Other';
                    $data->save();

                    $otherInventory = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($inserted_id);

                    return $otherInventory;

                }


            }

        }

        if($data->save()) {

            $inserted_id = $data->id;

            if($inserted_id){

                $data = new FixedAsset();
                $data->assetable_type = 'App\Models\Inventory\OtherAsset';
                $data->assetable_id = $inserted_id;
                $data->status = 'new';
                $data->description = $request->description;
                $data->date = Carbon::today();
                $data->type = 'Other';
                $data->save();

            }

            $otherInventory = $this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($inserted_id);

            return $otherInventory;

        }
    }

    public function updateOther($id, $request)
    {
        $data = $this->model()->find($id);
        $data->brand_name = $request->brand_name;
        $data->description = $request->description;
        $data->date_acquired = $request->date_acquired;
        $data->cost = $request->cost;
        $data->status = $request->status;

        if($request->hasFile('photo')) {
            \Storage::disk('public')->delete('/other_inventory/photo/'. $data->photo);

            $folder = "/other_inventory/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->photo = $name;

            if($data->save()) {
                return$this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($id);
            }
        }

        if($data->save()) {
            return$this->model()->with(['fixedAssets' => function($query) { $query->with('location');}])->find($id);
        }
    }

    public function deleteOther($id)
    {

        $data = $this->model()->find($id);
        $fixedAssets = FixedAsset::where('assetable_type', 'App\Models\Inventory\OtherAsset')->where('assetable_id', $data->id)->first();
        if($fixedAssets) {
            $fixedAssets->delete();
        }
        \Storage::disk('public')->delete('/other_inventory/photo/'. $data->photo);

        $file = OtherAssetDocument::where('other_asset_id', $id)->first();
        if($file) {
            \Storage::disk('public')->delete('/other_inventory/documents/'. $file->attached_file);
        }


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
                $query->where('assetable_type', 'App\Models\Inventory\OtherAsset');
                $query->where('assetable_id', $id);
                $query->with('location');
            });
        })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $history;

    }
}
