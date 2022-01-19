<?php

namespace App\Repositories;

use App\Models\Inventory\AssetType;
use App\Models\Inventory\VehicleAsset;
use App\Models\Inventory\FixedAsset;
use Illuminate\Support\Carbon;
class VehicleRepository{

    public function model()
    {

        return VehicleAsset::orderBy('created_at', 'desc')->get();

    }
    public function show($id)
    {
        return VehicleAsset::find($id);

    }

    public function store($request)
    {
        $request = $this->storeImage($request);
        
        $data = new VehicleAsset;
        $data->asset_category_id = $request->category_id;
        $data->brand_name = $request->brand_name;
        $data->plate_number = $request->plate_number;
        $data->body_type = $request->body_type;
        $data->date_acquired = $request->date_acquired;
        $data->assigned_to = $request->assigned_to;
        $data->photo = $request->photo;
        $data->cost = $request->cost;
        $data->save();

        $inserted_id = $data->id;

        if($inserted_id){

            $data = new FixedAsset;
            $data->assetable_type = 'App\Models\Inventory\VehicleAsset';
            $data->assetable_id = $inserted_id;
            $data->status = 'new';
            $data->description = $request->description;
            $data->date = Carbon::today();
            $data->save();

       }

       return 'Truck/Vehicle created successfully!';

    }
    
    
    public function storeImage($request)
    {
        if($request->photo != NULL)
        {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/assets/vehicle', $imageName);
            $request->photo = $imageName;
        }
        
        return $request;
    }

}