<?php

Route::group(['prefix' => 'payment', 'middleware' => 'auth'], function () {
    Route::get('/get-payments', [App\Http\Controllers\Accounting\PaymentController::class, 'getPayments']);
    Route::post('/store-payment', [App\Http\Controllers\Accounting\PaymentController::class, 'storePayment']);
    Route::post('/update-payment/{id}', [App\Http\Controllers\Accounting\PaymentController::class, 'updatePayment']);
    Route::post('/delete-payment/{id}', [App\Http\Controllers\Accounting\PaymentController::class, 'deletePayment']);
});
