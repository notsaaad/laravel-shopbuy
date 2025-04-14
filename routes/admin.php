<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductsController;


Route::get('/', [HomeController::class , 'index'])->name('admin.home');

// Route::withoutMiddleware('is_admin')->group(function (){
  Route::get('/Login', [AuthController::class, 'login'])->name('admin.index');
  Route::post('/login-post', [AuthController::class, 'postLogin'])->name('admin.post.login');
// });




Route::get('/product/add', [ProductsController::class, 'add'])->name('admin.product.add');
Route::post('/product/post', [ProductsController::class, 'post'])->name('admin.product.post');
Route::get('/products', [ProductsController::class, 'index'])->name('admin.products.index');
Route::get('/products/edit/{id}', [ProductsController::class, 'edit'])->name('admin.products.edit');
Route::post('/products/postEdit/{id}', [ProductsController::class, 'postedit'])->name('admin.products.postedit');
Route::post('/products/DeleteAll', [ProductsController::class, 'deleteAll'])->name('admin.products.deleteAll');
Route::post('/product/Delete',[ProductsController::class, 'Delete'])->name('admin.products.delete');
Route::post('/product/SetAllPublish',[ProductsController::class, 'SetAllPublish'])->name('admin.products.SetAllPublish');
Route::post('/product/SetAllDraft',[ProductsController::class, 'SetAllDraft'])->name('admin.products.SetAllDraft');



Route::resource('users', UserController::class);
Route::post('/users/deleteAll', [UserController::class, 'deleteAll'])->name('admin.users.deleteAll');



Route::resource('category', CategoryController::class);
Route::post('/category/deleteAll', [CategoryController::class, 'deleteAll'])->name('admin.category.deleteAll');
