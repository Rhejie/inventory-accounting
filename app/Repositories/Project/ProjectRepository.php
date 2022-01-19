<?php

namespace App\Repositories\Project;

use App\Models\Delivery\ConsumableSupplyStockOut;
use App\Models\Delivery\FixedAssetStockOut;
use App\Models\Project;
use App\Models\ProjectDocuments;
use App\Repositories\Repository;

class ProjectRepository extends Repository
{

    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function getProjects($params)
    {
        if ($params->search) {
            $getProjects = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
                $query->orWhere('location', 'LIKE', "%$params->search%");
                $query->orWhere('date_start', 'LIKE', "%$params->search%");
                $query->orWhere('date_end', 'LIKE', "%$params->search%");
                $query->orWhere('budget', 'LIKE', "%$params->search%");
                $query->orWhere('percentage', 'LIKE', "%$params->search%");
            })->with('projectStatus')->orderBy('id', 'DESC')->paginate($params->count, ['*'], 'page', $params->page);

            return $getProjects;
        }

        $getProjects = $this->model()->with('projectStatus')->orderBy('id', 'DESC')->paginate($params->count, ['*'], 'page', $params->page);

        return $getProjects;
    }

    public function storeProject($request)
    {
        $data = new $this->model();
        $data->name = $request->name;
        $data->location = $request->location;
        $data->date_start = $request->date_start;
        $data->date_end = $request->date_end;
        $data->budget = $request->budget;
        $data->status_id = $request->status_id;
        $data->percentage = $request->percentage;
        $data->description = $request->description;

        if($request->hasFile('photo')) {

            $folder = "/project/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->photo = $name;

            if($data->save()) {

                $project = $this->model()->with('projectStatus')->find($data->id);

                return $project;
            }
        }

        if($data->save()) {

            $project = $this->model()->with('projectStatus')->find($data->id);

            return $project;
        }
    }

    public function updateProject($id, $request)
    {
        $data = $this->model()->find($id);

        $data->name = $request->name;
        $data->location = $request->location;
        $data->date_start = $request->date_start;
        $data->date_end = $request->date_end;
        $data->budget = $request->budget;
        $data->status_id = $request->status_id;
        $data->percentage = $request->percentage;
        $data->description = $request->description;

        if($request->hasFile('photo')) {

            \Storage::disk('public')->delete('/project/photo/'. $data->photo);

            $folder = "/project/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->photo = $name;

            if($data->save()) {

                $updatedProject = $this->model()->with('projectStatus')->find($id);

                return $updatedProject;
            }
        }

        if($data->save()) {

            $updatedProject = $this->model()->with('projectStatus')->find($id);

            return $updatedProject;

        }
    }

    public function getProjectDetails($id)
    {

        $projectDetails = $this->model::find($id);

        return $projectDetails;
    }

    public function storeProjectDocument($id,  $request)
    {

        if($request->hasFile('file')) {
            $folder = "/project/documents";
            $media = $request->file('file');
            $name = $id . '_' . time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $store = new ProjectDocuments();
            $store->remarks = $request->remarks;
            $store->type = $request->type;
            $store->project_id = $id;
            $store->file_name = $request->file_name;
            $store->file = $name;

            if($store->save()) {
                return $store;
            }
        }
        return 'error';

    }

    public function getProjectDocuments($id, $params) {
        if ($params->search) {
            $getProjectDocuments = ProjectDocuments::where(function ($query) use ($params) {
                $query->orWhere('file_name', 'LIKE', "%$params->search%");
                $query->orWhere('remarks', 'LIKE', "%$params->search%");
                $query->orWhere('type', 'LIKE', "%$params->search%");
            })->orderBy('id', 'DESC')->where('project_id', $id)->paginate($params->count, ['*'], 'page', $params->page);

            return $getProjectDocuments;
        }

        $getProjectDocuments = ProjectDocuments::where('project_id', $id)->orderBy('id', 'DESC')->paginate($params->count, ['*'], 'page', $params->page);

        return $getProjectDocuments;
    }

    public function deleteProject($id)
    {

        $deleteProject = $this->model()->find($id);
        \Storage::disk('public')->delete('/project/photo/'. $deleteProject->photo);
        $deleteProject->delete();

        return 'Successfully Deleted';

    }

    public function deleteDocument($id)
    {

        $deleteDocument = ProjectDocuments::find($id);
        \Storage::disk('public')->delete('/project/documents/'. $deleteDocument->file);
        $deleteDocument->delete();

        return 'Successfully Deleted';

    }

    public function updateDocument($id, $request)
    {
        $data = ProjectDocuments::find($id);
        $data->remarks = $request->remarks;
        $data->type = $request->type;

        if($request->hasFile('file')) {
            \Storage::disk('public')->delete('/project/documents/'. $data->file);
            $folder = "/project/documents";
            $media = $request->file('file');
            $name = $id . '_' . time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->file = $name;
            $data->file_name = $request->file_name;

            if($data->save()) {
                return $data;
            }
        }

        if($data->save()) {
            return $data;
        }

        return 'error';
    }

    public function getProjectsData($params)
    {

        if($params->search) {
            $projects = $this->model()->where('name', 'LIKE', "%$params->search%")->limit(20)->get();
            return $projects;
        }


    }

    public function getFixedAssets($id, $params)
    {

        if($params->search) {

            $fixedAssets = FixedAssetStockOut::with(['requestMaterialsFixedAsset' => function ($query) {
                $query->with(['fixedAsset' => function ($query){
                    $query->with('assetable');
                }]);
                $query->with(['requestMaterial' => function ($query) {
                    $query->with('project');
                }]);
            }])->where(function ($query) use ($params) {
                $query->orWhere('date_delivered', 'LIKE', "%$params->search%");
                $query->orWhere('remarks', 'LIKE', "%$params->search%");
                $query->orWhereHas('requestMaterialsFixedAsset', function ($query2) use ($params) {
                    $query2->whereHas('fixedAsset', function ($query3) use ($params) {
                        $query3->whereHas('assetable', function ($query4) use ($params) {
                            $query4->where('brand_name', 'LIKE', "%$params->search%");
                        });
                    });
                });
            })->where(function ($query) use ($id) {
                $query->whereHas('requestMaterialsFixedAsset', function ($query2) use ($id) {
                    $query2->whereHas('requestMaterial', function ($query3) use ($id) {
                        $query3->whereHas('project', function ($query4) use ($id) {
                            $query4->where('id', $id);
                        });
                    });
                });
            })->where('is_delivered', true)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $fixedAssets;
        }

        $fixedAssets = FixedAssetStockOut::with(['requestMaterialsFixedAsset' => function ($query) {
            $query->with(['fixedAsset' => function ($query){
                $query->with('assetable');
            }]);
            $query->with(['requestMaterial' => function ($query) {
                $query->with('project');
            }]);
        }])->where(function ($query) use ($id) {
            $query->whereHas('requestMaterialsFixedAsset', function ($query2) use ($id) {
                $query2->whereHas('requestMaterial', function ($query3) use ($id) {
                    $query3->whereHas('project', function ($query4) use ($id) {
                        $query4->where('id', $id);
                    });
                });
            });
        })->where('is_delivered', true)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $fixedAssets;
    }

    public function getConsumableSupplies($id, $params)
    {

        if($params->search) {

            $consumableSupplies = ConsumableSupplyStockOut::with(['consumableItem' => function ($query) {
                $query->with(['consumableSupply']);
                $query->with(['requestMaterial' => function ($query) {
                    $query->with('project');
                }]);
            }])->where(function ($query) use ($params) {
                $query->orWhere('date_delivered', 'LIKE', "%$params->search%");
                $query->orWhere('remarks', 'LIKE', "%$params->search%");
                $query->orWhere('actual_quantity_delivered', 'LIKE', "%$params->search%");
                $query->orWhereHas('consumableItem', function ($query2) use ($params) {
                    $query2->whereHas('consumableSupply', function ($query3) use ($params) {
                        $query3->where(function ($query) use ($params) {
                            $query->where('item_name', 'LIKE', "%$params->search%");
                            $query->orWhere('item_code', 'LIKE', "%$params->search%");
                        });
                    });
                });
            })->where(function ($query) use ($id) {
                $query->whereHas('consumableItem', function ($query2) use ($id){
                    $query2->whereHas('requestMaterial', function ($query3) use ($id) {
                        $query3->whereHas('project', function ($query4) use ($id) {
                            $query4->where('id', $id);
                        });
                    });
                });
            })->where('is_delivered', true)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $consumableSupplies;

        }

        $consumableSupplies = ConsumableSupplyStockOut::with(['consumableItem' => function ($query) {
            $query->with(['consumableSupply']);
            $query->with(['requestMaterial' => function ($query) {
                $query->with('project');
            }]);
        }])->where(function ($query) use ($id) {
            $query->whereHas('consumableItem', function ($query2) use ($id){
                $query2->whereHas('requestMaterial', function ($query3) use ($id) {
                    $query3->whereHas('project', function ($query4) use ($id) {
                        $query4->where('id', $id);
                    });
                });
            });
        })->where('is_delivered', true)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $consumableSupplies;
    }

}
