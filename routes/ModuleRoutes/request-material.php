<?php

Route::get('/request-material', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'index'])->name('request-material.index');


Route::group(['prefix' => 'request-material'], function () {
    Route::get('/get-request', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getRequest'])->name('request-material.get');
    Route::post('/store-request', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'storeRequest'])->name('request-material.store');
    Route::post('/update-request/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'updateRequest'])->name('request-material.update');
    Route::post('/delete-request/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'deleteRequest'])->name('request-material.delete');
    Route::get('/get-projects', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getProjects'])->name('request-material.get-project');
    Route::get('/get-requested/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getRequested'])->name('request-material.get-requested');
    Route::get('/get-consumable-supply/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getConsumableSupply']);
    Route::post('/store-request-material-consumable/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'storeRequestConsumable']);
    Route::post('/update-request-material-consumable/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'updateRequestConsumable']);
    Route::post('/delete-request-consumable-supply/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'deleteRequestConsumable']);
    Route::get('/get-request-consumable/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getRequestConsumable']);
    Route::get('/get-fixed-assets', [App\Http\Controllers\Inventory\FixedAssetController::class, 'getFixedAssetsToRequest']);
    Route::post('/store-request-fixed-asset/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'storeRequestFixedAsset']);
    Route::get('/get-request-fixed-assets/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getRequestFixedAssets']);
    Route::post('/update-fixed-asset/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'updateRequestFixedAsset']);
    Route::post('/delete-request-fixed-asset/{id}', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'deleteFixedAsset']);
    Route::get('/get-request-fixed-assets-stock-out', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getRequestFixedAssetStockOut']);
    Route::get('/get-request-consumable-supplies-stock-out', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getRequestConsumableStockOut']);
    Route::get('/get-request-project', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getProject']);
    Route::get('/get-consumable-supplies-data', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getConsumableSuppliesData']);
    Route::get('/get-request-rmcode', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getRequestMaterialCode']);
    Route::get('/get-number', [App\Http\Controllers\Material\RequestMaterialFormController::class, 'getNumber']);
});

