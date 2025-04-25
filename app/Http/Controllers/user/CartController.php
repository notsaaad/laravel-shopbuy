<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class CartController extends Controller
{
  public function index(){
    if (! auth()->check()) {
      return redirect()->route('login');
    }
    $cart = Cart::session(auth()->id())->getContent();
    $cartItems = array();
    foreach ($cart as $item) {
      $item->associatedModel->qty = $item->quantity;
      array_push($cartItems, $item->associatedModel);
    }
    return view('user.cart', compact('cartItems'));
    return $cartItems;
  }
  public function add(Request $request)
  {
      $request->validate([
          'product_id' => 'required|exists:products,id',
          'quantity' => 'required|integer|min:1'
      ]);
      $product = Product::findOrFail($request->product_id);


      $sessionKey = auth()->check() ? auth()->id() : session()->getId();

      Cart::session($sessionKey)->add([
          'id' => $product->id,
          'name' => $product->title,
          'price' => $product->sale,
          'quantity' => $request->quantity,
          'attributes' => [],
          'associatedModel' => $product
      ]);

      return redirect()->back()->with('success', 'Added To Cart');
  }


  public function remove($product_id){
    $userId = Auth::id();
    Cart::session($userId)->remove($product_id);
    return redirect()->back()->with('success', 'Removed From Cart');
  }
}
