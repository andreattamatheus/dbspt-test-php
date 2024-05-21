<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TaskController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('tasks')->group(function () {
            Route::get('', [TaskController::class, 'getUserTasks']);
            Route::post('', [TaskController::class, 'store']);
            Route::put('', [TaskController::class, 'update']);
            Route::put('finishTask', [TaskController::class, 'finishTask']);
            Route::delete('/{task}', [TaskController::class, 'destroy']);
        });
    });
});
