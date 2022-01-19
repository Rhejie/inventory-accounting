<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Attachment;
use App\Models\Accounting\BillPayment;
use App\Repositories\Repository;

class BillPaymentRepository extends Repository
{

    private $bankAccountRepository;
    public function __construct(BillPayment $model, BankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        parent::__construct($model);

    }

    public function getPayments($id, $params)
    {

        $payments = $this->model()->with(['bill', 'account',  'attachable']);

        if($params->search) {

            $payments = $payments->where('bill_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $payments;

        }

        $payments = $payments->where('bill_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $payments;

    }

    public function storePayment($request)
    {

        $data = new $this->model();
        $data->bill_id = $request->bill_id;
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->account_id = $request->account_id;
        $data->reference = $request->reference;
        $data->description = $request->description;

        $params = [
            'amount' => $request->amount,
            'status' => 'add',
            'account_id' => $request->account_id,
        ];

        $account = $this->bankAccountRepository->billPaymentStore(json_decode(json_encode($params)));

        if($account == 'insufficient') {
            return 'insufficient';
        }

        if($data->save()) {
            if($request->hasFile('file')) {

                $folder = '/bill/payment/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\BillPayment';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            return $this->model()->with(['account', 'bill', 'attachable'])->find($data->id);

        }

    }

    public function updatePayment($id, $request)
    {

        $account_id = $request->account_id_id ? $request->account_id_id : $request->account_id;

        $data = $this->model()->find($id);

        if($account_id != $data->account_id) {
            $params  = [
                'prev_amount' => $data->amount,
                'prev_account_id' => $data->account_id,
                'new_amount' => $request->amount,
                'new_account_id' => $request->account_id,
                'status' => 'update',
            ];

            $account = $this->bankAccountRepository->updateBillPayment(json_decode(json_encode($params)));

            if($account == 'insufficient') {
                return 'insufficient';
            }

            $data->date = $request->date;
            $data->amount = $request->amount;
            $data->account_id = $account_id;
            $data->reference = $request->reference;
            $data->description = $request->description;
            if($data->save()) {

                return $this->model()->with(['account', 'bill'])->find($id);

            }

        }

        else {

            $params  = [
                'prev_amount' => $data->amount,
                'new_amount' => $request->amount,
                'account_id' => $request->account_id,
                'status' => 'update',
            ];

            $account = $this->bankAccountRepository->updateBillPaymentNewAmount(json_decode(json_encode($params)));

            if($account == 'insufficient') {
                return 'insufficient';
            }

            $data->date = $request->date;
            $data->amount = $request->amount;
            $data->account_id = $account_id;
            $data->reference = $request->reference;
            $data->description = $request->description;
            if($data->save()) {

                return $this->model()->with(['account', 'bill'])->find($id);

            }

        }
    }

    public function deletePayment($id)
    {

        $data = $this->model()->find($id);

        if($data) {

            $params = [
                'account_id' => $data->account_id,
                'amount' => $data->amount,
            ];

            $account = $this->bankAccountRepository->deletePaymentBill(json_decode(json_encode($params)));

            $data->delete();
        }

    }

}
