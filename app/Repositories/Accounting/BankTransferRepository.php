<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Attachment;
use App\Models\Accounting\BankTransfer;
use App\Repositories\Repository;

class BankTransferRepository extends Repository
{
    private $bankAccountRepository;
    public function __construct(BankTransfer $model, BankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        parent::__construct($model);

    }

    public function getBankTransfers($params)
    {

        $transfers = $this->model()->with(['fromAccount', 'toAccount', 'attachable']);

        if($params->search) {

            $transfers = $transfers->where(
                function ($query) use ($params) {
                    $query->orWhere('amount', 'LIKE', "%$params->search%");
                    $query->orWhere('description', 'LIKE', "%$params->search%");
                    $query->orWhere('reference', 'LIKE', "%$params->search%");
                    $query->orWhereHas('fromAccount', function ($query2) use ($params) {
                        $query2->where(function ($query3) use ($params) {
                            $query3->orWhere('bank_name', 'LIKE', "%$params->search%");
                            $query3->orWhere('holder_name', 'LIKE', "%$params->search%");
                        });
                    });
                }
            )->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $transfers;

        }

        $transfers = $transfers->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $transfers;

    }

    public function storeTransfer($request)
    {

        $accountMinus = $this->bankAccountRepository->transferAccount($request);
        if($accountMinus == 'insufficient') {
            return 'insufficient fund';
        }
        $accountAdd = $this->bankAccountRepository->transferAccountTo($request);

        $data = new $this->model();

        $data->from_account = $request->from_account;
        $data->to_account = $request->to_account;
        $data->amount = $request->amount;
        $data->date = $request->date;
        $data->reference = $request->reference;
        $data->description = $request->description;

        if($data->save()) {
            if($request->hasFile('file')) {

                $folder = '/bank/transfer/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\BankTransfer';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            return $this->model()->with(['fromAccount', 'toAccount', 'attachable'])->find($data->id);
        }

    }

    public function updateTransfer($id, $request)
    {

        $from_account = $request->from_account_id ? $request->from_account_id : $request->from_account;
        $to_account = $request->to_account_id ? $request->to_account_id : $request->to_account;

        $data = $this->model()->find($id);

        if($from_account == $data->from_account) {

            if($to_account == $data->to_account) {
                $params = [
                    'prev_amount' => $data->amount,
                    'new_amount' => $request->amount,
                    'from_account' => $from_account,
                    'to_account' => $to_account,
                ];

                $from = $this->bankAccountRepository->updateAmountFromToNotChange(json_decode(json_encode($params)));
                if($from == 'insufficient') {
                    return 'insufficient';
                }
            }

            else {
                $params = [
                    'prev_amount' => $data->amount,
                    'new_amount' => $request->amount,
                    'from_account' => $from_account,
                    'to_account' => $to_account,
                    'prev_account' => $data->to_account,
                ];

                $from = $this->bankAccountRepository->updateAmountFromNotChange(json_decode(json_encode($params)));
                if($from == 'insufficient') {
                    return 'insufficient';
                }
            }
        }
        else {

            if($to_account == $data->to_account) {

                $params = [
                    'prev_amount' => $data->amount,
                    'new_amount' => $request->amount,
                    'from_account' => $from_account,
                    'to_account' => $to_account,
                    'prev_from_account' => $data->from_account,
                ];

                $from = $this->bankAccountRepository->updateAmountToNotChange(json_decode(json_encode($params)));
                if($from == 'insufficient') {
                    return 'insufficient';
                }
            }

            else {

                $params = [
                    'prev_amount' => $data->amount,
                    'new_amount' => $request->amount,
                    'from_account' => $from_account,
                    'to_account' => $to_account,
                    'prev_from_account' => $data->from_account,
                    'prev_to_account' => $data->to_account,
                ];

                $from = $this->bankAccountRepository->updateAmountChange(json_decode(json_encode($params)));
                if($from == 'insufficient') {
                    return 'insufficient';
                }

            }

        }

        $data->from_account = $from_account;
        $data->to_account = $to_account;
        $data->amount = $request->amount;
        $data->date = $request->date;
        $data->reference = $request->reference;
        $data->description = $request->description;

        if($data->save()) {
            if($request->hasFile('file')) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\BankTransfer')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/bank/transfer/". $at->file);
                    $at->delete();
                }

                $folder = '/bank/transfer/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\BankTransfer';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }
            return $this->model()->with(['fromAccount', 'toAccount', 'attachable'])->find($id);
        }
    }

    public function deleteTransfer($id)
    {

        $transfer = $this->model()->find($id);
        if($transfer) {

            $params = [
                'amount' => $transfer->amount,
                'from_account' => $transfer->from_account,
                'to_account' => $transfer->to_account
            ];

            $this->bankAccountRepository->deleteAmount(json_decode(json_encode($params)));

            $transfer->delete();
        }

    }


}
