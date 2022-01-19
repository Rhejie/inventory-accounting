<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Attachment;
use App\Models\Accounting\DebitNote;
use App\Repositories\Repository;


class DebitNoteRepository extends Repository
{

    public function __construct(DebitNote $model)
    {

        parent::__construct($model);

    }

    public function getNotes($id = null,$params)
    {

        $notes = $this->model()->with(['bill', 'supplier', 'attachable']);

        if($params->search) {

            if($id != 0) {
                $notes = $notes->where('bill_id', $id);
            }

            $notes = $notes->where(function ($query) use ($params) {
                $query->orWhere('date', 'LIKE', "%$params->search%");
                $query->orWhere('amount', 'LIKE', "%$params->search%");
                $query->orWhere('description', 'LIKE', "%$params->search%");
                $query->orWhereHas('supplier', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('name', 'like', "%$params->search%");
                    });
                });
                $query->orWhereHas('bill', function($query2) use ($params) {
                    $query2->where(function($query3) use ($params) {
                        $query3->where('bill_number', 'like', "%$params->search%");
                    });
                });
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $notes;

        }

        if($id != 0) {
            $notes = $notes->where('bill_id', $id);
        }

        $notes = $notes->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $notes;

    }

    public function storeNote($request)
    {
        $bill_id = $request->bill_id_id ? $request->bill_id_id : $request->bill_id;
        $data = new $this->model();
        $data->bill_id = $bill_id;
        $data->supplier_id = $request->supplier_id;
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->description = $request->description;

        if($data->save()) {

            if($request->hasFile('file')) {

                $folder = '/bill/debit_note/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\DebitNote';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            return $this->model()->with(['bill', 'supplier', 'attachable'])->find($data->id);
        }

    }

    public function updateNote($id, $request)
    {
        $bill_id = $request->bill_id_id ? $request->bill_id_id : $request->bill_id;

        $data = $this->model()->find($id);
        $data->bill_id = $bill_id;
        $data->supplier_id = $request->supplier_id;
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->description = $request->description;
        if($data->save()) {

            if($request->hasFile('file')) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\DebitNote')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/bill/debit_note/". $at->file);
                    $at->delete();
                }

                $folder = '/bill/debit_note/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\DebitNote';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            else if($request->remove_file) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\DebitNote')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/bill/debit_note/". $at->file);
                    $at->delete();
                }

            }

            return $this->model()->with(['bill', 'supplier', 'attachable'])->find($id);
        }

    }

    public function deleteNote($id)
    {

        $data = $this->model()->find($id);
        if($data) {
            $data->delete();
        }

    }

}
