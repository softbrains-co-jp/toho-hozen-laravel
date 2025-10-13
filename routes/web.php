<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/main/{code?}', [MainController::class, 'index'])->name('main.index');
    Route::post('/main/{code?}', [MainController::class, 'post'])->name('main.post');
});

