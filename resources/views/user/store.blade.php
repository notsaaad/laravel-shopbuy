@extends('user.layouts.master')

@section('title', 'Store')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('public/user/css/store.css') }}">
@endsection

@section('content')
<br><br><br>
<div class="main-content">
  <div class="container my-4">
    <div class="row">
      <!-- Filters -->
      <div class="col-md-3">
        <div class="filter-section">
          <h3 class="mt-2 mb-5 text-center fw-bold pt-2 pb-2" style="border-bottom: 1px solid black">Filter</h3>
          <form action="{{ route('store', $category) }}" method="GET">
            {{-- Retain the current category in the request --}}
            @if(request()->has('category'))
              <input type="hidden" name="category" value="{{ request()->get('category') }}">
            @endif

            @foreach($filtersData as $attrId => $filter)
              <div class="filter-group mb-3">
                <h5 class="mb-2">{{ $filter['name'] }}</h5>
                @foreach($filter['values'] as $valId => $val)
                  <label class="d-flex align-items-center mb-1" style="cursor: pointer;">
                    <input type="checkbox" name="filters[{{ $attrId }}][]" class="me-2" value="{{ $valId }}"
                      {{ in_array($valId, request()->input("filters.$attrId", [])) ? 'checked' : '' }}>
                    @if($val['color_code'])
                      <span style="display:inline-block; width:20px; height:20px; background-color:{{ $val['color_code'] }}; border:1px solid #ccc; margin-right:8px;"></span>
                    @endif
                    <span>{{ $val['label'] }}</span>
                  </label>
                @endforeach
              </div>
              <hr>
            @endforeach
            <button type="submit" class="btn btn-primary mt-3">Search</button>
          </form>
        </div>
      </div>

      <!-- Products -->
      <div class="col-md-9">
        <hr>
        <div class="sort-bar">
          <span>Total Products: <b>{{ count($products) }}</b></span>
        </div>
        <hr>

        @if(!empty($category))
          <h4 class="mb-4">Showing products for category: <strong>{{ $category }}</strong></h4>
        @endif

        <div class="row g-4">
          @php
            $colorAttrId = collect($filtersData)->filter(fn($f) => $f['display_type'] === 'color')->keys()->first();
            $filteredColorId = request()->input("filters.$colorAttrId")[0] ?? null;
            $filteredColor = null;

            foreach ($filtersData[$colorAttrId]['values'] ?? [] as $id => $val) {
              if ((string)$id === (string)$filteredColorId) {
                $filteredColor = $val['label'];
                break;
              }
            }
          @endphp

          @foreach($products as $product)
            @php
              $imageToUse = $product->image;
              if ($filteredColor && $product->type === 'variant') {
                foreach ($product->variants as $variant) {
                  foreach ($variant->attributeValues as $attrVal) {
                    if (
                      strtolower($attrVal->value) === strtolower($filteredColor) &&
                      $attrVal->color_code &&
                      $variant->image_path
                    ) {
                      $imageToUse = $variant->image_path;
                      break 2;
                    }
                  }
                }
              }

              $productLink = route('product.show', ['id' => $product->id]);
              if ($filteredColor) {
                $productLink .= '?color=' . urlencode($filteredColor);
              }
            @endphp

            <div class="col-sm-12 col-md-6 col-lg-4">
              <a href="{{ $productLink }}" class="text-decoration-none text-dark">
                <div class="card h-100 position-relative single-product">
                  <img src="{{ URL::asset(ProductImagePath() . $imageToUse) }}" class="card-img-top single-product-img" alt="{{ $product->title }}">
                  <div class="card-body">
                    <h5 class="card-title text-center">{{ $product->title }}</h5>
                    <p class="card-text text-muted text-center product-description">{{ $product->description ?? "No Description" }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-decoration-line-through">{{ $product->price }} $</span>
                      <span class="text-primary fw-bold">{{ $product->sale }} $</span>
                    </div>

                    @auth
                      @if ($product->type == 'simple')
                        <form method="POST" action="{{ route('add_product') }}">
                          @csrf
                          <input type="hidden" name="product_id" value="{{ $product->id }}">
                          <input type="hidden" name="quantity" value="1" min="1">
                          <div class="center mt-2 mb-2">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                          </div>
                        </form>
                      @else
                        <div class="center mt-2 mb-2">
                          <a href="{{ $productLink }}" class="btn btn-primary">View</a>
                        </div>
                      @endif
                    @endauth
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
