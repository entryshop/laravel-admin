<?php

use Entryshop\Admin\Http\Controllers\AuthController;

admin()->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'submitLogin'])->name('admin.login.submit');
    Route::any('logout', [AuthController::class, 'logout'])->name('admin.logout');
});
