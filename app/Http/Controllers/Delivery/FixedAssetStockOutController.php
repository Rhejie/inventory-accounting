<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\StoreFixedAssetStockOutRequest;
use App\Http\Requests\Delivery\UpdateFixedAssetStockOutRequest;
use App\Repositories\Delivery\FixedAssetStockOutRepository;
use Illuminate\Http\Request;

class FixedAssetStockOutController extends Controller
{
    private $fixedAssetStockOutRepository;

    public function __construct(FixedAssetStockOutRepository $fixedAssetStockOutRepository)
    {

        $this->fixedAssetStockOutRepository = $fixedAssetStockOutRepository;

    }

    public function index()
    {

        return view('asset_stock_out.index');

    }

    public function getFixedAssets(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getStockOuts = $this->fixedAssetStockOutRepository->getFixedAssets(json_decode(json_encode($params)));

        return response()->json($getStockOuts, 200);

    }

    public function store(StoreFixedAssetStockOutRequest $request)
    {

        $storeStockOut = $this->fixedAssetStockOutRepository->store($request);

        return response()->json($storeStockOut, 200);

    }

    public function update($id, UpdateFixedAssetStockOutRequest $request)
    {

        $updateStockOut = $this->fixedAssetStockOutRepository->update($id, $request);

        return response()->json($updateStockOut, 200);

    }

    public function isDelivered($id, Request $request)
    {
        $is_delivered = $request->is_delivered ? $request->is_delivered : 0;

        $params = [
            'is_delivered' => $is_delivered
        ];

        $isDelivered = $this->fixedAssetStockOutRepository->isDelivered($id, json_decode(json_encode($params)));

        return response()->json($isDelivered, 200);
    }

    public function delete($id)
    {

        $delete = $this->fixedAssetStockOutRepository->delete($id);

        return response()->json($delete, 200);

    }


}
