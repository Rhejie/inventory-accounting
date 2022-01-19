<?php


Route::get('/consumable-supply-stock-out', [App\Http\Controllers\Delivery\ConsumableSupplyStockOutController::class, 'index'])->name('consumable-supply-out.index');

Route::group(['prefix' => 'supply-stock-out'], function() {
    Route::get('/list', [App\Http\Controllers\Delivery\ConsumableSupplyStockOutController::class, 'getConsumableSupplies']);
    Route::post('/store', [App\Http\Controllers\Delivery\ConsumableSupplyStockOutController::class, 'store']);
    Route::post('/update/{id}', [App\Http\Controllers\Delivery\ConsumableSupplyStockOutController::class, 'update']);
    Route::post('/delete/{id}', [App\Http\Controllers\Delivery\ConsumableSupplyStockOutController::class, 'deleteStockOut']);
    Route::post('/is-delivered/{id}', [App\Http\Controllers\Delivery\ConsumableSupplyStockOutController::class, 'isDelivered']);
    // request consumable items
    Route::get('/get-request-consumable-item', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getRequestConsumbaleItemToStockOut']);
});
