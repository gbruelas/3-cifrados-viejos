<?php

use App\Http\Controllers\PolybiosController;
use Illuminate\Support\Facades\Route;

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
Route::get('/cesar', function () {
    return view('cesar.index');
})->name('cesar.index');

// Vigenere
Route::get('/vigenere', function () {
    return view('vigenere.index');
})->name('vigenere.index');