<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Attachment;
use App\Models\Accounting\Payment;
use App\Repositories\Repository;

class PaymentRepository extends Repository {

    private $bankAccountRepository;

    public function __construct(Payment $model, BankAccountRepository $bankAccountRepository) {

        $this->bankAccountRepository = $bankAccountRepository;

        parent::__construct($model);

    }

    public function getPayments($params)
    {

        $payments = $this->model()->with(['supplier', 'account', 'attachable', 'project', 'customer']);

        if($params->search) {

            $payments = $payments->where(function ($query) use ($params) {
                $query->orWhere('date', 'LIKE', "%$params->search%");
                $query->orWhere('amount', 'LIKE', "%$params->search%");
                $query->orWhere('reference', 'LIKE', "%$params->search%");
                $query->orWhere('description', 'LIKE', "%$params->search%");
                $query->orWhereHas('supplier', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
                $query->orWhereHas('account', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->orWhere('holder_name', 'like', "%$params->search%");
                        $query3->orWhere('bank_name', 'like', "%$params->search%");
                    });
                });
                $query->orWhereHas('project', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
                $query->orWhereHas('customer', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $payments;

        }

        $payments = $payments->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $payments;

    }

    public function storePayment($request)
    {

        $data = new $this->model();
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->account_id = $request->account_id;
        $data->supplier_id = $request->supplier_id;
        $data->project_id = $request->project_id;
        $data->customer_id = $request->customer_id;
        $data->description = $request->description;
        $data->reference = $request->reference;

        if($data->save()) {

            $params = [
                'amount' => $data->amount,
                'account_id' => $data->account_id
            ];

            $account = $this->bankAccountRepository->payBill(json_decode(json_encode($params)));

            if($account == 'insufficient') {
                return ;
            }

            if($request->hasFile('file')) {

                $folder = '/bill/payment_direct/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\Payment';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            return $this->model()->with(['supplier', 'account', 'attachable', 'project', 'customer'])->find($data->id);

        }

    }

    public function updatePayment($id, $request)
    {

        $account_id = $request->account_id_id ? $request->account_id_id : $request->account_id;
        $supplier_id = $request->supplier_id_id ? $request->supplier_id_id : $request->supplier_id;
        $customer_id = $request->customer_id_id ? $request->customer_id_id : $request->customer_id;
        $project_id = $request->project_id_id ? $request->project_id_id : $request->project_id;

        $data = $this->model()->find($id);

        if($account_id != $data->account_id) {

            $params = [
                'prev_account_id' => $data->account_id,
                'new_account_id' => $account_id,
                'prev_amount' => $data->amount,
                'new_amount' => $request->amount
            ];

            $account = $this->bankAccountRepository->updatePayBillChangeAccount(json_decode(json_encode($params)));

            if($account == 'insufficient') {
                return 'insufficient';
            }
        }

        else {

            $params = [
                'account_id' => $account_id,
                'prev_amount' => $data->amount,
                'new_amount' => $request->amount
            ];

            $account = $this->bankAccountRepository->updatePayBillAccount(json_decode(json_encode($params)));

            if($account == 'insufficient') {
                return 'insufficient';
            }

        }

        $data->account_id = $account_id;
        $data->supplier_id = $supplier_id;
        $data->project_id = $project_id;
        $data->customer_id = $customer_id;
        $data->amount = $request->amount;
        $data->date = $request->date;
        $data->description = $request->description;
        $data->reference = $request->reference;

        if($data->save()) {

            if($request->hasFile('file')) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\Payment')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/bill/payment_direct/". $at->file);
                    $at->delete();
                }

                $folder = '/bill/payment_direct/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\Payment';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            else if( (boolean) $request->remove_file === true) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\Payment')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/bill/payment_direct/". $at->file);
                    $at->delete();
                }

            }

            return $this->model()->with(['supplier', 'account', 'attachable', 'project', 'customer'])->find($id);
        }
    }

    public function deletePayment($id)
    {

        $data = $this->model()->find($id);

        if($data) {

            $params = [
                'amount' => $data->amount,
                'account_id' => $data->account_id
            ];

            $this->bankAccountRepository->deletePaymentBill(json_decode(json_encode($params)));

            $data->delete();
        }

    }

}
