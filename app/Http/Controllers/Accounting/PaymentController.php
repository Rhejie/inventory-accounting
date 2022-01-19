<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\PaymentCustomRequest;
use App\Http\Requests\Accounting\PaymentUpdateCustomRequest;
use App\Repositories\Accounting\PaymentRepository;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {

        $this->paymentRepository = $paymentRepository;

    }

    public function getPayments(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $payments = $this->paymentRepository->getPayments(json_decode(json_encode($params)));

        return response()->json($payments, 200);

    }

    public function storePayment(PaymentCustomRequest $request)
    {

        $payment = $this->paymentRepository->storePayment($request);

        return response()->json($payment, 200);

    }

    public function updatePayment($id, PaymentUpdateCustomRequest $request)
    {

        $payment = $this->paymentRepository->updatePayment($id, $request);

        return response()->json($payment, 200);

    }

    public function deletePayment($id)
    {

        $payment = $this->paymentRepository->deletePayment($id);


        return response()->json($payment, 200);

    }
}
