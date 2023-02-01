<?php

use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\CancionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/store', [UserController::class, 'store']);
    Route::put('/update', [UserController::class, 'update']);
    Route::get('/show/{id}', [UserController::class, 'show']);
});

Route::prefix('artistas')->group(function () {
    Route::get('/', [ArtistaController::class, 'index']);
    Route::post('/store', [ArtistaController::class, 'store']);
    Route::put('/update', [ArtistaController::class, 'update']);
    Route::delete('/destroy', [ArtistaController::class, 'destroy']);
    Route::get('/show/{id}', [ArtistaController::class, 'show']);
    Route::get('/search', [ArtistaController::class, 'search']);
    Route::get('/data-source-artista', [ArtistaController::class, 'data_source_artista']);

});


Route::prefix('canciones')->group(function () {
    Route::get('/', [CancionController::class, 'index']);
    Route::post('/store', [CancionController::class, 'store']);
    Route::put('/update', [CancionController::class, 'update']);
    Route::delete('/destroy', [CancionController::class, 'destroy']);
    Route::get('/show/{id}', [CancionController::class, 'show']);
    Route::get('/search', [CancionController::class, 'search']);
});
