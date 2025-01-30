<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('authors', 'AuthorController');
    Route::apiResource('books', 'BookController');
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('reservations', 'ReservationController');
});