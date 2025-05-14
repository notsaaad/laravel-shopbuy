@extends('user.layouts.master')
@section('title', $product['title'])

@section('css')
<link rel="stylesheet" href="{{ URL::asset('public/user/css/single_product.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
  .color-circle {
    width: 25px;
    height: 25px;
    display: inline-block;
    border-radius: 50%;
    margin: 5px;
    cursor: pointer;
    border: 2px solid #ccc;
  }
  .color-circle.selected {
    border-color: #000;
  }
  .size-label {
    display: inline-block;
    padding: 5px 10px;
    border: 1px solid #ccc;
    margin: 5px;
    cursor: pointer;
  }
  .size-label.selected {
    background: #000;
    color: white;
  }
</style>
@stop

@section('content')
@php $requestedColor = request('color'); @endphp

<br><br><br>
<div class="main-content">
  <div class="container">
    @guest
      <div class="alert alert-danger" role="alert">
        Login For Add To Cart
        <a href="{{ route('login') }}">Login</a>
      </div>
    @endguest

    <div class="product-page d-flex gap-4 mt-5">
      {{-- Images --}}
      <div class="product-images">
        <a id="mainImageLink" href="{{ URL::asset(ProductImagePath() . $product['image']) }}" data-lightbox="product-gallery">
          <img src="{{ URL::asset(ProductImagePath() . $product['image']) }}" alt="{{ $product['title'] }}" class="main-image" id="mainImage" width="400" height="400">
        </a>

        @if (! empty($product['gallery']))
          <div class="thumbnails mt-3 d-flex gap-2">
            <img src="{{ URL::asset(ProductImagePath() . $product['image']) }}" alt="{{ $product['title'] }}" width="80" height="80" onclick="changeMainImage(this.src)">
            @foreach ($product['gallery'] as $img)
              <img src="{{ URL::asset(ProductImagePath() . $img)}}" alt="img" width="80" height="80" onclick="changeMainImage(this.src)">
            @endforeach
          </div>
        @endif
      </div>

      {{-- Product Details --}}
      <div class="product-details">
        <h1>{{ $product['title'] }}</h1>
        <p>{{ $product['description'] ?? 'No description available.' }}</p>

        <div class="price-section my-3">
          @if(!empty($product['sale']))
            <span class="text-muted text-decoration-line-through">{{ $product['price'] }} $</span>
            <span class="fw-bold text-primary">{{ $product['sale'] }} $</span>
          @else
            <span class="fw-bold">{{ $product['price'] }} $</span>
          @endif
        </div>

        @if($product['type'] === 'variant' && !empty($product['formatted_variants']))
          <form id="addToCartForm" method="POST" action="{{ route('add_product') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
            <input type="hidden" name="variant_id" id="selectedVariantId">

            @php
              $allAttributes = [];
              foreach ($product['formatted_variants'] as $variant) {
                foreach ($variant['attributes'] as $attr) {
                  $allAttributes[$attr['attribute']][] = $attr;
                }
              }
            @endphp

            @foreach($allAttributes as $attributeName => $values)
              <label class="mt-2 d-block fw-bold">{{ $attributeName }}</label>
              <div class="variant-options" data-attribute="{{ $attributeName }}">
                @foreach(collect($values)->unique('value') as $val)
                  @php
                    $isSelected = $requestedColor && strtolower($val['value']) == strtolower($requestedColor);
                    $imagePathForColor = $val['image_path'] ?? $product['image'];
                  @endphp
                  @if(!empty($val['color_code']))
                    <span class="color-circle {{ $isSelected ? 'selected' : '' }}"
                          style="background-color: {{ $val['color_code'] }}"
                          data-value="{{ $val['value'] }}"
                          title="{{ $val['value'] }}"
                          data-img="{{ $imagePathForColor }}">
                    </span>
                  @else
                    <label class="size-label {{ $isSelected ? 'selected' : '' }}" data-value="{{ $val['value'] }}">{{ $val['value'] }}</label>
                  @endif
                @endforeach
              </div>
            @endforeach

            @auth
              <button type="submit" class="btn btn-success mt-3">Add to Cart</button>
            @endauth
          </form>
        @else
          @auth
            <form method="POST" action="{{ route('add_product') }}">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product['id'] }}">
              <button type="submit" class="btn btn-success mt-3">Add to Cart</button>
            </form>
          @endauth
        @endif
        @guest
          <a href="{{ route('login') }}" class="btn btn-danger">Login For Add To Cart</a>
        @endguest
      </div>
    </div>
  </div>
</div>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
  const variantData = @json($product['formatted_variants']);
  const selectedAttributes = {};
  const productType = '{{ $product["type"] }}';
  const initialColor = '{{ strtolower(request("color")) }}';

  document.addEventListener("DOMContentLoaded", () => {
    const variantGroups = document.querySelectorAll('.variant-options');
    const mainImage = document.getElementById('mainImage');
    const mainImageLink = document.getElementById('mainImageLink');
    const selectedVariantInput = document.getElementById('selectedVariantId');

    variantGroups.forEach(group => {
      const attrName = group.dataset.attribute;

      group.querySelectorAll('[data-value]').forEach(option => {
        option.addEventListener('click', function () {
          group.querySelectorAll('.selected').forEach(el => el.classList.remove('selected'));
          this.classList.add('selected');
          selectedAttributes[attrName] = this.dataset.value;

          let updatedImage = false;

          // ✅ تحديث الصورة بمجرد اختيار اللون
          if (this.classList.contains('color-circle')) {
            const selectedColorValue = this.dataset.value;
            const colorVariant = Object.entries(variantData).find(([id, data]) =>
              data.attributes.some(attr =>
                attr.attribute.toLowerCase() === attrName.toLowerCase() &&
                attr.value === selectedColorValue &&
                attr.image_path
              )
            );

            if (colorVariant) {
              const imagePath = colorVariant[1].image_path;
              const fullImg = '{{ asset(ProductImagePath()) }}/' + imagePath;
              mainImage.src = fullImg;
              mainImageLink.href = fullImg;
              updatedImage = true;
            }
          }

          // ✅ محاولة إيجاد الـ variant الكامل
          const matchedVariant = Object.entries(variantData).find(([id, data]) =>
            data.attributes.every(attr =>
              selectedAttributes[attr.attribute] === attr.value
            )
          );

          if (matchedVariant) {
            selectedVariantInput.value = matchedVariant[0];

            if (!updatedImage && matchedVariant[1].image_path) {
              const fullImg = '{{ asset(ProductImagePath()) }}/' + matchedVariant[1].image_path;
              mainImage.src = fullImg;
              mainImageLink.href = fullImg;
            }
          }
        });

        // ⇨ تفعيل اللون المختار من URL عند تحميل الصفحة
        if (option.dataset.value.toLowerCase() === initialColor) {
          option.click();
        }
      });
    });
  });

  document.getElementById('addToCartForm')?.addEventListener('submit', function(e) {
    if (productType === 'variant' && !document.getElementById('selectedVariantId').value) {
      e.preventDefault();
      alert('Please select all variant options.');
    }
  });

  function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
    document.getElementById('mainImageLink').href = src;
  }
</script>
@stop
