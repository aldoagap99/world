<?php

use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/countries', [CountryController::class, 'list']);
Route::post('/countries/item/{id}', [CountryController::class, 'item']);
Route::post('/countries/create', [CountryController::class, 'create']);
Route::post('/countries/update', [CountryController::class, 'update']);
Route::post('/countries/delete', [CountryController::class, 'delete']);


Route::get('/states', [StateController::class, 'list']);
Route::get('/states/item/{id}', [StateController::class, 'item']);
Route::post('/states/create', [StateController::class, 'create']);
Route::post('/states/update', [StateController::class, 'update']);
Route::post('/states/delete', [StateController::class, 'delete']);


Route::get('/cities', [CityController::class, 'list']);
Route::get('/cities/item/{id}', [CityController::class, 'item']);
Route::post('/cities/create', [CityController::class, 'create']);
Route::post('/cities/update', [CityController::class, 'update']);
Route::post('/cities/delete', [CityController::class, 'delete']);








Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});