<?php

use App\Http\Controllers\Admin\BukuBesarController;
use App\Http\Controllers\Admin\CashFlowController;
use App\Http\Controllers\Admin\LabaRugiController;
use App\Http\Controllers\Admin\NeracaController;
use App\Http\Controllers\Admin\CoaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['as' => 'accounting.'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
    Route::group(['as' => 'coa.'], function () {
        Route::get('data-coa', [CoaController::class, 'index'])->name('coa');
        Route::post('store-coa', [CoaController::class, 'store'])->name('store-coa');
        // Route::get('edit-coa/{id}', [CoaController::class, 'edit'])->name('edit-coa');
        // Route::put('update-coa/{id}', [CoaController::class, 'update'])->name('update-coa');
        Route::put('update-coa', [CoaController::class, 'update'])->name('update-coa');
        Route::get('delete-coa/{id}', [CoaController::class, 'destroy'])->name('delete-coa');
        Route::get('export-coa-excel', [CoaController::class, 'exportExcel'])->name('export.excel');
        Route::get('export-coa-pdf', [CoaController::class, 'exportPDF'])->name('export.pdf');
    });
    Route::group(['as' => 'cashflow.'], function () {
        Route::get('data-cashflow', [CashFlowController::class, 'index'])->name('filterDate');
        // Route::get('data-cashflow', [CashFlowController::class, 'index'])->name('cashflow');
        Route::post('store-cashflow', [CashFlowController::class, 'store'])->name('store');
        // Route::put('update-cashflow', [CashFlowController::class, 'update'])->name('update');
        // Route::get('delete-cashflow/{id}', [CashFlowController::class, 'destroy'])->name('delete');
        Route::get('export-cashflow-excel', [CashFlowController::class, 'exportExcel'])->name('export.excel');
        Route::get('export-cashflow-pdf', [CashFlowController::class, 'exportPDF'])->name('export.pdf');
    });
    Route::group(['as' => 'bukubesar.'], function () {
        Route::get('buku-besar', [BukuBesarController::class, 'index'])->name('filterDate');
        Route::get('export-bukubesar-excel', [BukuBesarController::class, 'exportExcel'])->name('export.excel');
        Route::get('export-bukubesar-pdf', [BukuBesarController::class, 'exportPDF'])->name('export.pdf');
    });
    Route::group(['as' => 'neraca.'], function () {
        Route::get('data-neraca', [NeracaController::class, 'index'])->name('filterDate');
        Route::get('export-neraca-excel', [NeracaController::class, 'exportExcel'])->name('export.excel');
        Route::get('export-neraca-pdf', [NeracaController::class, 'exportPDF'])->name('export.pdf');
    });
    Route::group(['as' => 'labarugi.'], function () {
        Route::get('data-labarugi', [LabaRugiController::class, 'index'])->name('filterDate');
        Route::get('export-labarugi-excel', [LabaRugiController::class, 'exportExcel'])->name('export.excel');
        Route::get('export-labarugi-pdf', [LabaRugiController::class, 'exportPDF'])->name('export.pdf');
    });
    Route::group(['as' => 'user.'], function () {
        Route::get('data-user', [UserController::class, 'index'])->name('filterDate');
        Route::post('store-user', [UserController::class, 'store'])->name('store');
        Route::put('update-user', [UserController::class, 'update'])->name('update');
        Route::get('delete-user/{id}', [UserController::class, 'destroy'])->name('delete');
    });
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
