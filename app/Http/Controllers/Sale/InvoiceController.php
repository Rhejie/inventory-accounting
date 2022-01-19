<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('sale.invoice.index');
    }

    public function invoiceDetails(){

    	return view('sale.invoice.details');
    }

}
