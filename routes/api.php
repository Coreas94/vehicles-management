<?php

use App\Http\Controllers\ImportDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleOwnershipHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);
Route::apiResource('vehicles', VehicleController::class);


Route::get('/import-excel', function () {
    return view('import');
});

Route::post('/import-excel', [ImportDataController::class, 'import'])->name('import-excel');

Route::get('/vehicle-history', [VehicleOwnershipHistoryController::class, 'index'])->name('vehicle-history');