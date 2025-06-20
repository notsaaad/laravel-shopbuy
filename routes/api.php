<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\AuthController;
use App\Http\Controllers\APIs\UserController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\APIs\ProductController;
use App\Http\Controllers\APIs\CategroyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/products', [HomeController::class, 'api_product']);


Route::controller(ProductController::class)->prefix('products')->group(function(){
  Route::get('/', 'index');
  Route::get('{id}','category' );
  Route::get('/single/{id}', 'single_product');
});



Route::controller(CategroyController::class)->prefix('categroies')->group(function(){
  Route::get('/', 'index');
});



Route::controller(UserController::class)->prefix('users')->group(function(){
  Route::get('/', 'index');
});



Route::controller(AuthController::class)->group(function(){
  Route::post('/register',  'register');
  Route::post('/login',  'login');
  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile',  'profile');
    Route::post('/logout',  'logout');
  });
});


