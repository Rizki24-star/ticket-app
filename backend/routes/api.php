<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('tickets', TicketController::class);
    Route::post('tickets/{ticket}/response', [TicketController::class, 'respond']);
});
