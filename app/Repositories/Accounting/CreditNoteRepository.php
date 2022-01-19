<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Attachment;
use App\Models\Accounting\CreditNote;
use App\Repositories\Repository;

class CreditNoteRepository extends Repository
{

    public function __construct(CreditNote $model)
    {

        parent::__construct($model);

    }

    public function getCredits($params)
    {

        $credits = $this->model()->with(['invoice', 'customer', 'attachable']);

        if($params->search) {

            $credits = $credits->where(function ($query) use ($params) {
                $query->orWhere('amount', 'LIKE', "%$params->search%");
                $query->orWhere('date', 'LIKE', "%$params->search%");
                $query->orWhere('description', 'LIKE', "%$params->search%");
                $query->orWhereHas('invoice', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('ref_number', 'like', "%$params->search%");
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $credits;

        }

        $credits = $credits->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $credits;

    }

    public function storeCredit($request)
    {

        $data = new $this->model();
        $data->invoice_id = $request->invoice_id;
        $data->amount = $request->amount;
        $data->date = $request->date;
        $data->description = $request->description;
        if($data->save()) {

            if($request->hasFile('file')) {

                $folder = '/invoice/credit_note/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\CreditNote';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            return $this->model()->with(['invoice', 'customer', 'attachable'])->find($data->id);

        }
    }

    public function updateCredit($id, $request)
    {

        $invoice_id = $request->invoice_id_id ? $request->invoice_id_id : $request->invoice_id;

        $data = $this->model()->find($id);
        $data->invoice_id = $invoice_id;
        $data->amount = $request->amount;
        $data->date = $request->date;
        $data->description = $request->description;
        if($data->save()) {

            if($request->hasFile('file')) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\CreditNote')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/invoice/credit_note/". $at->file);
                    $at->delete();
                }

                $folder = '/invoice/credit_note/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\CreditNote';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }
            else if( (boolean) $request->remove_file === true) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\CreditNote')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/invoice/credit_note/". $at->file);
                    $at->delete();
                }

            }

            return $this->model()->with(['invoice', 'customer', 'attachable'])->find($data->id);

        }

    }

    public function deleteCredit($id)
    {

        $credit = $this->model()->find($id);
        if(!empty($credit)) {
            $credit->delete();
        }

    }

    public function getCreditNotes($id, $params)
    {

        $credits = $this->model()->with(['invoice', 'customer', 'attachable']);

        if($params->search) {

            $credits = $credits->where(function ($query) use ($params) {
                $query->orWhere('amount', 'LIKE', "%$params->search%");
                $query->orWhere('date', 'LIKE', "%$params->search%");
                $query->orWhere('description', 'LIKE', "%$params->search%");
            })->where('invoice_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $credits;

        }

        $credits = $credits->where('invoice_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $credits;

    }

}
