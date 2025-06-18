<?php

namespace App\Http\Controllers\APIs;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  function index(){
    $Product = Product::get();

    foreach ($Product as $q) {
      $path       = ProductImagePath() . $q->image;
      $q->image = URL::asset($path);
    }

    return response()->json([
    'status' => true,
    'message' => 'Products retrieved successfully.',
    'data' => $Product,
    ], 200);
  }

  function category($id){
    $category  = Category::find($id);
    $product   = $category->products;

    foreach ($product as $q) {
      $path       = ProductImagePath() . $q->image;
      $q->image = URL::asset($path);
    }

    return response()->json([
      'status' => true,
      'message' => 'Products retrieved successfully.',
      'data'    => $product,
    ], 200);
  }
}
