<?php


Route::group(['prefix' => 'bill', 'middleware' => 'auth'], function() {
    Route::get('/get-bills', [App\Http\Controllers\Accounting\BillController::class, 'getBills']);
    Route::post('/store-bill', [App\Http\Controllers\Accounting\BillController::class, 'storeBill']);
    Route::post('/update-bill/{id}', [App\Http\Controllers\Accounting\BillController::class, 'updateBill']);
    Route::post('/delete-bill/{id}', [App\Http\Controllers\Accounting\BillController::class, 'deleteBill']);
    Route::get('/get-number', [App\Http\Controllers\Accounting\BillController::class, 'getBillNumber']);
    Route::get('/view-bill/{id}', [App\Http\Controllers\Accounting\BillController::class, 'showBillByID']);
    Route::get('/get-items/{id}', [App\Http\Controllers\Accounting\BillController::class, 'getItems']);
    Route::post('/send-bill/{id}', [App\Http\Controllers\Accounting\BillController::class, 'sendBill']);
    Route::get('/search-bill', [App\Http\Controllers\Accounting\BillController::class, 'searchBill']);
    Route::get('/get-orders/{id}', [App\Http\Controllers\Accounting\BillController::class, 'getOrders']);

});
