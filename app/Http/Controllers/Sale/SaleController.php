<?php

namespace App\Http\Controllers\Sale;

use App\Models\Sale\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;

class SaleController extends Controller
{

    public function index()
    {
        return view('sale.daily_sales.index');
    }

    public function _load_sales()
    {
        return Sale::get();

    }

    public function store(StoreSaleRequest $request)
    {
        Sale::create([
            "date" =>  $request->date,
            "customer" => $request->customer,
            "clerk" => $request->clerk,
            "amount" => $request->amount
        ]);
    }



}
