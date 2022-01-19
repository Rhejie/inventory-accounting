<?php

namespace App\Repositories\Maintenance;

use App\Models\Maintenance\HeavyEquipmentMaintenance;
use App\Repositories\Repository;

class HeavyEquipmentMaintenanceRepository extends Repository
{

    public function __construct(HeavyEquipmentMaintenance $model)
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
            })->with('maintenanceType')->where('heavy_equipment_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $data;
        }

        return $this->model()->with('maintenanceType')->where('heavy_equipment_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

    }

    public function storeMaintenance($request)
    {

        $data = new $this->model();
        $data->heavy_equipment_id = $request->heavy_equipment_id;
        $data->maintenance_type_id = $request->maintenance_type_id;
        $data->date = $request->date;
        $data->assigned = $request->assigned;
        $data->amount = $request->amount;
        $data->file_name = $request->file_name;
        if($request->hasFile('file')) {
            $folder = "/heavy_equipments/maintenance_attachment";
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
        $maintenance_id = $request->maintenance_type_id_id ? $request->maintenance_type_id_id : $request->maintenance_type_id;
        $data->heavy_equipment_id = $request->heavy_equipment_id;
        $data->maintenance_type_id = $maintenance_id;
        $data->date = $request->date;
        $data->assigned = $request->assigned;
        $data->amount = $request->amount;
        $data->file_name = $request->file_name;
        if($request->hasFile('file')) {

            \Storage::disk('public')->delete('/heavy_equipments/maintenance_attachment/'. $data->file);

            $folder = "/heavy_equipments/maintenance_attachment";
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
