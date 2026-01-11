<?php

use App\Http\Controllers\CryptoController;

Route::get('/', [CryptoController::class, 'index']);
Route::post('/encrypt', [CryptoController::class, 'encryptMessage']);
Route::post('/decrypt', [CryptoController::class, 'decryptMessage']);


