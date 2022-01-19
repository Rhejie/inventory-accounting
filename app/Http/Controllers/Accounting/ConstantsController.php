<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Repositories\Accounting\TaxesRepository;
use App\Repositories\Accounting\UnitRepository;
use Illuminate\Http\Request;

class ConstantsController extends Controller
{
    private $taxesRepository;
    private $unitRepository;
    public function __construct(TaxesRepository $taxesRepository, UnitRepository $unitRepository) {
        $this->taxesRepository = $taxesRepository;
        $this->unitRepository = $unitRepository;
    }

    public function taxes()
    {

        return view('accounting.constant.taxes');

    }

    public function category()
    {

        return view('accounting.constant.category');

    }

    public function unit()
    {

        return view('accounting.constant.unit');

    }

    public function getTaxes(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $taxes = $this->taxesRepository->getTaxes(json_decode(json_encode($params)));

        return response()->json($taxes, 200);

    }

    public function storeTax(Request $request)
    {

        $tax = $this->taxesRepository->storeTax(json_decode(json_encode($request->all())));

        return response()->json($tax, 200);

    }

    public function updateTax($id, Request $request)
    {

        $tax = $this->taxesRepository->updateTax($id, json_decode(json_encode($request->all())));

        return response()->json($tax, 200);

    }

    public function deleteTax($id)
    {

        $tax = $this->taxesRepository->deleteTax($id);

        return response()->json($tax, 200);

    }

    public function selectTax(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $taxes = $this->taxesRepository->selectTax(json_decode(json_encode($params)));

        return response()->json($taxes, 200);

    }

    public function getUnits(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $units = $this->unitRepository->getUnits(json_decode(json_encode($params)));

        return response()->json($units, 200);

    }

    public function storeUnit(Request $request)
    {

        $unit = $this->unitRepository->storeUnit(json_decode(json_encode($request->all())));

        return response()->json($unit, 200);

    }

    public function updateUnit($id, Request $request)
    {

        $unit = $this->unitRepository->updateUnit($id, json_decode(json_encode($request->all())));

        return response()->json($unit, 200);

    }

    public function deleteUnit($id)
    {

        $unit = $this->unitRepository->deleteUnit($id);

        return response()->json($unit, 200);

    }

    public function selectUnit(Request $request)
    {

        $search = $request->search ? $request->search : null;

        $params = [
            'search' => $search
        ];

        $units = $this->unitRepository->selectUnit(json_decode(json_encode($params)));

        return response()->json($units, 200);

    }
}
