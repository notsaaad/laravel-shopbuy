<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | S&B</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{URL::asset('public/user/css/all.css')}}">
  <link rel="stylesheet" href="{{URL::asset('public/user/css/fontawesome.min.css')}}">
  <link rel="stylesheet" href="{{URL::asset('public/user/css/master.css')}}">
  <link rel="icon" href="{{URL::asset('public/user/images/logo.png')}}" type="image/x-icon">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
  @yield('css')

</head>

<body @if (Auth::check())
  class="user-{{ auth()->id()}}"
@endif>

      <!-- ================================================== Start Header ==================================================== -->
      <div class="aside-overlay">
        <button class="close">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <header class="header">
        @if(Auth::check())
          @if (Auth::user()->role == 'admin')
            <style>
              .admin-header{
                background-color: black;
                color: white;
                font-size: 14px;
                display: flex;
                width: 100%;
                justify-content: center;
                align-items: center;
                padding: 5px;
              }
              .admin-header a{
                color:white;
              }
            </style>
            <div class="admin-header">
              <a href="{{ route('admin.index') }}">Go to Admin MR/{{Auth::user()->name}}*</a>
            </div>
          @endif
        @endif
          <div class="main-header-content">
            <a href="{{route('index')}}" class="logo"><img src="{{URL::asset('public/user/images/logo.png')}}" class="Logo" alt="Logo" ></a>
            <button class="menu-button" id="menuButton">
                <span class="menu-icon"></span> Menu
            </button>

            <div class="search-bar-container position-relative">
                <input type="text" id="product-search" placeholder="What can we help you find today?" class="search-bar">
                <button class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></button>
                <div id="search-results" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
            </div>

            <div class="header-icons">
              @auth
                <div class="my-account-icons" title="{{Auth::user()->name}}">
                  <a  href="{{ route('myaccount') }}" id="account-header">
                    <i class="fa-solid fa-user"></i>
                  </a>
                </div>

              @endauth
                <div class="cart">
                  @php
                    use Darryldecode\Cart\Facades\CartFacade as Cart;
                    $cartCount = 0;
                    if (auth()->check()) {
                      $cart = Cart::session(auth()->id())->getContent();
                      $cartCount = count($cart);
                    }

                  @endphp
                    <a href="{{ route('cart') }}"><i class="fa-solid fa-cart-shopping"></i></a>
                    @if ($cartCount != 0)
                    <span title="cart count" class="cart-count">{{$cartCount}}</span>

                    @endif
                </div>
            </div>
          </div>
          <div class="navbar">
            <a class="links" href="{{ route('index') }}">Home</a>
            <a class="links" href="{{ route('Store.AllCategories') }}">Store</a>
            <a class="links" href="{{ route('myaccount', ['tab'=> 'my-orders']) }}">My Orders</a>
            <a class="links" href="#">Contact us</a>

            {{-- <div class="dropdown">
              <a class="links" href="">MORE &#9662;</a>
              <div class="dropdown-content">
                  <a href="#"> option 1</a>
                  <a href="#"> option 1</a>
                  <a href="#">option  3</a>
              </div>
          </div> --}}

          <div class="dropdown">
            <a class="links">My Account &#9662;</a>
            <div class="dropdown-content">
              @if(! Auth::check())
              <a href="{{route('Signup')}}">New Account</a>
              <a href="{{route('login')}}">Login</a>
              @endif
              @if (Auth::check())
              <a href="{{ route('myaccount') }}">My Account</a>
              <a href="{{ route('logout') }}">Logout</a>
              @endif
            </div>
        </div>

        {{-- <div class="dropdown">
          <a class="links" href="">order status &#9662;</a>
          <div class="dropdown-content">
            <a href="#">option 1</a>
            <a href="#">option 2</a>
            <a href="#">option 3</a>
          </div>
      </div> --}}






        </div>

      </header>

      @include('user.layouts.sidebar')

    <!-- ================================================== End Header ==================================================== -->
