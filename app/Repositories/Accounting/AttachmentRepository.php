<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Attachment;
use App\Repositories\Repository;

class AttachmentRepository extends Repository
{

    public function __construct(Attachment $model) {

        parent::__construct($model);

    }

    public function getAttachments($params) {

        $attachments = $this->model()->with(['attachable']);

        if($params->type) {

            if($params->type == 'bill_item') {
                $attachable_type = 'App\Models\Accounting\BillItem';
            }
            else if ($params->type == 'bill') {
                $attachable_type = 'App\Models\Accounting\Bill';
            }
            else if ($params->type == 'invoice_item') {
                $attachable_type = 'App\Models\Accounting\InvoiceItem';
            }
            else if ($params->type == 'invoice') {
                $attachable_type = 'App\Models\Accounting\Invoice';
            }
            else if ($params->type == 'proposal') {
                $attachable_type = 'App\Models\Accounting\Proposal';
            }
            else if ($params->type == 'proposal_item') {
                $attachable_type = 'App\Models\Accounting\ProposalItem';
            }

            $attachments = $attachments->where('attachable_type', $attachable_type)->where('attachable_id', $params->attachable_id);

            return $attachments->get();

        }

        return $attachments->get();

    }

    public function storeAttachment($request) {
        $data = new $this->model();
        if($request->hasFile('file')) {

            if($request->type == 'bill_item') {
                $folder = "/bill/bill_item/";
                $attachable_type = 'App\Models\Accounting\BillItem';
            }
            else if ($request->type == 'bill') {
                $folder = "/bill/";
                $attachable_type = 'App\Models\Accounting\Bill';
            }
            else if($request->type == 'invoice_item') {
                $folder = "/invoice/item/";
                $attachable_type = 'App\Models\Accounting\InvoiceItem';
            }
            else if($request->type == 'invoice') {
                $folder = "/invoice/";
                $attachable_type = 'App\Models\Accounting\Invoice';
            }
            else if($request->type == 'proposal') {
                $folder = "/proposal/";
                $attachable_type = 'App\Models\Accounting\Proposal';
            }
            else if($request->type == 'proposal_item') {
                $folder = "/proposal/item/";
                $attachable_type = 'App\Models\Accounting\ProposalItem';
            }

            $media = $request->file('file');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');


            $data->attachable_type = $attachable_type;
            $data->attachable_id = $request->attachment_id;
            $data->file = $name;
            $data->file_name = $request->file_name;
            $data->path = $folder;
            if($data->save()) {
                return $this->model()->with(['attachable'])->find($data->id);
            }

        }
    }

    public function deleteAttachment($params) {

        $data = $this->model()->find($params->id);
        if($data) {
            if($params->type == 'bill_item') {
                $folder = "/bill/bill_item/";
            }
            else if ($params->type == 'bill') {
                $folder = "/bill/";
            }
            else if ($params->type == 'proposal_item') {
                $folder = "/proposal/item/";
            }
            else if ($params->type == 'proposal') {
                $folder = "/proposal/";
            }
            else if ($params->type == 'invoice_item') {
                $folder = "/invoice/item/";
            }
            else if ($params->type == 'invoice') {
                $folder = "/invoice/";
            }
            if($params->type) {

                \Storage::disk('public')->delete($folder. $data->file);
                $data->delete();
            }
        }


    }

}
