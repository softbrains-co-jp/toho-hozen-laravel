<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ExclusionController;

Route::group(['middleware' => 'auth'], function() {
    /**
     * 保守管理
     */
    // 保守管理表
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/main/{code?}', [MainController::class, 'index'])->name('main.index');
    Route::post('/main/{code?}', [MainController::class, 'post'])->name('main.post');
    Route::patch('/main/{code?}', [MainController::class, 'release'])->name('main.release');
    Route::get('/main/{code?}/download/{filename}', [MainController::class, 'download'])->name('main.download');

    // 複合条件検索
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search/delete', [SearchController::class, 'delete'])->name('search.delete');


    /**
     * マスタ管理
     */
    Route::get('/master/{kind}', [MasterController::class, 'index'])->name('master.index');
    Route::post('/master/{kind}/delete', [MasterController::class, 'delete'])->name('master.delete');
    Route::get('/master/{kind}/add', [MasterController::class, 'edit'])->name('master.add');
    Route::post('/master/{kind}/add', [MasterController::class, 'post'])->name('master.add.post');
    Route::get('/master/{kind}/{id}', [MasterController::class, 'edit'])->name('master.edit');
    Route::post('/master/{kind}/{id}', [MasterController::class, 'post'])->name('master.edit.post');

    // 排他管理
    Route::get('/exclusion', [ExclusionController::class, 'index'])->name('exclusion.index');
    Route::post('/exclusion/delete', [ExclusionController::class, 'delete'])->name('exclusion.delete');

});

