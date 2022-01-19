<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\OtherInventory\StoreDocumentCustomRequest;
use App\Http\Requests\OtherInventory\UpdateOtherInventoryDocumentCustomRequest;
use App\Repositories\OtherInventory\OtherInventoryDocumentRepository;
use Illuminate\Http\Request;

class OtherAssetDocumentController extends Controller
{
    private $otherInventoryDocumentRepository;

    public function __construct(OtherInventoryDocumentRepository $otherInventoryDocumentRepository)
    {
        $this->otherInventoryDocumentRepository = $otherInventoryDocumentRepository;

        $this->middleware('auth');
    }

    public function getDocuments($id, Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $documents = $this->otherInventoryDocumentRepository->getDocuments($id, json_decode(json_encode($params)));

        return response()->json($documents, 200);
    }

    public function storeDocument($id, StoreDocumentCustomRequest $request)
    {

        $document = $this->otherInventoryDocumentRepository->storeDocument($id, $request);

        return response()->json($document, 200);

    }

    public function updateDocument($id, UpdateOtherInventoryDocumentCustomRequest $request)
    {
        $updatedDoucment = $this->otherInventoryDocumentRepository->updateDocument($id, $request);

        return response()->json($updatedDoucment, 200);
    }

    public function viewDocument(Request $request)
    {

        $file = $request->file;

        return view('inventory.view-other-inventory-document', compact('file'));

    }

    public function deleteDocument($id)
    {

        $delete = $this->otherInventoryDocumentRepository->deleteDocument($id);

        return response()->json($delete, 200);

    }
}
