<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\WalletController;

Route::get('auth/google/redirect', [AuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('ads', AdController::class);
    Route::get('wallet', [WalletController::class, 'show']);
    Route::post('wallet/deposit', [WalletController::class, 'deposit']);
});
