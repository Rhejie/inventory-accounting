<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {


    }

    public function transactions()
    {

        return view('accounting.report.transaction');

    }

    public function accountStatement()
    {

        return view('accounting.report.account_statement');

    }

    public function incomeSummary()
    {

        return view('accounting.report.income_summary');

    }

    public function expenseSummary()
    {

        return view('accounting.report.expenses_summary');

    }

    public function incomeExpense()
    {

        return view('accounting.report.IncomeExpense');

    }

    public function taxSummary()
    {

        return view('accounting.report.tax_summary');

    }

    public function profitLoss()
    {

        return view('accounting.report.profit_loss');

    }

    public function invoiceSummary()
    {

        return view('accounting.report.invoice_summary');

    }

    public function billSummary()
    {

        return view('accounting.report.bill_summary');

    }


}
