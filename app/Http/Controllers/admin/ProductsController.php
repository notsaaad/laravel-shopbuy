<?php

namespace App\Http\Controllers\admin;

use App\Model;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller
{
    function add(){
      return view('admin.products.add');
    }

    function post(Request $request){
      $validator = Validator::make($request->all(), [
        'title'     => 'required',
        'price'     => 'required',
        'sale_price'=> 'required',
        'image'     => 'required|mimes:png,jpg,jpeg,webp',
      ]);
      if ($validator->fails()) {
        return redirect()->back()->with(['error' => "Something Went Wrong"]);
      }
      $file = $request->file('image');
      $exta = $file->getClientOriginalExtension();
      $file_name  = time().  '.' . $exta;
      $path       = "/public/admin/images/products/";
      $file->move($path, $file_name);

      $arr = array(
        'title' => $request->title,
        'price' => $request->price,
        'sale' => $request->sale_price,
        'image'=> $path.$file_name
      );
      Products::create($arr);
      return redirect()->route('admin.product.add')->with(['success'=> 'Product Added']);
    }

}
