<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/portfolioDetail/{id}', [FrontendController::class, 'portfolioDetail'])->name('portfolioDetail');
Route::post('/guestMessage', [FrontendController::class, 'guestMessage'])->name('guestMessage');
