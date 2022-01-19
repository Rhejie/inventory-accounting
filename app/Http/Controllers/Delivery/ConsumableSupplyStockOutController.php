<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\StoreConsumableStockOutRequest;
use App\Http\Requests\Delivery\UpdateConsumableStockOutRequest;
use App\Repositories\Delivery\ConsumableStockOutRepository;
use Illuminate\Http\Request;

class ConsumableSupplyStockOutController extends Controller
{
    private $consumableStockOutRepository;

    public function __construct(ConsumableStockOutRepository $consumableStockOutRepository)
    {

        $this->consumableStockOutRepository = $consumableStockOutRepository;

    }

    public function index()
    {
        return view('consumable_item_stock_out.index');
    }

    public function getConsumableSupplies(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getStockOuts = $this->consumableStockOutRepository->getConsumableSupplies(json_decode(json_encode($params)));

        return response()->json($getStockOuts, 200);

    }

    public function store(StoreConsumableStockOutRequest $request)
    {

        $storeSupply = $this->consumableStockOutRepository->store($request);

        return response()->json($storeSupply, 200);

    }

    public function update($id, UpdateConsumableStockOutRequest $request)
    {
        $storeSupply = $this->consumableStockOutRepository->update($id, $request);

        return response()->json($storeSupply, 200);

    }

    public function deleteStockOut($id, Request $request)
    {

        $deleteStockOut = $this->consumableStockOutRepository->deleteStockOut($id, json_decode(json_encode($request->all())));

        return response()->json($deleteStockOut, 200);

    }

    public function isDelivered($id, Request $request)
    {

        $is_delivered = $request->is_delivered ? $request->is_delivered : 0;

        $params = [
            'is_delivered' => $is_delivered
        ];

        $isDelivered = $this->consumableStockOutRepository->isDelivered($id, json_decode(json_encode($params)));

        return response()->json($isDelivered, 200);

    }

}
