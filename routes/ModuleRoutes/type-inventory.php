<?php

    Route::get('/type-inventory', [App\Http\Controllers\Inventory\TypesController::class, 'index'])->name('type-inventory.index');

    Route::group(['prefix' => 'type-inventory'], function () {
        Route::get('/get-types-inventory', [App\Http\Controllers\Inventory\TypesController::class, 'getTypes'])->name('type-inventory.type');
        Route::post('/store-type-inventory', [App\Http\Controllers\Inventory\TypesController::class, 'storeType'])->name('type-inventory.store');
        Route::post('/update-type-inventory/{id}', [App\Http\Controllers\Inventory\TypesController::class, 'updateType'])->name('type-inventory.update');
        Route::post('/delete-type-inventory/{id}', [App\Http\Controllers\Inventory\TypesController::class, 'deleteType'])->name('type-inventory.update');
    });
