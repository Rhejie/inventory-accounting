<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\BillCustomRequest;
use App\Repositories\Accounting\BillRepository;
use Illuminate\Http\Request;

class BillController extends Controller
{
    private $billRepository;

    public function __construct(BillRepository $billRepository)
    {

        $this->billRepository = $billRepository;

    }

    public function getBills(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $bills = $this->billRepository->getBills(json_decode(json_encode($params)));

        return response()->json($bills, 200);

    }

    public function storeBill(Request $request)
    {
        $bill = $this->billRepository->storeBill(json_decode(json_encode($request->all())));

        return response()->json($bill, 200);

    }

    public function updateBill($id, Request $request)
    {

        $bill = $this->billRepository->updateBill($id, json_decode(json_encode($request->all())));

        return response()->json($bill, 200);

    }

    public function deleteBill($id)
    {

        $bill = $this->billRepository->deleteBill($id);

        return response()->json($bill, 200);

    }

    public function getBillNumber()
    {

        $bill = $this->billRepository->getNumber();

        return response()->json($bill, 200);

    }

    public function showBillByID($id)
    {

        $bill = $this->billRepository->getBillByID($id);

        return response()->json($bill, 200);

    }

    public function getItems($id)
    {

        $items = $this->billRepository->getItems($id);

        return response()->json($items, 200);

    }

    public function sendBill($id)
    {

        $bill = $this->billRepository->sendBill($id);

        return response()->json($bill, 200);

    }

    public function searchBill(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $bill = $this->billRepository->searchBill(json_decode(json_encode($params)));

        return response()->json($bill, 200);
    }

    public function getOrders($id)
    {

        $billOrders = $this->billRepository->billOrders($id);

        return response()->json($billOrders, 200);

    }
}
