<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Repositories\Accounting\ServicesRepository;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    private $servicesRepository;

    public function __construct(ServicesRepository $servicesRepository)
    {

        $this->servicesRepository = $servicesRepository;

    }

    public function index()
    {

        return view('accounting.services.index');

    }

    public function getServices(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $services = $this->servicesRepository->getServices(json_decode(json_encode($params)));

        return response()->json($services, 200);

    }

    public function storeService(Request $request)
    {

        $services = $this->servicesRepository->storeService(json_decode(json_encode($request->all())));

        return response()->json($services, 200);

    }

    public function updateService($id, Request $request)
    {

        $services = $this->servicesRepository->updateService($id, json_decode(json_encode($request->all())));

        return response()->json($services, 200);

    }

    public function deleteService($id)
    {

        $services = $this->servicesRepository->deleteService($id);

        return response()->json($services, 200);

    }

    public function searchService(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $services = $this->servicesRepository->searchService(json_decode(json_encode($params)));

        return response()->json($services, 200);

    }
}
