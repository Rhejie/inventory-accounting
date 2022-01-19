<?php

Route::group(['prefix' => 'bill-payment', 'middleware' => 'auth'], function () {
    Route::get('/get-payments/{id}', [App\Http\Controllers\Accounting\BillPaymentController::class, 'getPayments']);
    Route::post('/store-payment', [App\Http\Controllers\Accounting\BillPaymentController::class, 'storePayment']);
    Route::post('/update-payment/{id}', [App\Http\Controllers\Accounting\BillPaymentController::class, 'updatePayment']);
    Route::post('/delete-payment/{id}', [App\Http\Controllers\Accounting\BillPaymentController::class, 'deletePayment']);
});
