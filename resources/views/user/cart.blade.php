@extends('user.layouts.master')


@section('title', 'cart')





@section('css')
  {{-- From Home Blade --}}
  <link rel="stylesheet" href="{{ URL::asset('/public/user/css/cart.css') }}">

@stop
@section('content')
<br>
<br>
<br>
<div class="main-content">

    <div class="container">
      <div class="cart-page">
          <div class="main-cart">
              <div class="cart">
                  <h2>Your Cart</h2>
                  @foreach ($cartItems as $item )
                  <div class="cart-item">
                    <a  href="{{ route('cart_remove', $item->id) }}" class="removeProduct">X</a>
                      <div class="product-info">
                          <img src="{{ URL::asset($item->image) }}" alt="img">
                          <p class="product-name"><strong>{{$item->title}}</strong></p>
                      </div>
                      <div class="product-controls">
                          <input type="number" name="qty" value="{{ old('qty', $item->qty) }}" min="1">
                        </div>
                          <p class="price">${{$item->sale}}</p>
                      </div>
                      @endforeach
                      @empty($cartItems)
                      <div class="alert alert-warning" role="alert">
                        Your Cart is Empty
                        <br>
                        <a class="btn btn-primary" href="{{ route('store') }}">Shop Now</a>
                      </div>
                      <style>
                        .order-summary{
                          display: none
                        }
                      </style>
                      @endempty
                    </div>

          </div>
              <form class="order-summary">
                  <h2 class="order-summary-title">Order summary</h2>
                  <div class="divider"></div>
                  <p><strong> Original Price:</strong> <span>$899.90</span></p>
                  <p><strong>Shipping:</strong> <span>FREE</span></p>
                  <p><strong>Egtimated Sales Tax:</strong> <span>$40.10</span></p>
                  <div class="divider"></div>
                  <p class="total"><strong>Total:</strong> <span>$770.00</span></p>
                  <div class="checkout-buttons">
                  <button class="checkout-btn"> Checkout</button>
              </div>
              </form>
          </div>

  </div>
</div>

@stop
