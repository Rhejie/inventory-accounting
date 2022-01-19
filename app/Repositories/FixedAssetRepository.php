<?php

namespace App\Repositories;

use App\Models\Inventory\EquipmentDocument;
use File;
use  Carbon\Carbon;
use DB;


class FixedAssetRepository{

    public function show()
    {

        $equipment = DB::table('heavy_equipments')
        ->select('heavy_equipments.brand_name');
      

       $vehicle = DB::table('vehicle_assets')
       ->select('vehicle_assets.brand_name');
      

      $others = DB::table('other_assets')
      ->select('other_assets.brand_name')
      ->union($equipment)
      ->union($vehicle)
      ->get();

      return $others;
    }


}