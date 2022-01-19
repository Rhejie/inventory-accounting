<?php

namespace App\Http\Controllers\JobOrder;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobOrder\StoreHeavyEquipmentJobOrder;
use App\Http\Requests\JobOrder\UpdateHeavyEquipmentJobOrder;
use App\Repositories\JobOrder\HeavyEquipmentJobOrderRepository;
use App\Repositories\JobOrder\JobOrderTypeRepository;
use App\Repositories\JobOrder\OtherOrderRepository;
use App\Repositories\JobOrder\TruckJobOrderRepository;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{

    private $jobOrderTypeRepository;
    private $heavyEquipmentJobOrderRepository;
    private $truckJobOrderRepository;
    private $otherOrderRepository;

    public function __construct(
            JobOrderTypeRepository $jobOrderTypeRepository,
            HeavyEquipmentJobOrderRepository $heavyEquipmentJobOrderRepository,
            TruckJobOrderRepository $truckJobOrderRepository,
            OtherOrderRepository $otherOrderRepository)
    {
        $this->jobOrderTypeRepository = $jobOrderTypeRepository;
        $this->heavyEquipmentJobOrderRepository = $heavyEquipmentJobOrderRepository;
        $this->truckJobOrderRepository = $truckJobOrderRepository;
        $this->otherOrderRepository = $otherOrderRepository;
    }

    public function getTypes()
    {

        $types = $this->jobOrderTypeRepository->getTypesData();

        return response()->json($types, 200);

    }

    public function getHeavyJobOrders($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $jobOrders = $this->heavyEquipmentJobOrderRepository->getJobOrder($id, json_decode(json_encode($params)));

        return response()->json($jobOrders, 200);

    }

    public function storeHeavyJobOrder(StoreHeavyEquipmentJobOrder $request)
    {

        $storeHeavyEquipment = $this->heavyEquipmentJobOrderRepository->storeJobOrder($request);

        return response()->json($storeHeavyEquipment, 200);

    }

    public function deleteHeavyJobOrder($id)
    {

        $delete = $this->heavyEquipmentJobOrderRepository->deleteJobOrder($id);

        return response()->json($delete, 200);

    }

    public function updateHeavyJobOrder($id, UpdateHeavyEquipmentJobOrder $request)
    {

        $jobOrder = $this->heavyEquipmentJobOrderRepository->updateJobOrder($id, $request);

        return response()->json($jobOrder, 200);

    }

    // Truck Vehicle



    public function getTruckJobOrders($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $jobOrders = $this->truckJobOrderRepository->getJobOrder($id, json_decode(json_encode($params)));

        return response()->json($jobOrders, 200);

    }

    public function storeTruckJobOrder(StoreHeavyEquipmentJobOrder $request)
    {

        $storeHeavyEquipment = $this->truckJobOrderRepository->storeJobOrder($request);

        return response()->json($storeHeavyEquipment, 200);

    }

    public function deleteTruckJobOrder($id)
    {

        $delete = $this->truckJobOrderRepository->deleteJobOrder($id);

        return response()->json($delete, 200);

    }

    public function updateTruckJobOrder($id, UpdateHeavyEquipmentJobOrder $request)
    {

        $jobOrder = $this->truckJobOrderRepository->updateJobOrder($id, $request);

        return response()->json($jobOrder, 200);

    }

    // other

    public function getOtherJobOrders($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $jobOrders = $this->otherOrderRepository->getJobOrder($id, json_decode(json_encode($params)));

        return response()->json($jobOrders, 200);

    }

    public function storeOtherJobOrder(StoreHeavyEquipmentJobOrder $request)
    {

        $storeHeavyEquipment = $this->otherOrderRepository->storeJobOrder($request);

        return response()->json($storeHeavyEquipment, 200);

    }

    public function deleteOtherJobOrder($id)
    {

        $delete = $this->otherOrderRepository->deleteJobOrder($id);

        return response()->json($delete, 200);

    }

    public function updateOtherJobOrder($id, UpdateHeavyEquipmentJobOrder $request)
    {

        $jobOrder = $this->otherOrderRepository->updateJobOrder($id, $request);

        return response()->json($jobOrder, 200);

    }
}
