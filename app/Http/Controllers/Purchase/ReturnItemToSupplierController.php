<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReturnItemToSupplierController extends Controller
{
    public function index()
    {
        return view('purchase.return_item_to_supplier.index');
    }
}
