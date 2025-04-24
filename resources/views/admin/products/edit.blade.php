@extends('admin.layouts.master')
@section('title', 'Product Add')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{route('admin.products.postedit', $product->id)}}"  method="post" class="add_user" enctype="multipart/form-data">
    @csrf
      <div class="two-input">
        <div class="input-div w-half">
          <label for="title" class="riq">Title</label>
          <input value="{{ old('title' , $product->title) }}" type="text" id="title" name="title" placeholder="Enter Product Title">
          @error('title')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        <div class="input-div w-half">
          <label for="price" class="riq">Price</label>
          <input type="number" value="{{ old('price' , $product->price) }}" id="price" name="price" placeholder="Enter Product Price">
          @error('price')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>
      <div class="two-input">
        <div class="input-div w-half">
          <label for="sale_price" class="riq">Sale Price</label>
          <input value="{{  old('sale' , $product->sale) }}" type="number" id="sale_price" name="sale" placeholder="Sale Price">
          @error('sale_price')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        <div class="input-div w-half">
          <label for="cat" class="riq">Category</label>
          <select name="categories[]" id="categories" multiple>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}"
              {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
              {{ $category->name }}
          </option>

        @endforeach



          </select>
          @error('categories')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>

      </div>
      <div class="input-div ">
        <label for="price" class="riq">Status</label>
        <select name="statue" id="statue">
          <option value="0" {{ old('statue', $product->is_draft ) == 0 ? 'selected' : '' }}>Publish</option>
          <option value="1" {{ old('statue', $product->is_draft ) == 1 ? 'selected' : '' }}>Draft</option>
        </select>
        @error('price')
          <small class="text-danger">{{$message}}</small>
        @enderror
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
        <div id="preview" style="display: block;">
          <div class="upload-preview">
            <img id="previewImage" src="{{ URL::asset( old('image' , $product->image )) }}" alt="Preview">
            <span id="fileName"></span>
            <span class="remove-btn" onclick="removeFile()">X</span>
          </div>
        </div>
      </div>

      <button type="submit" >Update Product</button>
    </form>
</div>
@stop


@section('js')
<script>
  $(document).ready(function() {
      $('#categories').select2({
          placeholder: "Choose Categories",
          allowClear: true
      });
  });
</script>
@stop
