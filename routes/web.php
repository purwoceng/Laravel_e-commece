<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrdersControllers;
use App\Http\Controllers\ProductController;
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

Route::get('/', [ProductController::class,'index'])->name('welcome');

Route::get('/products',ProductController::class);

Auth::routes();
Route::get('pesan/{id}', [OrdersControllers::class,'index']);
Route::post('pesan/{id}', [OrdersControllers::class,'create']);
Route::get('check_out', [OrdersControllers::class,'check_out'])->name('check_out');
Route::delete('check_out/{id}', [OrdersControllers::class,'delete']);
Route::get('konfirmasi-check-out', [OrdersControllers::class,'konfirmasi']);
Route::get('history', [HistoryController::class,'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
