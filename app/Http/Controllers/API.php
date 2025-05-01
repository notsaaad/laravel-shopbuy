<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class API extends Controller
{
    function index(){
      $products = Product::get();
      return response()->json($products);
    }
}
