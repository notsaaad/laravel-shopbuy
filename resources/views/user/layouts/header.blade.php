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
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
  @yield('css')

</head>
<style>
  .logo img{
    width: 80px;
  }
</style>
<body>

      <!-- ================================================== Start Header ==================================================== -->
      <div class="aside-overlay">
        <button class="close">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <header class="header">
          <div class="main-header-content">
            <div class="logo"><img src="{{asset('public/user/images/logo.png')}}" class="Logo" alt="Logo" ></div>
            <button class="menu-button" id="menuButton">
                <span class="menu-icon"></span> Menu
            </button>

            <div class="search-bar-container">
                <input type="text" placeholder="What can we help you find today?" class="search-bar">
                <button class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <div class="header-icons">
                <div class="cart">
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
          </div>
          <div class="navbar">
            <a class="links" href="#">Top Deals</a>
            <a class="links" href="#">Deal of the Day</a>
            <a class="links" href="#">Yes, Best Buy Sells That</a>
            <a class="links" href="#">My Best Buy Memberships</a>


            <div class="dropdown">
              <a class="links" href="">MORE &#9662;</a>
              <div class="dropdown-content">
                  <a href="#"> option 1</a>
                  <a href="#"> option 1</a>
                  <a href="#">option  3</a>
              </div>
          </div>

          <div class="dropdown">
            <a class="links" href="">account &#9662;</a>
            <div class="dropdown-content">
              <a href="#">option 1</a>
              <a href="#">option 2</a>
              <a href="#">option 3</a>
            </div>
        </div>

        <div class="dropdown">
          <a class="links" href="">order status &#9662;</a>
          <div class="dropdown-content">
            <a href="#">option 1</a>
            <a href="#">option 2</a>
            <a href="#">option 3</a>
          </div>
      </div>

      <div class="dropdown">
        <a class="links" href="">saved items &#9662;</a>
        <div class="dropdown-content">
          <a href="#">option 1</a>
          <a href="#">option 2</a>
          <a href="#">option 3</a>
        </div>
    </div>





        </div>

      </header>
      @include('user.layouts.sidebar')

    <!-- ================================================== End Header ==================================================== -->
