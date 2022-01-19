<?php

namespace App\Repositories;

use App\Models\Inventory\EquipmentDocument;
use File;
use  Carbon\Carbon;


class EquipmentDocumentRepository
{

	 public function FindAll($id)
    {
        return EquipmentDocument::where('equipment_id', $id)->get();
    }


    public function store($request){


    	$name = $request->file('file')->getClientOriginalName();
       // $path = $request->file('file')->store('public\assets\img\file');
        $request->file->move(public_path('assets/img/file'), $name);

        $data = new EquipmentDocument;

        $data->equipment_id = $request->equipment_id;
        $data->attached_file = $name;
        $data->file_type = $request->file_type;
        $data->save();

         return 'Equipment Document created successfully!';


    }

}