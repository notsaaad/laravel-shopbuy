@extends('admin.layouts.master')
@section('title', 'Edit Variants for: ' . $product->title)

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
<style>
  .variant-image-selector img {
    width: 80px;
    height: 80px;
    border: 4px solid transparent;
    cursor: pointer;
    margin: 5px;
    border-radius: 3px;
  }
  .variant-image-selector img.selected {
    border-color: green;

  }

  td,th{
    background-color: var(--font_table) !important;
    color: var(--font-product) !important;
    vertical-align: middle;
  }
  .design_header  th{
  font-size: 15px !important;
  font-weight: bold !important;
  color: var(--link-color) !important;
}
</style>
@endsection

@section('content')
<div class="only-form">
  <h3>Edit Variants for Product: {{ $product->title }}</h3>

  <form action="{{ route('admin.products.variants.store2', $product->id) }}" method="POST">
    @csrf

    {{-- Color Image Selection --}}
    @if ($colorAttribute && $colorAttribute->values->count())
      <h4>Assign Images to Colors</h4>
      <div style="display: flex; flex-wrap: wrap; gap: 30px;">
        @foreach ($colorAttribute->values as $color)
          @php
            $selectedImage = $product->variants
              ->firstWhere(fn($v) => $v->attributeValues->contains('id', $color->id))
              ?->image_path;
          @endphp

          <div style="min-width: 200px;">
            <label>{{ $color->value }}</label>
            <div class="variant-image-selector" data-color-id="{{ $color->id }}">
              @foreach ($galleryImages as $img)
                <img src="{{ $img['url'] }}"
                     data-filename="{{ $img['filename'] }}"
                     class="{{ $selectedImage === $img['filename'] ? 'selected' : '' }}"
                     onclick="selectColorImage('{{ $color->id }}', this)">
              @endforeach
            </div>
            <input type="hidden"
                   name="color_images[{{ $color->id }}]"
                   id="color-image-{{ $color->id }}"
                   value="{{ $selectedImage }}">
          </div>
        @endforeach
      </div>
      <hr>
    @endif

    {{-- Attribute Selectors --}}
    @foreach ($attributes as $attribute)
      <div class="input-div" style="margin-bottom: 20px;">
        <label>{{ $attribute->name }}</label>
        <select name="attribute_values[{{ $attribute->id }}][]" multiple class="attribute-values-select" style="width: 100%;">
          @foreach ($attribute->values as $value)
            <option value="{{ $value->id }}"
              {{ in_array($value->id, $selectedAttributeValues) ? 'selected' : '' }}>
              {{ $value->value }}
            </option>
          @endforeach
        </select>
      </div>
    @endforeach

    <button type="button" class="btn btn-success" id="generate_variants_btn">Generate New Variants</button>

    <div id="variants_section" style="margin-top: 30px;">
      <h4>Existing Variants</h4>
      <div class="d-flex justfiy-content-end w-100">
        <div style="gap: 20px"  class="d-flex gx-3 gy-2 justify-content-center align-items-center w-100">
          <div class="input-div w-100">
            <input type="text" id="bulkstock" placeholder="Bulk Stock Edit">
          </div>
          <span  class="btn btn-primary" onclick="ChangeAllStock()">Edit</span>
        </div>
      </div>
      <div class="table_header">
      <table class="table">
        <thead>
          <tr class="design_header">
            <th>Variant</th>
            <th>Stock</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($product->variants as $index => $variant)
            <tr>
              <td>
                {{ $variant->attributeValues->pluck('value')->join(' - ') }}
                <input type="hidden" name="variants[{{ $index }}][attributes]" value="{{ $variant->attributeValues->pluck('id')->join(',') }}">
              </td>
              <td>
                <div class="input-div">
                  <input type="number" class="vairant-stock" name="variants[{{ $index }}][stock]" value="{{ $variant->stock }}" required>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Update Variants</button>
  </form>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
const galleryImages = @json($galleryImages);
const colorAttributeId = {{ $colorAttributeId ?? 'null' }};

$(document).ready(function () {
  $('.attribute-values-select').select2({ placeholder: 'Select values', allowClear: true });

  $('#generate_variants_btn').click(function () {
    let attributeValuesMap = {};

    $('.attribute-values-select').each(function () {
      let attrId = $(this).attr('name').match(/\d+/)[0];
      let selectedOptions = $(this).select2('data');
      let values = selectedOptions.map(opt => ({ id: opt.id, text: opt.text }));
      if (values.length) attributeValuesMap[attrId] = values;
    });

    generateVariantCombinations(attributeValuesMap);
  });

  function generateVariantCombinations(valuesMap) {
    let idCombinations = generateCombinations(Object.values(valuesMap).map(vs => vs.map(v => v.id)));
    let nameCombinations = generateCombinations(Object.values(valuesMap).map(vs => vs.map(v => v.text)));

    let existingVariants = $('input[name^="variants"]').map(function () {
      return $(this).val();
    }).get();

    let existingCount = $('input[name^="variants"]').length;
    let newRows = '';

    for (let i = 0; i < idCombinations.length; i++) {
      let ids = idCombinations[i];
      let names = nameCombinations[i];
      let idsKey = ids.join(',');

      if (existingVariants.includes(idsKey)) continue;

      let index = existingCount++;
      newRows += `<tr>
        <td>${names.join(' - ')}<input type="hidden" name="variants[${index}][attributes]" value="${idsKey}"></td>
        <td>
            <div class="input-div">
              <input type="number" class="vairant-stock" name="variants[${index}][stock]" placeholder="Stock" required>
            </div>
        </td>
      </tr>`;
    }

    $('#variants_section tbody').html(newRows);
  }

  function generateCombinations(arrays, prefix = []) {
    if (!arrays.length) return [prefix];
    let result = [];
    let first = arrays[0], rest = arrays.slice(1);
    for (let val of first) {
      result.push(...generateCombinations(rest, prefix.concat(val)));
    }
    return result;
  }

  window.selectColorImage = function (colorId, imgElement) {
    $(`.variant-image-selector[data-color-id="${colorId}"] img`).removeClass('selected');
    $(imgElement).addClass('selected');
    $(`#color-image-${colorId}`).val($(imgElement).data('filename'));
  };
});

function ChangeAllStock(){
  let val = $('#bulkstock').val();
  $('#variants_section .vairant-stock').val(val);
  $('#bulkstock').val();
}
</script>
@endsection
