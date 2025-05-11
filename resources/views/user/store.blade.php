@extends('user.layouts.master')


@section('title', 'store')





@section('css')
  {{-- From Home Blade --}}
  <link rel="stylesheet" href="{{URL::asset('public/user/css/store.css')}}">

@stop
@section('content')
<br>
<br>
<br>
<div class="main-content">

  <div class="container my-4">
    <div class="row">
        <div class="col-md-3">
            <div class="filter-section">
                <h3 class="mt-2 mb-5 text-center fw-bold pt-2 pb-2" style="border-bottom: 1px solid black">Filter</h3>
                <form action="{{ route('store') }}" method="GET">
                @foreach($filtersData  as $attrId => $filter)
                  <div class="filter-group mb-3">
                      <h5 class="mb-2">{{ $filter['name'] }}</h5>
                      @foreach($filter['values'] as $valId => $val)
                          <label class="d-flex align-items-center mb-1" style="cursor: pointer;">
                              <input type="checkbox" name="filters[{{ $attrId }}][]"  class="me-2"     value="{{ $valId }}"{{ in_array($valId, request()->input("filters.$attrId", [])) ? 'checked' : '' }} >


                              @if($val['color_code'])
                                  <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $val['color_code'] }}; border: 1px solid #ccc; margin-right: 8px;"></span>
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
        <div class="col-md-9">
            <hr>
            <div class="sort-bar">
                <span> Total Proucts :  <b>@php echo count($products) @endphp</b> </span>
            </div>
            <hr>
            <div class="row">
              @if(!empty($category))
                <h4 class="mb-4">Showing products for category: <strong>{{ $category }}</strong></h4>
              @endif
            @foreach ( $products as $product )
            <a  href="{{ route('product.show', $product->id) }}" class="col-sm-12 col-md-6 col-lg-4">
                <div class="card h-100 position-relative single-product">
                      <img src="{{ URL::asset(ProductImagePath().$product->image) }}" class="card-img-top single-product-img" alt="{{ $product->name }}">
                      <div class="card-body">
                          <h5 class="card-title text-center">{{ $product->title }}</h5>
                          <p class="card-text text-muted text-center product-description">{{$product->description ?? "No Desciption"}}</p>
                          <div class="d-flex justify-content-between align-items-center">
                              <span class="text-decoration-line-through">
                                @if ($product->price)
                                {{ $product->price}} $
                                @endif
                            </span>
                              <span class="text-primary fw-bold">{{$product->sale}} $</span>
                          </div>
                          @auth
                            @if ($product->type == 'simple' )
                            <form method="POST" action="{{ route('add_product') }}">
                              @csrf
                              <input type="hidden" name="product_id" value="{{ $product->id }}">
                              <input type="hidden" name="quantity" value="1" min="1">
                              <div class="center mt-2 mb-2"><button type="submit" class="btn btn-primary">Add to Cart</button></div>
                            </form>
                            @else
                            <div class="center mt-2 mb-2"><button  class="btn btn-primary disabled">Add to Cart</button></div>
                            @endif
                          @endauth
                      </div>
                </div>
              </a>
            @endforeach
            @empty($products)
            <p class="text-center">No Product Found</p>
            @endempty

            </div>
        </div>
    </div>
</div>




{{-- <div class="container my-4">
    <h3 class="mb-4">Popular PS5 Consoles</h3>
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row">
                    <div class="col">
                        <div class="product-card">
                            <img src="{{URL::asset('public/user/images/1.jpg')}}" alt="Product 1">
                            <h6>Sony - PlayStation 5 Slim Console Digital Edition</h6>
                            <div class="price">
                                $449.99 <span class="old-price">$499.99</span>
                            </div>
                            <button class="btn btn-primary btn-sm mt-2">Add to Cart</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <img src="{{URL::asset('public/user/images/2.jpg')}}" alt="Product 2">
                            <h6>Sony - PlayStation Portal Remote Player</h6>
                            <div class="price">$199.99</div>
                            <button class="btn btn-primary btn-sm mt-2">Add to Cart</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <img src="{{URL::asset('public/user/images/3.jpg')}}" alt="Product 3">
                            <h6>Sony - DualSense Wireless Controller</h6>
                            <div class="price">$74.99</div>

                            <button class="btn btn-primary btn-sm mt-2">Add to Cart</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <img src="{{URL::asset('public/user/images/4.jpeg')}}" alt="Product 4">
                            <h6>ASUS - ROG Ally 7" 120Hz FHD Gaming Handheld</h6>
                            <div class="price">
                                $449.99 <span class="old-price">$649.99</span>

                            </div>
                            <button class="btn btn-primary btn-sm mt-2">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row">
                    <div class="col">
                        <div class="product-card">
                            <img src="{{URL::asset('public/user/images/5.jpg')}}" alt="Product 5">
                            <h6>Another Product 1</h6>
                            <div class="price">$349.99</div>
                            <button class="btn btn-primary btn-sm mt-2">Add to Cart</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <img src="{{URL::asset('public/user/images/6.png')}}" alt="Product 6">
                            <h6>Another Product 2</h6>
                            <div class="price">$249.99</div>
                            <button class="btn btn-primary btn-sm mt-2">Add to Cart </button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <img src="{{URL::asset('public/user/images/3.jpg')}}" alt="Product 7">
                            <h6>Another Product 3</h6>
                            <div class="price">$149.99</div>
                            <button class="btn btn-primary btn-sm mt-2">Add to Cart</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card">
                            <img src="{{URL::asset('public/user/images/5.jpg')}}" alt="Product 8">
                            <h6>Another Product 4</h6>
                            <div class="price">$99.99</div>
                            <button class="btn btn-primary btn-sm mt-2">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div> --}}
    </div>

@stop
