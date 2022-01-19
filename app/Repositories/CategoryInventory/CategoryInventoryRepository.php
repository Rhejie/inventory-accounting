<?php

namespace App\Repositories\CategoryInventory;

use App\Models\Inventory\AssetCategory;
use App\Repositories\Repository;

class CategoryInventoryRepository extends Repository
{

    public function __construct(AssetCategory $model)
    {
        parent::__construct($model);
    }

    public function getCategories($params)
    {
        if($params->search) {
            $categories = $this->model()->with('assetTypes')->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
                $query->orWhereHas('assetTypes', function ($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('name', 'LIKE', "%$params->search%");
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $categories;
        }

        $categories = $this->model()->with('assetTypes')->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $categories;
    }

    public function storeCategory($request)
    {
        $data = new $this->model();
        $data->name = $request->name;
        $data->type_id = $request->type_id;

        if($data->save()) {

            $category = $this->model()->with('assetTypes')->find($data->id);

            return $category;

        }
    }

    public function updateCategory($id, $request)
    {

        $data = $this->model()->find($id);

        $data->name = $request->name;
        $data->type_id = $request->type_id;

        if($data->save()) {

            $category = $this->model()->with('assetTypes')->find($id);

            return $category;

        }

    }

    public function deleteCategory($id)
    {

        $category = $this->model()->find($id);

        $category->delete();

        return 'Successfully Deleted';

    }

}
