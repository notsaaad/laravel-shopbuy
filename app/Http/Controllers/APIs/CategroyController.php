<?php

namespace App\Http\Controllers\APIs;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategroyController extends Controller
{
  function index(){
    $categroies = Category::get();

    foreach ($categroies as $cat) {
      $cat->image = CategoryImagePath().$cat->image;
    }
    return response()->json([
    'status' => true,
    'message' => 'Categories retrieved successfully.',
    'data' => $categroies,
    ], 200);
  }
}
