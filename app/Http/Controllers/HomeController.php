<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


   //pages converted from interns

    public function budgetVsActual(){

        return view('pages.budget_vs_actual');

    }

     public function incomeVsExpense(){

        return view('pages.income_vs_expense');

    }

     public function tools(){

        return view('pages.tools');

    }

    public function budgetVariance(){

        return view('pages.budget_variance');

    }


     public function billsOfMaterials(){

        return view('pages.bills_of_materials');

    }


   public function canvass(){

        return view('pages.canvass');

    }

    public function test() {
        return view('test');
    }



}
