<?php


Route::get('/fixed-asset-stock-out', [App\Http\Controllers\Delivery\FixedAssetStockOutController::class, 'index'])->name('asset-stock-out.index');

Route::group(['prefix' => 'fixed-asset-stock-out'], function() {
    Route::get('/list', [App\Http\Controllers\Delivery\FixedAssetStockOutController::class, 'getFixedAssets']);
    Route::post('/store', [App\Http\Controllers\Delivery\FixedAssetStockOutController::class, 'store']);
    Route::post('/update/{id}', [App\Http\Controllers\Delivery\FixedAssetStockOutController::class, 'update']);
    Route::post('/delete/{id}', [App\Http\Controllers\Delivery\FixedAssetStockOutController::class, 'delete']);
    Route::post('/is-delivered/{id}', [App\Http\Controllers\Delivery\FixedAssetStockOutController::class, 'isDelivered']);
});
