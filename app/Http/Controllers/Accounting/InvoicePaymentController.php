<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\InvoicePaymentCustomRequest;
use App\Repositories\Accounting\InvoicePaymentRepository;
use Illuminate\Http\Request;

class InvoicePaymentController extends Controller
{
    private $invoicePaymentRepository;
    public function __construct(InvoicePaymentRepository $invoicePaymentRepository)
    {

        $this->invoicePaymentRepository = $invoicePaymentRepository;

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

        $payments = $this->invoicePaymentRepository->getPayments($id, json_decode(json_encode($params)));

        return response()->json($payments, 200);

    }

    public function storePayment(InvoicePaymentCustomRequest $request)
    {

        $payment = $this->invoicePaymentRepository->storePayment($request);

        return response()->json($payment, 200);

    }

    public function updatePayment($id, Request $request)
    {

        $payment = $this->invoicePaymentRepository->updatePayment($id, json_decode(json_encode($request->all())));

        return response()->json($payment, 200);

    }

    public function deletePayment($id)
    {

        $payment = $this->invoicePaymentRepository->deletePayment($id);

        return response()->json($payment, 200);

    }
}
