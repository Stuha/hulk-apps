<?php

use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoriteController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::apiResource('/movie', MovieController::class)->only('index', 'show');
Route::apiResource('/post', PostController::class)->except('index');
Route::apiResource('/follow', FollowController::class)->except('show');
Route::apiResource('/favorite', FavoriteController::class)->only('index', 'store', 'destroy');
