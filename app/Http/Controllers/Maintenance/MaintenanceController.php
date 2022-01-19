<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Maintenance\StoreMaintenanceRequest;
use App\Http\Requests\Maintenance\UpdateMaintenanceRequest;
use App\Repositories\Maintenance\HeavyEquipmentMaintenanceRepository;
use App\Repositories\Maintenance\MaintenanceTypeRepository;
use App\Repositories\Maintenance\TruckVehicleMaintenanceRepository;
use App\Repositories\Maintenance\OtherMaintenanceRepository;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    private $heavyEquipmentMaintenanceRepository;
    private $maintenanceTypeRepository;
    private $truckVehicleMaintenanceRepository;
    private $otherMaintenanceRepository;

    public function __construct(
            MaintenanceTypeRepository $maintenanceTypeRepository,
            HeavyEquipmentMaintenanceRepository $heavyEquipmentMaintenanceRepository,
            TruckVehicleMaintenanceRepository $truckVehicleMaintenanceRepository,
            OtherMaintenanceRepository $otherMaintenanceRepository)
    {
        $this->heavyEquipmentMaintenanceRepository = $heavyEquipmentMaintenanceRepository;
        $this->maintenanceTypeRepository = $maintenanceTypeRepository;
        $this->truckVehicleMaintenanceRepository = $truckVehicleMaintenanceRepository;
        $this->otherMaintenanceRepository = $otherMaintenanceRepository;
    }

    public function getTypes()
    {

        $types = $this->maintenanceTypeRepository->getTypesData();

        return response()->json($types, 200);

    }

    public function getHeavyMaintenance($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getHeavyEquipmentMaintenance = $this->heavyEquipmentMaintenanceRepository->getMaintenance($id, json_decode(json_encode($params)));

        return response()->json($getHeavyEquipmentMaintenance, 200);

    }

    public function storeHeavyMaintenance(StoreMaintenanceRequest $request)
    {

        $storeHeavyEquipment = $this->heavyEquipmentMaintenanceRepository->storeMaintenance($request);

        return response()->json($storeHeavyEquipment, 200);

    }

    public function deleteHeavyMaintenance($id)
    {

        $delete = $this->heavyEquipmentMaintenanceRepository->deleteMaintenance($id);

        return response()->json($delete, 200);

    }

    public function updateHeavyMaintenance($id, UpdateMaintenanceRequest $request)
    {

        $updateHeavyEquipment = $this->heavyEquipmentMaintenanceRepository->updateMaintenance($id, $request);

        return response()->json($updateHeavyEquipment, 200);

    }

    // truck

    public function getTruckMaintenance($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getHeavyEquipmentMaintenance = $this->truckVehicleMaintenanceRepository->getMaintenance($id, json_decode(json_encode($params)));

        return response()->json($getHeavyEquipmentMaintenance, 200);

    }

    public function storeTruckMaintenance(StoreMaintenanceRequest $request)
    {

        $storeHeavyEquipment = $this->truckVehicleMaintenanceRepository->storeMaintenance($request);

        return response()->json($storeHeavyEquipment, 200);

    }

    public function deleteTruckMaintenance($id)
    {

        $delete = $this->truckVehicleMaintenanceRepository->deleteMaintenance($id);

        return response()->json($delete, 200);

    }

    public function updateTruckMaintenance($id, UpdateMaintenanceRequest $request)
    {

        $updateHeavyEquipment = $this->truckVehicleMaintenanceRepository->updateMaintenance($id, $request);

        return response()->json($updateHeavyEquipment, 200);

    }

    // Other

    public function getOtherMaintenance($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getHeavyEquipmentMaintenance = $this->otherMaintenanceRepository->getMaintenance($id, json_decode(json_encode($params)));

        return response()->json($getHeavyEquipmentMaintenance, 200);

    }

    public function storeOtherMaintenance(StoreMaintenanceRequest $request)
    {

        $storeHeavyEquipment = $this->otherMaintenanceRepository->storeMaintenance($request);

        return response()->json($storeHeavyEquipment, 200);

    }

    public function deleteOtherMaintenance($id)
    {

        $delete = $this->otherMaintenanceRepository->deleteMaintenance($id);

        return response()->json($delete, 200);

    }

    public function updateOtherMaintenance($id, UpdateMaintenanceRequest $request)
    {
        $updateHeavyEquipment = $this->otherMaintenanceRepository->updateMaintenance($id, $request);

        return response()->json($updateHeavyEquipment, 200);

    }
}
