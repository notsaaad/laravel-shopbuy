<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    function index(){
      return view('user.store');
    }









    // =============================== Prodducts ===============================

    function product_show($id){
      $product = Product::with('variants.attributeValues.attribute')->findOrFail($id);
      // return $product;
      return view('user.singleProduct', compact('product'));
    }
}
