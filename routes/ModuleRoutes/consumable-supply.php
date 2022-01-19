<?php

Route::get('/consumable-supply', [App\Http\Controllers\Inventory\ConsumableSupplyController::class, 'index'])->name('consumable-supply.index');

Route::group(['prefix' => 'consumable-supply'], function() {
    Route::get('/get-consumable-supplies', [App\Http\Controllers\Inventory\ConsumableSupplyController::class, 'getSupply'])->name('consumable-supply.get');
    Route::post('/store-supply', [App\Http\Controllers\Inventory\ConsumableSupplyController::class, 'storeSupply'])->name('consumable-supply.store');
    Route::post('/update-supply/{id}', [App\Http\Controllers\Inventory\ConsumableSupplyController::class, 'updateSupply'])->name('consumable-supply.update');
    Route::post('/delete-supply/{id}', [App\Http\Controllers\Inventory\ConsumableSupplyController::class, 'deleteSupply'])->name('consumable-supply.delete');
});
