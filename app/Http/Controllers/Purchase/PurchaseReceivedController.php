<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\StorePurchaseReceivedRequest;
use App\Http\Requests\Purchase\UpdatePurchaseReceivedRequest;
use App\Repositories\Purchase\PurchaseReceivedRepository;
use Illuminate\Http\Request;

class PurchaseReceivedController extends Controller
{
    private $purchaseReceivedRepository;
    public function __construct(PurchaseReceivedRepository $purchaseReceivedRepository)
    {
        $this->purchaseReceivedRepository = $purchaseReceivedRepository;
    }

    public function index()
    {
        return view('purchase.purchase_received.index');
    }

    public function getReceived(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getReceived = $this->purchaseReceivedRepository->getReceived(json_decode(json_encode($params)));

        return response()->json($getReceived, 200);

    }

    public function store(StorePurchaseReceivedRequest $request)
    {
        $store = $this->purchaseReceivedRepository->storeReceived($request);

        return response()->json($store, 200);

    }
    public function storeItem(StorePurchaseReceivedRequest $request)
    {
        // dd($request->all());
        $store = $this->purchaseReceivedRepository->storeReceivedItem($request);

        return response()->json($store, 200);

    }

    public function update($id, UpdatePurchaseReceivedRequest $request)
    {

        $update = $this->purchaseReceivedRepository->updateReceived($id, $request);

        return response()->json($update, 200);

    }

    public function delete($id)
    {

        $delete = $this->purchaseReceivedRepository->deleteReceived($id);

        return response()->json($delete, 200);

    }

    public function getDetails($id) {

        $details = $this->purchaseReceivedRepository->getDetails($id);

        return response()->json($details, 200);
    }

    public function getItems($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getItems = $this->purchaseReceivedRepository->getItems($id, json_decode(json_encode($params)));

        return response()->json($getItems, 200);

    }

    public function getItemReceivedQunatity($id)
    {
        $receivedQuantity = $this->purchaseReceivedRepository->getItemReceivedQunatity($id);

        return response()->json($receivedQuantity, 200);
    }

    public function getItemReceivedQunatityItem($id)
    {
        $receivedQuantity = $this->purchaseReceivedRepository->getItemReceivedQunatityItem($id);

        return response()->json($receivedQuantity, 200);
    }
}
