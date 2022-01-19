<?php

Route::group(['prefix' => 'constant', 'middleware' => 'auth'], function () {
    Route::get('/get-taxes', [App\Http\Controllers\Accounting\ConstantsController::class, 'getTaxes']);
    Route::post('/store-tax', [App\Http\Controllers\Accounting\ConstantsController::class, 'storeTax']);
    Route::post('/update-tax/{id}', [App\Http\Controllers\Accounting\ConstantsController::class, 'updateTax']);
    Route::post('/delete-tax/{id}', [App\Http\Controllers\Accounting\ConstantsController::class, 'deleteTax']);
    Route::get('/search-tax', [App\Http\Controllers\Accounting\ConstantsController::class, 'selectTax']);

    Route::get('/get-units', [App\Http\Controllers\Accounting\ConstantsController::class, 'getUnits']);
    Route::post('/store-unit', [App\Http\Controllers\Accounting\ConstantsController::class, 'storeUnit']);
    Route::post('/update-unit/{id}', [App\Http\Controllers\Accounting\ConstantsController::class, 'updateUnit']);
    Route::post('/delete-unit/{id}', [App\Http\Controllers\Accounting\ConstantsController::class, 'deleteUnit']);
    Route::get('/search-units', [App\Http\Controllers\Accounting\ConstantsController::class, 'selectUnit']);
});
