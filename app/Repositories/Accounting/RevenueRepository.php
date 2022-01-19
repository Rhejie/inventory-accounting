<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Attachment;
use App\Models\Accounting\Revenue;
use App\Repositories\Repository;

class RevenueRepository extends Repository
{
    private $bankAccountRepository;
    public function __construct(Revenue $model, BankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        parent::__construct($model);

    }

    public function getRevenues($params)
    {

        $revenues = $this->model()->with(['account', 'customer', 'attachable', 'project']);

        if($params->search) {

            $revenues = $revenues->where(function($query) use ($params) {
                $query->orWhere('amount', 'LIKE', "%$params->search%");
                $query->orWhere('date', 'LIKE', "%$params->search%");
                $query->orWhere('reference', 'LIKE', "%$params->search%");
                $query->orWhere('description', 'LIKE', "%$params->search%");
                $query->orWhereHas('account', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->orWhere('bank_name', 'like', "%$params->search%");
                        $query3->orWhere('holder_name', 'like', "%$params->search%");
                    });
                });
                $query->orWhereHas('customer', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
                $query->orWhereHas('project', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $revenues;
        }

        $revenues = $revenues->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $revenues;

    }

    public function storeRevenue($request)
    {

        $data = new $this->model();
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->account_id = $request->account_id;
        $data->customer_id = $request->customer_id;
        $data->reference = $request->reference;
        $data->description = $request->description;
        $data->project_id = $request->project_id;
        if($data->save()) {

            $params = [
                'account_id' => $request->account_id,
                'status' => 'add',
                'amount' => $request->amount,
            ];

            $this->bankAccountRepository->addAmount(json_decode(json_encode($params)));

            if($request->hasFile('file')) {

                $folder = '/revenue/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\Revenue';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            return $this->model()->with(['account', 'customer', 'attachable', 'project'])->find($data->id);

        }

    }

    public function updateRevenue($id, $request)
    {
        $account_id = $request->account_id_id ? $request->account_id_id : $request->account_id;
        $customer_id = $request->customer_id_id ? $request->customer_id_id : $request->customer_id;
        $project_id = $request->project_id_id ? $request->project_id_id : $request->project_id;

        $data = $this->model()->find($id);

        $prev = $data->amount;

        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->account_id = $account_id;
        $data->customer_id = $customer_id;
        $data->reference = $request->reference;
        $data->description = $request->description;
        $data->project_id = $project_id;
        if($data->save()) {

            $params = [
                'account_id' => $account_id,
                'status' => 'update',
                'amount' => $request->amount,
                'previous_amount' => $prev
            ];

            $this->bankAccountRepository->addAmount(json_decode(json_encode($params)));

            if($request->hasFile('file')) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\Revenue')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/revenue/". $at->file);
                    $at->delete();
                }

                $folder = '/revenue/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\Revenue';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            else if($request->remove_file) {
                $at = Attachment::where('attachable_type', 'App\Models\Accounting\Revenue')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/revenue/". $at->file);
                    $at->delete();
                }
            }

            return $this->model()->with(['account', 'customer', 'attachable', 'project'])->find($id);

        }

    }

    public function deleteRevenue($id)
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
