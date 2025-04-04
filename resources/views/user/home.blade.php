@extends('user.layouts.master')


@section('title', 'Home')





@section('css')
  {{-- From Home Blade --}}
  <link rel="stylesheet" href="{{URL::asset('public/user/css/home.css')}}">

@stop
@section('content')
<div class="main-content">
    <!-- Hero Section -->
    <div class="container-fluid hero-section">
        <div class="row w-100">
            <div class="col-md-6">
                <img src="{{ URL::asset('public/user/images/9.jpeg') }}"alt="TV image" class="img-fluid">
            </div>
            <div class="col-md-6 hero-text">
                <h1 class="fw-bold">The best home entertainment system is here</h1>
                <p class="text-muted">Sit diam odio eget rhoncus volutpat est nibh velit posuere egestas.</p>
                <a href="{{ route('store') }}" class="btn btn-primary">Shop now</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container features-section mt-5">
        <div class="row">
            <div class="col-md-3 feature-item">
                <i class="bi bi-truck"></i>
                <h6 class="mt-3">Free shipping</h6>
                <p class="text-muted">When you spend $80 or more</p>
            </div>
            <div class="col-md-3 feature-item">
                <i class="bi bi-headset"></i>
                <h6 class="mt-3">We are available 24/7</h6>
                <p class="text-muted">Need help? Contact us anytime</p>
            </div>
            <div class="col-md-3 feature-item">
                <i class="bi bi-arrow-return-left"></i>
                <h6 class="mt-3">Satisfied or return</h6>
                <p class="text-muted">Easy 30-day return policy</p>
            </div>
            <div class="col-md-3 feature-item">
                <i class="bi bi-lock"></i>
                <h6 class="mt-3">100% secure payments</h6>
                <p class="text-muted">Visa, Mastercard, Stripe, PayPal</p>
            </div>
        </div>
    </div>


    <!-- Section 2: Product Categories -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Product Categories</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <!-- Air Conditioner -->
            <div class="col">
                <div class="card text-center border-0">
                    <img src="{{ asset('public/user/images/10.jpeg') }}" alt="Air Conditioner"
                        class="card-img-top mx-auto mt-3" style="width: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">AIR CONDITIONER</h6>
                        <p class="card-text text-muted">4 PRODUCTS</p>
                    </div>
                </div>
            </div>
            <!-- Audio & Video -->
            <div class="col">
                <div class="card text-center border-0">
                    <img src="{{ asset('public/user/images/11.jpeg') }}" alt="Audio & Video"
                        class="card-img-top mx-auto mt-3" style="width: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">AUDIO & VIDEO</h6>
                        <p class="card-text text-muted">5 PRODUCTS</p>
                    </div>
                </div>
            </div>
            <!-- Gadgets -->
            <div class="col">
                <div class="card text-center border-0">
                    <img src="{{ asset('public/user/images/12.jpeg') }}" alt="Gadgets"
                        class="card-img-top mx-auto mt-3" style="width: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">GADGETS</h6>
                        <p class="card-text text-muted">6 PRODUCTS</p>
                    </div>
                </div>
            </div>
            <!-- Home Appliances -->
            <div class="col">
                <div class="card text-center border-0">
                    <img src="{{ asset('public/user/images/13.jpeg') }}" alt="Home Appliances"
                        class="card-img-top mx-auto mt-3" style="width: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">HOME APPLIANCES</h6>
                        <p class="card-text text-muted">5 PRODUCTS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <!-- Air Conditioner -->
            <div class="col">
                <div class="card text-center border-0">
                    <img src="{{ asset('public/user/images/14.jpeg') }}" alt="Air Conditioner"
                        class="card-img-top mx-auto mt-3" style="width: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">AIR CONDITIONER</h6>
                        <p class="card-text text-muted">4 PRODUCTS</p>
                    </div>
                </div>
            </div>
            <!-- Audio & Video -->
            <div class="col">
                <div class="card text-center border-0">
                    <img src="{{ asset('public/user/images/15.jpeg') }}" alt="Audio & Video"
                        class="card-img-top mx-auto mt-3" style="width: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">AUDIO & VIDEO</h6>
                        <p class="card-text text-muted">5 PRODUCTS</p>
                    </div>
                </div>
            </div>
            <!-- Gadgets -->
            <div class="col">
                <div class="card text-center border-0">
                    <img src="{{ asset('public/user/images/16.jpeg') }}" alt="Gadgets"
                        class="card-img-top mx-auto mt-3" style="width: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">GADGETS</h6>
                        <p class="card-text text-muted">6 PRODUCTS</p>
                    </div>
                </div>
            </div>
            <!-- Home Appliances -->
            <div class="col">
                <div class="card text-center border-0">
                    <img src="{{ asset('public/user/images/17.jpeg') }}" alt="Home Appliances"
                        class="card-img-top mx-auto mt-3" style="width: 120px;">
                    <div class="card-body">
                        <h6 class="card-title">HOME APPLIANCES</h6>
                        <p class="card-text text-muted">5 PRODUCTS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Today's Best Deal -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Today's Best Deal</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <!-- Product 1 -->
            <div class="col">
                <div class="card h-100 position-relative">
                    <img src="{{ asset('public/user/images/17.jpeg') }}" class="card-img-top" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">Multigroomer All-in-One</h5>
                        <p class="card-text text-muted">23 Piece Men's Grooming Kit</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-decoration-line-through">$60.00</span>
                            <span class="text-primary fw-bold">$44.00</span>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="col">
                <div class="card h-100 position-relative">
                    <img src="{{ asset('public/user/images/16.jpeg') }}" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Smart Speaker</h5>
                        <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-decoration-line-through">$250.00</span>
                            <span class="text-primary fw-bold">$219.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="col">
                <div class="card h-100 position-relative">
                    <img src="{{ asset('public/user/images/15.jpeg') }}" class="card-img-top" alt="Product 3">
                    <div class="card-body">
                        <h5 class="card-title">Home Speaker 500</h5>
                        <p class="card-text text-muted">Smart Bluetooth Speaker</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-decoration-line-through">$220.00</span>
                            <span class="text-primary fw-bold">$209.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product 4 -->
            <div class="col">
                <div class="card h-100 position-relative">
                    <img src="{{ asset('public/user/images/10.jpeg') }}" class="card-img-top" alt="Product 4">
                    <div class="card-body">
                        <h5 class="card-title">Note 10 Pro</h5>
                        <p class="card-text text-muted">128GB 6GB RAM</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-decoration-line-through">$800.00</span>
                            <span class="text-primary fw-bold">$659.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 position-relative">
                    <img src="{{ asset('public/user/images/11.jpeg') }}" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Smart Speaker</h5>
                        <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-decoration-line-through">$250.00</span>
                            <span class="text-primary fw-bold">$219.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 position-relative">
                    <img src="{{ asset('public/user/images/12.jpeg') }}" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Smart Speaker</h5>
                        <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-decoration-line-through">$250.00</span>
                            <span class="text-primary fw-bold">$219.00</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col">
                <div class="card h-100 position-relative">
                    <img src="{{ asset('public/user/images/13.jpeg') }}" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Smart Speaker</h5>
                        <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-decoration-line-through">$250.00</span>
                            <span class="text-primary fw-bold">$219.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 position-relative">
                    <img src="{{ asset('public/user/images/14.jpeg') }}" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Smart Speaker</h5>
                        <p class="card-text text-muted">Compact size with Alexa Voice Control</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-decoration-line-through">$250.00</span>
                            <span class="text-primary fw-bold">$219.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <h3 class="fw-bold mb-4">What is everyone saying?</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="border rounded p-4 bg-white">
                    <div class="text-warning mb-2">
                    </div>
                    <p>Dolores porro laboriosam molestias est quo. Et et eos. Ab error modi labore sed eaque est.</p>
                    <div class="d-flex align-items-center mt-3">
                        <i class="bi bi-person"></i>
                        <strong>Rafael Stokes</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-4 bg-white">
                    <div class="text-warning mb-2">
                    </div>
                    <p>Dolorem et cumque consequuntur consequuntur cumque eligendi voluptate.</p>
                    <div class="d-flex align-items-center mt-3">
                        <i class="bi bi-person"></i>
                        <strong>Chelsea Turner</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-4 bg-white">
                    <div class="text-warning mb-2">
                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                            class="fas fa-star"></i> <i class="fas fa-star"></i>
                    </div>
                    <p>Et eum neque ipsum quaerat ratione qui dolore eos. Numquam quo vel amet expedita.</p>
                    <div class="d-flex align-items-center mt-3">
                        <i class="bi bi-person"></i>
                        <strong>Jacqueline Mueller</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-4 bg-white">
                    <div class="text-warning mb-2">
                    </div>
                    <p>Itaque dicta rerum aliquam sit corporis iste omnis.</p>
                    <div class="d-flex align-items-center mt-3">
                        <i class="bi bi-person"></i>
                        <strong>Olive Borer</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-4 bg-white">
                    <div class="text-warning mb-2">
                    </div>
                    <p>In saepe veniam. Rerum excepturi dolor voluptatibus.</p>
                    <div class="d-flex align-items-center mt-3">
                        <i class="bi bi-person"></i>
                        <strong>Priscilla Jacobson</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-4 bg-white">
                    <div class="text-warning mb-2">
                    </div>
                    <p>Saepe doloribus deserunt in. At beatae neque pariatur harum vel.</p>
                    <div class="d-flex align-items-center mt-3">
                        <i class="bi bi-person"></i>
                        <strong>Joseph Reinger</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
