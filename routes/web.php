<?php

use App\Http\Controllers\API;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\AuthController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\user\StoreController;
use App\Http\Controllers\admin\ProductsController;

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




Route::get('/',   [HomeController::class, 'home'])->name('index');


// =============================== Start Auth Routes ================================

Route::controller(AuthController::class)->group(function(){
  Route::get('/login' ,'login')->name('login')->middleware('guest');
  Route::post('post-login' ,'postLogin')->name('loign_post');
  Route::get('/signup' ,'Signup')->name('Signup')->middleware('guest');
  Route::post('/post-new-Account' ,'new_user')->name('signup_post');
  Route::get('logout' ,'logout')->name('logout');
  Route::get('/account', 'account')->name('myaccount')->middleware('auth');
});



// =============================== End Auth Routes ================================


Route::controller(CartController::class)->group(function(){
  Route::get('/cart', 'index')->name('cart');
  Route::post('/cart/add', 'add')->name('add_product');
  Route::get('/cart/remove/{product_id}', 'remove')->name('cart_remove');
  Route::post('/cart/update/{id}', 'update')->name('cart_update');
});

Route::get('/categories', [StoreController::class, 'categories'])->name('Store.AllCategories');

Route::prefix('/store')->controller(StoreController::class)->group(function(){
  Route::get('/{category?}', 'index')->name('store');
  Route::get('/product/{id}', 'product_show')->name('product.show');
});



Route::get('api/products', [API::class, 'index']);
