<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ExclusionController;

Route::group(['middleware' => 'auth'], function() {
    /**
     * 保守管理
     */
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    // 保守管理表
    Route::prefix('/main')->name('main.')->group(function () {
        Route::get('/{code?}', [MainController::class, 'index'])->name('index');
        Route::post('/{code?}', [MainController::class, 'post'])->name('post');
        Route::patch('/{code?}', [MainController::class, 'release'])->name('release');
        Route::get('/{code?}/download/{filename}', [MainController::class, 'download'])->name('download');
    });

    // 複合条件検索
    Route::prefix('/search')->name('search.')->group(function () {
        Route::get('/', [SearchController::class, 'index'])->name('index');
        Route::post('/delete', [SearchController::class, 'delete'])->name('delete');
    });

    // 帳票インポート
    Route::prefix('/import')->name('import.')->group(function () {
        Route::get('/', [ImportController::class, 'index'])->name('index');
        Route::post('/daily-report', [ImportController::class, 'importDailyReport'])->name('daily-report');
        Route::post('/relocation-reception', [ImportController::class, 'importRelocationReception'])->name('relocation-reception');
    });

    /**
     * マスタ管理
     */
    Route::prefix('/master')->name('master.')->group(function () {
        Route::get('/{kind}', [MasterController::class, 'index'])->name('index');
        Route::post('/{kind}/delete', [MasterController::class, 'delete'])->name('delete');
        Route::get('/{kind}/add', [MasterController::class, 'edit'])->name('add');
        Route::post('/{kind}/add', [MasterController::class, 'post'])->name('add.post');
        Route::get('/{kind}/{id}', [MasterController::class, 'edit'])->name('edit');
        Route::post('/{kind}/{id}', [MasterController::class, 'post'])->name('edit.post');
    });

    // 排他管理
    Route::prefix('/exclusion')->name('exclusion.')->group(function () {
        Route::get('/', [ExclusionController::class, 'index'])->name('index');
        Route::post('/delete', [ExclusionController::class, 'delete'])->name('delete');
    });

});

