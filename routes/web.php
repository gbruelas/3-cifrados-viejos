<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CesarController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cesar', [CesarController::class, 'index']);
Route::post('/cesar', [CesarController::class, 'procesar'])->name('cesar.procesar');

Route::get('/', [CesarController::class, 'index']);
Route::post('/procesar', [CesarController::class, 'procesar'])->name('cesar.procesar');
