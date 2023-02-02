<?php

use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\CancionController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\RepertorioController;
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
    Route::get('/data-source-cancion', [CancionController::class, 'data_source_cancion']);

});

Route::prefix('miembros')->group(function () {
    Route::get('/', [MembersController::class, 'index']);
    Route::post('/store', [MembersController::class, 'store']);
    Route::put('/update', [MembersController::class, 'update']);
    Route::delete('/destroy', [MembersController::class, 'destroy']);
    Route::get('/show/{id}', [MembersController::class, 'show']);
    Route::get('/search', [MembersController::class, 'search']);
    Route::get('/data-source-member', [MembersController::class, 'data_source_member']);

});

Route::prefix('repertorio')->group(function () {
    Route::get('/', [RepertorioController::class, 'index']);
    Route::post('/store', [RepertorioController::class, 'store']);
    Route::put('/update', [RepertorioController::class, 'update']);
    Route::delete('/destroy', [RepertorioController::class, 'destroy']);
    Route::get('/show/{id}', [RepertorioController::class, 'show']);
});
