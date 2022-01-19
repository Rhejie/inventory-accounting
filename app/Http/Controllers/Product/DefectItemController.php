<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DefectItemController extends Controller
{
    public function index()
    {
        return view('product.defect_item.index');
    }
}
