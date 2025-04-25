<?php

namespace App\Http\Controllers\admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{


  public function index(){
    $Attributes = Attribute::paginate(SELF::Pagination_count);
    // return $Attributes;
    return view('admin.attribute.index', compact('Attributes'));
  }

  public function add(){
    return view('admin.attribute.add');
  }

  public function store(Request $request){
    $request->validate([
      'name'         =>  'required|string|unique:attributes,name',
      'type'         =>  'required'
    ]);

    Attribute::create([
      'name'          => $request->name,
      'display_type'  => $request->type
    ]);

    return redirect()->route('attribute.index')->with(['succuess'=> 'Attribute Added']);
  }

  function destroy(string $id){
    $attribute = Attribute::findOrFail($id);
    $attribute->delete();
    return back()->with(['success'=> "Deleted Attribute  $id successfuly"]);
  }


  function DeleteAllAtt(Request $request){
    $ids = $request->ids;
    Attribute::whereIn('id', $ids)->delete();
    return response()->json(["success"=>"Deleted All Attributes"]);
  }


  function Edit(string $id){
    $att = Attribute::findOrFail($id);
    return view('admin.attribute.edit', compact('att'));
  }

  function post_edit_att(Request $request, string $id){
    $att = Attribute::findOrFail($id);
    $request->validate([
      'name' => 'required|string|unique:attributes,name,'.$id
    ]);

    $att->update(["name"=> $request->name]);

    return redirect()->route('attribute.index', $id)->with('success', "update attribute $id");
  }

  // ============================================== Start Attributes Value ======================================


  function att_value_show($id){
    $att = Attribute::with('values')->findOrFail($id);
    // return $att;
    return view('admin.attribute.attributeValues.index', compact('att'));
  }

  function att_value_add($id){
    $att = Attribute::with('values')->findOrFail($id);
    return view('admin.attribute.attributeValues.add', compact('att'));
  }

  function store_value_add(Request $request,string $id){
      $request->validate([
        'attribute_id' => 'required|exists:attributes,id',
        'value'        => 'required|string|max:255',
        'color_code'   => 'nullable',
        'image_path'   => 'nullable|image|mimes:jpeg,png,jpg,gif'
    ]);

    $data = $request->only(['attribute_id', 'value', 'color_code']);

    if ($request->hasFile('image_path')) {
      $file      = $request->file('image_path');
      $path      = AttributeImagePath();
      $imagePath = uploadImage($file, $path);
      $data['image_path'] = $imagePath;
  }
    AttributeValue::create($data);
    return redirect()->route('att-values.view', $id)->with('success', 'value added');
  }


  function delete_value(string $id){
    $value = AttributeValue::findOrFail($id);
    $value->delete();
    return back()->with(['success'=> "Deleted value successfuly"]);
  }

  function edit_page(string $id){
    $value = AttributeValue::findOrFail($id);
    return view('admin.attribute.attributeValues.edit', compact('value'));
  }

  function update_att_value(Request $request, string $id){
    $value      = AttributeValue::findOrFail($id);
    $file_name  = $value->image_path;
    $request->validate([
      'value'        => 'required|string|max:255',
      'color_code'   => 'nullable',
      'image_path'   => 'nullable|image|mimes:jpeg,png,jpg,gif'
    ]);

    $data = $request->only(['attribute_id', 'value', 'color_code']);

    if($request->hasFile('image_path')) {
      $file      = $request->file('image_path');
      // $imagepath = $request->image_path;
      if($value->image && file_exists(  $value->image)  && $value->image != $imagepath){
        $path = "admin/images/attributes/";
        DeleteImage($file, $path);
      }
      $valuesPath = AttributeImagePath();
      $file_name  = uploadImage($file, $valuesPath);
      $data['image_path'] = $file_name;
    }

    $value->update($data);

    return redirect()->route('att-values.view', $value->attribute_id)->with('success', "update $value->value");
  }

  function DeleteALLValues(Request $request){
    $ids = $request->ids;
    AttributeValue::whereIn('id', $ids)->delete();
    return response()->json(["success"=>"Deleted All Values"]);
  }

  // ============================================== End Attributes Value ========================================
}
