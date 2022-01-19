<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\BillPaymentCustomeRequest;
use App\Repositories\Accounting\BillPaymentRepository;
use Illuminate\Http\Request;

class BillPaymentController extends Controller
{

    private $billPaymentRepository;

    public function __construct(BillPaymentRepository $billPaymentRepository)
    {

        $this->billPaymentRepository = $billPaymentRepository;

    }

    public function getPayments($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $payments = $this->billPaymentRepository->getPayments($id, json_decode(json_encode($params)));

        return response()->json($payments, 200);

    }

    public function storePayment(BillPaymentCustomeRequest $request)
    {

        $payment = $this->billPaymentRepository->storePayment($request);

        return response()->json($payment, 200);

    }

    public function updatePayment($id, Request $request)
    {

        $payment = $this->billPaymentRepository->updatePayment($id, json_decode(json_encode($request->all())));

        return response()->json($payment, 200);

    }

    public function deletePayment($id)
    {

        $payment = $this->billPaymentRepository->deletePayment($id);

        return response()->json($payment, 200);

    }
}
