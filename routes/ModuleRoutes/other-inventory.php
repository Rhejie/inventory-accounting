<?php

Route::get('/other-inventory', [App\Http\Controllers\Inventory\OtherAssetsController::class, 'index'])->name('other-invetory.index');
Route::get('/view-other-inventory-document', [App\Http\Controllers\Inventory\OtherAssetDocumentController::class, 'viewDocument'])->name('other-inventory.view-document');
Route::get('/view-other-maintenance-attachment', [App\Http\Controllers\Inventory\OtherAssetsController::class, 'viewAttachment']);

Route::group(['prefix' => 'other-inventory'], function() {
    Route::get('/get-other-inventory', [App\Http\Controllers\Inventory\OtherAssetsController::class, 'getOtherInventory'])->name('other-inventory.get-other-inventory');
    Route::get('/get-other-inventory-info/{id}', [App\Http\Controllers\Inventory\OtherAssetsController::class, 'getInfo'])->name('other-inventory.get-info');
    Route::post('/add-other-inventory', [App\Http\Controllers\Inventory\OtherAssetsController::class, 'storeOtherInventory'])->name('other-inventory.store');
    Route::get('/get-documents/{id}', [App\Http\Controllers\Inventory\OtherAssetDocumentController::class, 'getDocuments'])->name('other-inventory.documents');
    Route::post('/store-document/{id}', [App\Http\Controllers\Inventory\OtherAssetDocumentController::class, 'storeDocument'])->name('other-inventory.store-documents');
    Route::post('/update-other-inventory/{id}', [App\Http\Controllers\Inventory\OtherAssetsController::class, 'updateOther'])->name('other-inventory.update');
    Route::post('/update-document/{id}', [App\Http\Controllers\Inventory\OtherAssetDocumentController::class, 'updateDocument'])->name('other-inventory.update-document');
    Route::post('/delete-document/{id}', [App\Http\Controllers\Inventory\OtherAssetDocumentController::class, 'deleteDocument'])->name('other-inventory.delete-document');
    Route::post('/delete-other-inventory/{id}', [App\Http\Controllers\Inventory\OtherAssetsController::class, 'deleteOtherInventory'])->name('other-inventory.delete');
    Route::get('/get-other-inventory-history/{id}', [App\Http\Controllers\Inventory\OtherAssetsController::class, 'otherLocationHistory']);
});


Route::group(['prefix' => 'other-job-order'], function () {
    Route::get('/get-types', [App\Http\Controllers\JobOrder\JobOrderController::class, 'getTypes']);
    Route::post('/store-job-order', [App\Http\Controllers\JobOrder\JobOrderController::class, 'storeOtherJobOrder']);
    Route::get('/get-other-job-orders/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'getOtherJobOrders']);
    Route::post('/delete-job-order/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'deleteOtherJobOrder']);
    Route::post('/update-job-order/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'updateOtherJobOrder']);
});

Route::group(['prefix' => 'other-maintenance'], function () {
    Route::get('/get-types', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'getTypes']);
    Route::post('/store-maintenance', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'storeOtherMaintenance']);
    Route::get('/get-other-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'getOtherMaintenance']);
    Route::post('/delete-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'deleteOtherMaintenance']);
    Route::post('/update-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'updateOtherMaintenance']);
});
