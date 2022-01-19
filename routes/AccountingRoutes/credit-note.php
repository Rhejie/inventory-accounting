<?php

Route::group(['prefix' => 'credit-note', 'middleware' => 'auth'], function () {
    Route::get('/get-credits', [App\Http\Controllers\Accounting\CreditNoteController::class, 'getCredits']);
    Route::post('/store-credit', [App\Http\Controllers\Accounting\CreditNoteController::class, 'storeCredit']);
    Route::post('/update-credit/{id}', [App\Http\Controllers\Accounting\CreditNoteController::class, 'updateCredit']);
    Route::post('/delete-credit/{id}', [App\Http\Controllers\Accounting\CreditNoteController::class, 'deleteCredit']);
});
