<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFControllerUsers;
use App\Http\Controllers\ExcelControllerUsers;

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


Auth::routes(["register" => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/error403', [App\Http\Controllers\Error403Controller::class, 'index'])->name('error403');

    // Report in pdf
    Route::get('/reports/users/{typeuser}', [PDFControllerUsers::class, 'PDF'])->name('usersReport');

    // Report in Excel
    Route::get('/reports/excel/users', [ExcelControllerUsers::class, 'export'])->name('usersExcel');

    