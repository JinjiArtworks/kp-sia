<?php

use App\Http\Controllers\Admin\LabaRugiController;
use App\Http\Controllers\Admin\NeracaController;
use App\Http\Controllers\Admin\CoaController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\AssignOp\Coalesce;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['auth'])->group(function () {
    Route::group(['as' => 'accounting.'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/neraca', [NeracaController::class, 'index'])->name('neraca');
        Route::get('/labarugi', [LabaRugiController::class, 'index'])->name('labarugi');
    });
    Route::group(['as' => 'coa.'], function () {
        Route::get('data-coa', [CoaController::class, 'index'])->name('coa');
        Route::post('store-coa', [CoaController::class, 'store'])->name('store-coa');
        // Route::get('edit-coa/{id}', [CoaController::class, 'edit'])->name('edit-coa');
        // Route::put('update-coa/{id}', [CoaController::class, 'update'])->name('update-coa');
        Route::put('update-coa', [CoaController::class, 'update'])->name('update-coa');
        Route::get('delete-coa/{id}', [CoaController::class, 'destroy'])->name('delete-coa');
    });
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
