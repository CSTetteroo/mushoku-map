<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Place;
use App\Models\Travels;
use App\Http\Controllers\Api\{PlaceController, TravelController, PlaceVisitController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('places', PlaceController::class);
Route::apiResource('travels', TravelController::class);
Route::apiResource('place-visits', PlaceVisitController::class);

// Custom route to get visits for one place
Route::get('places/{place}/visits', [PlaceVisitController::class, 'indexByPlace']);
