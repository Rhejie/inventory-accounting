<?php

Route::get('/supplier-management', [App\Http\Controllers\Purchase\SupplierManagementController::class, 'index'])->name('supplier-management.index');


Route::group(['prefix' => 'supplier-management'], function () {
    Route::get('/get-suppliers', [App\Http\Controllers\Purchase\SupplierManagementController::class, 'getSuppliers'])->name('supplier-management.get-suppliers');
    Route::post('/store-supplier', [App\Http\Controllers\Purchase\SupplierManagementController::class, 'storeSupplier'])->name('supplier-management.store');
    Route::get('/get-supplier/{id}', [App\Http\Controllers\Purchase\SupplierManagementController::class, 'getSupplier'])->name('supplier-management.getSupplier');
    Route::post('/update-supplier/{id}', [App\Http\Controllers\Purchase\SupplierManagementController::class, 'updateSupplier'])->name('supplier-manage.update');
    Route::post('/delete-supplier/{id}', [App\Http\Controllers\Purchase\SupplierManagementController::class, 'deleteSupplier'])->name('supplier-management.delete');
});
