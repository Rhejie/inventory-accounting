<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Repositories\Accounting\CustomersRepository;
use Illuminate\Http\Request;

class CustomersController extends Controller
{

    private $customersRepository;

    public function __construct(CustomersRepository $customersRepository)
    {

        $this->customersRepository = $customersRepository;

    }

    public function index()
    {

        return view('accounting.customer.index');

    }



    public function getCustomers(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $services = $this->customersRepository->getCustomers(json_decode(json_encode($params)));

        return response()->json($services, 200);

    }

    public function storeCustomer(Request $request)
    {

        $services = $this->customersRepository->storeCustomer(json_decode(json_encode($request->all())));

        return response()->json($services, 200);

    }

    public function updateCustomer($id, Request $request)
    {

        $services = $this->customersRepository->updateCustomer($id, json_decode(json_encode($request->all())));

        return response()->json($services, 200);

    }

    public function deleteCustomer($id)
    {

        $services = $this->customersRepository->deleteCustomer($id);

        return response()->json($services, 200);

    }

    public function searchCustomer(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $customers = $this->customersRepository->searchCustomers(json_decode(json_encode($params)));

        return response()->json($customers, 200);

    }

    public function findCustomer($id)
    {

        $customer = $this->customersRepository->findCustomer($id);

        return response()->json($customer, 200);

    }
}
