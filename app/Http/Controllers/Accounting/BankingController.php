<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Repositories\Accounting\BankAccountRepository;
use App\Repositories\Accounting\BankTransferRepository;
use App\Http\Requests\Accounting\BankAccountCustomRequest;
use App\Http\Requests\Accounting\BankAccountTransferCustomRequest;
use App\Http\Requests\Accounting\BankAccountTransferUpdateCustomRequest;
use App\Http\Requests\Accounting\BankAccountUpdateCustomRequest;
use Illuminate\Http\Request;

class BankingController extends Controller
{
    private $bankAccountRepository;
    private $bankTransferRepository;

    public function __construct(BankAccountRepository $bankAccountRepository, BankTransferRepository $bankTransferRepository)
    {

        $this->bankAccountRepository = $bankAccountRepository;
        $this->bankTransferRepository = $bankTransferRepository;

    }

    public function account()
    {

        return view('accounting.banking.account');

    }

    public function transfer()
    {

        return view('accounting.banking.transfer');

    }

    public function getAccounts(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $accounts = $this->bankAccountRepository->getBankAccounts(json_decode(json_encode($params)));

        return response()->json($accounts, 200);

    }

    public function storeAccount(BankAccountCustomRequest $request)
    {

        $account = $this->bankAccountRepository->storeAccount($request);

        return response()->json($account, 200);

    }

    public function updateAccount($id, BankAccountUpdateCustomRequest $request)
    {

        $account = $this->bankAccountRepository->updateAccount($id, $request);

        return response()->json($account, 200);

    }

    public function deleteAccount($id)
    {

        $account = $this->bankAccountRepository->deleteAccount($id);

        return response()->json($account, 200);

    }

    public function searchAccount(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $accounts = $this->bankAccountRepository->searchAccount(json_decode(json_encode($params)));

        return response()->json($accounts, 200);

    }

    public function getTransfers(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $transfer = $this->bankTransferRepository->getBankTransfers(json_decode(json_encode($params)));

        return response()->json($transfer, 200);

    }

    public function storeTransfer(BankAccountTransferCustomRequest $request)
    {

        $transfer = $this->bankTransferRepository->storeTransfer($request);

        return response()->json($transfer, 200);

    }

    public function updateTransfer($id, BankAccountTransferUpdateCustomRequest $request)
    {

        $transfer = $this->bankTransferRepository->updateTransfer($id, $request);

        return response()->json($transfer, 200);

    }

    public function deleteTransfer($id)
    {

        $transfer = $this->bankTransferRepository->deleteTransfer($id);

        return response()->json($transfer, 200);

    }
}
