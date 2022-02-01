<?php

use App\Http\Controllers\ProductsController;
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

Route::get('/', [ProductsController::class, 'index'])->name('all_products');

Route::get('/add', [ProductsController::class, 'newItem'])->name('add_product');

Route::post('/store', [ProductsController::class, 'store'])->name('store_product');

Route::delete('product/{id}', [ProductsController::class, 'destroy'])->name('destroy_product');

Route::get('product/{id}', [ProductsController::class, 'edit'])->name('edit_product');

Route::put('update/{id}', [ProductsController::class, 'update'])->name('update_product');
