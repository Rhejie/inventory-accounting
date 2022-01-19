<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomesController extends Controller
{
    public function __construct()
    {



    }

    public function invoice()
    {

        return view('accounting.income.invoice');

    }

    public function revenue()
    {

        return view('accounting.income.revenue');

    }

    public function creditNote()
    {

        return view('accounting.income.credit_note');

    }
}
