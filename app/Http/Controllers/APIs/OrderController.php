<?php

namespace App\Http\Controllers\APIs;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\OrderUserMeta;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


  function store(Request $request){
       $request->validate([
        'shipping.name'     => 'required|string',
        'shipping.email'    => 'required|email',
        'shipping.phone'    => 'required|string',
        // 'shipping.country'  => 'required|string',
        'shipping.city'     => 'required|string',
        'shipping.address'  => 'required|string',
        'items'             => 'required|array|min:1',
        'total_price'       => 'required|numeric',
    ]);

    $userId = Auth::id();


    $order = Order::create([
        'user_id'     => $userId,
        'total_price' => $request->total_price,
        'status'      => 'pending',
    ]);


    foreach ($request->items as $item) {
        OrderItem::create([
            'order_id'          => $order->id,
            'product_title'     => $item['product_title'],
            'product_image'     => $item['product_image'],
            'variant_attributes' => json_encode($item['variant_attributes']),
            'unit_price'        => $item['unit_price'],
            'quantity'          => $item['quantity'],
            'total_price'       => $item['unit_price'] * $item['quantity'],
        ]);
    }


    $shipping = $request->shipping;
    OrderUserMeta::create([
        'order_id' => $order->id,
        'name'     => $shipping['name'],
        'email'    => $shipping['email'],
        'phone'    => $shipping['phone'],
        'country'  => $shipping['country'],
        'city'     => $shipping['city'],
        'address'  => $shipping['address'],
    ]);

    return response()->json([
        'message' => 'تم إنشاء الطلب بنجاح',
        'order_id' => $order->id,
    ], 201);
  }

}
