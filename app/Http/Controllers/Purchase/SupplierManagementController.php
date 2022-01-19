<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\StoreSupplierCustomeRequest;
use App\Http\Requests\Purchase\UpdateSupplierCustomeRequest;
use App\Repositories\SupplierManagement\SupplierManagementRepository;
use Illuminate\Http\Request;

class SupplierManagementController extends Controller
{

    private $supplierManagementRepository;
    public function __construct(SupplierManagementRepository $supplierManagementRepository)
    {
        $this->supplierManagementRepository = $supplierManagementRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('purchase.supplier_management.index');
    }

    public function getSuppliers(Request $request) {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getSuppliers = $this->supplierManagementRepository->getSuppliers(json_decode(json_encode($params)));

        return response()->json($getSuppliers, 200);

    }

    public function storeSupplier(StoreSupplierCustomeRequest $request)
    {

        $storeSupplier = $this->supplierManagementRepository->storeSupplier($request);

        return response()->json($storeSupplier, 200);

    }

    public function getSupplier($id)
    {

        $getSupplier = $this->supplierManagementRepository->getSupplier($id);

        return response()->json($getSupplier, 200);

    }

    public function updateSupplier($id, UpdateSupplierCustomeRequest $request)
    {

        $updateSupplier = $this->supplierManagementRepository->updateSupplier($id, $request);

        return response()->json($updateSupplier, 200);

    }

    public function deleteSupplier($id)
    {

        $deleteSupplier = $this->supplierManagementRepository->deleteSupplier($id);

        return response()->json($deleteSupplier, 200);

    }

    public function getSuppliersData(Request $request)
    {
        $search = $request->search ? $request->search : '';

        $params = [
            'search' => $search
        ];
        $suppliers = $this->supplierManagementRepository->getSuppliersData(json_decode(json_encode($params)));

        return response()->json($suppliers, 200);

    }
}
