<?php

// ==================== Start For Upload Any Image =======================

if (! function_exists('uploadImage')){
  function uploadImage($file, $path = 'public/images'){
    if (!$file || !$file->isValid()) {
      return null;
    }
    $ext = $file->getClientOriginalExtension();
    $file_name = time() . '.' . $ext;
    $file->move($path, $file_name);
    return $file_name;
  }
}
// ==================== End For Upload Any Image ========================





// ==================== Start Delete Image =======================

if (! function_exists('DeleteImage')){
  function DeleteImage($path){
    unlink(public_path($path));
  }
}
// ==================== End Delete Image ========================






// ==================== Start Products Image Path =======================

if (! function_exists('ProductImagePath')){
  function ProductImagePath(){
    return "public/admin/images/products/";
  }
}

// ==================== End Products Image Path ==========================





// ==================== Start Attributes Image Path =======================

if (! function_exists('AttributeImagePath')){
  function AttributeImagePath(){
    return "public/admin/images/attributes/";
  }
}

// ==================== End Attributes Image Path ==========================






// ==================== Start Categories Image Path =======================

if (! function_exists('CategoryImagePath')){
  function CategoryImagePath(){
    return "public/admin/images/categories/";
  }
}
// ==================== End Categories Image Path ==========================
