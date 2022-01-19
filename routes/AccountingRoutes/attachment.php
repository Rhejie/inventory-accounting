<?php

Route::group(['prefix' => 'attachment', 'middleware' => 'auth'], function () {

    Route::post('/store-attachment', [App\Http\Controllers\Accounting\AttachmentController::class, 'storeAttachment']);
    Route::get('/get-attachments', [App\Http\Controllers\Accounting\AttachmentController::class, 'getAttachments']);
    Route::post('/delete-attachment/{id}', [App\Http\Controllers\Accounting\AttachmentController::class, 'deleteAttachment']);
    Route::get('/attachment-file', [App\Http\Controllers\Accounting\AttachmentController::class, 'viewAttachment']);
});
