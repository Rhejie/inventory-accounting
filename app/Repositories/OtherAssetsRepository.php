<?php
 namespace App\Repositories;
use App\Models\Inventory\OtherAsset;
use App\Models\Inventory\FixedAsset;
use Illuminate\Support\Carbon;

class OtherAssetsRepository{


    public function model()
    {

        return OtherAsset::orderBy('created_at', 'desc')->get();

    }
    public function show($id)
    {
        return OtherAsset::find($id);

    }

    public function store($request)
    {
        $request = $this->storeImage($request);
        
        $data = new OtherAsset;
        $data->asset_category_id = $request->category_id;
        $data->brand_name = $request->brand_name;
        $data->date_acquired = $request->date_acquired;
        $data->cost = $request->cost;
        $data->photo = $request->photo;
        $data->save();

        $inserted_id = $data->id;

        if($inserted_id){

            $data = new FixedAsset;
            $data->assetable_type = 'App\Models\Inventory\OtherAsset';
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
            $request->photo->storeAs('public/assets/others', $imageName);
            $request->photo = $imageName;
        }
        // storeAs('public/assets/vehicle', $imageName);
        return $request;
    }

}