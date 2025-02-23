<?php

use Entryshop\Admin\Http\Controllers\AuthController;
use Entryshop\Admin\Http\Controllers\FormSubmitController;
use Entryshop\Admin\Http\Controllers\IndexController;
use Entryshop\Admin\Http\Controllers\RenderElementController;
use Entryshop\Admin\Http\Middlewares\AdminAuthenticate;
use Illuminate\Support\Facades\Route;

admin()->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'submitLogin'])->name('login.submit');
    Route::any('logout', [AuthController::class, 'logout'])->name('logout');

    Route::any('render', RenderElementController::class)->name('api.render.element');
    Route::post('form-submit', FormSubmitController::class)->name('api.form.submit');

    Route::group(['middleware' => AdminAuthenticate::class], function () {
        Route::get('/', IndexController::class)->name('home');
    });
});
