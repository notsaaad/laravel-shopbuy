<?php

namespace App\Http\Controllers\admin;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  function index(){
    $query = Order::query();

    if (request()->has('status') && in_array(request('status'), ['pending', 'complete', 'cancelled'])) {
        $query->where('status', request('status'));
    }

    $orders        = $query->paginate(self::Pagination_count);
    $completeCount = Order::where('status', 'complete')->count();
    $pendingCount  = Order::where('status', 'pending')->count();
    $cancledCount  = Order::where('status', 'cancelled')->count();

    return view('admin.orders.index', compact('orders', 'completeCount', 'pendingCount', 'cancledCount'));
  }


  function DeleteAllAtt(Request $request){
    $ids = $request->ids;
    Order::whereIn('id', $ids)->delete();
    return response()->json(["success"=>"Deleted All Orders"]);
  }

    function destroy(string $id){
    $attribute = Order::findOrFail($id);
    $attribute->delete();
    return back()->with(['success'=> "Deleted Order  $id successfuly"]);
  }


  function add(){
    $users = User::all();
    $products = Product::all();
    return view('admin.orders.add', compact('users', 'products'));
  }

   public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'status'       => 'required|in:pending,complete,cancelled',
            'products'     => 'required|array|min:1',
            'products.*'   => 'exists:products,id',
            'quantities'   => 'required|string',
        ]);

        $quantities = explode(',', $request->quantities);

        if (count($request->products) !== count($quantities)) {
            return back()->withErrors(['quantities' => 'عدد الكميات لا يطابق عدد المنتجات المحددة.']);
        }

        DB::beginTransaction();

        try {
            $totalPrice = 0;


            $order = Order::create([
                'user_id'     => $request->user_id,
                'status'      => $request->status,
                'total_price' => 0,
            ]);


            foreach ($request->products as $index => $productId) {
                $product = Product::findOrFail($productId);
                $quantity = (int) trim($quantities[$index]);
                $unitPrice = $product->sale;
                $itemTotal = $unitPrice * $quantity;

                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_title'      => $product->title,
                    'product_image'      => $product->image,
                    'variant_attributes' => '[]',
                    'unit_price'         => $unitPrice,
                    'quantity'           => $quantity,
                    'total_price'        => $itemTotal,
                ]);

                $totalPrice += $itemTotal;
            }


            $order->update([
                'total_price' => $totalPrice,
            ]);

            DB::commit();

            return redirect()->route('admin_order_view')->with('success', 'Order created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء الطلب: ' . $e->getMessage()]);
        }
    }


    public function edit(Order $order)
    {
        $users = User::all();
        $products = Product::all();
        $order->load('items');

        return view('admin.orders.edit', compact('order', 'users', 'products'));
    }
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'status'     => 'required|in:pending,complete,cancelled',
            'products'   => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|string',
        ]);

        $quantities = explode(',', $request->quantities);

        if (count($request->products) !== count($quantities)) {
            return back()->withErrors(['quantities' => 'عدد الكميات لا يطابق عدد المنتجات.']);
        }

        DB::beginTransaction();
        try {
            $totalPrice = 0;

            $order->update([
                'user_id' => $request->user_id,
                'status' => $request->status,
            ]);

            $order->items()->delete();

            foreach ($request->products as $index => $productId) {
                $product = Product::findOrFail($productId);
                $quantity = (int) trim($quantities[$index]);
                $unitPrice = $product->sale;
                $itemTotal = $unitPrice * $quantity;

                $order->items()->create([
                    'product_title'      => $product->title,
                    'product_image'      => $product->image,
                    'variant_attributes' => '[]',
                    'unit_price'         => $unitPrice,
                    'quantity'           => $quantity,
                    'total_price'        => $itemTotal,
                ]);

                $totalPrice += $itemTotal;
            }

            $order->update(['total_price' => $totalPrice]);

            DB::commit();

            return redirect()->route('admin_order_view')->with('success', 'Order updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'خطأ أثناء التحديث: ' . $e->getMessage()]);
        }
    }

}
