<?php

use Blume\Modules\Admin\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web']], function () {
    Route::get('welcome', function () {
        return view('admin::welcome');
    });

    Route::group(['prefix' => 'test', 'as' => 'test.'], function () {
        Route::get('auth', function () {
            return view('admin::apiAuthTest');
        });

        Route::get('events', function () {
            return view('admin::apiEventsTest');
        });

        Route::get('plugins', function () {
            return view('admin::apiPluginsTest');
        });

        Route::get('modules', function () {
            return view('admin::apiModulesTest');
        });

        Route::get('carbon', function () {
            return view('admin::apiCarbonTest');
        });
    });

    Route::resource('posts', PostsController::class)
        /*->middleware(['role:admin'])*/;
});

Route::get('admin', function () {
    return view('admin::welcome');
});

/*Route::group(['middleware' => ['role:editor']], function () {
    Route::get('editor/dashboard', [EditorController::class, 'index']);
});*/
