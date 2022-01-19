<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\AttachmentCustomRequest;
use App\Repositories\Accounting\AttachmentRepository;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    private $attachmentRepository;
    public function __construct(AttachmentRepository $attachmentRepository) {

        $this->attachmentRepository = $attachmentRepository;

    }

    public function getAttachments(Request $request) {

        $attachable_id = $request->attachable_id ? $request->attachable_id : null;
        $type = $request->type ? $request->type : null;

        $params = [
            'attachable_id' => $attachable_id,
            'type' => $type,
        ];
        $attachments = $this->attachmentRepository->getAttachments(json_decode(json_encode($params)));

        return response()->json($attachments, 200);

    }

    public function storeAttachment(AttachmentCustomRequest $request)
    {

        $attach = $this->attachmentRepository->storeAttachment($request);

        return response()->json($attach, 200);

    }

    public function deleteAttachment($id, Request $request) {

        $type = $request->type ? $request->type : null;

        $params = [
            'type' => $type,
            'id' => $id,
        ];

        $attach = $this->attachmentRepository->deleteAttachment(json_decode(json_encode($params)));

        return response()->json($attach, 200);

    }

    public function viewAttachment(Request $request) {
        $file = $request->file;
        $path= $request->path;

        return view('attachment.view_attachment', compact(['file', 'path']));
    }
}
