<?php

    Route::get('/category-inventory', [App\Http\Controllers\Inventory\CategoryController::class, 'index'])->name('category-inventory.index');

    Route::group(['prefix' => 'category-inventory'], function () {
        Route::get('/get-category-inventory', [App\Http\Controllers\Inventory\CategoryController::class, 'getCategory'])->name('category-inventory.get');
        Route::post('/store-category-inventory', [App\Http\Controllers\Inventory\CategoryController::class, 'storeCategory'])->name('category-inventory.store');
        Route::post('/update-category-inventory/{id}', [App\Http\Controllers\Inventory\CategoryController::class, 'updateCategory'])->name('category-inventory.update');
        Route::post('/delete-category-inventory/{id}', [App\Http\Controllers\Inventory\CategoryController::class, 'deleteCategory'])->name('category-inventory.delete');
        Route::get('/get-types-value', [App\Http\Controllers\Inventory\TypesController::class, 'getTypesForCategory'])->name('category-inventory.types-inventory');
    });
