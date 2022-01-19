<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillOfMaterial\StoreBillOfMaterialRequest;
use App\Http\Requests\BillOfMaterial\UpdateBillOfMaterialRequest;
use App\Repositories\BillOfMaterial\BillOfMaterialDescriptionRepository;
use App\Repositories\BillOfMaterial\BillOfMaterialItemRepository;
use App\Repositories\BillOfMaterial\BillOfMaterialRepository;
use Illuminate\Http\Request;

class BillOfMaterialController extends Controller
{

    private $billOfMaterialRepository;
    private $billOfMaterialItemRepository;
    private $billOfMaterialDescriptionRepository;

    public function __construct(BillOfMaterialRepository $billOfMaterialRepository,
        BillOfMaterialItemRepository $billOfMaterialItemRepository,
        BillOfMaterialDescriptionRepository $billOfMaterialDescriptionRepository)
    {

        $this->billOfMaterialDescriptionRepository = $billOfMaterialDescriptionRepository;
        $this->billOfMaterialItemRepository = $billOfMaterialItemRepository;
        $this->billOfMaterialRepository = $billOfMaterialRepository;

    }

    public function getBillOfMaterials($id)
    {

        $materials = $this->billOfMaterialItemRepository->getBillOfMaterials($id);

        return response()->json($materials, 200);

    }

    public function storeBillOfMaterial(StoreBillOfMaterialRequest $request)
    {

        $material = $this->billOfMaterialRepository->storeMaterial($request);

        return response()->json($material, 200);

    }

    public function updateBillOfMaterial($id, UpdateBillOfMaterialRequest $request)
    {

        $material = $this->billOfMaterialRepository->updateMaterial($id, $request);

        return response()->json($material, 200);

    }

    public function deleteMaterial($id)
    {

        $material = $this->billOfMaterialRepository->deleteMaterial($id);

        return response()->json($material, 200);

    }

    // item

    public function getItems(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $items = $this->billOfMaterialItemRepository->getMaterials(json_decode(json_encode($params)));

        return response()->json($items, 200);

    }

    public function storeItem(Request $request)
    {

        $item = $this->billOfMaterialItemRepository->storeMaterial(json_decode(json_encode($request->all())));

        return response()->json($item, 200);
    }

    public function updateItem($id, Request $request)
    {

        $item = $this->billOfMaterialItemRepository->updateMaterial($id, json_decode(json_encode($request->all())));

        return response()->json($item, 200);
    }

    public function deleteItem($id)
    {

        $item = $this->billOfMaterialItemRepository->deleteMaterial($id);

        return response()->json($item, 200);

    }

    // description

    public function getDescriptions(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $descriptions = $this->billOfMaterialDescriptionRepository->getMaterials(json_decode(json_encode($params)));

        return response()->json($descriptions, 200);

    }

    public function storeDescription(Request $request)
    {

        $description = $this->billOfMaterialDescriptionRepository->storeMaterial(json_decode(json_encode($request->all())));

        return response()->json($description, 200);

    }

    public function updateDescription($id, Request $request)
    {

        $description = $this->billOfMaterialDescriptionRepository->updateMaterial($id, json_decode(json_encode($request->all())));

        return response()->json($description, 200);

    }

    public function deleteDescription($id)
    {

        $description = $this->billOfMaterialDescriptionRepository->deleteMaterial($id);

        return response()->json($description, 200);

    }

    public function getItemsData()
    {

        $items = $this->billOfMaterialItemRepository->getItemsData();

        return response()->json($items, 200);

    }

    public function getDescriptionsData(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $descriptions = $this->billOfMaterialDescriptionRepository->getDescriptionsData($search);

        return response()->json($descriptions, 200);

    }

    public function updateProjectBillOfMaterial($id, Request $request)
    {

        $request->validate([

            'unit' => 'required',
            'quantity' => 'required',
            'unit_cost' => 'required',
            'amount' => 'required',

        ]);

        $bill = $this->billOfMaterialRepository->updateBillOfMaterialProject($id, json_decode(json_encode($request->all())));

        return response()->json($bill, 200);


    }
}
