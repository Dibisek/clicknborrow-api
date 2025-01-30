<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ReservationController;
use App\Models\Book;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
//     Route::apiResource('authors', 'AuthorController');
//     Route::apiResource('books', 'BookController');
//     Route::apiResource('categories', 'CategoryController');
//     Route::apiResource('reservations', 'ReservationController');
// });

Route::prefix('v1')->group(function () {
    Route::apiResource('authors', AuthorController::class)
    ->only(['index', 'show']);

    Route::apiResource('books', BookController::class)
        ->only(['index', 'show']);

    Route::apiResource('books', BookController::class)
        ->only(['store', 'update', 'destroy'])
        ->middleware('auth:sanctum');

    Route::apiResource('categories', CategoryController::class)
        ->only(['index', 'show']);

    Route::apiResource('reservations', ReservationController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy'])
        ->middleware('auth:sanctum');


    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});

