<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\TruckVehicle\StoreTruckVehicleDocumentCustomRequest;
use App\Http\Requests\TruckVehicle\UpdateTruckVehicleDocumentCustomRequest;
use App\Repositories\TruckVehicle\TruckVehicleDocumentRepository;
use Illuminate\Http\Request;

class TruckVehicleDocumentController extends Controller
{

    private $truckVehicleDocumentRepository;

    public function __construct(TruckVehicleDocumentRepository $truckVehicleDocumentRepository)
    {
        $this->truckVehicleDocumentRepository = $truckVehicleDocumentRepository;
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

        $documents = $this->truckVehicleDocumentRepository->getDocuments($id, json_decode(json_encode($params)));

        return response()->json($documents, 200);
    }

    public function storeDocument($id, StoreTruckVehicleDocumentCustomRequest $request)
    {

        $document = $this->truckVehicleDocumentRepository->storeDocument($id, $request);

        return response()->json($document, 200);

    }

    public function updateDocument($id, UpdateTruckVehicleDocumentCustomRequest $request)
    {

        $updateDocument = $this->truckVehicleDocumentRepository->updateDocument($id, $request);

        return response()->json($updateDocument, 200);

    }

    public function deleteDocument($id)
    {

        $delete = $this->truckVehicleDocumentRepository->deleteDocument($id);

        return response()->json($delete, 200);

    }
}
