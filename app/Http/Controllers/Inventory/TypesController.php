<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\TypesRepository;
use App\Http\Requests\StoreTypesRequest;
use App\Http\Requests\TypeInventory\StoreTypeCustomRequest;
use App\Http\Requests\TypeInventory\UpdateTypeCustomRequest;
use App\Repositories\TypeInventory\TypeInventoryRepository;
//use Config;
use  Carbon\Carbon;

class TypesController extends Controller
{
    //
    private $typeInventoryRepository;
    public function __construct(TypeInventoryRepository $typeInventoryRepository)
    {
        $this->middleware('auth');
        $this->typeInventoryRepository = $typeInventoryRepository;
    }

    public function index(){

        return view('inventory.asset_types');
    }

    public function getTypes(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $types = $this->typeInventoryRepository->getTypes(json_decode(json_encode($params)));

        return response()->json($types, 200);
    }

    public function storeType(StoreTypeCustomRequest $request)
    {
        $type = $this->typeInventoryRepository->storeType($request);

        return response()->json($type, 200);
    }

    public function updateType($id, UpdateTypeCustomRequest $request)
    {
        $type = $this->typeInventoryRepository->updateType($id, $request);

        return response()->json($type, 200);
    }

    public function deleteType($id)
    {

        $deleteType = $this->typeInventoryRepository->deleteType($id);

        return response()->json($deleteType, 200);

    }

    public function getTypesForCategory() {

        $types = $this->typeInventoryRepository->getTypesForSelect();

        return response()->json($types, 200);

    }

}
