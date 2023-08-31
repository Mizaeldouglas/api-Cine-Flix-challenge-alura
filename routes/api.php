<?php

use App\Http\Controllers\api\VideoController;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::prefix('v1')->group(function () {
    Route::resource('videos', VideoController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);
});
