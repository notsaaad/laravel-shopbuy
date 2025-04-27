<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class CartController extends Controller
{
  public function index(){
    $sessionKey = auth()->check() ? auth()->id() : session()->getId();
    $cartItems = Cart::session($sessionKey)->getContent();
    $adjustedItems = [];

    foreach ($cartItems as $item) {
        if ($item->attributes->type === 'variant' && isset($item->attributes->variant_id)) {
            $variant = \App\Models\ProductVariant::find($item->attributes->variant_id);

            if ($variant) {
                if ($variant->stock === 0) {
                    // لا تعديل لو نفذ المخزون لكن نسجل اسم المنتج
                    $adjustedItems[] = '"' . $item->name . '" is Out of Stock.';
                    continue;
                }

                if ($item->quantity > $variant->stock) {
                    Cart::session($sessionKey)->update($item->id, [
                        'quantity' => [
                            'relative' => false,
                            'value' => $variant->stock,
                        ],
                    ]);

                    $adjustedItems[] = '"' . $item->name . '" adjusted to available stock (' . $variant->stock . ').';
                }
            }
        }
    }

    // رسالة جماعية
    if (!empty($adjustedItems)) {
        session()->flash('error', implode('<br>', $adjustedItems));
    }

    $cartItems = Cart::session($sessionKey)->getContent(); // إعادة تحميل بعد التعديل
    $cartTotal = Cart::session($sessionKey)->getTotal();

    return view('user.cart', compact('cartItems', 'cartTotal'));
    return $cartItems;
  }
  public function add(Request $request){
    $request->validate([
      'product_id' => 'required|exists:products,id',
      'quantity' => 'nullable|integer|min:1',
      'variant_id' => 'nullable|exists:product_variants,id',
  ]);

  $product = Product::findOrFail($request->product_id);
  $quantity = $request->quantity ?? 1; // لو مش مرسلة

  // الحصول على sessionKey بناء على حالة المستخدم
  $sessionKey = auth()->check() ? auth()->id() : session()->getId();

  // Simple Product Logic
  if ($product->type === 'simple') {
      Cart::session($sessionKey)->add([
          'id' => 'product_' . $product->id,
          'name' => $product->title,
          'price' => $product->sale ?? $product->price,
          'quantity' => $quantity,
          'attributes' => [
              'image' => $product->image,
              'type' => 'simple',
          ],
          'associatedModel' => $product
      ]);
  }

  // Variant Product Logic
  if ($product->type === 'variant') {
      $variant = ProductVariant::findOrFail($request->variant_id);

      // Get attributes for display (optional)
      $variantAttributes = $variant->attributeValues->map(function ($attrVal) {
          return [
              'attribute' => $attrVal->attribute->name,
              'value' => $attrVal->value,
              'color_code' => $attrVal->color_code,
          ];
      });

      Cart::session($sessionKey)->add([
          'id' => 'variant_' . $variant->id,
          'name' => $product->title,
          'price' => $product->sale ?? $product->price,
          'quantity' => $quantity,
          'attributes' => [
              'image' => $variant->image_path ?? $product->image,
              'type' => 'variant',
              'variant_id' => $variant->id,
              'variant_attributes' => $variantAttributes,
          ],
          'associatedModel' => $product
      ]);
  }

      return redirect()->back()->with('success', 'Added To Cart');
  }


  public function remove($product_id){
    $userId = Auth::id();
    Cart::session($userId)->remove($product_id);
    return redirect()->back()->with('success', 'Removed From Cart');
  }

  public function update(Request $request, $id){
      $request->validate([
          'quantity' => 'required|integer|min:1',
      ]);

      $sessionKey = auth()->check() ? auth()->id() : session()->getId();
      $cartItem = Cart::session($sessionKey)->get($id);

      if (!$cartItem) {
          return redirect()->back()->with('error', 'Item not found in cart.');
      }

      // تحقق من نوع المنتج
      if ($cartItem->attributes->type === 'variant') {
          $variant = ProductVariant::find($cartItem->attributes->variant_id);
          if (!$variant || $variant->stock < $request->quantity) {
              return redirect()->back()->with('error', 'Requested quantity exceeds available stock (' . $variant->stock . ').');
          }
      }

      // لو Simple ممكن تضيف تحقق من المخزون هنا لو عايز
      // تحديث الكمية
      Cart::session($sessionKey)->update($id, [
          'quantity' => [
              'relative' => false,
              'value' => $request->quantity,
          ],
      ]);

      return redirect()->back()->with('success', 'Quantity updated successfully.');
  }


}



