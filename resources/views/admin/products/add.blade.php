@extends('admin.layouts.master')
@section('title', 'Product Add')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{route('admin.product.post')}}"  method="post" class="add_user" enctype="multipart/form-data">
    @csrf
      <div class="two-input">
        <div class="input-div w-half">
          <label for="title" class="riq">Title</label>
          <input type="text" id="title" name="title" placeholder="Enter Product Title">
        </div>
        <div class="input-div w-half">
          <label for="price" class="riq">Price</label>
          <input type="number" id="price" name="price" placeholder="Enter Product Price">
        </div>
      </div>
      <div class="two-input">
        <div class="input-div w-half">
          <label for="sale_price" class="riq">Sale Price</label>
          <input type="number" id="sale_price" name="sale_price" placeholder="Sale Price">
        </div>
        <div class="input-div w-half">
          <label for="cat" class="riq">Category</label>
          <select name="cat" id="cat">
            <option value="NULL">Select Product Cateogry </option>
            @foreach ($categories as $cat )
              <option value="{{ $cat->id }}">{{$cat->name}}</option>
            @endforeach
            @empty($categories)
              <option value="NULL">-- Please Add Category --</option>
            @endempty

          </select>
        </div>
      </div>
      <div class="product_editor upload-container">
        <div class="image-upload">
            <i class="fa-regular fa-image"></i>
          <input  type="file" name="image"id="fileInput" class="fileInput" accept="image/*" >
          <span class="Upload_image">Upload image</span>
        </div>
        <div id="progressContainer" class="progress-bar" style="display: none;">
          <div id="progress" class="progress"></div>
        </div>
        <div id="preview" style="display: none;">
          <div class="upload-preview">
            <img id="previewImage" src="" alt="Preview">
            <span id="fileName"></span>
            <span class="remove-btn" onclick="removeFile()">X</span>
          </div>
        </div>
      </div>

      <button type="submit" >Add Product</button>
    </form>
</div>
@stop
