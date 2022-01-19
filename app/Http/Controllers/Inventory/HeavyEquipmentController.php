<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeavyEquipment\AddEquipmentDocumentCustomRequest;
use App\Http\Requests\HeavyEquipment\HeavyEquipmentCustomRequest;
use App\Http\Requests\HeavyEquipment\UpdateDocumentCustomRequest;
use App\Http\Requests\HeavyEquipment\UpdateEquipmentCustomRequest;
use App\Http\Requests\HeavyEquipment\UpdateHeavyEquipmentDocumentCustomRequest;
use App\Models\Inventory\AssetCategory;

use App\Repositories\HeavyEquipment\HeavyEquipmentRepository;
use App\Http\Requests\StoreEquipmentRequest;
use  Carbon\Carbon;
use Crypt;
use Illuminate\Http\Request;

class HeavyEquipmentController extends Controller
{
   //
    private $heavyEquipmentRepository;

    public function __construct(HeavyEquipmentRepository $heavyEquipmentRepository )
    {

        $this->middleware('auth');
        $this->heavyEquipmentRepository = $heavyEquipmentRepository;
    }



    public function showList(HeavyEquipmentRepository $equipmentRepository){

        $query = $equipmentRepository->model();

    	return datatables($query)
                ->addIndexColumn()
                ->addColumn('asset_category_id', function($row){

                	$catName = AssetCategory::find($row->asset_category_id);
                    return $catName->name;

                })
                ->addColumn('action', function($row){
                    $btn = '';

                     $btn = $btn . '<div class="btn-group " role="group" aria-label="" >';
                     $btn = $btn . '<a  href="/inventory/heavy/equipment/'. Crypt::encrypt($row->id) .'"  class="btn flaticon2-eye"><i class="far fa-eye"></i> view</a> ';
                    // $btn = $btn . '<a  onClick="editDoctor('.$row->id.')"   class="btn flaticon2-edit postbutton" data-toggle="modal" data-target="#editDoctorDialog" ></a> ';

                    $btn = $btn . '<button  class="btn flaticon2-trash" > Delete</button>';

                        return $btn;
                })
                ->rawColumns(['action','checkbox'])
                ->make(true);

    }


     public function addEquipment(StoreEquipmentRequest $request, HeavyEquipmentRepository $equipmentRepository){

    	 $data = $equipmentRepository->store($request);
         return back()->with('success', $data);
    }



    public function displayEquipment($id, HeavyEquipmentRepository $equipmentRepository){


    	 $eid = Crypt::decrypt($id);

    	 $equipment = $equipmentRepository->show($eid);

    	 return view('inventory.display_equipment', compact('equipment'));

    }
    // updated

    public function heavyEquipmentIndex() {

        $AssetCategory = AssetCategory::All();
        return view('inventory.heavy_equipment', compact('AssetCategory'));

    }

    public function storeEquipment(HeavyEquipmentCustomRequest $request) {

        $storeEquipment = $this->heavyEquipmentRepository->storeEquipment($request);

        return response()->json($storeEquipment, 200);

    }

    public function getEquipments(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getEquipments = $this->heavyEquipmentRepository->getEquipments(json_decode(json_encode($params)));

        return response()->json($getEquipments, 200);

    }

    public function getEquipmentInfo($id) {

        $equipmentInfo = $this->heavyEquipmentRepository->getEquipmentInfo($id);

        return response()->json($equipmentInfo, 200);

    }

    public function storeEquipmentDocument($id, AddEquipmentDocumentCustomRequest $request)
    {

        $equipementDocument = $this->heavyEquipmentRepository->storeEquipmentDocument($id, $request);

        return response()->json($equipementDocument, 200);

    }

    public function getEquipmentDocuments($id, Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $documents = $this->heavyEquipmentRepository->getEquipmentDocuments($id, json_decode(json_encode($params)));

        return response()->json($documents, 200);
    }

    public function updateEquipment($id, UpdateEquipmentCustomRequest $request) {

        $updatedEquipment = $this->heavyEquipmentRepository->updateEquipment($id, $request);

        return response()->json($updatedEquipment, 200);
    }

    public function downloadEquipment($data)
    {
        $myFile = storage_path("app\\public\\heavy_equipments\\documents\\". $data);

    	return response()->download($myFile);
    }

    public function viewDocument(Request $request)
    {

        $file = $request->file;

        return view('inventory.view-heavy-equipment-document', compact('file'));

    }

    public function viewAttachment(Request $request)
    {

        $file = $request->file;

        return view('inventory.view_heavy_maintenance_attachment', compact('file'));

    }

    public function updateDocument($id, UpdateHeavyEquipmentDocumentCustomRequest $request)
    {
        $updateDocument = $this->heavyEquipmentRepository->updateDocument($id, $request);

        return response()->json($updateDocument, 200);
    }

    public function deleteDocument($id)
    {
        $deleteDocument = $this->heavyEquipmentRepository->deleteDocument($id);

        return response()->json($deleteDocument, 200);
    }

    public function deleteEquipment($id)
    {
        $deleteEquipment = $this->heavyEquipmentRepository->deleteEquipment($id);

        return response()->json($deleteEquipment, 200);
    }

    public function getEquipmentHistory($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getHistory = $this->heavyEquipmentRepository->getLocationHistory($id, json_decode(json_encode($params)));

        return response()->json($getHistory, 200);

    }

    public function returnToWarehouse(Request $request)
    {

        $return = $this->heavyEquipmentRepository->returnToWarehouse(json_decode(json_encode($request->all())));

        return response()->json($return, 200);

    }
}
