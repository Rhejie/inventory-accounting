<?php

namespace App\Repositories\JobOrder;

use App\Models\JobOrder\TruckJobOrder;
use App\Repositories\Repository;

class TruckJobOrderRepository extends Repository
{

    public function __construct(TruckJobOrder $model)
    {

        parent::__construct($model);

    }

    public function getJobOrder($id, $params)
    {

        if($params->search ) {
            $data = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('date_created', 'LIKE', "%$params->search%");
                $query->orWhere('assignee', 'LIKE', "%$params->search%");
                $query->orWhere('status', 'LIKE', "%$params->search%");
                $query->orWhereHas('jobOrdertype', function ($query2) use ($params) {
                    $query2->where('type', 'LIKE', "%$params->search%");
                });
            })->with('jobOrdertype')->where('truck_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $data;
        }

        return $this->model()->with('jobOrdertype')->where('truck_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

    }

    public function storeJobOrder($request)
    {

        $data = new $this->model();
        $data->truck_id = $request->truck_id;
        $data->job_order_type_id = $request->job_order_type_id;
        $data->date_created = $request->date_created;
        $data->assignee = $request->assignee;
        $data->status = $request->status;
        if($data->save()) {
            return $this->model()->with('jobOrdertype')->find($data->id);
        }

    }

    public function updateJobOrder($id, $request)
    {
        $data = $this->model()->find($id);
        $job_type_id = $request->job_order_type_id_id ? $request->job_order_type_id_id : $request->job_order_type_id;
        $data->truck_id = $request->truck_id;
        $data->job_order_type_id = $job_type_id;
        $data->date_created = $request->date_created;
        $data->assignee = $request->assignee;
        $data->status = $request->status;
        if($data->save()) {
            return $this->model()->with('jobOrdertype')->find($id);
        }
    }

    public function deleteJobOrder($id)
    {

        $data = $this->model()->find($id);

        if($data) {
            $data->delete();
        }

    }

}
