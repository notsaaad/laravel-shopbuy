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

    return $product;

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


  public function getCategoryProducts($categoryId, Request $request){

    $filters = $request->query('filters', []);

    $products = Product::with(['variants.attributeValues.attribute', 'categories'])
        ->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        })
        ->when(!empty($filters), function ($query) use ($filters) {
            $query->whereHas('variants.attributeValues', function ($q) use ($filters) {
                foreach ($filters as $attribute => $value) {
                    $q->whereHas('attribute', function ($subQ) use ($attribute) {
                        $subQ->where('name', $attribute);
                    })->where('value', $value);
                }
            });
        })
        ->get();

    $response = $products->map(function ($product) {
        $type = $product->variants()->exists() ? 'variant' : 'simple';

        $gallery = [];

        try {
            $decoded = json_decode($product->gallery, true);
            $gallery = is_string($decoded) ? json_decode($decoded, true) : $decoded;
        } catch (\Exception $e) {
            $gallery = [];
        }
        $gallary = collect($gallery)->map(fn($img) => URL::asset(ProductImagePath() . $img));
        $image = URL::asset(ProductImagePath() . $product->image);

        $attributes = [];

        if ($type === 'variant') {
            foreach ($product->variants as $variant) {
                foreach ($variant->attributeValues as $value) {
                    $attrName = $value->attribute->name ?? $value->attribute_name ?? 'Attribute';
                    $attrVal = $value->value;
                    $attributes[$attrName][] = $attrVal;
                }
            }

            foreach ($attributes as $key => $vals) {
                $attributes[$key] = array_values(array_unique($vals));
            }
        }

        $variantList = $type === 'variant'
            ? $product->variants->map(function ($variant) {
                $attrs = [];

                foreach ($variant->attributeValues as $val) {
                    $attrName = $val->attribute->name ?? $val->attribute_name ?? 'Attribute';
                    $attrs[$attrName] = $val->value;
                }

                $image = $variant->image_path
                    ? URL::asset(ProductImagePath() . $variant->image_path)
                    : null;

                return [
                    'id'         => $variant->id,
                    'attributes' => $attrs,
                    'price'      => $variant->price ?? null,
                    'stock'      => $variant->stock,
                    'image_path' => $image,
                ];
            })->values()
            : [];

        return [
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
        ];
    });

    return response()->json([
        'success'  => true,
        'products' => $response,
    ]);
  }


public function single_product($id)
{
    $product = Product::with('variants.attributeValues.attribute')->findOrFail($id);


    $type = $product->variants()->exists() ? 'variant' : 'simple';


    $gallery = [];

    try {
        $decoded = json_decode($product->gallery, true);
        $gallery = is_string($decoded) ? json_decode($decoded, true) : $decoded;
    } catch (\Exception $e) {
        $gallery = [];
    }

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

            // تحديد المسار الكامل للصورة إن وُجدت
            $image = $variant->image_path
                ? URL::asset(ProductImagePath() . $variant->image_path)
                : null;

            return [
                'id'           => $variant->id,
                'attributes'   => $attrs,
                'price'        => $variant->price ?? null,
                'stock'        => $variant->stock,
                'image_path'   => $image,
            ];
        })->values();
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
