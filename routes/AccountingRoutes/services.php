<?php

Route::group(['prefix' => 'service', 'middleware' => 'auth'], function () {

    Route::get('/get-services', [App\Http\Controllers\Accounting\ServicesController::class, 'getServices']);
    Route::post('/store-service', [App\Http\Controllers\Accounting\ServicesController::class, 'storeService']);
    Route::post('/update-service/{id}', [App\Http\Controllers\Accounting\ServicesController::class, 'updateService']);
    Route::post('/delete-service/{id}', [App\Http\Controllers\Accounting\ServicesController::class, 'deleteService']);
    Route::get('/search-service', [App\Http\Controllers\Accounting\ServicesController::class, 'searchService']);
});
