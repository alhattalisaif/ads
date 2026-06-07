<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\WalletController;

Route::post('auth/google', [AuthController::class, 'googleCallback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('ads', AdController::class);
    Route::get('wallet', [WalletController::class, 'show']);
    Route::post('wallet/deposit', [WalletController::class, 'deposit']);
});
