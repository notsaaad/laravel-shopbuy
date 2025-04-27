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
                @error('title')
                  <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="input-div w-half">
                <label for="price" class="riq">Price</label>
                <input type="number" value="{{ old('price') }}" id="price" name="price" placeholder="Enter Product Price">
                @error('price')
                  <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>

        <div class="two-input">
            <div class="input-div w-half">
                <label for="sale" class="riq">Sale Price</label>
                <input type="number" value="{{ old('sale') }}" id="sale" name="sale" placeholder="Sale Price">
                @error('sale')
                  <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="input-div w-half">
                <label for="cat" class="riq">Category</label>
                <select name="categories[]" id="categories" multiple>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                    @empty($categories)
                        <option value="NULL">-- Please Add Category --</option>
                    @endempty
                </select>
            </div>
        </div>
        <div class="input-div Description_div">
          <label for="description" >Description</label>
          <textarea name="description" value="{{ old('description') }}"  class="Description"  placeholder="Enter Product Descraiption" id="description" ></textarea>
        </div>

        <div class="input-div ">
            <label for="cat" class="riq">Product Type</label>
            <select name="type" id="product_type">
                <option value="NULL">Select Product Type </option>
                <option value="simple">Simple</option>
                <option value="variant">Variant</option>
            </select>

            <div id="variant_section" class="input-div" style="display: none; margin-top: 20px;">
                <label for="attribute_selector">Select Attribute:</label>
                <select id="attribute_selector" style="width: 100%;" multiple></select>

                <button class="btn btn-primary mt-2" type="button" id="add_attribute_btn">Add Attribute</button>

                <div id="selected_attributes_section" style="margin-top: 20px;"></div>

                <button class="btn btn-success mt-2" type="button" id="generate_variants_btn" style="display: none;">Generate Variants</button>

                <div id="variants_section" style="margin-top: 30px;"></div>
            </div>
        </div>

        <div class="product_editor upload-container">
            <div class="image-upload">
                <i class="fa-regular fa-image"></i>
                <input type="file" name="image" id="fileInput" class="fileInput" accept="image/*">
                <span class="Upload_image">Upload image</span>
            </div>
            <div id="progressContainer" class="progress-bar" style="display: none;">
                <div id="progress" class="progress"></div>
            </div>
            <div id="preview" style="display: none;">
                <div class="upload-preview">
                    <img id="previewImage" src="" alt="Preview" >
                    <span id="fileName"></span>
                    <span class="remove-btn" onclick="removeFile()">X</span>
                </div>
            </div>
        </div>

        <button type="submit">Add Product</button>
    </form>
</div>
@stop

@section('js')
<script>
var getAttributeValuesUrl = "{{ route('admin.products.GetAllAttributsValues', ':id') }}";

$(document).ready(function() {
    $('#categories').select2({
        placeholder: "Choose Categories",
        allowClear: true
    });

    let selectedAttributes = [];

    $('#product_type').change(function() {
        if ($(this).val() === 'variant') {
            $('#variant_section').show();

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
            $('#variants_section').empty();
            selectedAttributes = [];
        }
    });

    $('#add_attribute_btn').click(function(e) {
        e.preventDefault();

        let attrId = $('#attribute_selector').val();
        let attrData = $('#attribute_selector').select2('data')[0];
        let attrText = attrData.text;

        if (!attrId) {
            alert('Please select an attribute first.');
            return;
        }

        if (selectedAttributes.includes(attrId)) {
            alert('This attribute has already been added.');
            return;
        }

        selectedAttributes.push(attrId);

        // إزالة العنصر من الاختيارات
        let newOptions = $('#attribute_selector option').filter(function() {
            return $(this).val() != attrId;
        });
        $('#attribute_selector').empty().append(newOptions).trigger('change');

        let url = getAttributeValuesUrl.replace(':id', attrId);

        $.ajax({
            url: url,
            method: 'GET',
            success: function(values) {
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
                        <button type="button" class="remove_attribute_btn btn btn-danger" data-attr-id="${attrId}" style="margin-top: 10px;">Remove</button>
                    </div>
                `;

                $('#selected_attributes_section').append(html);

                $(`.attribute-block[data-attr-id="${attrId}"] .attribute-values-select`).select2({
                    placeholder: 'Select values for ' + attrText,
                    allowClear: true
                });

                // إظهار زرار Generate لو فيه قيم مختارة
                checkGenerateButtonVisibility();
            }
        });
    });

    $(document).on('click', '.remove_attribute_btn', function() {
        let attrId = $(this).data('attr-id');
        let attrName = $(`.attribute-block[data-attr-id="${attrId}"] h4`).text();

        $(`.attribute-block[data-attr-id="${attrId}"]`).remove();
        selectedAttributes = selectedAttributes.filter(id => id !== attrId);

        // رجع العنصر للـ Select
        let newOption = new Option(attrName, attrId, false, false);
        $('#attribute_selector').append(newOption).trigger('change');

        checkGenerateButtonVisibility();
    });

    $('#generate_variants_btn').click(function() {
        let attributeValuesMap = {};

        $('.attribute-block').each(function() {
            let attrId = $(this).data('attr-id');
            let selectedOptions = $(this).find('.attribute-values-select').select2('data');
            let valuesWithNames = selectedOptions.map(opt => ({ id: opt.id, text: opt.text }));

            if (valuesWithNames.length > 0) {
                attributeValuesMap[attrId] = valuesWithNames;
            }
        });

        let nameCombinations = [];
        let idCombinations = [];

        function generateCombinationsWithNames(valuesMap) {
            let arraysOfIds = [];
            let arraysOfNames = [];

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
            let comboNames = nameCombinations[i];
            let comboIds = idCombinations[i];

            let combinedDisplay = comboIds.map((id, index) => {
                return `${id} (${comboNames[index]})`;
            }).join(' - ');

            let comboIdsArray = comboIds;
            let name = comboNames.join(' - ');
            html += `<tr>
                        <td>${combinedDisplay}<input type="hidden" name="variants[${i}][attributes][]" value="${comboIdsArray.join(',')}"></td>
                        <td><input type="number" name="variants[${i}][stock]" placeholder="Enter ${name} Stock" ></td>
                    </tr>`;
        }
        html += '</tbody></table>';

        $('#variants_section').html(html);
    });

    function generateCombinations(arrays, prefix = []) {
        if (!arrays.length) {
            return [prefix];
        }
        let result = [];
        let first = arrays[0];
        let rest = arrays.slice(1);

        first.forEach(function(value) {
            result = result.concat(generateCombinations(rest, prefix.concat(value)));
        });

        return result;
    }

    function checkGenerateButtonVisibility() {
        let hasValues = false;
        $('.attribute-values-select').each(function() {
            if ($(this).val() && $(this).val().length > 0) {
                hasValues = true;
            }
        });

        if (hasValues) {
            $('#generate_variants_btn').show();
        } else {
            $('#generate_variants_btn').hide();
        }
    }
});
</script>
@stop
