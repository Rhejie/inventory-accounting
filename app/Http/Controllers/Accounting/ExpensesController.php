<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function __construct()
    {


    }

    public function bill()
    {

        return view('accounting.expenses.bill');

    }

    public function payment()
    {

        return view('accounting.expenses.payment');

    }

    public function debitNote()
    {

        return view('accounting.expenses.debit_note');

    }
}
