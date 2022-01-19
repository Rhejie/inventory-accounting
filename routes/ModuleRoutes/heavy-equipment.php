<?php

Route::get('/heavy-equipment', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'heavyEquipmentIndex'])->name('heavy-equipment.index');
Route::get('/view-heavy-equipment-document', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'viewDocument'])->name('heavy-equipment.view-document');
Route::get('/view-heavy-equipment-attachment', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'viewAttachment']);

Route::group(['prefix' => 'heavy-equipment'], function () {
    Route::post('/add-equipment', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'storeEquipment'])->name('heavy-equipment.store');
    Route::get('/get-equipments', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'getEquipments'])->name('heavy-equipment.get');
    Route::get('/get-equipment-info/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'getEquipmentInfo'])->name('heavy-equipment.info');
    Route::post('/add-equipment-document/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'storeEquipmentDocument'])->name('heavy-equipment.add-document');
    Route::get('/get-equipment-documents/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'getEquipmentDocuments'])->name('heavy-equipment.get-documents');
    Route::get('/download-document/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'downloadEquipment'])->name('heavy-equipment.download-document');
    Route::post('/update-equipment/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'updateEquipment'])->name('heavy-equipment.update');
    Route::post('/update-equipment-document/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'updateDocument'])->name('heavy-equipment.update-document');
    Route::post('/delete-document/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'deleteDocument'])->name('heavy-equipment.delete-document');
    Route::post('/delete-equipment/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'deleteEquipment'])->name('heavy-equipment.delete');
    Route::get('/get-equipment-history/{id}', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'getEquipmentHistory']);
    Route::post('/return-to-warehouse', [App\Http\Controllers\Inventory\HeavyEquipmentController::class, 'returnToWarehouse']);
});


Route::group(['prefix' => 'heavy-job-order'], function () {
    Route::get('/get-types', [App\Http\Controllers\JobOrder\JobOrderController::class, 'getTypes']);
    Route::post('/store-job-order', [App\Http\Controllers\JobOrder\JobOrderController::class, 'storeHeavyJobOrder']);
    Route::get('/get-heavy-job-orders/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'getHeavyJobOrders']);
    Route::post('/delete-job-order/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'deleteHeavyJobOrder']);
    Route::post('/update-job-order/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'updateHeavyJobOrder']);
});

Route::group(['prefix' => 'heavy-maintenance'], function () {
    Route::get('/get-types', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'getTypes']);
    Route::post('/store-maintenance', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'storeHeavyMaintenance']);
    Route::get('/get-heavy-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'getHeavyMaintenance']);
    Route::post('/delete-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'deleteHeavyMaintenance']);
    Route::post('/update-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'updateHeavyMaintenance']);
});
