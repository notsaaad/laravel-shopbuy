<?php

namespace App\Http\Controllers\APIs;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class CategroyController extends Controller
{
  function index(){
    $categroies = Category::withCount('products')->get();

    foreach ($categroies as $cat) {
      $path       = CategoryImagePath() . $cat->image;
      $cat->image = URL::asset($path);
    }
    return response()->json([
    'status' => true,
    'message' => 'Categories retrieved successfully.',
    'data' => $categroies,
    ], 200);
  }
}
