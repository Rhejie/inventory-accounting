<?php

Route::group(['prefix' => 'vendor', 'middleware' => 'auth'], function () {
    Route::get('get-vendors', [App\Http\Controllers\Accounting\VendorsController::class, 'getVendors']);
    Route::post('/');
});
