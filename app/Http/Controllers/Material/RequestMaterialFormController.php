<?php

namespace App\Http\Controllers\Material;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestMaterial\StoreRequestMaterialConsumable;
use App\Http\Requests\RequestMaterial\StoreRequestMaterialCustomeRequest;
use App\Http\Requests\RequestMaterial\StoreRequestMaterialFixedAsset;
use App\Http\Requests\RequestMaterial\UpdateRequestMaterialConsumable;
use App\Http\Requests\RequestMaterial\UpdateRequestMaterialCustomeRequest;
use App\Http\Requests\RequestMaterial\UpdateRequestMaterialFixedAsset;
use App\Repositories\RequestMaterial\RequestMaterialRepository;
use Illuminate\Http\Request;

class RequestMaterialFormController extends Controller
{
    private $requestMaterialRepository;

    public function __construct(RequestMaterialRepository $requestMaterialRepository)
    {
        $this->requestMaterialRepository = $requestMaterialRepository;
    }

    public function index()
    {

        return view('material.request_material');

    }

    public function getRequest(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getRequest = $this->requestMaterialRepository->getRequest(json_decode(json_encode($params)));

        return response()->json($getRequest, 200);
    }

    public function storeRequest(StoreRequestMaterialCustomeRequest $request)
    {

        $storeRequest = $this->requestMaterialRepository->storeRequest($request);

        return response()->json($storeRequest, 200);

    }

    public function updateRequest($id, UpdateRequestMaterialCustomeRequest $request)
    {

        $updateRequest = $this->requestMaterialRepository->updateRequest($id, $request);

        return response()->json($updateRequest, 200);

    }

    public function deleteRequest($id)
    {

        $deleteRequest = $this->requestMaterialRepository->deleteRequest($id);

        return response()->json($deleteRequest, 200);

    }

    public function getNumber()
    {

        $number = $this->requestMaterialRepository->getNumber();

        return response()->json($number, 200);

    }

    public function getProjects(Request $request)
    {

        $project = $request->project ? $request->project : null;

        $params = [
            'project' => $project
        ];

        $getprojects = $this->requestMaterialRepository->getProjects(json_decode(json_encode($params)));

        return response()->json($getprojects, 200);

    }

    public function getRequested($id)
    {

        $requested = $this->requestMaterialRepository->getRequested($id);

        return response()->json($requested, 200);

    }

    public function getConsumableSupply($id, Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $supplies = $this->requestMaterialRepository->getConsumableSupply($id, json_decode(json_encode($params)));

        return response()->json($supplies, 200);

    }

    public function storeRequestConsumable($id, StoreRequestMaterialConsumable $request)
    {

        $storeRequestConsumable = $this->requestMaterialRepository->storeRequestConsumable($id, $request);

        return response()->json($storeRequestConsumable, 200);

    }


    public function updateRequestConsumable($id, UpdateRequestMaterialConsumable $request)
    {

        $updateRequestConsumable = $this->requestMaterialRepository->updateRequestConsumable($id, $request);

        return response()->json($updateRequestConsumable, 200);

    }

    public function deleteRequestConsumable($id)
    {

        $deleteRequestConsumable = $this->requestMaterialRepository->deleteRequestConsumable($id);

        return response()->json($deleteRequestConsumable, 200);

    }

    public function getRequestConsumable($id, Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getRequestConsumable = $this->requestMaterialRepository->getRequestConsumable($id, json_decode(json_encode($params)));

        return response()->json($getRequestConsumable, 200);

    }

    public function storeRequestFixedAsset($id, StoreRequestMaterialFixedAsset $request)
    {

        $storeRequest = $this->requestMaterialRepository->storeRequestFixedAsset($id, $request);

        return response()->json($storeRequest, 200);

    }

    public function getRequestFixedAssets($id, Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getRequestFixedAssets = $this->requestMaterialRepository->getRequestFixedAssets($id, json_decode(json_encode($params)));

        return response()->json($getRequestFixedAssets, 200);
    }

    public function updateRequestFixedAsset($id, UpdateRequestMaterialFixedAsset $request)
    {

        $updateFixedAsset = $this->requestMaterialRepository->updateRequestFixedAsset($id, $request);

        return response()->json($updateFixedAsset, 200);

    }

    public function deleteFixedAsset($id)
    {

        $deleteFixedAsset = $this->requestMaterialRepository->deleteRequestFixedAsset($id);

        return response()->json($deleteFixedAsset, 200);

    }

    public function getRequestFixedAssetStockOut(Request $request)
    {

        $search = $request->search ? $request->search : null;
        $request_form_id = $request->request_form_from_project_id ? $request->request_form_from_project_id : null;

        $params = [
            'search' => $search,
            'request_form_id' => $request_form_id
        ];

        $getRequestFixedAssets = $this->requestMaterialRepository->getRequestFixedAssetStockOut(json_decode(json_encode($params)));

        return response()->json($getRequestFixedAssets, 200);

    }

    public function getRequestConsumableStockOut(Request $request)
    {

        $search = $request->search ? $request->search : null;
        $request_form_id = $request->request_form_from_project_id ? $request->request_form_from_project_id : null;

        $params = [
            'search' => $search,
            'request_form_id' => $request_form_id
        ];

        $getRequestFixedAssets = $this->requestMaterialRepository->getRequestConsumableStockOut(json_decode(json_encode($params)));

        return response()->json($getRequestFixedAssets, 200);

    }

    public function getProject(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search,
        ];

        $getRequestProjects = $this->requestMaterialRepository->getRequestProjects(json_decode(json_encode($params)));

        return response()->json($getRequestProjects, 200);

    }

    public function getConsumableSuppliesData(Request $request)
    {

        $request_from_from_project = $request->request_form_from_project ? $request->request_form_from_project : null;

        $params = [
            'request_from_from_project' => $request_from_from_project
        ];

        $getConsumableSuppliesData = $this->requestMaterialRepository->getConsumableSuppliesData(json_decode(json_encode($params)));

        return response()->json($getConsumableSuppliesData, 200);
    }

    public function getRequestMaterialCode(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $getCode = $this->requestMaterialRepository->getRequestMaterialCode(json_decode(json_encode($params)));

        return response()->json($getCode, 200);

    }
}
