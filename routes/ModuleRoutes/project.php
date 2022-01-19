<?php

Route::group(['namespace'=>'Project'],function(){
    // Route::get('/project','ProjectController@index')->name('project.index');
    Route::prefix('project')->group(function(){
        Route::get('/searchProject','ProjectController@searchProject')->name('project.searchProject');
    });

    // Route::post('project/store','ProjectController@store')->name('project.store');
    // Route::post('project/document/store','ProjectController@storeDocument')->name('projectDocument.store');
    // Route::get('project/document/{project_id}','ProjectController@showDocuments')->name('projectDocument.list');
    // Route::resource('project', ProjectController::class);
    Route::get('project', 'ProjectController@index')->name('project');
    Route::get('/view-project-document', [App\Http\Controllers\Project\ProjectController::class, 'viewProjectDocument'])->name('project.view-document');
});


Route::group(['prefix' => 'projects'], function() {
    Route::get('/get-projects', [App\Http\Controllers\Project\ProjectController::class, 'getProjects'])->name('project.get');
    Route::get('/project-details/{id}', [App\Http\Controllers\Project\ProjectController::class, 'showDetails'])->name('project.showDetails');
    Route::post('/store-project-document/{id}', [App\Http\Controllers\Project\ProjectController::class, 'storeProjectDocument']);
    Route::get('/get-project-documents/{id}', [App\Http\Controllers\Project\ProjectController::class, 'getProjectDocuments']);
    Route::post('/store-project', [App\Http\Controllers\Project\ProjectController::class, 'storeProject'])->name('project.store');
    Route::post('/update-project/{id}', [App\Http\Controllers\Project\ProjectController::class, 'updateProject'])->name('project.update');
    Route::post('/delete-project/{id}', [App\Http\Controllers\Project\ProjectController::class, 'deleteProject'])->name('project.delete');
    Route::post('/delete-project-document/{id}', [App\Http\Controllers\Project\ProjectController::class, 'deleteDocument'])->name('project.delete-document');
    Route::post('/update-project-document/{id}', [App\Http\Controllers\Project\ProjectController::class, 'updateDocument'])->name('project.update-document');
    Route::get('/get-project-data', [App\Http\Controllers\Project\ProjectController::class, 'getProjectsData']);
    Route::get('/get-fixed-assets/{id}', [App\Http\Controllers\Project\ProjectController::class, 'getFixedAssets']);
    Route::get('/get-consumable-supplies/{id}', [App\Http\Controllers\Project\ProjectController::class, 'getConsumableSupplies']);
    Route::post('/store-project-fixed-assets', [App\Http\Controllers\Project\ProjectController::class, 'storeProjectFixedAsset']);
    Route::post('/delete-project-fixed-assets', [App\Http\Controllers\Project\ProjectController::class, 'deleteProjectFixedAsset']);
});
