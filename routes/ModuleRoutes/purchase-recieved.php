<?php

Route::get('/purchase-recieved', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'index'])->name('purchase-recieve.index');


Route::group(['prefix' => 'purchase-received'], function () {
    Route::get('/get-receives', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'getReceived']);
    Route::post('/store', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'store']);
    Route::post('/storeItem', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'storeItem']);
    Route::post('/update/{id}', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'update']);
    Route::post('/delete/{id}', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'delete']);
    Route::get('/get-received-details/{id}', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'getDetails']);
    Route::get('/get-received-items/{id}', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'getItems']);
    Route::get('/get-item-received-quantity/{id}', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'getItemReceivedQunatity']);
    Route::get('/get-item-received-quantity-item/{id}', [App\Http\Controllers\Purchase\PurchaseReceivedController::class, 'getItemReceivedQunatityItem']);
    // purhcase order and item
    Route::get('/get-purchase-order-forms', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getPurhcaseOrderForms']);
    Route::get('/get-purchase-order-items/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getPurchaseOrderItems']);
    Route::get('/get-has-supply/{project_id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getHasSupply']);
});
