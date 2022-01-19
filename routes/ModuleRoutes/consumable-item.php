<?php
Route::get('/consumable-items', [App\Http\Controllers\Purchase\ConsumableController::class, 'index'])->name('consumable-inventory.index');

Route::group(['prefix' => 'consumable-items'], function () {
    Route::get('/get-consumable-items/{id}', [App\Http\Controllers\Purchase\ConsumableController::class, 'getItems'])->name('consumable-item.get');
    Route::post('/store-consumable-item/{id}', [App\Http\Controllers\Purchase\ConsumableController::class, 'storeItem'])->name('consumable-item.store');
    Route::post('/update-consumable-item/{id}', [App\Http\Controllers\Purchase\ConsumableController::class, 'updateItem'])->name('consumable-item.update');
    Route::post('/delete-consumable-item/{id}', [App\Http\Controllers\Purchase\ConsumableController::class, 'deleteItem'])->name('consumable-item.delete');
    Route::get('/get-consumable-items-inventory', [App\Http\Controllers\Purchase\ConsumableController::class, 'consumableItems'])->name('consumable-item-inventory.get');
    Route::get('/check-per-item', [App\Http\Controllers\Purchase\ConsumableController::class, 'checkPerItem']);
});
