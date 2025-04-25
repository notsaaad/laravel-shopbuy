@extends('admin.layouts.master')
@section('title',$value->value .' Edit')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('att_update_value', $value->id) }}"  method="post" class="add_user" enctype="multipart/form-data">
    @csrf
        <div class="input-div">
          <label for="value" class="riq">label name</label>
          <input type="text" autocomplete="off" value="{{ old('value', $value->value) }}" id="value" name="value" placeholder="Enter Name of  value">
          @error('value')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        @if ($value->image_path)
        <div class="product_editor upload-container">
          <div class="image-upload">
              <i class="fa-regular fa-image"></i>
            <input  type="file" name="image_path" id="fileInput" class="fileInput" accept="image/*" >
            <span class="Upload_image">Upload image</span>
          </div>
          <div id="progressContainer" class="progress-bar" style="display: none;">
            <div id="progress" class="progress"></div>
          </div>
          <div id="preview" style="display: block;">
            <div class="upload-preview">
              <img id="previewImage" src="{{ URL::asset( AttributeImagePath().$value->image_path ) }}" alt="Preview">
              <span id="fileName"></span>
              <span class="remove-btn" onclick="removeFile()">X</span>
            </div>
          </div>
          @error('image_path')
          <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        @elseif ($value->color_code)
        <div class="input-div" style="width: fit-content; display:flex">
          <label for="value" class="riq">Color Code</label>
          <input type="color"  value="{{ old('color_code', $value->color_code) }}" id="color_code" name="color_code" placeholder="Enter Color code">
          @error('color_code')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>




        @endif




      <button type="submit" >Update Value</button>
    </form>
</div>
@stop
