@extends('admin.layouts.master')
@section('title', 'Edit Product')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('admin.products.postedit', $product->id) }}" method="post" class="add_user" enctype="multipart/form-data">
    @csrf
    @if ($product->type == 'variant')
      <div class="d-flex justify-content-end">
        <a href="{{ route('admin.products.variants.edit2', $product) }}" class="btn btn-primary link">Edit Variants</a>
      </div>
    @endif
    <div class="two-input">
      <div class="input-div w-half">
        <label for="title" class="riq">Title</label>
        <input value="{{ old('title', $product->title) }}" type="text" id="title" name="title" placeholder="Enter Product Title">
        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="input-div w-half">
        <label for="price" class="riq">Price</label>
        <input type="number" value="{{ old('price', $product->price) }}" id="price" step="any" name="price" placeholder="Enter Product Price">
        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
    </div>

    <div class="two-input">
      <div class="input-div w-half">
        <label for="sale_price" class="riq">Sale Price</label>
        <input value="{{ old('sale', $product->sale) }}" type="number" step="any" id="sale_price" name="sale" placeholder="Sale Price">
        @error('sale') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="input-div w-half">
        <label for="cat" class="riq">Category</label>
        <select name="categories[]" id="categories" multiple>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
        @error('categories') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
    </div>

    @if($product->type == 'simple')
    <div class="two-input">
      <div class="input-div w-half">
        <label for="stock">Stock</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" placeholder="Enter stock amount">
        @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
    </div>
    @endif

    <div class="input-div Description_div">
      <label for="description">Description</label>
      <textarea name="description" class="Description" placeholder="Enter Product Description" id="description">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="two-inputs">
      <div class="input-div w-half">
        <label for="statue" class="riq">Status</label>
        <select name="statue" id="statue">
          <option value="0" {{ old('statue', $product->is_draft) == 0 ? 'selected' : '' }}>Publish</option>
          <option value="1" {{ old('statue', $product->is_draft) == 1 ? 'selected' : '' }}>Draft</option>
        </select>
        @error('statue') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
    </div>

    <!-- Image Upload -->
    <div class="product_editor upload-container mb-2">
      <hr>
      <div class="input-div"><label for="" class="riq">Product Image</label></div>
      <div class="image-upload">
        <i class="fa-regular fa-image"></i>
        <input type="file" name="image" id="fileInput" class="fileInput" accept="image/*">
        <span class="Upload_image">Upload image</span>
      </div>

      <div id="preview" style="display: block;">
        <div class="upload-preview">
          <img id="previewImage" src="{{ URL::asset(ProductImagePath() . $product->image) }}" alt="Preview">
          <span class="remove-btn" onclick="removeFile()">X</span>
        </div>
      </div>
    </div>

    <!-- Gallery Upload -->
    <div class="product_editor upload-container mt-2">
      <hr>
      <div class="input-div">
        <label for="galleryInput">Product Gallery</label>
      </div>
      <div class="image-upload">
        <i class="fa-regular fa-image"></i>
        <input type="file" name="gallery[]" id="galleryInput" class="galleryInput fileInput" accept="image/*" multiple>
        <span class="Upload_image">Upload Images</span>
      </div>

      @if ($product->gallery)
        <div id="gallarypreview" class="upload-preview" style="display: flex; flex-wrap: wrap; gap: 10px;">
          @foreach ($product->gallery as $index => $image)
            <div class="previewContainer" data-index="{{ $index }}">
              <img src="{{ URL::asset(ProductImagePath() . $image) }}" alt="Gallery Image" width="100" height="100">
              <span class="GallaryRemoveImage" onclick="removeExistingImage({{ $index }})">X</span>
            </div>
          @endforeach
        </div>
        <input type="hidden" name="removed_images" id="removedImages" value="">
      @endif

      @error('gallery')<small class="text-danger">{{ $message }}</small>@enderror

      @if($errors->has('gallery.*'))
        @foreach ($errors->get('gallery.*') as $messages)
          @foreach ($messages as $message)
            <small class="text-danger">{{ $message }}</small><br>
          @endforeach
        @endforeach
      @endif
    </div>

    <button type="submit">Update Product</button>
  </form>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  let removedImages = [];

  function removeExistingImage(index) {
    const container = document.querySelector(`.previewContainer[data-index='${index}']`);
    container.remove();
    removedImages.push(index);
    document.getElementById('removedImages').value = removedImages.join(',');
  }

  $(document).ready(function() {
    $('#categories').select2({ placeholder: "Choose Categories", allowClear: true });

    window.removeFile = function() {
      $('#fileInput').val('');
      $('#preview').hide();
    }
  });
</script>
@endsection
