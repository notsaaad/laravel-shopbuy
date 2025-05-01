<?php

namespace App\Http\Controllers\admin;

use App\Model;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Models\VariantAttributeValue;
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

      $rules = [
        'title' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'sale' => 'required|numeric|min:0',
        'image' => 'required|mimes:png,jpg,jpeg,webp',
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id',
        'type' => 'required|in:simple,variant',
        'stock' => 'nullable|integer|min:0',
        'gallery' => 'nullable',
        'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ];

      if ($request->type == 'variant') {
        $rules['attribute_values'] = 'required|array|min:1';

        foreach ($request->input('attribute_values', []) as $attrId => $values) {
            $rules["attribute_values.$attrId"] = 'required|array|min:1';
            $rules["attribute_values.$attrId.*"] = 'exists:attribute_values,id';
        }

        $rules['variants'] = 'required|array|min:1';

        foreach ($request->input('variants', []) as $index => $variant) {
            $rules["variants.$index.attributes"] = 'required|array|min:1';
            $rules["variants.$index.attributes.*"] = 'exists:attribute_values,id';
            $rules["variants.$index.stock"] = 'required|numeric|min:0';
        }
      }

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $product = new Product();
      $product->title         = $request->title;
      $product->price         = $request->price;
      $product->sale          = $request->sale;
      $product->type          = $request->type;
      $product->description   = $request->description;
      $product->stock         = $request->stock;

      if ($request->hasFile('image')) {
        $path = ProductImagePath();
        $file_name = uploadImage($request->image, $path );
        $product->image = $file_name;
      }

      $galleryPaths = [];

      if ($request->hasFile('gallery')) {
          $path = ProductImagePath(); // مكان الحفظ
          foreach ($request->file('gallery') as $file) {
              $file_name = uploadImage($file, $path);

              if (!in_array($file_name, $galleryPaths)) {
                  $galleryPaths[] = $file_name;
              }
          }
      }

      // إزالة التكرار احتياطي:
      $galleryPaths = array_unique($galleryPaths);

      $product->gallery = !empty($galleryPaths) ? json_encode($galleryPaths) : null;

      $product->save();

      $product->categories()->sync($request->categories);

      if ($product->type == 'variant' && isset($request->variants)) {
          foreach ($request->variants as $variantData) {
              $variant = new ProductVariant();
              $variant->product_id = $product->id;
              $variant->stock = $variantData['stock'];
              $variant->save();

              // تعديل بسيط هنا:
              $attributeValueIds = is_array($variantData['attributes'])
                  ? $variantData['attributes']
                  : explode(',', $variantData['attributes'][0]); // في حالة إنها String داخل Array.

              foreach ($attributeValueIds as $attrValId) {
                  VariantAttributeValue::create([
                      'variant_id' => $variant->id,
                      'attribute_value_id' => $attrValId,
                  ]);
              }
          }
      }


      // if ($validator->fails()) {
      //   return redirect()->back()->with(['error' => "Something Went Wrong"]);
      // }

      // $path = ProductImagePath();

      // $file_name = uploadImage($request->image, $path );
      // $arr = array(
      //   'title' => $request->title,
      //   'price' => $request->price,
      //   'sale' => $request->sale_price,
      //   'image'=> $file_name,
      // );

      // $product = Product::create($arr);
      // $product->categories()->sync($request->categories);

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
      // $product = Product::findOrFail($id);
      $categories = Category::get();
      $product = Product::with(['categories', 'variants.attributeValues.attribute'])->findOrFail($id);
      $product->gallery = json_decode($product->gallery, true);
      // return $product;
      $attributes = Attribute::with('values')->get();
      return view('admin.products.edit', compact('product', 'attributes', 'categories'));
    }



    function postedit(editRequest $request, string $id){




      $product = Product::findOrFail($id);

    $rules = [
        'title' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'sale' => 'required|numeric|min:0',
        'image' => 'nullable|mimes:png,jpg,jpeg,webp',
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id',
        'statue' => 'required|in:0,1',
        'stock' => 'nullable|integer|min:0',
        'gallery' => 'nullable',
        'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    if ($product->type === 'variant') {
        $rules['attribute_values'] = 'required|array|min:1';

        foreach ($request->input('attribute_values', []) as $attrId => $values) {
            $rules["attribute_values.$attrId"] = 'required|array|min:1';
            $rules["attribute_values.$attrId.*"] = 'exists:attribute_values,id';
        }

        $rules['variants'] = 'required|array|min:1';
        foreach ($request->input('variants', []) as $index => $variant) {
            $rules["variants.$index.attributes"] = 'required|string';
            $rules["variants.$index.stock"] = 'required|numeric|min:0';
        }
    }

    $validated = $request->validate($rules);


    $product->title         = $validated['title'];
    $product->price         = $validated['price'];
    $product->sale          = $validated['sale'];
    $product->is_draft      = $validated['statue'];
    $product->description   = $request->description;
    $product->stock         = $request->stock;


    if ($request->hasFile('image')) {
        $path = ProductImagePath();
        $file_name = uploadImage($request->image, $path, $product->image);
        $product->image = $file_name;
    }
        $product->gallery = json_decode($product->gallery, true);
        $existingGallery = $product->gallery ?? [];

    // حذف الصور اللي طلب المستخدم يشيلها
    if ($request->filled('removed_images')) {

        $indicesToRemove = explode(',', $request->removed_images);
        foreach ($indicesToRemove as $index) {
            if (isset($existingGallery[$index])) {
                $file_name  = $existingGallery[$index];
                $path       = 'admin/images/products/'.$file_name;
                DeleteImage($path);
                // Storage::disk('public')->delete($existingGallery[$index]);
                unset($existingGallery[$index]);
            }
        }
    }


    $existingGallery = array_values($existingGallery);


    if ($request->hasFile('gallery')) {
      $path = ProductImagePath();
        foreach ($request->file('gallery') as $file) {
            $file_name = uploadImage($file, $path);
            $existingGallery[] = $file_name;
        }
    }

    $product->gallery = !empty($existingGallery) ? json_encode($existingGallery) : null;

    $product->save();


    $product->categories()->sync($validated['categories']);


    if ($product->type === 'variant') {

        foreach ($product->variants as $oldVariant) {
            $oldVariant->attributeValues()->detach();
            $oldVariant->delete();
        }


        foreach ($validated['variants'] as $variantData) {
            $variant = new ProductVariant();
            $variant->product_id = $product->id;
            $variant->stock = $variantData['stock'];
            $variant->save();

            $attributeValueIds = explode(',', $variantData['attributes']);
            $variant->attributeValues()->attach($attributeValueIds);
        }
    }

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
