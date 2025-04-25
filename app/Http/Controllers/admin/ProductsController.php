<?php

namespace App\Http\Controllers\admin;

use App\Model;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\admin\product\editRequest;


class ProductsController extends Controller
{

    public function index(){
      $allProducts  = Product::get();
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
      $products    = Product::with('categories')->paginate(SELF::Pagination_count);
      // return $products;
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
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id',
      ]);


      if ($validator->fails()) {
        return redirect()->back()->with(['error' => "Something Went Wrong"]);
      }

      $path = ProductImagePath();

      $file_name = uploadImage($request->image, $path );
      $arr = array(
        'title' => $request->title,
        'price' => $request->price,
        'sale' => $request->sale_price,
        'image'=> $file_name,
      );

      $product = Product::create($arr);
      $product->categories()->sync($request->categories);

      return redirect()->route('admin.product.add')->with(['success'=> 'Product Added']);
    }

    function deleteAll(Request $request){
      $ids = $request->ids;
      Product::whereIn('id', $ids)->delete();
      return response()->json(["success"=>"Products Deleted"]);
    }

    function SetAllPublish(Request $request){
      $ids = $request->ids;
      Product::whereIn('id', $ids)->update([
        'is_draft' => 0
      ]);
      return response()->json(["success"=>"Products Set to Publish"]);
    }
    function SetAllDraft(Request $request){
      $ids = $request->ids;
      Product::whereIn('id', $ids)->update([
        'is_draft' => 1
      ]);
      return response()->json(["success"=>"Products Set to Draft"]);
    }


    function Delete(Request $request){
      $id = $request->id;
      $prodcut = Product::findOrFail($id);
      $prodcut->delete();
      return back()->with(['success'=> "Delete Product id $id successfuly"]);
    }

    function Edit(string $id){
      $product = Product::findOrFail($id);
      $categories = Category::get();
      return view('admin.products.edit', compact('product', 'categories'));
    }



    function postedit(editRequest $request, string $id){



      $product = Product::findOrFail($id);

      $file_name = $product->image;
      if($request->hasFile('image')) {
        if($product->image && file_exists( $product->image)){
          $imageName = basename($product->image);
          $path = 'admin/images/products/'.$imageName;
          DeleteImage($path);
        }
        $productFilePath = ProductImagePath();
        $file_name = uploadImage($request->file, $productFilePath);
        }


      $product->update([
        'title' => $request->title,
        'price' => $request->price,
        'sale' => $request->sale,
        'is_draft' => $request->statue,
        'image' => $file_name,
      ]);

      $product->categories()->sync($request->categories);

      return redirect()->route('admin.products.index')->with(['success'=> "updated Product id:$id"]);
    }

    function GetAllAttributs(){
      $Attributs = Attribute::get();
      return response()->json($Attributs);
    }

    function GetAllAttributsvalues(string $id){
      $values = AttributeValue::where('attribute_id', $id)->get();
      return response()->json($values);
    }
}
