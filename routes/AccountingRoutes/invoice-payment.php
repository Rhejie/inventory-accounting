<?php

Route::group(['prefix' => 'invoice-payment', 'middleware' => 'auth'], function () {
    Route::get('/get-payments/{id}', [App\Http\Controllers\Accounting\InvoicePaymentController::class, 'getPayments']);
    Route::post('/store-payment', [App\Http\Controllers\Accounting\InvoicePaymentController::class, 'storePayment']);
    Route::post('/update-payment/{id}', [App\Http\Controllers\Accounting\InvoicePaymentController::class, 'updatePayment']);
    Route::post('/delete-payment/{id}', [App\Http\Controllers\Accounting\InvoicePaymentController::class, 'deletePayment']);
});
