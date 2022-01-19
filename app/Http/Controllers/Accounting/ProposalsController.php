<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Repositories\Accounting\ProposalRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use App\Http\Requests\Accounting\SendFileCustomRequest;

class ProposalsController extends Controller
{
    private $proposalRepository;
    public function __construct(ProposalRepository $proposalRepository)
    {

        $this->proposalRepository = $proposalRepository;

    }

    public function index()
    {

        $status = $this->proposalRepository->status();

        return view('accounting.proposal.index', ['status' => $status]);

    }

    public function getProposals(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $proposals = $this->proposalRepository->getProposals(json_decode(json_encode($params)));

        return response()->json($proposals, 200);

    }

    public function getProposalNumber()
    {

        $number = $this->proposalRepository->getNumber();

        return response()->json($number, 200);

    }


    public function storeProposal(Request $request)
    {

        // dd($request->all());

        $proposal = $this->proposalRepository->storeProposal(json_decode(json_encode($request->all())));

        return response()->json($proposal, 200);

    }

    public function findProposal($id)
    {

        $proposal = $this->proposalRepository->findProposalByID($id);

        return response()->json($proposal, 200);

    }

    public function updateProposal($id, Request $request)
    {
        // dd($request->all());
        $proposal = $this->proposalRepository->updateProposal($id, json_decode(json_encode($request->all())));

        return response()->json($proposal);

    }

    public function deleteProposal($id)
    {

        $proposal = $this->proposalRepository->deleteProposal($id);

        return response()->json($proposal, 200);

    }

    public function convertInvoice($id)
    {

        $proposal = $this->proposalRepository->convertInvoice($id);

        return response()->json($proposal, 200);

    }

    public function sendProposal($id)
    {
        $proposal = $this->proposalRepository->sendProposal($id);

        return response()->json($proposal, 200);

    }

    public function changeStatus($id, Request $request)
    {

        $status = $request->status ? $request->status : 0;

        $proposal = $this->proposalRepository->changeStatus($id, $status);

        return response()->json($proposal, 200);

    }

    public function downloadProposal($id) {

        $proposal = $this->proposalRepository->findProposalByID($id);

        return view('accounting.proposal.downloadProposal')->with(['propoasal' => $proposal, 'id' => $id]);

    }

    public function generatePdf($id) {

        $proposal = $this->proposalRepository->findProposalByID($id);

        $data = [
            'proposal' => $proposal,
            'id' => "4"
        ];

        $tax_total = 0 ;
        $discount_total = 0 ;
        $subtotal = 0 ;
        $total_amount = 0;

        foreach($proposal->items as $item) {
            if($item->tax_rate) {
                $taxTotal = ($item->service_fee * $item->quantity) * ($item->tax_rate / 100);
                $tax_total += $taxTotal;
            }

            $discount_total += $item->discount;

            $subtotal += ($item->service_fee * $item->quantity);

        }

        $total_amount = ($subtotal + $tax_total) - $discount_total;

        $inv = $proposal->items->map(function($item) {
            $tax_total = ($item->service_fee * $item->quantity) * ($item->tax_rate / 100);
            if(!$item->tax_rate) {
                $item->tax_rate = '-';
            }
            else {
                $item->tax_rate = $item->tax_rate."% (P ".number_format(round($tax_total, 2), 2, '.', ',').")";
            }
            $item->price = "P ".number_format(round($item->price, 2), 2, '.', ',');
            $item->service_fee = "P ".number_format(round($item->service_fee, 2), 2, '.', ',');

            return $item;
        });

        $proposal->issue_date = (new Carbon($proposal->issue_date))->format('Y-m-d');
        $proposal->date_issue = (new Carbon($proposal->issue_date))->format('M-d-Y');

        $proposal->date = 'Downloaded on '.Carbon::now()->format('M-d-Y');

        $proposal->items = $inv;
        $proposal->total_tax = "P ".number_format(round($tax_total, 2), 2, '.', ',');
        $proposal->total_discount = "P ".number_format(round($discount_total, 2), 2, '.', ',');
        $proposal->subtotal = "P ".number_format(round($subtotal, 2), 2, '.', ',');
        $proposal->total_amount = "P ".number_format(round($total_amount, 2), 2, '.', ',');



        // return view('my-pdf-file')->with($data);
        $pdf = PDF::loadView('my-pdf-file', $data);


        return $pdf->download($proposal->proposal_number.'.pdf');
    }
}
