@extends('admin.layouts.master')
@section('title', 'Product Add')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
    <form action="{{ route('admin.product.post') }}" method="post" class="add_user" enctype="multipart/form-data">
        @csrf

        <div class="two-input">
            <div class="input-div w-half">
                <label for="title" class="riq">Title</label>
                <input type="text" value="{{ old('title') }}" id="title" name="title" placeholder="Enter Product Title">
                @error('title')<small class="text-danger">{{$message}}</small>@enderror
            </div>

            <div class="input-div w-half">
                <label for="price" class="riq">Price</label>
                <input type="number" step="any" value="{{ old('price') }}" id="price" name="price" placeholder="Enter Product Price">
                @error('price')<small class="text-danger">{{$message}}</small>@enderror
            </div>
        </div>

        <div class="two-input">
            <div class="input-div w-half">
                <label for="sale" class="riq">Sale Price</label>
                <input type="number" step="any" value="{{ old('sale') }}" id="sale" name="sale" placeholder="Sale Price">
                @error('sale')<small class="text-danger">{{$message}}</small>@enderror
            </div>

            <div class="input-div w-half">
                <label for="cat" class="riq">Category</label>
                <select name="categories[]" id="categories" multiple>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ in_array($cat->id, old('categories', [])) ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('categories')<small class="text-danger">{{$message}}</small>@enderror
            </div>
        </div>

        <div class="input-div Description_div">
            <label for="description">Description</label>
            <textarea name="description" class="Description" placeholder="Enter Product Description" id="description">{{ old('description') }}</textarea>
        </div>

        <div class="two-input">
            <div class="input-div w-half">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock') }}" placeholder="Enter stock amount or leave empty">
                @error('stock')<small class="text-danger">{{$message}}</small>@enderror
            </div>

            <div class="input-div w-half">
                <label for="type">Product Type</label>
                <select name="type" id="product_type">
                    <option value="simple" {{ old('type') == 'simple' ? 'selected' : '' }}>Simple</option>
                    <option value="variant" {{ old('type') == 'variant' ? 'selected' : '' }}>Variant</option>
                </select>
                @error('type')<small class="text-danger">{{$message}}</small>@enderror
            </div>
        </div>

        <div class="product_editor upload-container mb-2">
          <hr>
            <div class="input-div"><label for="" class="riq">Add Product Image</label></div>
            <div class="image-upload">
                <i class="fa-regular fa-image"></i>
                <input type="file" name="image" id="fileInput" class="fileInput" accept="image/*">
                <span class="Upload_image">Main Image</span>
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
        @error('image')
          <small class="text-danger">{{$message}}</small>
        @enderror

        <div class="product_editor upload-container mt-2">
            <hr>
            <div class="input-div">
                <label for="galleryInput" >Add Product Gallery</label>
            </div>

            <div class="image-upload">
                <i class="fa-regular fa-image"></i>
                <input type="file" name="gallery[]" id="galleryInput" class="galleryInput fileInput" accept="image/*" multiple>
                <span class="Upload_image">Upload Images</span>
            </div>

            <div id="gallarypreview" class="upload-preview" style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach (old('gallery', []) as $image)
                    <div class="image-preview">
                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image">
                    </div>
                @endforeach
            </div>
          </div>
          @error('gallery')
            <small class="text-danger">{{ $message }}</small><br>
          @enderror

          @if($errors->has('gallery.*'))
            @foreach ($errors->get('gallery.*') as $messages)
              @foreach ($messages as $message)
                <small class="text-danger">{{ $message }}</small><br>
              @endforeach
            @endforeach
          @endif

        <button type="submit">Add Product</button>
    </form>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#categories').select2({
        placeholder: "Choose Categories",
        allowClear: true
    });

    $('#product_type').change(function() {
        if ($(this).val() === 'simple') {
            $('#stock').closest('.input-div').show();
        } else {
            $('#stock').closest('.input-div').hide();
        }
    }).trigger('change');
});
</script>
@endsection
