<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\BonusController;

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login_post', [LoginController::class, 'login_post'])->name('login_post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/bonus/list', [BonusController::class, 'index'])->name('bonus_list');
    Route::get('/bonus/detail/{id}', [BonusController::class, 'show'])->name('bonus_detail');
    Route::get('/bonus/add', [BonusController::class, 'create'])->name('bonus_add');
    Route::post('/bonus/post', [BonusController::class, 'store'])->name('bonus_post');
    
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/bonus/edit/{id}', [BonusController::class, 'edit'])->name('bonus_edit');
        Route::put('/bonus/update/{id}', [BonusController::class, 'update'])->name('bonus_update');
        Route::delete('/bonus/delete/{id}', [BonusController::class, 'destroy'])->name('bonus_delete');
    });
});