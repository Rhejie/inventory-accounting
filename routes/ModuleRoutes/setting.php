<?php

Route::get('/setting-project', [App\Http\Controllers\Setting\SettingController::class, 'index'])->name('setting.project-status');
Route::get('/setting-maintenance', [App\Http\Controllers\Setting\SettingController::class, 'maintenanceType'])->name('setting.maintenance-type');
Route::get('/setting-job-order', [App\Http\Controllers\Setting\SettingController::class, 'jobOrderType'])->name('setting.job-order-type');
Route::get('/setting-bill-of-material', [App\Http\Controllers\Setting\SettingController::class, 'billOfMaterial'])->name('setting.bill-of-material');
Route::group(['prefix' => 'setting'], function () {
    // job order type
    Route::get('/get-job-order', [App\Http\Controllers\Setting\SettingController::class, 'getJobOrderType']);
    Route::post('/store-job-order', [App\Http\Controllers\Setting\SettingController::class, 'storeJobOrderType']);
    Route::post('/update-job-order/{id}', [App\Http\Controllers\Setting\SettingController::class, 'updateJobOrderType']);
    Route::post('/delete-job-order/{id}', [App\Http\Controllers\Setting\SettingController::class, 'deleteJobOrderType']);

    // maintenance type
    Route::get('/get-maintenance-type', [App\Http\Controllers\Setting\SettingController::class, 'getMaintenanceType']);
    Route::post('/store-maintenance-type', [App\Http\Controllers\Setting\SettingController::class, 'storeMaintenanceType']);
    Route::post('/update-maintenance-type/{id}', [App\Http\Controllers\Setting\SettingController::class, 'updateMaintenanceType']);
    Route::post('/delete-maintenance-type/{id}', [App\Http\Controllers\Setting\SettingController::class, 'deleteMaintenanceType']);

    // Project Status

    Route::get('/get-project-status', [App\Http\Controllers\Setting\SettingController::class, 'getProjectStatus']);
    Route::post('/store-project-status', [App\Http\Controllers\Setting\SettingController::class, 'storeProjectStatus']);
    Route::post('/update-project-status/{id}', [App\Http\Controllers\Setting\SettingController::class, 'updateProjectStatus']);
    Route::post('/delete-project-status/{id}', [App\Http\Controllers\Setting\SettingController::class, 'deleteProjectStatus']);

    Route::get('/get-material-items', [App\Http\Controllers\Project\BillOfMaterialController::class, 'getItems']);
    Route::get('/get-material-descriptions', [App\Http\Controllers\Project\BillOfMaterialController::class, 'getDescriptions']);
    Route::post('/store-item', [App\Http\Controllers\Project\BillOfMaterialController::class, 'storeItem']);
    Route::post('/update-item/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'updateItem']);
    Route::post('/delete-item/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'deleteItem']);
    
    Route::post('/store-description', [App\Http\Controllers\Project\BillOfMaterialController::class, 'storeDescription']);
    Route::post('/update-description/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'updateDescription']);
    Route::post('/delete-description/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'deleteDescription']);
});
