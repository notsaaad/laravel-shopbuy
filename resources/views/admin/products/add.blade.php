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
          <select name="categories[]" id="categories" multiple>
            {{-- <option value="NULL">Select Product Cateogry </option> --}}
            @foreach ($categories as $cat )
              <option value="{{ $cat->id }}">{{$cat->name}}</option>
            @endforeach
            @empty($categories)
              <option value="NULL">-- Please Add Category --</option>
            @endempty

          </select>
        </div>
      </div>

      <div class="input-div ">
        <label for="cat" class="riq">Product Type</label>
        <select name="type" id="product_type">
          <option value="NULL">Select Product Cateogry </option>
          <option value="simple">Simple</option>
          <option value="variant">variant</option>
        </select>
      </div>
      <div id="variant_section" class="input-div" style="display: none; margin-top: 20px;">
        <label for="attribute_selector">Select Attribute:</label>
        <select id="attribute_selector" style="width: 100%;" multiple>
        </select>

        <button class="btn btn-primary mt-2" type="button" id="add_attribute_btn">Add Attribute</button>

        <div id="selected_attributes_section" style="margin-top: 20px;">
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

@section('js')
<script>
  $(document).ready(function() {
      $('#categories').select2({
          placeholder: "Choose Categories",
          allowClear: true
      });
  });

  // ============================== For Vairents =====================================
    $(document).ready(function() {

  let selectedAttributes = [];

  // Show variant section if type is 'variant'
  $('#product_type').change(function() {
    if ($(this).val() === 'variant') {
      $('#variant_section').show();

      // Load available attributes via AJAX
      $('#attribute_selector').select2({
        ajax: {
          url: '{{ route('admin.products.GetAllAttributs') }}',
          dataType: 'json',
          processResults: function(data) {
            return {
              results: data.map(function(attr) {
                return { id: attr.id, text: attr.name };
              })
            };
          }
        },
        placeholder: 'Select an attribute',
        allowClear: true
      });

    } else {
      $('#variant_section').hide();
      $('#selected_attributes_section').empty();
      selectedAttributes = [];
    }
  });

  // Add selected attribute
  $('#add_attribute_btn').click(function(e) {
    e.preventDefault();

    let attrId = $('#attribute_selector').val();
    let attrText = $('#attribute_selector option:selected').text();

    if (!attrId) {
      alert('Please select an attribute first.');
      return;
    }

    // Check for duplicate attribute
    if (selectedAttributes.includes(attrId)) {
      alert('This attribute has already been added.');
      return;
    }

    selectedAttributes.push(attrId);

    // Load values for the selected attribute
    $.ajax({
      // url: '/api/attribute/' + attrId + '/values',
      url: `admin//product/getAllAttributsValues/${attrId}`,
      method: 'GET',
      success: function(values) {
        console.log(values);

        let html = `
          <div class="attribute-block" data-attr-id="${attrId}" style="margin-bottom: 20px;">
            <h4>${attrText}</h4>
            <select multiple class="attribute-values-select" name="attribute_values[${attrId}][]" style="width: 100%;">
        `;

        values.forEach(function(val) {
          html += `<option value="${val.id}">${val.value}</option>`;
        });

        html += `
            </select>
            <button type="button" class="remove_attribute_btn" data-attr-id="${attrId}" style="margin-top: 10px;">Remove</button>
          </div>
        `;

        $('#selected_attributes_section').append(html);

        // Initialize Select2 for the values
        $(`.attribute-block[data-attr-id="${attrId}"] .attribute-values-select`).select2({
          placeholder: 'Select values for ' + attrText
        });
      }
    });
  });

  // Remove attribute block
  $(document).on('click', '.remove_attribute_btn', function() {
    let attrId = $(this).data('attr-id');
    $(`.attribute-block[data-attr-id="${attrId}"]`).remove();
    selectedAttributes = selectedAttributes.filter(id => id !== attrId);
  });

  });


</script>
@stop
