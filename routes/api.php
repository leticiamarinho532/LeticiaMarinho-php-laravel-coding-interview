<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientBookingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientDogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('clients', ClientController::class)->except(['destroy']);
Route::apiResource('clients.dogs', ClientDogController::class)->except(['destroy']);
Route::apiResource('clients.bookings', ClientBookingController::class)->except(['store', 'update', 'destroy'])->shallow();
Route::apiResource('bookings', BookingController::class)->only(['index']);
