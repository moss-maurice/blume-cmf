<?php

use Illuminate\Support\Facades\Route;

Route::get('admin/welcome', function () {
    return view('admin::welcome');
});

Route::get('admin/events', function () {
    return view('admin::apiEventsTest');
});

Route::get('admin/plugins', function () {
    return view('admin::apiPluginsTest');
});

Route::get('admin/modules', function () {
    return view('admin::apiModulesTest');
});

Route::get('admin', function () {
    return view('admin::welcome');
});
