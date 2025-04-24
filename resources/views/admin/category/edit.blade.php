@extends('admin.layouts.master')
@section('title', 'update  ' . $cat->name)

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('category.update', $cat->id) }}"  method="post" class="add_user"  enctype="multipart/form-data">
    @method('put')
    @csrf
        <div class="input-div w-half">
          <label for="name" class="riq">Category name</label>
          <input type="text" autocomplete="off" value="{{ old('name') ?? $cat->name }}" id="name" name="name" placeholder="Enter category name">
          @error('name')
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
              <img id="previewImage" src="{{ URL::asset( old('image' , 'public/admin/images/categories/'. $cat->image )) }}" alt="Preview">
              <span id="fileName"></span>
              <span class="remove-btn" onclick="removeFile()">X</span>
            </div>
          </div>
        </div>
      <button type="submit" >Update Category</button>
    </form>
</div>
@stop
