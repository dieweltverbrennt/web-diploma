<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HallController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\API\UserController;

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

Route::apiResource('halls', HallController::class);
Route::apiResource('films', FilmController::class);
Route::apiResource('sessions', SessionController::class);
Route::apiResource('seats', SeatController::class);

Route::middleware('auth:sanctum')->get('/access', function (Request $request) {
    if ($request->user()) {
        return response()->json(['success' => true, 'user' => $request]);
    } else {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], Response::HTTP_OK);
    }
});

Route::post('/login', [UserController::class, 'login']);