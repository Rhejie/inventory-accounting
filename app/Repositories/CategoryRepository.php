<?php

namespace App\Repositories;

use App\Models\Inventory\AssetCategory;
use File;

class CategoryRepository
{
    public function model()
    {
        return AssetCategory::orderBy('created_at', 'desc')->get();
    }


     public function show($id)
    {
        return AssetCategory::find($id);
    }

     public function store($request)
    {
       
        $data = new AssetCategory;
        $data->name = $request->name;
        $data->type_id = $request->type_id;
        $data->save();

        return 'Category created successfully!';

    }

}
