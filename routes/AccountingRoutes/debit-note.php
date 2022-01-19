<?php

Route::group(['prefix' => 'debit-note', 'middleware' => 'auth'], function () {
    Route::get('/get-notes/{id}', [App\Http\Controllers\Accounting\DebitNoteController::class, 'getNotes']);
    Route::post('/store-note', [App\Http\Controllers\Accounting\DebitNoteController::class, 'storeNote']);
    Route::post('/update-note/{id}', [App\Http\Controllers\Accounting\DebitNoteController::class, 'updateNote']);
    Route::post('/delete-note/{id}', [App\Http\Controllers\Accounting\DebitNoteController::class, 'deleteNote']);
});
