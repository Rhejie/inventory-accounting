<?php

Route::group(['prefix' => 'bill-of-material', 'middleware' => 'auth'], function () {
    Route::get('/bill-of-materials/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'getBillOfMaterials']);
    Route::post('/store-bill-of-material', [App\Http\Controllers\Project\BillOfMaterialController::class, 'storeBillOfMaterial']);
    Route::post('/update-bill-of-material/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'updateBillOfMaterial']);
    Route::post('/delete-bill-of-material/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'deleteMaterial']);

    // item

    Route::get('/items', [App\Http\Controllers\Project\BillOfMaterialController::class, 'getItems']);
    Route::post('/store-item', [App\Http\Controllers\Project\BillOfMaterialController::class, 'storeItem']);
    Route::post('/update-item/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'updateItem']);
    Route::post('/delete-item/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'deleteItem']);
    Route::get('/get-items-data', [App\Http\Controllers\Project\BillOfMaterialController::class, 'getItemsData']);
    // description

    Route::get('/descriptions', [App\Http\Controllers\Project\BillOfMaterialController::class, 'getDescriptions']);
    Route::post('/store-description', [App\Http\Controllers\Project\BillOfMaterialController::class, 'storeDescription']);
    Route::post('/update-description/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'updateDescription']);
    Route::post('/delete-description/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'deleteDescription']);
    Route::get('/get-description-data', [App\Http\Controllers\Project\BillOfMaterialController::class, 'getDescriptionsData']);

    Route::post('/update-bill-of-material-project/{id}', [App\Http\Controllers\Project\BillOfMaterialController::class, 'updateProjectBillOfMaterial']);
});
