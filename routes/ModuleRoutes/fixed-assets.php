<?php

Route::get('/fixed-asset', [App\Http\Controllers\Inventory\FixedAssetController::class, 'index'])->name('fixed-asset.index');

Route::group(['prefix' => 'fixed-assets'], function () {
    Route::get('/get-fixed-assets', [App\Http\Controllers\Inventory\FixedAssetController::class, 'getFixedAssets'])->name('fixed-asset.get');
});
