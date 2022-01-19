<?php


Route::group(['middleware' => 'auth'], function () {
    Route::get('/accounting/home', [App\Http\Controllers\Accounting\HomeController::class, 'index'])->name('accounting.home');
    Route::get('/accounting/services', [App\Http\Controllers\Accounting\ServicesController::class, 'index'])->name('accounting.services');
    Route::get('/accounting/customer', [App\Http\Controllers\Accounting\CustomersController::class, 'index'])->name('accounting.customer');
    Route::get('/accounting/vendor', [App\Http\Controllers\Accounting\VendorsController::class, 'index'])->name('accounting.vendor');
    Route::get('/accounting/proposal', [App\Http\Controllers\Accounting\ProposalsController::class, 'index'])->name('accounting.proposal');
    Route::get('/accounting/banking/account', [App\Http\Controllers\Accounting\BankingController::class, 'account'])->name('accounting.account');
    Route::get('/accounting/banking/transfer', [App\Http\Controllers\Accounting\BankingController::class, 'transfer'])->name('accounting.transfer');
    Route::get('/accounting/income/invoice', [App\Http\Controllers\Accounting\IncomesController::class, 'invoice'])->name('accounting.invoice');
    Route::get('/accounting/income/revenue', [App\Http\Controllers\Accounting\IncomesController::class, 'revenue'])->name('accounting.revenue');
    Route::get('/accounting/income/credit-note', [App\Http\Controllers\Accounting\IncomesController::class, 'creditNote'])->name('accounting.credit-note');
    Route::get('/accounting/expense/bill', [App\Http\Controllers\Accounting\ExpensesController::class, 'bill'])->name('accounting.bill');
    Route::get('/accounting/expense/payment', [App\Http\Controllers\Accounting\ExpensesController::class, 'payment'])->name('accounting.payment');
    Route::get('/accounting/expense/debit-note', [App\Http\Controllers\Accounting\ExpensesController::class, 'debitNote'])->name('accounting.debit-note');
    Route::get('/accounting/report/transcation', [App\Http\Controllers\Accounting\ReportsController::class, 'transactions'])->name('accounting.transactions');
    Route::get('/accounting/report/account-statement', [App\Http\Controllers\Accounting\ReportsController::class, 'accountStatement'])->name('accounting.account-statement');
    Route::get('/accounting/report/income-summary', [App\Http\Controllers\Accounting\ReportsController::class, 'incomeSummary'])->name('accounting.income-summary');
    Route::get('/accounting/report/expense-summary', [App\Http\Controllers\Accounting\ReportsController::class, 'expenseSummary'])->name('accounting.expense-summary');
    Route::get('/accounting/report/income-expense', [App\Http\Controllers\Accounting\ReportsController::class, 'incomeExpense'])->name('accounting.income-expense');
    Route::get('/accounting/report/tax-summary', [App\Http\Controllers\Accounting\ReportsController::class, 'taxSummary'])->name('accounting.tax-summary');
    Route::get('/accounting/report/profit-loss', [App\Http\Controllers\Accounting\ReportsController::class, 'profitLoss'])->name('accounting.profit-loss');
    Route::get('/accounting/report/invoice-summary', [App\Http\Controllers\Accounting\ReportsController::class, 'invoiceSummary'])->name('accounting.invoice-summary');
    Route::get('/accounting/report/bill-summary', [App\Http\Controllers\Accounting\ReportsController::class, 'billSummary'])->name('accounting.bill-summary');
    Route::get('/accounting/constant/taxes', [App\Http\Controllers\Accounting\ConstantsController::class, 'taxes'])->name('accounting.taxes');
    Route::get('/accounting/constant/category', [App\Http\Controllers\Accounting\ConstantsController::class, 'category'])->name('accounting.category');
    Route::get('/accounting/constant/unit', [App\Http\Controllers\Accounting\ConstantsController::class, 'unit'])->name('accounting.unit');
    Route::get('/accounting/setting', [App\Http\Controllers\Accounting\SettingsController::class, 'index'])->name('accounting.setting');




});


