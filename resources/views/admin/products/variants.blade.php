@extends('admin.layouts.master')
@section('title', 'Manage Variants for: ' . $product->title)

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .variant-image-selector img {
    width: 80px;
    height: 80px;
    border: 2px solid transparent;
    cursor: pointer;
    margin: 5px;
  }
  .variant-image-selector img.selected {
    border-color: green;
  }
</style>
@endsection

@section('content')
<div class="only-form">
  <h3>Manage Variants for Product: {{ $product->title }}</h3>

  <form action="{{ route('admin.products.variants.store', $product->id) }}" method="POST">
    @csrf

    {{-- Select images for each color --}}
    @if ($colorAttribute && $colorAttribute->values->count())
      <h4>Assign Images to Colors</h4>
      <div style="display: flex; flex-wrap: wrap; gap: 30px;">
        @foreach ($colorAttribute->values as $color)
          <div style="min-width: 200px;">
            <label>{{ $color->value }}</label>
            <div class="variant-image-selector" data-color-id="{{ $color->id }}">
              @foreach ($galleryImages as $img)
                <img src="{{ $img['url'] }}" data-filename="{{ $img['filename'] }}"
                     onclick="selectColorImage('{{ $color->id }}', this)">
              @endforeach
            </div>
            <input type="hidden" name="color_images[{{ $color->id }}]" value="">
          </div>
        @endforeach
      </div>
      <hr>
    @endif

    {{-- Attributes --}}
    @foreach ($attributes as $attribute)
      <div class="input-div" style="margin-bottom: 20px;">
        <label>{{ $attribute->name }}</label>
        <select name="attribute_values[{{ $attribute->id }}][]" multiple class="attribute-values-select" style="width: 100%;">
          @foreach ($attribute->values as $value)
            <option value="{{ $value->id }}">{{ $value->value }}</option>
          @endforeach
        </select>
      </div>
    @endforeach

    <button type="button" class="btn btn-success" id="generate_variants_btn">Generate Variants</button>

    <div id="variants_section" style="margin-top: 30px;"></div>

    <button type="submit" class="btn btn-primary mt-3">Save Variants</button>
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

      let html = '<table class="table"><thead><tr><th>Variant</th><th>Stock</th></tr></thead><tbody>';

      for (let i = 0; i < idCombinations.length; i++) {
        let ids = idCombinations[i];
        let names = nameCombinations[i];

        html += `<tr>
          <td>${names.join(' - ')}<input type="hidden" name="variants[${i}][attributes]" value="${ids.join(',')}"></td>
          <td><input type="number" name="variants[${i}][stock]" placeholder="Stock" required></td>
        </tr>`;
      }

      html += '</tbody></table>';
      $('#variants_section').html(html);
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
      $(`input[name="color_images[${colorId}]"]`).val($(imgElement).data('filename'));
    };
  });
</script>
@endsection
