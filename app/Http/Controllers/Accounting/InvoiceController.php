<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Repositories\Accounting\InvoiceRepository;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {

        $this->invoiceRepository = $invoiceRepository;

    }

    public function getInvoices(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $invoices = $this->invoiceRepository->getInvoices(json_decode(json_encode($params)));

        return response()->json($invoices, 200);
    }

    public function getInvoiceNumber()
    {

        $number = $this->invoiceRepository->getNumber();

        return response()->json($number, 200);

    }

    public function storeInvoice(Request $request)
    {

        $invoice = $this->invoiceRepository->storeInvoice(json_decode(json_encode($request->all())));

        return response()->json($invoice, 200);

    }

    public function findInvoice($id)
    {

        $invoice  = $this->invoiceRepository->findInvoiceByID($id);

        return response()->json($invoice, 200);

    }

    public function updateInvoice($id, Request $request)
    {

        $invoice = $this->invoiceRepository->updateInvoice($id, json_decode(json_encode($request->all())));

        return response()->json($invoice, 200);

    }

    public function searchInvoice(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $invoices = $this->invoiceRepository->searchInvoice(json_decode(json_encode($params)));

        return response()->json($invoices, 200);

    }

    public function sendInvoice($id)
    {

        $invoice = $this->invoiceRepository->sendInvoice($id);

        return response()->json($invoice, 200);

    }

    public function deleteInvoice($id) {
        $invoice = $this->invoiceRepository->deleteInvoice($id);

        return response()->json($invoice, 200);
    }

    public function downloadInvoice($id, Request $request)
    {

        $invoice  = $this->invoiceRepository->findInvoiceByID($id);

        return view('accounting.income.downloadInvoce')->with(['invoice' => $invoice, 'id' => $id]);

    }
}
