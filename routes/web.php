<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadController;
;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/paises')->group(function(){
    Route::get('/', [CountryController::class, 'index'])->name('countries');
    Route::get('/{id}', [CountryController::class, 'item'])->name('countries.item');
    Route::post('/crear', [CountryController::class, 'store'])->name('countries.store');
    Route::put('/actualizar/{id}', [CountryController::class, 'update'])->name('countries.update');

    Route::put('/status', [CountryController::class, 'status'])->name('countries.status');
});

Route::prefix('/estados')->group(function(){
    Route::get('/', [StateController::class, 'index'])->name('states');
    Route::get('/{id}', [StateController::class, 'item'])->name('states.item');
    Route::post('/crear', [StateController::class, 'store'])->name('states.store');
    Route::put('/actualizar/{id}', [StateController::class, 'update'])->name('states.update');
    Route::put('/status', [StateController::class, 'status'])->name('states.status');
});

Route::prefix('/ciudades')->group(function(){
    Route::get('/', [CityController::class, 'index'])->name('cities');
    Route::get('/{id}', [CityController::class, 'item'])->name('cities.item');
    Route::post('/crear', [CityController::class, 'store'])->name('cities.store');
    Route::put('/actualizar/{id}', [CityController::class, 'update'])->name('cities.update');
    Route::put('/status', [CityController::class, 'status'])->name('cities.status');
});


Route::prefix('/archivo')->group(function(){
    Route::get('/', [UploadController::class, 'index'])->name('archivo');
    Route::post('/crear', [UploadController::class, 'uploadDataFromText'])->name('archivo.store');

});