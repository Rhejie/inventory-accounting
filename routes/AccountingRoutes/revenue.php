<?php

Route::group(['prefix' => 'revenue', 'middleware' => 'auth'], function () {
    Route::get('get-revenues', [App\Http\Controllers\Accounting\RevenueController::class, 'getRevenues']);
    Route::post('store-revenue', [App\Http\Controllers\Accounting\RevenueController::class, 'storeRevenue']);
    Route::post('update-revenue/{id}', [App\Http\Controllers\Accounting\RevenueController::class, 'updateRevenue']);
    Route::post('delete-revenue/{id}', [App\Http\Controllers\Accounting\RevenueController::class, 'deleteRevenue']);
});
