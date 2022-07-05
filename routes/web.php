<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\IconUploadController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceGeneratorController;
use App\Http\Controllers\UserBankController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\UserPanelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::post('upload-icon', [IconUploadController::class, 'upload'])->name('upload');

Route::post('generate-invoice', [InvoiceGeneratorController::class, 'generate'])->name('generate');

Route::post('download-invoice', [InvoiceGeneratorController::class, 'download'])->name('download');

Route::get('redownload-invoice/{id}', [InvoiceGeneratorController::class, 'redownload'])->name('redownload');

Route::get('load-invoice/{id}', [InvoiceGeneratorController::class, 'load'])->name('load');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoiceController::class);

Route::resource('userDetails', UserInfoController::class);

Route::resource('userBanks', UserBankController::class);

Route::resource('clients', ClientController::class);

Route::get('user-panel', [UserPanelController::class, 'index'])->name('user-panel');
