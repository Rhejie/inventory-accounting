<?php

namespace App\Repositories\Maintenance;

use App\Models\Maintenance\TruckVehicleMaintenance;
use App\Repositories\Repository;

class TruckVehicleMaintenanceRepository extends Repository
{

    public function __construct(TruckVehicleMaintenance $model)
    {

        parent::__construct($model);

    }

    public function getMaintenance($id, $params)
    {

        if($params->search ) {
            $data = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('date', 'LIKE', "%$params->search%");
                $query->orWhere('amount', 'LIKE', "%$params->search%");
                $query->orWhere('assigned', 'LIKE', "%$params->search%");
                $query->orWhereHas('maintenanceType', function ($query2) use ($params) {
                    $query2->where('type', 'LIKE', "%$params->search%");
                });
            })->with('maintenanceType')->where('truck_vehicle_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $data;
        }

        return $this->model()->with('maintenanceType')->where('truck_vehicle_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

    }

    public function storeMaintenance($request)
    {

        $data = new $this->model();
        $data->truck_vehicle_id = $request->truck_vehicle_id;
        $data->maintenance_type_id = $request->maintenance_type_id;
        $data->date = $request->date;
        $data->assigned = $request->assigned;
        $data->amount = $request->amount;
        $data->file_name = $request->file_name;
        if($request->hasFile('file')) {
            $folder = "/truck_vehicle/maintenance_attachment";
            $media = $request->file('file');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');
            $data->file = $name;
            if($data->save()) {
                $equipment =$this->model()->with('maintenanceType')->find($data->id);
                return $equipment;
            }
        }
        if($data->save()) {
            return $this->model()->with('maintenanceType')->find($data->id);
        }

    }

    public function updateMaintenance($id, $request)
    {
        $data = $this->model()->find($id);
        $maintenane_id = $request->maintenance_type_id_id ? $request->maintenance_type_id_id : $request->maintenance_type_id;
        $data->truck_vehicle_id = $request->truck_vehicle_id;
        $data->maintenance_type_id = $maintenane_id;
        $data->date = $request->date;
        $data->assigned = $request->assigned;
        $data->file_name = $request->file_name;
        $data->amount = $request->amount;
        if($request->hasFile('file')) {

            \Storage::disk('public')->delete('/truck_vehicle/maintenance_attachment/'. $data->file);

            $folder = "/truck_vehicle/maintenance_attachment";
            $media = $request->file('file');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->file = $name;
            if($data->save()) {
                return $this->model()->with('maintenanceType')->find($id);
            }
        }
        if($data->save()) {
            return $this->model()->with('maintenanceType')->find($id);
        }
    }

    public function deleteMaintenance($id)
    {

        $data = $this->model()->find($id);

        if($data) {
            $data->delete();
        }

    }

}
