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


public function single_product($id)
{
    $product = Product::with('variants.attributeValues.attribute')->findOrFail($id);

    // تحديد نوع المنتج
    $type = $product->variants()->exists() ? 'variant' : 'simple';

    // معالجة الصور
    $gallery = json_decode($product->gallery, true) ?? [];

    $gallary = collect($gallery)->map(function ($img) {
        return URL::asset(ProductImagePath() . $img);
    });

    $image = URL::asset(ProductImagePath() . $product->image);

    // إعداد الـ attributes لكل variant
    $attributes = [];

    if ($type === 'variant') {
        foreach ($product->variants as $variant) {
            foreach ($variant->attributeValues as $value) {
                $attrName = $value->attribute->name ?? $value->attribute_name ?? 'Attribute';
                $attrVal = $value->value;
                $attributes[$attrName][] = $attrVal;
            }
        }

        // إزالة القيم المكررة
        foreach ($attributes as $key => $vals) {
            $attributes[$key] = array_values(array_unique($vals));
        }
    }

    // قائمة الـ variants بصيغة مرتبة
    $variantList = [];

    if ($type === 'variant') {
        $variantList = $product->variants->map(function ($variant) {
            $attrs = [];

            foreach ($variant->attributeValues as $val) {
                $attrName = $val->attribute->name ?? $val->attribute_name ?? 'Attribute';
                $attrs[$attrName] = $val->value;
            }

            return [
                'id'        => $variant->id,
                'attributes'=> $attrs,
                'price'     => $variant->price ?? null,
                'stock'     => $variant->stock,
            ];
        })->values(); // للتأكد من عدم وجود مفاتيح غير مرتبة
    }

    return response()->json([
        'id'          => $product->id,
        'type'        => $type,
        'name'        => $product->title,
        'description' => $product->description ?? '',
        'price'       => $product->price,
        'sale'        => $product->sale,
        'image'       => $image,
        'gallary'     => $gallary,
        'attributes'  => $attributes,
        'variants'    => $variantList,
    ]);
}

}
