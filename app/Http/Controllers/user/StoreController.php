<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
public function index(Request $request, $category = null)
{
    // استخلاص category من query string إذا لم يُمرر من الـ route
    if (!$category && $request->has('category')) {
        $category = $request->get('category');
    }

    // 1. قراءة الفلاتر من الطلب
    $filters = $request->input('filters', []);
    $flattenedValues = array_merge(...array_values($filters));
    $requiredCount = count($flattenedValues);
    $filteredProductIds = [];

    // 2. استخراج الـ Products اللي الـ Variants بتاعتهم فيها الفلاتر دي كلها
    if ($requiredCount > 0) {
        $matchedProductIds = DB::table('product_variants as pv')
            ->join('variant_attribute_value as vav', 'vav.variant_id', '=', 'pv.id')
            ->whereIn('vav.attribute_value_id', $flattenedValues)
            ->select('pv.product_id', 'pv.id as variant_id', DB::raw('COUNT(DISTINCT vav.attribute_value_id) as matched_count'))
            ->groupBy('pv.id', 'pv.product_id')
            ->having('matched_count', '=', $requiredCount)
            ->pluck('pv.product_id')
            ->unique();

        $filteredProductIds = $matchedProductIds;
    }

    // 3. استخراج المنتجات نفسها
    $products = Product::where('is_draft', 0)
        ->when(!empty($filteredProductIds), function ($q) use ($filteredProductIds) {
            $q->whereIn('id', $filteredProductIds);
        })
        ->when($category, function ($q) use ($category) {
            $q->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category);
            });
        })
        ->with('variants.attributeValues.attribute')
        ->get();

    // 4. استخراج كل الـ variant من المنتجات الظاهرة فقط
    $visibleProductIds = $products->pluck('id')->toArray();
    $allVariants = ProductVariant::with('attributeValues.attribute')
        ->whereIn('product_id', $visibleProductIds)
        ->get();

    // 5. بناء الفلاتر فقط من المنتجات الحالية
    $filtersData = [];
    foreach ($allVariants as $variant) {
        foreach ($variant->attributeValues as $val) {
            $attr = $val->attribute;
            if (!$attr) continue;

            $filtersData[$attr->id]['name'] = $attr->name;
            $filtersData[$attr->id]['display_type'] = $attr->display_type;
            $filtersData[$attr->id]['values'][$val->id] = [
                'label' => $val->value,
                'color_code' => $val->color_code,
            ];
        }
    }

    // 6. اسم التصنيف للعرض (اختياري)
    $categoryName = null;
    if ($category) {
        $categoryModel = Category::find($category);
        $categoryName = $categoryModel ? $categoryModel->name : null;
    }

    return view('user.store', compact('products', 'filtersData', 'categoryName', 'category'));
}



  function categories(Request $request){
    $categories = Category::withCount('products')->get();
    $sort = $request->get('sort', 'asc');

    $query = Category::withCount('products');

    if ($sort === 'asc') {
        $query->orderBy('name', 'asc');
    } elseif ($sort === 'desc') {
        $query->orderBy('name', 'desc');
    } elseif ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } elseif ($sort === 'newest') {
        $query->orderBy('created_at', 'desc');
    }

    $categories = $query->get();

    return view('user.categories', compact('categories'));
  }







    // =============================== Prodducts ===============================

public function product_show(Request $request, $id)
{
    $product = Product::with(['variants.attributeValues.attribute'])->findOrFail($id);
    $product->gallery = json_decode($product->gallery, true) ?? [];

    $selectedColor = $request->get('color');
    $colorOptions = [];

    $defaultImage = $product->image;

    foreach ($product->variants as $variant) {
        foreach ($variant->attributeValues as $val) {
            if ($val->attribute->display_type === 'color') {
                $colorOptions[] = [
                    'value' => $val->value,
                    'color_code' => $val->color_code,
                    'image_path' => $variant->image_path ?? null,
                ];

                if ($selectedColor && $selectedColor === $val->value && $variant->image_path) {
                    $defaultImage = $variant->image_path;
                }
            }
        }
    }

    return view('user.singleProduct', compact('product', 'selectedColor', 'colorOptions', 'defaultImage'));
}


    public function search(Request $request)
    {
        $query = $request->get('query');

        $products = Product::where('title', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'title', 'image']);

        // إعداد الصورة لو كانت في ملفات
        $products->transform(function ($product) {
            $product->image = asset( ProductImagePath() . $product->image);
            return $product;
        });

        foreach ($products as $product) {
          $product->URL = route('product.show', $product->id);
        }

        return response()->json($products);
    }
}
