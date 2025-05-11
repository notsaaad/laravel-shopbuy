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
  function index(Request $request, $category = null){
    $filters = $request->input('filters', []);
    $flattenedValues = array_merge(...array_values($filters));
    $requiredCount = count($flattenedValues);
    $filteredProductIds = [];

    if ($requiredCount > 0) {
        // جلب الـ variants اللي تحتوي على جميع القيم المختارة
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

    // المنتجات المفلترة + التصنيف إن وُجد
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

    // الفلاتر من كل المنتجات المتاحة
    $filtersData = [];
    $allVariants = ProductVariant::with('attributeValues.attribute')->get();

    foreach ($allVariants as $variant) {
        foreach ($variant->attributeValues as $val) {
            $attr = $val->attribute;
            $filtersData[$attr->id]['name'] = $attr->name;
            $filtersData[$attr->id]['display_type'] = $attr->display_type;
            $filtersData[$attr->id]['values'][$val->id] = [
                'label' => $val->value,
                'color_code' => $val->color_code,
            ];
        }
    }
    if($category){
      $categoryModel = Category::find($category);
      $category = $categoryModel ? $categoryModel->name : null;
    }
    // return $category;
    return view('user.store', compact('products', 'filtersData', 'category'));
  }


  function categories(){
    $categories = Category::withCount('products')->get();
    // return $categories;
    return view('user.categories', compact('categories'));
  }







    // =============================== Prodducts ===============================

    function product_show($id){
      $product = Product::with('variants.attributeValues.attribute')->findOrFail($id);
      $product->gallery = json_decode($product->gallery, true);
      // return $product;
      return view('user.singleProduct', compact('product'));
    }
}
