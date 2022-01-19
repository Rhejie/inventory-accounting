<?php

namespace App\Http\Controllers\PointOfSale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        return view('point_of_sale.cashier.index');
    }
}
