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
        'title'        => 'required|string|max:255',
        'price'        => 'required|numeric|min:0',
        'sale'         => 'required|numeric|min:0',
        'image'        => 'required|mimes:png,jpg,jpeg,webp',
        'categories'   => 'required|array',
        'categories.*' => 'exists:categories,id',
        'type'         => 'required|in:simple,variant',
        'stock'        => 'nullable|integer|min:0',
        'gallery'      => 'nullable',
        'gallery.*'    => 'image|mimes:jpeg,png,jpg,webp|max:2048',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $product = new Product();
    $product->title       = $request->title;
    $product->price       = $request->price;
    $product->sale        = $request->sale;
    $product->type        = $request->type;
    $product->description = $request->description;

    if ($request->type === 'simple') {
        $product->stock = $request->stock;
    }

    if ($request->hasFile('image')) {
        $path = ProductImagePath();
        $file_name = uploadImage($request->image, $path);
        $product->image = $file_name;
    }

    $galleryPaths = [];

    if ($request->hasFile('gallery')) {
        $path = ProductImagePath();
        foreach ($request->file('gallery') as $file) {
            $file_name = uploadImage($file, $path);
            $galleryPaths[] = $file_name;
        }
    }

    $product->gallery = !empty($galleryPaths) ? json_encode(array_unique($galleryPaths)) : null;

    $product->save();

    $product->categories()->sync($request->categories);


    if ($product->type === 'variant') {
        return redirect()->route('admin.products.variants.edit', $product->id)
            ->with('success', 'Product Save , Add your variants');
    }

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



    function postedit(Request $request, string $id){




      $product = Product::findOrFail($id);

    $product = Product::findOrFail($id);

    $rules = [
        'title'        => 'required|string|max:255',
        'price'        => 'required|numeric|min:0',
        'sale'         => 'required|numeric|min:0',
        'image'        => 'nullable|mimes:png,jpg,jpeg,webp',
        'categories'   => 'required|array',
        'categories.*' => 'exists:categories,id',
        'statue'       => 'required|in:0,1',
        'stock'        => 'nullable|integer|min:0',
        'gallery'      => 'nullable',
        'gallery.*'    => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ];

    $validated = $request->validate($rules);

    $product->title       = $validated['title'];
    $product->price       = $validated['price'];
    $product->sale        = $validated['sale'];
    $product->is_draft    = $validated['statue'];
    $product->description = $request->description;
    $product->type        = $product->type; // لا يتم تغييره هنا

    if ($product->type === 'simple') {
        $product->stock = $validated['stock'];
    }

    // صورة رئيسية
    if ($request->hasFile('image')) {
        $path = ProductImagePath();
        $file_name = uploadImage($request->image, $path, $product->image);
        $product->image = $file_name;
    }

    // معرض الصور
    $existingGallery = json_decode($product->gallery, true) ?? [];

    if ($request->filled('removed_images')) {
        $indicesToRemove = explode(',', $request->removed_images);
        foreach ($indicesToRemove as $index) {
            if (isset($existingGallery[$index])) {
                $file_name = $existingGallery[$index];
                $path = ProductImagePath() . $file_name;
                // DeleteImage($path);
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

    $product->gallery = !empty($existingGallery) ? json_encode(array_unique($existingGallery)) : null;

    $product->save();

    $product->categories()->sync($validated['categories']);

      return redirect()->route('admin.products.index')->with(['success'=> "updated Product id:$id"]);
    }

    function editVaraint(Product $product){
    $attributes = Attribute::with('values')->get();

    // Identify the attribute that is a color (has values with color_code)
    $colorAttributeId = null;

    foreach ($attributes as $attribute) {
        foreach ($attribute->values as $value) {
            if (!empty($value->color_code)) {
                $colorAttributeId = $attribute->id;
                break 2;
            }
        }
    }

      $galleryImages = collect(json_decode($product->gallery, true) ?? [])->map(function ($filename) {
          return [
              'filename' => $filename,
              'url' => asset(ProductImagePath() . $filename)
          ];
      });

      $colorAttribute = Attribute::where('display_type', 'color')
                          ->with('values')
                          ->first();

      return view('admin.products.variants', [
          'product' => $product,
          'attributes' => $attributes, // all attributes with values
          'colorAttribute' => $colorAttribute,
          'colorAttributeId' => $colorAttribute?->id,
          'galleryImages' => $galleryImages
      ]);
    }

    function editVaraintpost(Request $request, Product $product){
$request->validate([
        'attribute_values' => 'required|array|min:1',
        'variants'         => 'required|array|min:1',
        'variants.*.attributes' => 'required|string',
        'variants.*.stock'      => 'required|numeric|min:0',
    ]);

    // color_images: [color_value_id => image_filename]
    $colorImages = $request->input('color_images', []);

    // Identify color attribute dynamically (based on color_code)
    $colorAttributeId = null;
    foreach (AttributeValue::with('attribute')->get() as $value) {
        if (!empty($value->color_code)) {
            $colorAttributeId = $value->attribute_id;
            break;
        }
    }

    // Delete existing variants if any
    foreach ($product->variants as $oldVariant) {
        $oldVariant->attributeValues()->detach();
        $oldVariant->delete();
    }

    // Create new variants
    foreach ($request->input('variants') as $variantData) {
        $variant = new ProductVariant();
        $variant->product_id = $product->id;
        $variant->stock = $variantData['stock'];

        $attributeValueIds = explode(',', $variantData['attributes']);
        $variant->save();
        $variant->attributeValues()->attach($attributeValueIds);

        // Assign image based on color value
        if ($colorAttributeId) {
            foreach ($attributeValueIds as $valId) {
                $val = AttributeValue::find($valId);
                if ($val && $val->attribute_id == $colorAttributeId && isset($colorImages[$valId])) {
                    $variant->image_path = $colorImages[$valId];
                    $variant->save(); // Save after assigning image
                    break;
                }
            }
        }
    }

    return redirect()->route('admin.products.variants.edit', $product->id)
        ->with('success', 'Variants have been saved successfully.');
    }


    public function editVaraint2(Product $product)
    {
        // جلب كل الخصائص مع القيم المرتبطة بها
        $attributes = Attribute::with('values')->get();

        // تجهيز صور الجاليري للعرض
        $galleryImages = collect(json_decode($product->gallery, true) ?? [])->map(function ($filename) {
            return [
                'filename' => $filename,
                'url' => asset(ProductImagePath() . $filename),
            ];
        });

        // جلب خصائص اللون إن وجدت
        $colorAttribute = Attribute::where('display_type', 'color')->with('values')->first();
        $colorAttributeId = $colorAttribute?->id;

        // استخراج كل القيم المستخدمة مسبقًا في الفاريانتات
        $selectedAttributeValues = $product->variants
            ->flatMap(fn($variant) => $variant->attributeValues->pluck('id'))
            ->unique()
            ->toArray();

        return view('admin.products.variants_edit2', [
            'product' => $product,
            'attributes' => $attributes,
            'galleryImages' => $galleryImages,
            'colorAttribute' => $colorAttribute,
            'colorAttributeId' => $colorAttributeId,
            'selectedAttributeValues' => $selectedAttributeValues,
        ]);
    }


    public function editVaraintpost2(Request $request, Product $product)
    {
        $request->validate([
            'attribute_values' => 'required|array|min:1',
            'variants'         => 'required|array|min:1',
            'variants.*.attributes' => 'required|string',
            'variants.*.stock'      => 'required|numeric|min:0',
            'color_images'          => 'nullable|array',
        ]);

        $colorImages = $request->input('color_images', []);

        // Identify the color attribute dynamically
        $colorAttributeId = AttributeValue::with('attribute')
            ->whereNotNull('color_code')
            ->first()?->attribute_id;

        // Delete old variants
        foreach ($product->variants as $oldVariant) {
            $oldVariant->attributeValues()->detach();
            $oldVariant->delete();
        }

        foreach ($request->input('variants') as $variantData) {
            $variant = new ProductVariant();
            $variant->product_id = $product->id;
            $variant->stock = $variantData['stock'];

            $attributeValueIds = explode(',', $variantData['attributes']);
            $variant->save();
            $variant->attributeValues()->attach($attributeValueIds);

            // Assign image based on color value if applicable
            if ($colorAttributeId) {
                foreach ($attributeValueIds as $valId) {
                    $val = AttributeValue::find($valId);
                    if ($val && $val->attribute_id == $colorAttributeId && isset($colorImages[$valId])) {
                        $variant->image_path = $colorImages[$valId];
                        $variant->save();
                        break;
                    }
                }
            }
        }

        return redirect()->route('admin.products.variants.edit2', $product->id)
            ->with('success', 'Variants updated successfully.');
    }
}


