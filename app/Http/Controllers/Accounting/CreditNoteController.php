<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\CreditNoteCustomRequest;
use App\Http\Requests\Accounting\CreditNoteUpdateCustomRequest;
use App\Repositories\Accounting\CreditNoteRepository;
use Illuminate\Http\Request;

class CreditNoteController extends Controller
{

    private $creditNoteRepository;

    public function __construct(CreditNoteRepository $creditNoteRepository)
    {
        $this->creditNoteRepository = $creditNoteRepository;
    }

    public function getCredits(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $credits = $this->creditNoteRepository->getCredits(json_decode(json_encode($params)));

        return response()->json($credits, 200);

    }

    public function storeCredit(CreditNoteCustomRequest $request)
    {

        $credit = $this->creditNoteRepository->storeCredit($request);

        return response()->json($credit, 200);

    }

    public function updateCredit($id, CreditNoteUpdateCustomRequest $request)
    {

        $credit = $this->creditNoteRepository->updateCredit($id, $request);

        return response()->json($credit, 200);

    }

    public function deleteCredit($id)
    {

        $credit = $this->creditNoteRepository->deleteCredit($id);

        return response()->json($credit, 200);

    }

    public function getCreditsNotes($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $credits = $this->creditNoteRepository->getCreditNotes($id, json_decode(json_encode($params)));

        return response()->json($credits, 200);

    }
}
