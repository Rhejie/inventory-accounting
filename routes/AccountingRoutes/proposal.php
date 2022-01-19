<?php

Route::group(['prefix' => 'proposal', 'middleware' => 'auth'], function () {
    Route::get('/get-proposals', [App\Http\Controllers\Accounting\ProposalsController::class, 'getProposals']);
    Route::get('/get-proposal-number', [App\Http\Controllers\Accounting\ProposalsController::class, 'getProposalNumber']);
    Route::post('/store-proposal', [App\Http\Controllers\Accounting\ProposalsController::class, 'storeProposal']);
    Route::get('/find-proposal/{id}', [App\Http\Controllers\Accounting\ProposalsController::class, 'findProposal']);
    Route::post('/update-proposal/{id}', [App\Http\Controllers\Accounting\ProposalsController::class, 'updateProposal']);
    Route::post('/delete-proposal/{id}', [App\Http\Controllers\Accounting\ProposalsController::class, 'deleteProposal']);
    Route::post('/conver-to-invoice/{id}', [App\Http\Controllers\Accounting\ProposalsController::class, 'convertInvoice']);
    Route::post('/send-proposal/{id}', [App\Http\Controllers\Accounting\ProposalsController::class, 'sendProposal']);
    Route::post('/change-status/{id}', [App\Http\Controllers\Accounting\ProposalsController::class, 'changeStatus']);
    Route::get('/download-proposal/{id}', [App\Http\Controllers\Accounting\ProposalsController::class, 'downloadProposal']);
    Route::get('/generate-pdf/{id}',[App\Http\Controllers\Accounting\ProposalsController::class, 'generatePdf']);
});
