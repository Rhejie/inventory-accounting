<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseOrderStoreRequest;
use App\Http\Requests\Purchase\StorePurchaseOrderItemRequest;
use App\Http\Requests\Purchase\UpdatePurchaseOrderItemRequest;
use App\Http\Requests\Purchase\UpdatePurchaseOrderRequest;
use App\Http\Requests\Purchase\UpdatePurchaseOrderInView;
use App\Repositories\Purchase\PurchaseOrderItemRepository;
use App\Repositories\Purchase\PurchaseOrderRepository;
use App\Repositories\Purchase\PurchaseReceivedRepository;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    private $purchaseOrderRepository;
    private $purchaseOrderItemRepository;
    private $purchaseReceivedRepository;

    public function __construct(
        PurchaseOrderRepository $purchaseOrderRepository,
        PurchaseOrderItemRepository $purchaseOrderItemRepository,
        PurchaseReceivedRepository $purchaseReceivedRepository)
    {

        $this->purchaseOrderRepository = $purchaseOrderRepository;
        $this->purchaseReceivedRepository = $purchaseReceivedRepository;
        $this->purchaseOrderItemRepository = $purchaseOrderItemRepository;

    }

    public function index()
    {
        return view('purchase.purchase_order.index');
    }

    public function storeOrder(PurchaseOrderStoreRequest $request)
    {

        $storeOrder = $this->purchaseOrderRepository->storeOrder($request);

        return response()->json($storeOrder, 200);

    }

    public function getOrders(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getOrders = $this->purchaseOrderRepository->getOrders(json_decode(json_encode($params)));

        return response()->json($getOrders, 200);
    }

    public function updateOrder($id, UpdatePurchaseOrderRequest $request)
    {

        $updateOrder = $this->purchaseOrderRepository->updateOrder($id, $request);

        return response()->json($updateOrder, 200);

    }

    public function updateOrderInView($id, UpdatePurchaseOrderInView $request)
    {

        $updateOrder = $this->purchaseOrderRepository->updateOrder($id, $request);

        return response()->json($updateOrder, 200);

    }

    public function deleteOrder($id)
    {

        $deleteOrder = $this->purchaseOrderRepository->deleteOrder($id);

        return;

    }

    public function getNumber()
    {

        $number = $this->purchaseOrderRepository->getNumber();

        return response()->json($number, 200);

    }

    public function getPurchaseOrderData($id)
    {
        $dataPO = $this->purchaseOrderRepository->getPurchaseOrderData($id);

        return response()->json($dataPO, 200);
    }

    public function getItems($id)
    {
        $items = $this->purchaseOrderItemRepository->getItems($id);

        return response()->json($items, 200);
    }

    public function storeOrderItem($id, $supplier_id ,StorePurchaseOrderItemRequest $request)
    {

        $newItem = $this->purchaseOrderItemRepository->newItem($id, $supplier_id, $request);

        return response()->json($newItem, 200);

    }

    public function updateOrderItem($id, UpdatePurchaseOrderItemRequest $request)
    {

        $updateItem = $this->purchaseOrderItemRepository->updateItem($id, $request);

        return response()->json($updateItem, 200);

    }

    public function deleteOrderItem($id, Request $request)
    {
        $po_form_id = $request->po_id ? $request->po_id : null;

        $deleteItem = $this->purchaseOrderItemRepository->deleteItem($id, $po_form_id);

        return response()->json($deleteItem, 200);

    }

    public function getPurhcaseOrderForms(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search,
        ];

        $forms = $this->purchaseOrderRepository->getPurhcaseOrderForms(json_decode(json_encode($params)));

        return response()->json($forms, 200);

    }

    public function getPurchaseOrderItems($id, Request $request)
    {
        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search,
        ];

        $items = $this->purchaseOrderItemRepository->getPurchaseOrderItems($id, json_decode(json_encode($params)));

        return response()->json($items, 200);
    }

    public function addVat($id, Request $request)
    {
        $vat = $request->vat ? $request->vat : 0;

        $params = [
            'vat' => $vat
        ];

        $vat = $this->purchaseOrderRepository->addVat($id, json_decode(json_encode($params)));

        return response()->json($vat, 200);
    }

    public function addDiscount($id, Request $request)
    {

        $discount = $request->discount ? $request->discount : 0;

        $params = [
            'discount' => $discount
        ];

        $discount = $this->purchaseOrderRepository->addDiscount($id, json_decode(json_encode($params)));

        return response()->json($discount, 200);

    }

    public function addOthers($id, Request $request)
    {

        $others = $request->others ? $request->others : 0;

        $params = [
            'others' => $others
        ];

        $others = $this->purchaseOrderRepository->addOthers($id, json_decode(json_encode($params)));

        return response()->json($others, 200);

    }

    public function getHasSupply($project_id, Request $request)
    {
        $consumable_item = $request->consumable_item ? $request->consumable_item : null;

        $params = [
            'consumable_item' => $consumable_item
        ];

        $hasSupply = $this->purchaseOrderRepository->hasSupply($project_id, json_decode(json_encode($params)));

        return response()->json($hasSupply, 200);

    }

    public function getTransactions($id)
    {

        $transactions = $this->purchaseReceivedRepository->getTransactions($id);

        return response()->json($transactions, 200);

    }

    public function getPurchaseOrders($id)
    {

        $order = $this->purchaseOrderRepository->getPurchaseOrders($id);

        return response()->json($order, 200);

    }

    public function getPurchaseOrdersUpdate($id) {

        $order = $this->purchaseOrderRepository->getPurchaseOrdersUpdate($id);

        return response()->json($order, 200);
    }

    public function getPurchaseOrderByNumber(Request $request) {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $order = $this->purchaseOrderRepository->getPurchaseOrderByNumber(json_decode(json_encode($params)));

        return response()->json($order, 200);

    }
}
