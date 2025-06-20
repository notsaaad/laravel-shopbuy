<?php

namespace App\Http\Controllers\APIs;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  function index(){
    $Product = Product::where('is_draft', 0)->get();

    foreach ($Product as $q) {
      $path       = ProductImagePath() . $q->image;
      $q->image = URL::asset($path);
    }

    return response()->json([
    'status' => true,
    'message' => 'Products retrieved successfully.',
    'data' => $Product,
    ], 200);
  }

  function category($id){
    $category  = Category::find($id);
    $product   = $category->products()->where('is_draft', 0);

    foreach ($product as $q) {
      $path       = ProductImagePath() . $q->image;
      $q->image = URL::asset($path);
    }

    return response()->json([
      'status' => true,
      'message' => 'Products retrieved successfully.',
      'data'    => $product,
    ], 200);
  }


  public function single_product($id){
      $product = Product::findOrFail($id);

      $type = $product->variants()->exists() ? 'variant' : 'simple';


      $gallery = json_decode($product->gallery, true);

      // توليد روابط URL كاملة باستخدام Storage
      $gallary = collect($gallery)->map(function ($img) {
          $path       = ProductImagePath() .$img;
          return URL::asset($path);
      });

      $imagePath = ProductImagePath() .$product->image;
      $image     = URL::asset($imagePath);

      $attributes = [];
      if ($type === 'variant') {
          $product->variants->each(function ($variant) use (&$attributes) {
              foreach ($variant->attributeValues as $value) {
                  $attrName = $value->attribute_name;
                  $attrVal = $value->value;
                  $attributes[$attrName][] = $attrVal;
              }
          });


          foreach ($attributes as $key => $vals) {
              $attributes[$key] = array_unique($vals);
          }
      }


      $variantList = [];
      if ($type === 'variant') {
          $variantList = $product->variants->map(function ($variant) {
              $attrs = [];
              foreach ($variant->attributeValues as $val) {
                  $attrs[$val->attribute_name] = $val->value;
              }

              return [
                  'id' => $variant->id,
                  'attributes' => $attrs,
                  'price' => $variant->price,
                  'stock' => $variant->stock
              ];
          });
      }

      return response()->json([
          'id' => $product->id,
          'type' => $type,
          'name' => $product->title,
          'description' => $product->description ?? '',
          'price' => $product->price,
          'image' => $image,
          'sale' => $product->sale,
          'gallary' => $gallary,
          'attributes' => $attributes,
          'variants' => $variantList,
      ]);
  }
}
