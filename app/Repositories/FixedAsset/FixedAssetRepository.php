<?php

namespace App\Repositories\FixedAsset;

use App\Models\Inventory\FixedAsset;
use App\Repositories\Repository;

class FixedAssetRepository extends Repository
{
    public function __construct(FixedAsset $model)
    {
        parent::__construct($model);
    }

    public function getFixedAssets($params)
    {
        if($params->search) {

            if($params->type) {

                $getFixedAssets = $this->model()->with(['assetable'])->has('assetable')->where('type', $params->type)->where(function ($query) use ($params) {
                    $query->orWhere('description', 'LIKE', "%$params->search%");
                    $query->orWhere('date', 'LIKE', "%$params->search%");
                    $query->orWhere('status', 'LIKE', "%$params->search%");
                    $query->orWhereHas('assetable', function($query2) use ($params) {
                        $query2->where(function ($query3) use ($params) {
                            $query3->orWhere('brand_name', 'LIKE', "%$params->search%");
                        });
                    });
                })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

                return $getFixedAssets;

            }

            $getFixedAssets = $this->model()->with(['assetable'])->has('assetable')->where(function ($query) use ($params) {
                $query->orWhere('description', 'LIKE', "%$params->search%");
                $query->orWhere('date', 'LIKE', "%$params->search%");
                $query->orWhere('status', 'LIKE', "%$params->search%");
                $query->orWhereHas('assetable', function($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('brand_name', 'LIKE', "%$params->search%");
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $getFixedAssets;
        }

        if($params->type) {

            $getFixedAssets = $this->model()->with(['assetable', 'location'])->where('type', $params->type)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $getFixedAssets;
        }

        $getFixedAssets = $this->model()->with(['assetable', 'location'])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $getFixedAssets;
    }

    public function getFixedAssetsRequest($params)
    {

        if($params->search) {
            $data = $this->model()->whereHas('assetable', function ($query2) use ($params) {
                $query2->where(function ($query3) use ($params) {
                    $query3->orWhere('brand_name', 'LIKE', "%$params->search%");
                });
            })->with('assetable')->limit(20)->get();

            return $data;
        }

    }
}
