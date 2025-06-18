<?php

namespace App\Http\Controllers\APIs;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  function index(){
    $Product = Product::where('is_draft', 1)->get();

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
    $product   = $category->products()->where('is_draft', 1);

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
