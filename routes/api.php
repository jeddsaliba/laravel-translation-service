<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Translation\LocaleController;
use App\Http\Controllers\Translation\TranslationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    }); 
});

/**
 * Translations
 */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'translations'], function () {
    Route::post('/', [TranslationController::class, 'store']);
    Route::get('/{locale}', [TranslationController::class, 'list']);
    Route::group(['prefix' => '{translation}'], function () {
        Route::get('/', [TranslationController::class, 'show']);
        Route::put('/', [TranslationController::class, 'update']);
        Route::delete('/', [TranslationController::class, 'destroy']);
    });
});

/**
 * Locales
 */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'locales'], function () {
    Route::post('/', [LocaleController::class, 'store']);
    Route::get('/', [LocaleController::class, 'index']);
    Route::group(['prefix' => '{locale}'], function () {
        Route::get('/', [LocaleController::class, 'show']);
        Route::put('/', [LocaleController::class, 'update']);
        Route::delete('/', [LocaleController::class, 'destroy']);
    });
});