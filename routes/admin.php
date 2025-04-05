<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProductsController;


Route::get('/', [HomeController::class , 'index'])->name('admin.home');

// Route::withoutMiddleware('is_admin')->group(function (){
  Route::get('/Login', [AuthController::class, 'login'])->name('admin.index');
  Route::post('/login-post', [AuthController::class, 'postLogin'])->name('admin.post.login');
// });




Route::get('/product/add', [ProductsController::class, 'add'])->name('admin.product.add');
Route::post('/product/post', [ProductsController::class, 'post'])->name('admin.product.post');



Route::resource('users', UserController::class);
