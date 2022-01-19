<?php

Route::group(['prefix' => 'invoice', 'middleware' => 'auth'], function () {
    Route::get('/get-invoices', [App\Http\Controllers\Accounting\InvoiceController::class, 'getInvoices']);
    Route::get('/get-invoice-number', [App\Http\Controllers\Accounting\InvoiceController::class, 'getInvoiceNumber']);
    Route::post('/store-invoice', [App\Http\Controllers\Accounting\InvoiceController::class, 'storeInvoice']);
    Route::get('/find-invoice/{id}', [App\Http\Controllers\Accounting\InvoiceController::class, 'findInvoice']);
    Route::post('/update-invoice/{id}', [App\Http\Controllers\Accounting\InvoiceController::class, 'updateInvoice']);
    Route::get('/search-invoice', [App\Http\Controllers\Accounting\InvoiceController::class, 'searchInvoice']);
    Route::get('/get-credits/{id}', [App\Http\Controllers\Accounting\CreditNoteController::class, 'getCreditsNotes']);
    Route::post('/send-invoice/{id}', [App\Http\Controllers\Accounting\InvoiceController::class, 'sendInvoice']);
    Route::post('/delete-invoice/{id}', [App\Http\Controllers\Accounting\InvoiceController::class, 'deleteInvoice']);
    Route::get('/download-invoice/{id}', [App\Http\Controllers\Accounting\InvoiceController::class, 'downloadInvoice']);
});
