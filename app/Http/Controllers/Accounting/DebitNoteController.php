<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\DebitNoteCustomeRequest;
use App\Http\Requests\Accounting\UpdateDebitNoteCustomeRequest;
use App\Repositories\Accounting\DebitNoteRepository;
use Illuminate\Http\Request;

class DebitNoteController extends Controller
{
    private $debitNoteRepository;

    public function __construct(DebitNoteRepository $debitNoteRepository) {

        $this->debitNoteRepository = $debitNoteRepository;

    }

    public function getNotes($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $id = $id ? $id : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $notes = $this->debitNoteRepository->getNotes($id, json_decode(json_encode($params)));

        return response()->json($notes, 200);

    }

    public function storeNote(DebitNoteCustomeRequest $request)
    {

        $note = $this->debitNoteRepository->storeNote($request);

        return response()->json($note, 200);

    }

    public function updateNote($id, UpdateDebitNoteCustomeRequest $request)
    {

        $note = $this->debitNoteRepository->updateNote($id, $request);

        return response()->json($note, 200);

    }

    public function deleteNote($id)
    {

        $note = $this->debitNoteRepository->deleteNote($id);

        return response()->json($note, 200);

    }
}
