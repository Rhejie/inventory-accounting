<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\TruckVehicle\StoreTruckVehicleCustomRequest;
use App\Http\Requests\TruckVehicle\UpdateTruckVehcileCustomRequest;
use App\Models\Inventory\AssetCategory;
use App\Repositories\TruckVehicle\TruckVehicleRepository;
use App\Repositories\VehicleRepository;
use Crypt;
class VehicleController extends Controller
{
    private $truckVehicleRepository;

    public function __construct(TruckVehicleRepository $truckVehicleRepository)
    {
        $this->truckVehicleRepository = $truckVehicleRepository;

        $this->middleware('auth');
    }

    public function index()
    {
        $AssetCategory = AssetCategory::All();

        return view('inventory.vehicle',compact('AssetCategory'));
    }

    public function getTrucksVehicles(Request $request) {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $trucksVehicles = $this->truckVehicleRepository->getTrucksVehicles(json_decode(json_encode($params)));

        return response()->json($trucksVehicles, 200);

    }

    public function storeTruckVehicle(StoreTruckVehicleCustomRequest $request)
    {
        $storeTruckVehicle = $this->truckVehicleRepository->storeTruckVehicle($request);

        return response()->json($storeTruckVehicle, 200);
    }

    public function getTruckVehicleInfo($id)
    {
        $info = $this->truckVehicleRepository->getTruckVehicleInfo($id);

        return response()->json($info, 200);
    }

    public function updateTruckVehicle($id, UpdateTruckVehcileCustomRequest $request)
    {
        $updatedInfo = $this->truckVehicleRepository->updateTruckVehicle($id, $request);

        return response()->json($updatedInfo, 200);
    }

    public function viewDocument(Request $request)
    {

        $file = $request->file;

        return view('inventory.view-truck-vehicle-document', compact('file'));

    }

    public function viewAttachment(Request $request)
    {

        $file = $request->file;
        $file_name = $request->file_name;

        return view('inventory.view_vehicle_maintenance_attachment', compact('file', 'file_name'));

    }

    public function deleteTruckVehicle($id)
    {

        $delete = $this->truckVehicleRepository->deleteTruckVehicle($id);

        return response()->json($delete, 200);

    }

    public function getLocationHistory($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getHistory = $this->truckVehicleRepository->getLocationHistory($id, json_decode(json_encode($params)));

        return response()->json($getHistory, 200);

    }

}
