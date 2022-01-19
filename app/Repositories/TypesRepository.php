<?php

namespace App\Repositories;

use App\Models\Inventory\AssetType;
use File;

class TypesRepository
{
    public function model()
    {
        return AssetType::orderBy('updated_at', 'desc')->get();
    }


     public function show($id)
    {
        return AssetType::find($id);
    }

     public function store($request)
    {
       
        $data = new AssetType;
        $data->name = $request->name;
        $data->resource_type = $request->resource_type;
        $data->save();

        return 'Asset Type created successfully!';

    }

}
