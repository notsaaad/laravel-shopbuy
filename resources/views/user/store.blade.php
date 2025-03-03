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
                <h5>Get it fast</h5>
                <p>Store Pickup at <a href=""> Bangor</a></p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="storePickup">
                    <label class="form-check-label" for="storePickup">
                        Ready in 1 hour - Tue, Jan 28
                    </label>
                </div>
                <hr>
                <h5>Availability</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="excludeOutOfStock">
                    <label class="form-check-label" for="excludeOutOfStock">
                        Exclude Out of Stock Items
                    </label>
                </div>
                <hr>
                <h5>Condition</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="newCondition">
                    <label class="form-check-label" for="newCondition">New</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="refurbishedCondition">
                    <label class="form-check-label" for="refurbishedCondition">Refurbished</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="openBoxCondition">
                    <label class="form-check-label" for="openBoxCondition">Open-Box</label>
                </div>
                <hr>
                <h5>Current Deals</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="onSale">
                    <label class="form-check-label" for="onSale">On Sale</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="freeShipping">
                    <label class="form-check-label" for="freeShipping">Free Shipping Eligible</label>
                </div>
                <hr>
                <h5>Model Family</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="ps5Pro">
                    <label class="form-check-label" for="ps5Pro">PlayStation 5 Pro</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="ps5Slim">
                    <label class="form-check-label" for="ps5Slim">PlayStation 5 Slim</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="ps5">
                    <label class="form-check-label" for="ps5">PlayStation 5</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="ps5SlimDigital">
                    <label class="form-check-label" for="ps5SlimDigital">PlayStation 5 Slim Digital Edition</label>
                </div>
            </div>
        </div>
        <div class="col-md-9">
             <hr>
            <div class="sort-bar">
                <span> <b>10 items</b> </span>
                <select class="form-select w-auto">
                    <option selected>Sort By: Best Selling</option>
                    <option value="priceLowToHigh">Price: Low to High</option>
                    <option value="priceHighToLow">Price: High to Low</option>
                </select>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <img src="{{URL::asset('public/user/images/3.jpg')}}" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h6>Sony - PlayStation 5 Slim Console - White</h6>
                            <p class="price">$499.99</p>
                            <p><b>Model:</b> 1000039671 </p>
                             <p><b>Release Date:</b> 11/24/2023</p>
                            <button class="btn btn-primary w-100">Add to Cart</button>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <img src="{{URL::asset('public/user/images/4.jpeg')}}" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h6>Sony - PlayStation 5 Slim Console - White</h6>
                            <p class="price">$499.99</p>
                            <p><b>Model:</b> 1000039671 </p>
                            <p><b>Release Date:</b> 11/24/2023</p>
                            <button class="btn btn-primary w-100">Add to Cart</button>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <img src="{{URL::asset('public/user/images/5.jpg')}}" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h6>Sony - PlayStation 5 Slim Console - White</h6>
                            <p class="price">$499.99</p>
                            <p><b>Model:</b> 1000039671 </p>
                            <p><b>Release Date:</b> 11/24/2023</p>
                            <button class="btn btn-primary w-100">Add to Cart</button>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <img src="{{URL::asset('public/user/images/6.png')}}" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h6>Sony - PlayStation 5 Slim Console - White</h6>
                            <p class="price">$499.99</p>
                            <p><b>Model:</b> 1000039671 </p>
                            <p><b>Release Date:</b> 11/24/2023</p>
                            <button class="btn btn-primary w-100">Add to Cart</button>
                        </div>
                    </div>
                </div>



                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <img src="{{URL::asset('public/user/images/1.jpg')}}" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h6>Sony - PlayStation 5 Slim Console - White</h6>
                            <p class="price">$499.99</p>
                            <p><b>Model:</b> 1000039671 </p>
                            <p><b>Release Date:</b> 11/24/2023</p>
                            <button class="btn btn-primary w-100">Add to Cart</button>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <img src="{{URL::asset('public/user/images/2.jpg')}}" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h6>Sony - PlayStation 5 Slim Console - White</h6>
                            <p class="price">$499.99</p>
                            <p><b>Model:</b> 1000039671 </p>
                            <p><b>Release Date:</b> 11/24/2023</p>
                            <button class="btn btn-primary w-100">Add to Cart</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<div class="container my-4">
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
</div>
    </div>

@stop
