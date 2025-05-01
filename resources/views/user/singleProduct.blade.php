@extends('user.layouts.master')

@section('title', $product['title'])

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('public/user/css/single_product.css') }}">
@stop

@section('content')

<br><br><br>
<div class="main-content">
    <div class="container">
      @guest
      <div class="alert alert-success" role="alert">
        Login for cart
        <a href="{{ route('login') }}">Login</a>
      </div>
      @endguest
        <div class="product-page" style="display: flex; gap: 30px;">
            <div class="product-images">
                <img src="{{ URL::asset(ProductImagePath() . $product['image']) }}" alt="{{ $product['title'] }}" class="main-image">
                @if (! empty($product['gallery']))
                <div class="thumbnails">
                  <img src="{{ URL::asset(ProductImagePath() . $product['image']) }}" alt="{{ $product['title'] }}">

                @foreach ($product['gallery'] as $img )
                <img src="{{ URL::asset(ProductImagePath() . $img)}}" alt="img">
                @endforeach
                </div>
                @endif
            </div>

            <div class="product-details">
                <h1 class="product-title">{{ $product['title'] }}</h1>
                <p class="product-short-desc">{{ $product['description'] ?? 'No description available.' }}</p>
                <div class="price-section">
                    @if(!empty($product['sale']))
                        <span class="old-price">{{ $product['price'] }} $</span>
                        <span class="current-price">{{ $product['sale'] }} $</span>
                    @else
                        <span class="current-price">{{ $product['price'] }} $</span>
                    @endif
                </div>

                {{-- Variant Product --}}
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
                            <label>Select {{ $attributeName }}:</label>
                            <div class="variant-options" data-attribute="{{ $attributeName }}">
                                @foreach(collect($values)->unique('value') as $val)
                                    @php
                                        $valValue = $val['value'] ?? '';
                                        $colorCode = $val['color_code'] ?? null;
                                    @endphp
                                    @if(!empty($colorCode))
                                        <span class="color-circle" style="background-color: {{ $colorCode }};" data-value="{{ $valValue }}" title="{{ $valValue }}"></span>
                                    @else
                                        <button type="button" class="size-btn" data-value="{{ $valValue }}">{{ $valValue }}</button>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach

                        @auth
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                        @endauth
                    </form>
                @else
                    {{-- Simple Product --}}
                    @auth
                      <form method="POST" action="{{ route('add_product') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                      </form>
                    @endauth
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    const thumbnails = document.querySelectorAll('.thumbnails img');
    const mainImage = document.querySelector('.main-image');

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', () => {
            mainImage.src = thumb.src;
        });
    });

    const variantData = @json($product['formatted_variants']);
    const selectedAttributes = {};
    const productType = '{{ $product['type'] }}';

    document.querySelectorAll('.variant-options').forEach(group => {
        const attribute = group.dataset.attribute;
        group.addEventListener('click', (e) => {
            const target = e.target;
            if (target.dataset.value) {
                selectedAttributes[attribute] = target.dataset.value;

                group.querySelectorAll('.selected').forEach(el => el.classList.remove('selected'));
                target.classList.add('selected');

                const variantId = Object.entries(variantData).find(([id, data]) => {
                    return data.attributes.every(attr => selectedAttributes[attr.attribute] === attr.value);
                });

                if (variantId) {
                    document.getElementById('selectedVariantId').value = variantId[0];
                }
            }
        });
    });

    document.getElementById('addToCartForm')?.addEventListener('submit', function(e) {
        if (productType === 'variant' && !document.getElementById('selectedVariantId').value) {
            e.preventDefault();
            alert('Please select all variant options.');
        }
    });
</script>
@stop
