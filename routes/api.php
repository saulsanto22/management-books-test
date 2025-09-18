<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\LoanController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum','role:admin'])->group(function () {
    Route::apiResource('books', BookController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('loans', [LoanController::class, 'store']);
    Route::get('loans/', [LoanController::class, 'index']);
});
