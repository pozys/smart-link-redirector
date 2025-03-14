<?php

use App\Infrastructure\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:auth_service')->group(function () {
    Route::get('/redirect/{link}', [RedirectController::class, 'resolve'])->name('redirect');
});
