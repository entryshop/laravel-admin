<?php

use Entryshop\Admin\Http\Controllers\AuthController;
use Entryshop\Admin\Http\Controllers\FormSubmitController;
use Entryshop\Admin\Http\Controllers\RenderElementController;
use Illuminate\Support\Facades\Route;

admin()->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('login', [AuthController::class, 'submitLogin'])->name('admin.login.submit');
    Route::any('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::any('render', RenderElementController::class)->name('admin.api.render.element');
    Route::post('form-submit', FormSubmitController::class)->name('admin.api.form.submit');
});
