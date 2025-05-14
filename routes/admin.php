<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductsController;
use App\Http\Controllers\admin\AttributeController;


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
Route::get('/product/getAllAttributs',[ProductsController::class, 'GetAllAttributs'] )->name('admin.products.GetAllAttributs');
Route::get('/product/getAllAttributsValues/{id}',[ProductsController::class, 'GetAllAttributsvalues'] )->name('admin.products.GetAllAttributsValues');
Route::get('/prouct/{product}/variants', [ProductsController::class, 'editVaraint'])->name('admin.products.variants.edit');
Route::post('/prouct/{product}/variantspost', [ProductsController::class, 'editVaraintpost'])->name('admin.products.variants.store');
Route::get('/prouct/{product}/variants2', [ProductsController::class, 'editVaraint2'])->name('admin.products.variants.edit2');
Route::post('/prouct/{product}/variantspost2', [ProductsController::class, 'editVaraintpost2'])->name('admin.products.variants.store2');





Route::resource('users', UserController::class);
Route::post('/users/deleteAll', [UserController::class, 'deleteAll'])->name('admin.users.deleteAll');





Route::resource('category', CategoryController::class);
Route::post('/category/deleteAll', [CategoryController::class, 'deleteAll'])->name('admin.category.deleteAll');





Route::prefix('attribute')->controller(AttributeController::class)->group(function(){
  Route::get('/', 'index')->name('attribute.index');
  Route::get('/add', 'add')->name('attribute.add');
  Route::post('/save', 'store')->name('attribute.store');
  Route::delete('/destroy/{id}', 'destroy')->name('attribute.destroy');
  Route::post('/DeleteAttAll', 'DeleteAllAtt')->name('attributes.DeleteALL');
  Route::get('edit/{id}', 'Edit')->name('Attribut.edit');
  Route::post('/post_edit/{id}', 'post_edit_att')->name('attribute.post_edit');
  // ================= Start Attributes values =========

    Route::get('/values/{id}', 'att_value_show')->name('att-values.view'); //$att id
    Route::get('/value-add/{id}', 'att_value_add')->name('att_values.add');
    Route::post('/value-post/{id}', 'store_value_add')->name('att_value_store');
    Route::delete('/value-delete/{id}', 'delete_value')->name('att_value_delete');
    Route::get('/value-edit/{id}', 'edit_page')->name('att_value_edit');
    Route::post('/value_post_edit/{id}', 'update_att_value')->name('att_update_value');
    Route::post('/DeleteALLValues', 'DeleteALLValues')->name('att_value_delete_all');
  // ================= End Attributes values ===========
});

