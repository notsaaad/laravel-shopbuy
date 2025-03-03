<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\HomeController;

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



Route::get('/', [HomeController::class, 'home'])->name('index');
Route::get('/store', [HomeController::class, 'store'])->name('store');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/signup', [HomeController::class, 'Signup'])->name('Signup');
Route::post('/post-new-Account', [HomeController::class, 'new_user'])->name('signup_post');

