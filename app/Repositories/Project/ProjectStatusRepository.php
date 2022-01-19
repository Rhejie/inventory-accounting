<?php

namespace App\Repositories\Project;

use App\Models\ProjectStatus;
use App\Repositories\Repository;

class ProjectStatusRepository extends Repository
{

    public function __construct(ProjectStatus $model)
    {

        parent::__construct($model);

    }

    public function getStatus($params)
    {

        if($params->search) {

            $data = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $data;
        }

        return $this->model()->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

    }

    public function storeStatus($request)
    {

        $data = new $this->model();
        $data->name = $request->name;
        $data->is_archive = 'no';
        if($data->save()) {
            return $data;
        }

    }

    public function updateStatus($id, $request)
    {
        $data = $this->model()->find($id);
        $data->name = $request->name;
        $data->is_archive = 'no';
        if($data->save()) {
            return $data;
        }
    }

    public function deleteStatus($id)
    {

        $data = $this->model()->find($id);
        if($data) {
            $data->delete();
        }

    }

}
