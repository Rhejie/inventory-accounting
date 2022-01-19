<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        return view('product.stock_adjustment.index');
    }
}
