<?php

namespace App\Repositories\RequestMaterial;

use App\Models\ConsumableSupplies;
use App\Models\Project;
use App\Models\RequestMaterialForm;
use App\Models\RequestMaterialFormConsumableItem;
use App\Models\RequestMaterialFormFixedAssetItem;
use App\Models\RequestMaterialsFormConsumableItems;
use App\Repositories\Repository;
use App\Repositories\SupplierManagement\ConsumableSupplyRepository;
use Carbon\Carbon;

class RequestMaterialRepository extends Repository
{
    private $consumableSupplyRepository;
    public function __construct(RequestMaterialForm $model, ConsumableSupplyRepository $consumableSupplyRepository)
    {
        $this->consumableSupplyRepository = $consumableSupplyRepository;
        parent::__construct($model);
    }

    public function getRequest($params)
    {

        if($params->search) {
            $getRequest = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
                $query->orWhere('date_request', 'LIKE', "%$params->search%");
                $query->orWhere('requested_by', 'LIKE', "%$params->search%");
                $query->orWhere('approved_by', 'LIKE', "%$params->search%");
                $query->orWhereHas('project', function($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('name', 'LIKE', "%$params->search%");
                    });
                });
            })->with(['project',
                'requestMaterialStockOut',
                'requestMaterialFixedAssetItem',
                'requestMaterialConsumableStock',
                'requestMaterialConsumableItem'])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $getRequest;
        }

        $getRequest = $this->model()->with(['project',
            'requestMaterialStockOut',
            'requestMaterialFixedAssetItem',
            'requestMaterialConsumableStock',
            'requestMaterialConsumableItem'])->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $getRequest;

    }

    public function storeRequest($request)
    {

        $data = new $this->model();

        $data->project_id = $request->project_id;
        $data->date_request = Carbon::now();
        $data->requested_by = $request->requested_by;
        $data->request_material_code = $request->request_material_code;
        $data->approved_by = $request->approved_by;

        if($data->save()) {
            $getRequest = $this->model()->with(['project',
            'requestMaterialStockOut',
            'requestMaterialFixedAssetItem',
            'requestMaterialConsumableStock',
            'requestMaterialConsumableItem'])->find($data->id);
            return $getRequest;
        }

    }

    public function updateRequest($id, $request)
    {
        if($request->project_project_id){
            $project_id = $request->project_project_id;
        }
        else {
            $project_id = $request->project_id;
        }

        $data = $this->model()->find($id);
        $data->project_id = $project_id;
        $data->date_request = Carbon::now();
        $data->requested_by = $request->requested_by;
        $data->request_material_code = $request->request_material_code;
        $data->approved_by = $request->approved_by;

        if($data->save()) {
            $getRequest = $this->model()->with(['project',
            'requestMaterialStockOut',
            'requestMaterialFixedAssetItem',
            'requestMaterialConsumableStock',
            'requestMaterialConsumableItem'])->find($data->id);
            return $getRequest;
        }

    }

    public function getNumber() {

        $number = $this->model()->orderBy('id', 'desc')->first();
        $name = 'RM';
        if(!empty($number)) {
            $invoiceNumber = $number->request_material_code;
            foreach(explode('-', $invoiceNumber) as $data) {
                $form_id = (int)$data + 1;
            }
        }
        else {
            $form_id = 1;
        }

        return $name.'-'.str_pad($form_id, 6, '0', STR_PAD_LEFT);
    }

    public function deleteRequest($id)
    {

        $data = $this->model()->find($id);
        $data->delete();

        return 'Successfully Deleted';

    }

    public function getProjects($params)
    {

        if($params->project) {

            $getProjects = Project::where('name', 'LIKE', "%$params->project%")->limit(20)->get();

            return $getProjects;
        }

    }

    public function getRequested($id)
    {

        $requested = $this->model()->with('project')->find($id);

        return $requested;

    }

    public function getConsumableSupply($id, $params)
    {
        if($params->search) {
            $supplies = ConsumableSupplies::where('item_name', 'LIKE', "%$params->search%")->where('project_id', $id)->limit(20)->get();
            return $supplies;
        }

        return;

    }

    public function storeRequestConsumable($id, $request)
    {
        $response = [];
        if($request->consumable_items) {
            foreach($request->consumable_items as $key => $value) {
                if(isset($value['quantity'])) {
                    $newItem = [];
                    if(isset($value['newItem'])) {
                        $newItem = $this->consumableSupplyRepository->storeSupply(json_decode(json_encode($value)));
                    }
                    $data = new RequestMaterialFormConsumableItem();
                    $data->r_m_form_id = $id;
                    $data->date_requested = $request->date_requested;
                    $data->material_request = $request->material_request;
                    $data->c_s_id = isset($value['id']) ? $value['id'] : $newItem->id;
                    $data->quantity = $value['quantity'];
                    if($data->save()) {
                        $request = RequestMaterialFormConsumableItem::with('consumableSupply')->find($data->id);
                        array_push($response, $request);
                    }
                }
            }
        }

        return $response;

    }

    public function updateRequestConsumable($id, $request)
    {
        if($request->c_s_id_value){

            $c_s_id = $request->c_s_id_value;
        }
        else {
            $c_s_id = $request->c_s_id;
        }

        $data = RequestMaterialFormConsumableItem::find($id);
        $data->c_s_id = $c_s_id;
        $data->date_requested = $request->date_requested;
        $data->material_request = $request->material_request;
        $data->quantity = $request->quantity;

        if($data->save()) {
            $request = RequestMaterialFormConsumableItem::with('consumableSupply')->find($data->id);
            return $request;
        }

    }

    public function deleteRequestConsumable($id)
    {

        $delete = RequestMaterialFormConsumableItem::find($id);

        if($delete) {
            $delete->delete();
            return ;
        }

    }

    public function getRequestConsumable($id, $params)
    {
        if($params->search) {
            $getRequest = RequestMaterialFormConsumableItem::where(function ($query) use ($params) {
                $query->orWhere('date_requested', 'LIKE', "%$params->search%");
                $query->orWhere('material_request', 'LIKE', "%$params->search%");
                $query->orWhere('quantity', 'LIKE', "%$params->search%");
                $query->orWhereHas('consumableSupply', function($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('item_name', 'LIKE', "%$params->search%");
                    });
                });
            })->with('consumableSupply')->where('r_m_form_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $getRequest;
        }

        $getRequest = RequestMaterialFormConsumableItem::with('consumableSupply')->where('r_m_form_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $getRequest;
    }

    public function storeRequestFixedAsset($id, $request)
    {
        $data = new RequestMaterialFormFixedAssetItem();
        $data->request_materials_form_id = $id;
        $data->type_id = $request->type_id;
        $data->type = $request->type;
        $data->date_requested = $request->date_requested;

        if($data->save()) {
            $request = RequestMaterialFormFixedAssetItem::with(['fixedAsset' => function ($query) {
                $query->with('assetable');
            }])->find($data->id);
            return $request;
        }
    }

    public function updateRequestFixedAsset($id, $request)
    {
        if($request->type_id_id){

            $type_id = $request->type_id_id;
        }
        else {
            $type_id = $request->type_id;
        }

        $data = RequestMaterialFormFixedAssetItem::find($id);
        $data->type_id = $type_id;
        $data->type = $request->type;
        $data->date_requested = $request->date_requested;

        if($data->save())
        {

            $request = RequestMaterialFormFixedAssetItem::with(['fixedAsset' => function ($query) {
                $query->with('assetable');
            }])->find($id);
            return $request;
        }


    }

    public function deleteRequestFixedAsset($id)
    {

        $request = RequestMaterialFormFixedAssetItem::find($id);
        if($request) {
            $request->delete();
            return 'successfully deleted';
        }

    }

    public function getRequestFixedAssets($id, $params)
    {
        if($params->search) {
            $getRequest = RequestMaterialFormFixedAssetItem::where(function ($query) use ($params) {
                $query->orWhere('type', 'LIKE', "%$params->search%");
                $query->orWhere('date_requested', 'LIKE', "%$params->search%");
                $query->orWhereHas('fixedAsset', function($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('brand_name', 'LIKE', "%$params->search%");
                        $query3->orWhere('type', 'LIKE', "%$params->search%");
                    });
                });
            })->with(['fixedAsset' => function ($query) {
                $query->with('assetable');
            }])->where('request_materials_form_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $getRequest;
        }

        $getRequest = RequestMaterialFormFixedAssetItem::with(['fixedAsset' => function ($query) {
            $query->with('assetable');
        }])->where('request_materials_form_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $getRequest;
    }

    public function getRequestFixedAssetStockOut($params) {

        if($params->search) {

            $getRequest = RequestMaterialFormFixedAssetItem::where(function ($query) use ($params) {
                $query->orWhereHas('fixedAsset', function($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhereHas('assetable', function ($query4) use ($params) {
                            $query4->where(function ($query5) use ($params) {
                                $query5->orWhere('brand_name', 'LIKE', "%$params->search%");
                            });
                        });
                    });
                });
            })->with(['requestMaterial' => function ($query) {
                $query->with('project');
            }, 'fixedAsset' => function ($query) {
                $query->with('assetable');
            }])->doesntHave('requestMaterialStockOut')->where('request_materials_form_id', $params->request_form_id)->limit(20)->get();

            return $getRequest;
        }

        return  '';
    }

    public function getRequestConsumableStockOut($params)
    {

        if($params->search) {
            $getRequest = RequestMaterialFormConsumableItem::where(function ($query) use ($params) {
                $query->orWhereHas('consumableSupply', function ($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('item_name', 'LIKE', "%$params->search%");
                    });
                });
            })->with('consumableSupply')->where('r_m_form_id', $params->request_form_id)->limit(20)->get();

            return $getRequest;
        }

        return ;

    }

    public function getRequestProjects($params)
    {

        if($params->search) {
            $getRequest = $this->model()->where(function ($query) use ($params) {
                $query->orWhereHas('project', function($query2) use ($params) {
                    $query2->where(function ($query3) use ($params) {
                        $query3->orWhere('name', 'LIKE', "%$params->search%");
                    });
                });
            })->with('project')->orderBy('id', 'desc')->limit(20)->get();

            return $getRequest;
        }

    }

    public function getConsumableSuppliesData($params)
    {

        if($params->request_from_from_project) {
            $getRequest = RequestMaterialFormConsumableItem::with(['consumableSupply', 'consumableStockOut'])->where('r_m_form_id', $params->request_from_from_project)->get();

            return $getRequest;
        }

    }

    public function getRequestMaterialCode($params)
    {

        if($params->search) {
            $code = $this->model()->where(function ($query) use ($params) {
                $query->where('request_material_code', 'LIKE', "%$params->search%");
            })->with(['requestMaterialFixedAsset','requestMaterialConsumableItem' => function ($query) {$query->with('consumableSupply');}, 'requestMaterialStockOut', 'project'])->limit(20)->get();

            return $code;
        }

    }
}
