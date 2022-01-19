<?php

Route::get('/truck-vehicle', [App\Http\Controllers\Inventory\VehicleController::class, 'index'])->name('truck-vehicle.index');
Route::get('/view-truck-vehicle-document', [App\Http\Controllers\Inventory\VehicleController::class, 'viewDocument'])->name('truck-vehicle.view-document');
Route::get('/view-truck-vehicle-attachment', [App\Http\Controllers\Inventory\VehicleController::class, 'viewAttachment']);

Route::group(['prefix' => 'truck-vehicle'], function() {
    Route::get('/get-trucks-vehicles', [App\Http\Controllers\Inventory\VehicleController::class, 'getTrucksVehicles'])->name('truck-vehicle.get-trucks-vehicles');
    Route::post('/add-truck-vehicle', [App\Http\Controllers\Inventory\VehicleController::class, 'storeTruckVehicle'])->name('truck-vehicle.store');
    Route::get('/get-truck-vehicle-info/{id}', [App\Http\Controllers\Inventory\VehicleController::class, 'getTruckVehicleInfo'])->name('truck-vehicle.info');
    Route::post('/update-truck-vehicle/{id}', [App\Http\Controllers\Inventory\VehicleController::class, 'updateTruckVehicle'])->name('truck-vehicle.update');
    Route::get('/get-trucks-vehicles-documents/{id}', [App\Http\Controllers\Inventory\TruckVehicleDocumentController::class, 'getDocuments'])->name('truck-vehicle.documents');
    Route::post('/store-document/{id}', [App\Http\Controllers\Inventory\TruckVehicleDocumentController::class, 'storeDocument'])->name('truck-vehicle.store-document');
    Route::post('/update-document/{id}', [App\Http\Controllers\Inventory\TruckVehicleDocumentController::class, 'updateDocument'])->name('truck-vehicle.update-document');
    Route::post('/delete-document/{id}', [App\Http\Controllers\Inventory\TruckVehicleDocumentController::class, 'deleteDocument'])->name('truck-vehicle.delete-document');
    Route::post('/delete-truck-vehicle/{id}', [App\Http\Controllers\Inventory\VehicleController::class, 'deleteTruckVehicle'])->name('truck-vehicle.delete');
    Route::get('/get-truck-vehicle-history/{id}', [App\Http\Controllers\Inventory\VehicleController::class, 'getLocationHistory']);
});

Route::group(['prefix' => 'truck-job-order'], function () {
    Route::get('/get-types', [App\Http\Controllers\JobOrder\JobOrderController::class, 'getTypes']);
    Route::post('/store-job-order', [App\Http\Controllers\JobOrder\JobOrderController::class, 'storeTruckJobOrder']);
    Route::get('/get-truck-job-orders/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'getTruckJobOrders']);
    Route::post('/delete-job-order/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'deleteTruckJobOrder']);
    Route::post('/update-job-order/{id}', [App\Http\Controllers\JobOrder\JobOrderController::class, 'updateTruckJobOrder']);
});


Route::group(['prefix' => 'truck-maintenance'], function () {
    Route::get('/get-types', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'getTypes']);
    Route::post('/store-maintenance', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'storeTruckMaintenance']);
    Route::get('/get-truck-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'getTruckMaintenance']);
    Route::post('/delete-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'deleteTruckMaintenance']);
    Route::post('/update-maintenance/{id}', [App\Http\Controllers\Maintenance\MaintenanceController::class, 'updateTruckMaintenance']);
});
