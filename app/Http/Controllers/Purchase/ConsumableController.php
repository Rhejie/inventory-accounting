<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\StoreConsumableItem;
use App\Http\Requests\Purchase\UpdateConsumableItem;
use App\Repositories\SupplierManagement\ConsumableItemRepository;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{
    private $consumableItemRepository;

    public function __construct(ConsumableItemRepository $consumableItemRepository)
    {
        $this->consumableItemRepository = $consumableItemRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('inventory.consumable-item');
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

        $getConsumableItems = $this->consumableItemRepository->getItems($id, json_decode(json_encode($params)));

        return response()->json($getConsumableItems, 200);

    }

    public function storeItem($id, StoreConsumableItem $request)
    {

        $storeItem = $this->consumableItemRepository->storeItem($id, $request);

        return response()->json($storeItem, 200);

    }

    public function updateItem($id, UpdateConsumableItem $request)
    {

        $updateItem = $this->consumableItemRepository->updateItem($id, $request);

        return response()->json($updateItem, 200);
    }

    public function deleteItem($id)
    {

        $deleteItem = $this->consumableItemRepository->deleteItem($id);

        return response()->json($deleteItem, 200);

    }

    public function consumableItems(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getConsumableItems = $this->consumableItemRepository->getConsumableItems(json_decode(json_encode($params)));

        return response()->json($getConsumableItems, 200);
    }

    public function getSupplierItems($id, Request $request)
    {
        $search = $request->search ? $request->search : null;
        $params = [
            'search' => $search
        ];

        $items = $this->consumableItemRepository->getSupplierItems($id, json_decode(json_encode($params)));

        return response()->json($items, 200);

    }

    public function checkPerItem(Request $request)
    {

        $supplier_id = $request->supplier_id ? $request->supplier_id : null;
        $consumable_items = $request->consumable_items ? $request->consumable_items : null;
        dd($request->all());
        $params = [
            'supplier_id' => $supplier_id,
            'consumable_items' => (Array) $consumable_items
        ];

        $checkedItems = $this->consumableItemRepository->checkItem(json_decode(json_encode($params)));

        return response()->json($checkedItems, 200);

    }

}
