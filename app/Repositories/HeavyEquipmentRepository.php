<?php

namespace App\Repositories;

use App\Models\Inventory\HeavyEquipment;
use App\Models\Inventory\FixedAsset;
use File;
use  Carbon\Carbon;

class HeavyEquipmentRepository
{

	public function model()
    {
        return HeavyEquipment::orderBy('created_at', 'desc')->get();
    }


    public function show($id)
    {
        return HeavyEquipment::find($id);
    }

    public function store($request)
    {
        $request = $this->storeImage($request);
        $data = new HeavyEquipment;
        $data->control_number = $request->control_number;
        $data->asset_category_id = $request->category_id;
        $data->brand_name = $request->brand_name;
        $data->model = $request->model;
        $data->engine_model = $request->engine_model;
        $data->engine_number = $request->engine_number;
        $data->serial_number = $request->serial_number;
        $data->reference_number = $request->reference_number;
        $data->capacity = $request->capacity;
        $data->description = $request->description;
        $data->date_acquired = $request->date_acquired;
        $data->photo = $request->photo;
        $data->cost = $request->cost;
        $data->assigned_to = $request->assigned_to;
        $data->save();

        $inserted_id = $data->id;


        //insert to fixed_assets table

       if($inserted_id){

             $data = new FixedAsset;
             $data->assetable_type = 'App\Models\Inventory\HeavyEquipment';
             $data->assetable_id = $inserted_id;
             $data->status = 'new';
             $data->description = $request->description;
             $data->date = Carbon::today();
             $data->save();

        }

        return 'Heavy Equipment created successfully!';
    }


     public function storeImage($request)
    {
        if($request->photo != NULL)
        {
            $imageName = $request->control_number . '.' . $request->photo->extension();
            $request->photo->move(public_path('assets/img/equipments'), $imageName);
            $request->photo = $imageName;
        }
        
        return $request;
    }


}