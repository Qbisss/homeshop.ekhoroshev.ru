<?php

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

Route::get('/', function () { return view('home'); })->name('home');
Route::get('/contact', function(){ return view('contact'); })->name('contact');
Route::get('/checkorder', function(){ return view('checkorder'); })->name('checkorder');

Route::prefix('category')->group(function(){
    Route::get('/{id}', [App\Http\Controllers\CategoryController::class, 'index'])->name('category');
    Route::get('/loadmore/{category}/{loadmore}/{order}/{type}', [App\Http\Controllers\CategoryController::class, 'load_more'])->name('load_more');
    Route::get('/sort/{id}/{order}/{type}', [App\Http\Controllers\CategoryController::class, 'sort_products'])->name('sort_products');
    Route::get('/modal/{id}', [App\Http\Controllers\CategoryController::class, 'show_fastmodal'])->name('show_fastmodal');
});

Route::get('/catalog', [App\Http\Controllers\CategoryController::class, 'mainIndex'])->name('catalog');

Route::get('/product/{id}',  [App\Http\Controllers\ProductController::class, 'index'])->name('product');
Route::get('/search/{value}', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

Route::get('/basket',  [App\Http\Controllers\BasketController::class, 'index'])->name('basket');
Route::post('/addtobasket', [App\Http\Controllers\BasketController::class, 'addtobasket'])->name('addtobasket');
Route::post('/deletefrombasket', [App\Http\Controllers\BasketController::class, 'deletefrombasket'])->name('deletefrombasket');
Route::get('/basket/productamount/{id}/{amount}', [App\Http\Controllers\BasketController::class, 'productamount'])->name('productamount');

Route::post('/basket/add_order', [App\Http\Controllers\OrderController::class, 'add_order'])->name('add_order');
Route::get('/myorder/{id}', [App\Http\Controllers\OrderController::class, 'show_order'])->name('show_order');
Route::get('/neworder/{id}', [App\Http\Controllers\OrderController::class, 'show_neworder'])->name('show_neworder');

Route::get('/lk', [App\Http\Controllers\AuthController::class, 'index_login'])->name('lk');
Route::get('/lk/orders', [App\Http\Controllers\AuthController::class, 'index_login'])->name('lk');
Route::get('/login_process', [App\Http\Controllers\AuthController::class, 'login'])->name('login_process');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'index_register'])->name('register');
Route::post('/register_process', [App\Http\Controllers\AuthController::class, 'register'])->name('register_process');
Route::get('/registered', function() { return view('registered'); })->name('registered');
