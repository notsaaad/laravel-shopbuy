<?php

namespace App\Http\Controllers\admin;

use App\Model;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\admin\product\editRequest;


class ProductsController extends Controller
{

    public function index(){
      $allProducts  = Products::get();
      $allCount     = count($allProducts);
      $publishCount = 0;
      $draftCount   = 0;
      foreach ($allProducts as $product) {
        if($product->is_draft == 0){
          $publishCount++;
        }else{
          $draftCount++;
        }
      }
      $products    = Products::paginate(SELF::Pagination_count);
      return view('admin.products.view', compact('allCount', 'publishCount', 'draftCount', 'products' ));
    }



    function add(){
      $categories = Category::get();
      return view('admin.products.add', compact('categories'));
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
      $path       = "public/admin/images/products/";
      $file->move($path, $file_name);

      $arr = array(
        'title' => $request->title,
        'price' => $request->price,
        'sale' => $request->sale_price,
        'image'=> $path.$file_name,
        'category_id' => $request->cat,
      );
      Products::create($arr);
      return redirect()->route('admin.product.add')->with(['success'=> 'Product Added']);
    }

    function deleteAll(Request $request){
      $ids = $request->ids;
      Products::whereIn('id', $ids)->delete();
      return response()->json(["success"=>"Products Deleted"]);
    }

    function SetAllPublish(Request $request){
      $ids = $request->ids;
      Products::whereIn('id', $ids)->update([
        'is_draft' => 0
      ]);
      return response()->json(["success"=>"Products Set to Publish"]);
    }
    function SetAllDraft(Request $request){
      $ids = $request->ids;
      Products::whereIn('id', $ids)->update([
        'is_draft' => 1
      ]);
      return response()->json(["success"=>"Products Set to Draft"]);
    }


    function Delete(Request $request){
      $id = $request->id;
      $prodcut = Products::findOrFail($id);
      $prodcut->delete();
      return back()->with(['success'=> "Delete Product id $id successfuly"]);
    }

    function Edit(string $id){
      $product = Products::findOrFail($id);
      $categories = Category::get();
      return view('admin.products.edit', compact('product', 'categories'));
    }

    function postedit(editRequest $request, string $id){

      $product = Products::findOrFail($id);
      $file_name = $product->image;
      if($request->hasFile('image')) {
        if($product->image && file_exists( $product->image)){
          $imageName = basename($product->image);
          unlink(public_path('admin/images/products/'.$imageName));

        }

        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $file_name = time() . '.' . $ext;
        $path = 'public/admin/images/products/';
        $file->move($path, $file_name);
        $file_name = $path.$file_name;
        }


      $product->update([
        'title' => $request->title,
        'price' => $request->price,
        'sale' => $request->sale,
        'category_id' => $request->cat,
        'is_draft' => $request->statue,
        'image' => $file_name,
      ]);

      return redirect()->route('admin.products.index')->with(['success'=> "updated Product id:$id"]);
    }

}
