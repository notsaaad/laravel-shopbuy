@extends('user.layouts.master')

@section('title', $product['title'])

@section('css')
    <style>
        .product-images { flex: 1; }
        .main-image { width: 100%; border-radius: 8px; max-height: 400px; object-fit: contain; background: #f9f9f9; }
        .product-details { flex: 1; }
        .product-title { font-size: 28px; margin-bottom: 10px; }
        .product-short-desc { font-size: 16px; color: #555; margin-bottom: 20px; }
        .price-section { font-size: 20px; margin-bottom: 20px; }
        .old-price { text-decoration: line-through; color: #999; margin-right: 10px; }
        .current-price { color: #007bff; font-weight: bold; }
        .product-variants label { display: block; margin-top: 15px; margin-bottom: 5px; font-weight: bold; }
        .color-circle { width: 25px; height: 25px; border-radius: 50%; border: 2px solid #ddd; cursor: pointer; display: inline-block; }
        .color-circle.selected { border-color: #007bff; box-shadow: 0 0 4px 1px #000000b8; }
        .size-btn { padding: 5px 10px; border: 1px solid #ddd; cursor: pointer; background: #f9f9f9; }
        .size-btn.selected { border: 2px solid #007bff; }
        .add-to-cart-btn { margin-top: 20px; padding: 12px 25px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .add-to-cart-btn:hover { background-color: #0056b3; }
    </style>
@stop

@section('content')

<br><br><br>
<div class="main-content">
    <div class="container">
        <div class="product-page" style="display: flex; gap: 30px;">
            <div class="product-images">
                <img src="{{ URL::asset(ProductImagePath() . $product['image']) }}" alt="{{ $product['title'] }}" class="main-image">
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

                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                @else
                    {{-- Simple Product --}}
                    <form method="POST" action="{{ route('add_product') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
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
