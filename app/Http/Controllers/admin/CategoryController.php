<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::withCount('products')->paginate(self::Pagination_count);

        return view('admin.category.index', compact('categories'));
    }

    function deleteAll(Request $request){
      $ids = $request->ids;
      Category::whereIn('id', $ids)->delete();
      return response()->json(["success"=>"users Deleted"]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
          'name' => 'required|unique:categories,name',
          'image' => 'sometimes|nullable|mimes:png,jpg,jpeg,webp|max:2048',
        ]);
        try{
          $imagepath = 'default.jpg';
          if($request->hasFile('image')){
            $file = $request->file('image');
            $exta = $file->getClientOriginalExtension();
            $file_name  = time().  '.' . $exta;
            $path       = "public/admin/images/categories/";
            $file->move($path, $file_name);
            $imagepath = $file_name;
          }


          Category::create([
            'name' => $request->name,
            'image' => $imagepath
          ]);

          return back()->with(['success'=> 'create Category']);
        }catch(\Exception $e ){
          return back()->withErrors(['error' => 'حدث خطأ: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $cat = Category::findOrFail($id);

      return view('admin.category.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $request->validate([
        'name' => 'required|unique:categories,name,'.$id,
      ]);
      $imagepath = "default.jpg";
      $category = Category::findOrFail($id);
      $file_name =  $category->image;
      if($request->hasFile('image')) {
        if( $category->image && file_exists(  $category->image)  && $category->image != $imagepath){
          $imageName = basename(  $category->image);
          unlink(public_path('admin/categories/products/'.$imageName));
        }
        $file = $request->file('image');
        $exta = $file->getClientOriginalExtension();
        $file_name  = time().  '.' . $exta;
        $path       = "public/admin/images/categories/";
        $file->move($path, $file_name);
        $imagepath = $file_name;
      }

      Category::where('id', $id)->update([
        'name' => $request->name,
        'image'=> $imagepath
      ]);

      return redirect()->route('category.index')->with(['success' => "Update Cateogry $id"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $Category = Category::findOrFail($id);
      $Category->delete();

      return back()->with(['success'=> "Deleted Categroy  $id successfuly"]);
    }
}
