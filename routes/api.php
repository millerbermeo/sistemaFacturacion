<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DynamicCrudController;
use App\Http\Controllers\UserController;

// Rutas de autenticación
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});

// Rutas de usuario
Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function () {
    Route::get('/', [UserController::class, 'index'])->middleware('auth:api');
    Route::get('/{id}', [UserController::class, 'show'])->middleware('auth:api');
    Route::post('/', [UserController::class, 'store'])->middleware('auth:api');
    Route::post('/{id}', [UserController::class, 'update'])->middleware('auth:api');
    Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('auth:api');
});

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'dynamic'
    ],
    function () {
        Route::get('{model}', [DynamicCrudController::class, 'index'])->middleware('auth:api');
        Route::post('{model}', [DynamicCrudController::class, 'store'])->middleware('auth:api');
        Route::get('{model}/{id}', [DynamicCrudController::class, 'show'])->middleware('auth:api');
        Route::post('{model}/{id}', [DynamicCrudController::class, 'update'])->middleware('auth:api');
        Route::delete('{model}/{id}', [DynamicCrudController::class, 'destroy'])->middleware('auth:api');
    }
);
