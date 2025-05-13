<?php

namespace App\Http\Controllers\user;

use App\Models\User;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderUserMeta;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class OrderController extends Controller
{
    private function getSessionKey(){
      return auth()->check() ? auth()->id() : session()->getId();
    }


    function checkout(){
        $sessionKey = $this->getSessionKey();
        $cartItems = Cart::session($sessionKey)->getContent();
        $adjustedItems = [];

        foreach ($cartItems as $item) {
            if ($item->attributes->type === 'variant' && isset($item->attributes->variant_id)) {
                $variant = ProductVariant::find($item->attributes->variant_id);

                if ($variant) {
                    if ($variant->stock === 0) {
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

            if ($item->attributes->type === 'simple') {
                $product = Product::find($item->associatedModel->id);
                if ($product && $product->stock !== null) {
                    if ($product->stock === 0) {
                        $adjustedItems[] = '"' . $item->name . '" is Out of Stock.';
                        continue;
                    }

                    if ($item->quantity > $product->stock) {
                        Cart::session($sessionKey)->update($item->id, [
                            'quantity' => [
                                'relative' => false,
                                'value' => $product->stock,
                            ],
                        ]);
                        $adjustedItems[] = '"' . $item->name . '" adjusted to available stock (' . $product->stock . ').';
                    }
                }
            }
        }

        if (!empty($adjustedItems)) {
            session()->flash('error', implode('<br>', $adjustedItems));
        }

        $cartItems = Cart::session($sessionKey)->getContent();
        $cartTotal = Cart::session($sessionKey)->getTotal();




      return view('user.checkout', compact('cartItems', 'cartTotal'));
    }

    public function store(Request $request)
    {
     // 1. التحقق من صحة البيانات
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'required|string|max:50',
        'country' => 'required|string|max:100',
        'city'    => 'required|string|max:100',
        'address' => 'required|string|max:1000',
    ]);



    $sessionKey = $this->getSessionKey();
    $cartItems = Cart::session($sessionKey)->getContent();

    if ($cartItems->isEmpty()) {
        return back()->withErrors(['cart' => 'السلة فارغة']);
    }

    // 2. حساب السعر الكلي
    $total = $cartItems->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    DB::beginTransaction();

    try {
        // 3. إنشاء الطلب
        $order = Order::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // 4. حفظ بيانات العميل
        $order->userMeta()->create([
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'phone'       => $request->input('phone'),
            'country'     => $request->input('country'),
            'city'        => $request->input('city'),
            'address'     => $request->input('address'),
            'postal_code' => null,
        ]);

        // 5. حفظ المنتجات في order_items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_title' => $item->name,
                'product_image' => $item->attributes['image'] ?? null,
                'variant_attributes' => $item->attributes['variant_attributes'] ?? [],
                'unit_price' => $item->price,
                'quantity' => $item->quantity,
                'total_price' => $item->price * $item->quantity,
            ]);
        }

        DB::commit();

        // 6. تفريغ السلة
        Cart::clear();

        return redirect()->route('thank.you.page', $order)->with('success', 'تم إرسال طلبك بنجاح');

    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage());
        return back()->withErrors(['error' => 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage()]);
    }
  }
    public function thankYou(Order $order)
    {
        $order->load('items', 'userMeta');
        return view('user.thank_you', compact('order'));
    }
}
