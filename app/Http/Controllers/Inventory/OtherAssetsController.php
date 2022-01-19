<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Models\Inventory\AssetCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\OtherInventory\StoreOtherInventoryCustomRequest;
use App\Http\Requests\OtherInventory\UpdateOtherInventoryCustomRequest;
use App\Repositories\OtherInventory\OtherInventoryRepository;

class OtherAssetsController extends Controller
{
    private $otherInventoryRepository;

    public function __construct(OtherInventoryRepository $otherInventoryRepository)
    {
        $this->otherInventoryRepository = $otherInventoryRepository;

        $this->middleware('auth');
    }

    public function index()
    {

        $AssetCategory = AssetCategory::All();

        return view('inventory.others',compact('AssetCategory'));
    }

    public function getOtherInventory(Request $request) {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $othersInventory = $this->otherInventoryRepository->getOtherInventory(json_decode(json_encode($params)));

        return response()->json($othersInventory, 200);

    }

    public function viewAttachment(Request $request) 
    {

        $file = $request->file;

        return view('inventory.view_other_maintenance_attachment', compact('file'));
        
    }

    public function getInfo($id)
    {

        $getInfo = $this->otherInventoryRepository->getInfo($id);

        return response()->json($getInfo, 200);

    }

    public function storeOtherInventory(StoreOtherInventoryCustomRequest $request)
    {
        $storeOther = $this->otherInventoryRepository->store($request);

        return response()->json($storeOther, 200);
    }

    public function updateOther($id, UpdateOtherInventoryCustomRequest $request)
    {
        $otherInventory = $this->otherInventoryRepository->updateOther($id, $request);

        return response()->json($otherInventory, 200);
    }

    public function deleteOtherInventory($id)
    {

        $delete = $this->otherInventoryRepository->deleteOther($id);

        return response()->json($delete, 200);

    }

    public function otherLocationHistory($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getHistory = $this->otherInventoryRepository->getLocationHistory($id, json_decode(json_encode($params)));

        return response()->json($getHistory, 200);

    }
}
