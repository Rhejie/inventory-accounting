<?php

Route::get('/purchase-order', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'index'])->name('purchase-order.index');


Route::group(['prefix' => 'purchase-order'], function() {
    Route::get('/get-suppliers', [App\Http\Controllers\Purchase\SupplierManagementController::class, 'getSuppliersData']);
    Route::post('/store-order', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'storeOrder']);
    Route::get('/get-orders', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getOrders']);
    Route::post('/update-order/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'updateOrder']);
    Route::post('/update-order-in-view/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'updateOrderInView']);
    Route::post('/delete-order/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'deleteOrder']);
    Route::get('/get-purchase-order/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getPurchaseOrderData']);
    Route::get('/get-purchase-order-items/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getItems']);
    Route::post('/store-order-item/{id}/{supplier_id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'storeOrderItem']);
    Route::post('/update-order-item/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'updateOrderItem']);
    Route::post('/delete-order-item/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'deleteOrderItem']);
    Route::get('/get-supplier-items/{id}', [App\Http\Controllers\Purchase\ConsumableController::class, 'getSupplierItems']);
    Route::post('/add-vat/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'addVat']);
    Route::post('/add-discount/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'addDiscount']);
    Route::post('/add-others/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'addOthers']);
    Route::get('/get-transactions/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getTransactions']);
    Route::get('/get-number', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getNumber']);
    Route::get('/get-purchase-orders/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getPurchaseOrders']);
    Route::get('/get-purchase-orders-update/{id}', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getPurchaseOrdersUpdate']);
    Route::get('/get-purchase-orders-by-number', [App\Http\Controllers\Purchase\PurchaseOrderController::class, 'getPurchaseOrderByNumber']);
});
