<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\V1\RoverController;
use App\Http\Api\V1\MapController;

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
Route::group( ["prefix" => "v1"], function () {
    Route::group(["prefix" => "map"], function () {
        Route::post("/", [MapController::class, "createMap"])->name("api-create-map");
        Route::get("/{id}", [MapController::class, "getMap"])->name('api-get-map');
    });

    Route::group( ["prefix" => "rover"], function () {
        Route::post("/", [RoverController::class, "createRover"])->name("api-create-rover");
        Route::post("/{roverId}/move", [RoverController::class, "moveRover"])->name("api-move-rover");
    });
});
