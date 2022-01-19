<?php

namespace App\Repositories\JobOrder;

use App\Models\JobOrder\OtherJobOrder;
use App\Repositories\Repository;

class OtherOrderRepository extends Repository
{

    public function __construct(OtherJobOrder $model)
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
            })->with('jobOrdertype')->where('other_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $data;
        }

        return $this->model()->with('jobOrdertype')->where('other_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

    }

    public function storeJobOrder($request)
    {

        $data = new $this->model();
        $data->other_id = $request->other_id;
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

        $job_type_id = $request->job_order_type_id_id ? $request->job_order_type_id_id : $request->job_order_type_id;
        $data = $this->model()->find($id);
        $data->other_id = $request->other_id;
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
