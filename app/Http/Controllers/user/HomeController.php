<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\user\newuserRequest;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class HomeController extends Controller
{
  function home(){
    $cartCount = 0;
    $categories = Category::withCount('products')->take(4)->get();
    // foreach ($categories as $cat) {
    //   $products = Product::where('category_id', $cat->id)->get();
    //   $count    = count($products);
    //   $cat->count = $count;
    // }

    if (auth()->check()) {
      $cart = Cart::session(auth()->id())->getContent();
      $cartCount = count($cart);
    }


    $products = Product::where('is_draft', 0)->take(6)->get();
    return view('user.home', compact('categories', 'products', 'cartCount'));
  }

  function store(){
    return view('user.store');
  }



}
