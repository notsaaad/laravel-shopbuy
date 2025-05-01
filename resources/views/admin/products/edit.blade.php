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


    <div class="two-input">
      <div class="input-div w-half">
        <label for="title" class="riq">Title</label>
        <input value="{{ old('title', $product->title) }}" type="text" id="title" name="title" placeholder="Enter Product Title">
        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
      <div class="input-div w-half">
        <label for="price" class="riq">Price</label>
        <input type="number" value="{{ old('price', $product->price) }}" id="price" name="price" placeholder="Enter Product Price">
        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
    </div>

    <div class="two-input">
      <div class="input-div w-half">
        <label for="sale_price" class="riq">Sale Price</label>
        <input value="{{ old('sale', $product->sale) }}" type="number" id="sale_price" name="sale" placeholder="Sale Price">
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


      <div class="two-input">
        <div class="input-div w-half" style="width: 50%">
          <label for="stock" >Stock</label>
          <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"  placeholder="Enter Stock amount or leave it empty for non tracking">
          @error('stock')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>

    <div class="input-div Description_div">
      <label for="description" >Description</label>
      <textarea name="description"  class="Description"  placeholder="Enter Product Descraiption" id="description" >{{ old('description', $product->description) }}</textarea>
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
      <div class="input-div"><label for="" class="riq">Add Product Image</label></div>
      <div class="image-upload">
        <i class="fa-regular fa-image"></i>
        <input type="file" name="image" id="fileInput" class="fileInput" accept="image/*">
        <span class="Upload_image">Upload image</span>
      </div>
      <div id="progressContainer" class="progress-bar" style="display: none;">
        <div id="progress" class="progress"></div>
      </div>
      <div id="preview" style="display: block;">
        <div class="upload-preview">
          <img id="previewImage" src="{{ URL::asset(ProductImagePath().$product->image) }}" alt="Preview">
          <span id="fileName"></span>
          <span class="remove-btn" onclick="removeFile()">X</span>
        </div>
      </div>
    </div>

    <!-- Variant Section -->
    @if($product->type == 'variant')
      <div class="input-div" style="margin-top: 20px;">
        <h4>Attributes & Variants</h4>

        @foreach($attributes as $attribute)
          <div style="margin-bottom: 20px;">
            <label>{{ $attribute->name }}</label>
            <select name="attribute_values[{{ $attribute->id }}][]" multiple class="attribute-values-select" style="width: 100%;">
              @foreach($attribute->values as $value)
                <option value="{{ $value->id }}"
                  @foreach($product->variants as $variant)
                    @foreach($variant->attributeValues as $attrVal)
                      {{ $attrVal->id == $value->id ? 'selected' : '' }}
                    @endforeach
                  @endforeach
                >{{ $value->value }}</option>
              @endforeach
            </select>
          </div>
        @endforeach

        <!-- زر توليد الـ Variants -->
        <button class="btn btn-success mt-2" type="button" id="generate_variants_btn">Generate Variants</button>

        <!-- مكان عرض الـ Variants -->
        <div id="variants_section" style="margin-top: 30px;"></div>
      </div>
    @endif
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

      @if ($product->gallery)
      <div id="gallarypreview"  class="upload-preview" style="display: flex; flex-wrap: wrap; gap: 10px;">
          @foreach ($product->gallery as $index => $image)
              <div class="previewContainer" data-index="{{ $index }}">
                  <img src="{{ URL::asset(ProductImagePath(). $image) }}" alt="Gallery Image" width="100" height="100">
                  <span class="GallaryRemoveImage" onclick="removeExistingImage({{ $index }})">X</span>
              </div>
          @endforeach
      </div>

      <!-- Hidden input to track removed images -->
      <input type="hidden" name="removed_images" id="removedImages" value="">
    @endif



    <button type="submit">Update Product</button>
  </form>
</div>
@stop

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
    $('.attribute-values-select').select2({ placeholder: "Choose Values", allowClear: true, width: '100%' });

    $('#generate_variants_btn').click(function() {
      let attributeValuesMap = {};
      $('.attribute-values-select').each(function() {
        let attrId = $(this).attr('name').match(/\d+/)[0];
        let selectedOptions = $(this).select2('data');
        let valuesWithNames = selectedOptions.map(opt => ({ id: opt.id, text: opt.text }));
        if (valuesWithNames.length > 0) {
          attributeValuesMap[attrId] = valuesWithNames;
        }
      });

      let nameCombinations = [], idCombinations = [];
      function generateCombinations(arrays, prefix = []) {
        if (!arrays.length) return [prefix];
        let result = [], first = arrays[0], rest = arrays.slice(1);
        first.forEach(function(value) {
          result = result.concat(generateCombinations(rest, prefix.concat(value)));
        });
        return result;
      }

      function generateCombinationsWithNames(valuesMap) {
        let arraysOfIds = [], arraysOfNames = [];
        Object.values(valuesMap).forEach(attrValues => {
          arraysOfIds.push(attrValues.map(v => v.id));
          arraysOfNames.push(attrValues.map(v => v.text));
        });
        idCombinations = generateCombinations(arraysOfIds);
        nameCombinations = generateCombinations(arraysOfNames);
      }

      generateCombinationsWithNames(attributeValuesMap);

      let html = '<table class="table_header"><thead><tr class="design_header"><th>Variant</th><th>Stock</th></tr></thead><tbody>';
      for (let i = 0; i < nameCombinations.length; i++) {
        let comboNames = nameCombinations[i], comboIds = idCombinations[i];
        let combinedDisplay = comboIds.map((id, index) => `${id} (${comboNames[index]})`).join(' - ');
        let comboIdsString = comboIds.join(','), name = comboNames.join(' - ');
        html += `<tr>
                  <td>${combinedDisplay}<input type="hidden" name="variants[${i}][attributes]" value="${comboIdsString}"></td>
                  <td><input type="number" name="variants[${i}][stock]" placeholder="Enter ${name} Stock"></td>
                </tr>`;
      }
      html += '</tbody></table>';
      $('#variants_section').html(html);
    });

    window.removeFile = function() {
      $('#fileInput').val('');
      $('#preview').hide();
    }
  });
</script>
@stop
