<?php

namespace App\Http\Controllers\APIs;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  function index(){
    $Product = Product::get();
    return response()->json([
    'status' => true,
    'message' => 'Products retrieved successfully.',
    'data' => $Product,
    ], 200);
  }
}
