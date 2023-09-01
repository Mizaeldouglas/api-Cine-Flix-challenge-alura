<?php

use App\Http\Controllers\api\VideoController;
use App\Http\Controllers\api\CategoryController;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::prefix('v1')->group(function () {
    Route::resource('videos', VideoController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);
    Route::resource('categorias', CategoryController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    Route::get('categorias/{id}/videos', [CategoryController::class, 'videosPorCategoria']);
    Route::get('videos', [VideoController::class, 'searchVideosByTitle']);


});
