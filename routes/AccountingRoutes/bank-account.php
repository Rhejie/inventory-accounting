<?php

Route::group(['prefix' => 'bank-account', 'middleware' => 'auth'], function () {
    Route::get('/get-accounts', [App\Http\Controllers\Accounting\BankingController::class, 'getAccounts']);
    Route::post('/store-account', [App\Http\Controllers\Accounting\BankingController::class, 'storeAccount']);
    Route::post('/update-account/{id}', [App\Http\Controllers\Accounting\BankingController::class, 'updateAccount']);
    Route::post('/delete-account/{id}', [App\Http\Controllers\Accounting\BankingController::class, 'deleteAccount']);
    Route::get('/search-account', [App\Http\Controllers\Accounting\BankingController::class, 'searchAccount']);

    Route::get('/get-transfers', [App\Http\Controllers\Accounting\BankingController::class, 'getTransfers']);
    Route::post('/store-transfer', [App\Http\Controllers\Accounting\BankingController::class, 'storeTransfer']);
    Route::post('/update-transfer/{id}', [App\Http\Controllers\Accounting\BankingController::class, 'updateTransfer']);
    Route::post('/delete-transfer/{id}', [App\Http\Controllers\Accounting\BankingController::class, 'deleteTransfer']);
});
