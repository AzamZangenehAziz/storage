<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\crud\DestroyController;
use App\Http\Controllers\crud\ShowController;
use App\Http\Controllers\crud\StoreController;
use App\Http\Controllers\crud\UpdateController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Order\StoreController as OrderStoreController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('auth')->group(function (){
    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware([AuthMiddleware::class]);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('createuser', [AuthController::class, 'create'])->withoutMiddleware([AuthMiddleware::class]);
});
    Route::prefix('/product')->group(function (){
        Route::post('/', StoreController::class)->middleware(AdminMiddleware::class);
        Route::get('/main', IndexController::class)->middleware(AdminMiddleware::class);
        Route::get('/show/{product}', ShowController::class);
        Route::patch('/{product}', UpdateController::class);
        Route::delete('/{product}', DestroyController::class);
});
Route::prefix('/order')->group(function (){
    Route::post('/', OrderStoreController::class);
});