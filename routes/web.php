<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::post('/guestMessage', [FrontendController::class, 'guestMessage'])->name('guestMessage');
