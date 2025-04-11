<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(SELF::Pagination_count);
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
        ]);
        Category::create([
          'name' => $request->name
        ]);

        return back()->with(['success'=> 'create Category']);
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
        'name' => 'required|unique:categories,name',
      ]);
      Category::where('id', $id)->update([
        'name' => $request->name,
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
