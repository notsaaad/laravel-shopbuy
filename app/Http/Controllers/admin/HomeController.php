<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
  function index(){
    $allProducts  = Product::count();
    $allUsers     = User::count();
    $Attributes   = Attribute::count();
    $products     = Product::with('categories')->paginate(SELF::Pagination_count);
    return view('admin.Home', get_defined_vars());
  }
}
