<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Repositories\JobOrder\JobOrderTypeRepository;
use App\Repositories\Maintenance\MaintenanceTypeRepository;
use App\Repositories\Project\ProjectStatusRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $jobOrderTypeRepository;
    private $maintenanceTypeRepository;
    private $projectStatusRepository;
    public function __construct(
            JobOrderTypeRepository $jobOrderTypeRepository,
            MaintenanceTypeRepository $maintenanceTypeRepository,
            ProjectStatusRepository $projectStatusRepository)
    {
        $this->jobOrderTypeRepository = $jobOrderTypeRepository;
        $this->maintenanceTypeRepository = $maintenanceTypeRepository;
        $this->projectStatusRepository = $projectStatusRepository;

    }

    public function index()
    {

        return view('setting.project_status');

    }

    public function maintenanceType()
    {

        return view('setting.maintenance_type');

    }

    public function jobOrderType()
    {

        return view('setting.job_order_type');

    }

    public function getJobOrderType(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $jobOrderTypes = $this->jobOrderTypeRepository->getTypes(json_decode(json_encode($params)));

        return response()->json($jobOrderTypes, 200);

    }

    public function storeJobOrderType(Request $request)
    {

        $storeJobOrdertype = $this->jobOrderTypeRepository->storeType(json_decode(json_encode($request->all())));

        return response()->json($storeJobOrdertype, 200);

    }

    public function updateJobOrderType($id, Request $request)
    {

        $updateJobOrderType = $this->jobOrderTypeRepository->updateType($id, json_decode(json_encode($request->all())));

        return response()->json($updateJobOrderType, 200);

    }

    public function deleteJobOrderType($id)
    {

        $deleteJobOrderType = $this->jobOrderTypeRepository->deleteType($id);

        return response()->json($deleteJobOrderType, 200);

    }

    public function getMaintenanceType(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getMaintenanceType = $this->maintenanceTypeRepository->getTypes(json_decode(json_encode($params)));

        return response()->json($getMaintenanceType, 200);

    }

    public function storeMaintenanceType(Request $request)
    {

        $storetype = $this->maintenanceTypeRepository->storeType(json_decode(json_encode($request->all())));

        return response()->json($storetype, 200);

    }

    public function updateMaintenanceType($id, Request $request)
    {

        $updateStore = $this->maintenanceTypeRepository->updateType($id, json_decode(json_encode($request->all())));

        return response()->json($updateStore, 200);

    }

    public function deleteMaintenanceType($id)
    {

        $deleteMaintenanceType = $this->maintenanceTypeRepository->deleteType($id);

        return response()->json($deleteMaintenanceType, 200);

    }

    public function getProjectStatus(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getMaintenanceType = $this->projectStatusRepository->getStatus(json_decode(json_encode($params)));

        return response()->json($getMaintenanceType, 200);

    }

    public function storeProjectStatus(Request $request)
    {

        $storetype = $this->projectStatusRepository->storeStatus(json_decode(json_encode($request->all())));

        return response()->json($storetype, 200);

    }

    public function updateProjectStatus($id, Request $request)
    {

        $updateStore = $this->projectStatusRepository->updateStatus($id, json_decode(json_encode($request->all())));

        return response()->json($updateStore, 200);

    }

    public function deleteProjectStatus($id)
    {

        $deleteMaintenanceType = $this->projectStatusRepository->deleteStatus($id);

        return response()->json($deleteMaintenanceType, 200);

    }

    public function billOfMaterial()
    {

        return view('bill_of_material.index');

    }
}
