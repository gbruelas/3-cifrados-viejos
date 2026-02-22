<?php

use App\Http\Controllers\PolybiosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CesarController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Polybios
Route::prefix('polybios')->name('polybios.')->group(function () {
    Route::get('/', [PolybiosController::class, 'index'])->name('index');
    Route::post('/encrypt', [PolybiosController::class, 'encrypt'])->name('encrypt');
    Route::post('/decrypt', [PolybiosController::class, 'decrypt'])->name('decrypt');
});

// César
Route::prefix('cesar')->name('cesar.')->group(function () {
    Route::get('/', [CesarController::class, 'index'])->name('index');
    Route::post('/encrypt', [CesarController::class, 'encrypt'])->name('encrypt');
    Route::post('/decrypt', [CesarController::class, 'decrypt'])->name('decrypt');
    Route::get('/info', [CesarController::class, 'info'])->name('info');
});

// Vigenere
Route::get('/vigenere', function () {
    return view('vigenere.index');
})->name('vigenere.index');
