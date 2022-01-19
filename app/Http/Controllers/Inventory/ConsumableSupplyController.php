<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsumableSupply\StoreConsumableSupplyCostumRequest;
use App\Http\Requests\ConsumableSupply\UpdateConsumableSupplyCostumRequest;
use App\Repositories\SupplierManagement\ConsumableSupplyRepository;
use Illuminate\Http\Request;

class ConsumableSupplyController extends Controller
{
    private $consumableSupplyRepository;

    public function __construct(ConsumableSupplyRepository $consumableSupplyRepository)
    {

        $this->consumableSupplyRepository = $consumableSupplyRepository;

    }

    public function index()
    {
        return view('inventory.consumable_supply');
    }

    public function getSupply(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getSupplies = $this->consumableSupplyRepository->getSupplies(json_decode(json_encode($params)));

        return response()->json($getSupplies, 200);

    }

    public function storeSupply(StoreConsumableSupplyCostumRequest $request)
    {

        $storeSupply = $this->consumableSupplyRepository->storeSupply($request);

        return response()->json($storeSupply, 200);

    }

    public function updateSupply($id, UpdateConsumableSupplyCostumRequest $request)
    {

        $updateSupply = $this->consumableSupplyRepository->updateSupply($id, $request);

        return response()->json($updateSupply, 200);
    }

    public function deleteSupply($id)
    {

        $deleteSupply = $this->consumableSupplyRepository->deleteSupply($id);

        return response()->json($deleteSupply, 200);

    }
}
