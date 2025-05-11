<?php

use App\Http\Controllers\homeController;
use Illuminate\Support\Facades\Route;

Route::get('/zz', [homeController::class, 'index'])->middleware('auth')->name('home');
