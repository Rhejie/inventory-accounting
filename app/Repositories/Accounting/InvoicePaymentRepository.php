<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Attachment;
use App\Models\Accounting\InvoicePayment;
use App\Repositories\Repository;

class InvoicePaymentRepository extends Repository
{
    private $bankAccountRepository;

    public function __construct(InvoicePayment $model, BankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        parent::__construct($model);

    }

    public function getPayments($id = null, $params)
    {

        $payments = $this->model()->with(['account', 'invoice', 'attachable']);

        if($params->search) {

            if($id) {
                $payments = $payments->where('invoice_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

                return $payments;
            }

            $payments = $payments->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $payments;
        }

        if($id) {
            $payments = $payments->where('invoice_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $payments;
        }

        $payments = $payments->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $payments;

    }

    public function storePayment($request)
    {

        $data = new $this->model();
        $data->invoice_id = $request->invoice_id;
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->account_id = $request->account_id;
        $data->reference = $request->reference;
        $data->description = $request->description;
        if($data->save()) {

            $params = [
                'account_id' => $request->account_id,
                'status' => 'add',
                'amount' => $request->amount,
            ];

            $this->bankAccountRepository->addAmount(json_decode(json_encode($params)));

            if($request->hasFile('file')) {

                $folder = '/invoice/payment/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\InvoicePayment';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            return $this->model()->with(['account', 'invoice', 'attachable'])->find($data->id);
        }

    }

    public function updatePayment($id, $request)
    {

        $data = $this->model()->find($id);
        $data->invoice_id = $request->invoice_id;
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->account_id = $request->account_id;
        $data->reference = $request->reference;
        $data->description = $request->description;
        if($data->save()) {
            return $this->model()->with(['account', 'invoice', 'attachable'])->find($id);
        }

    }

    public function deletePayment($id)
    {

        $data = $this->model()->find($id);
        if($data) {
            $params = [
                'account_id' => $data->account_id,
                'status' => 'delete',
                'amount' => $data->amount,
            ];

            $this->bankAccountRepository->addAmount(json_decode(json_encode($params)));

            $data->delete();
        }

    }
}
