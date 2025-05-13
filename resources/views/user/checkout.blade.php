
@extends('user.layouts.master')

@section('title', 'Checkout')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('/public/user/css/checkout_page.css') }}">
@stop

@section('content')
<br><br><br>
@php    $variant = array(); @endphp
    <div class="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2 class="mb-4">Checkout</h2>
                <h5>Shipping Information</h5>


                <form action="{{ route('ordersave') }}" method="POST">
                  @csrf
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name" placeholder="Enter Your Name">
                        @error('name')
                          <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ old('email') }}" id="email" name="email" placeholder="Enter Your Email">
                        @error('email')
                          <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            {{-- <span class="input-group-text">+1</span> --}}
                            <input type="text" class="form-control" value="{{ old('phone') }}" id="phoneNumber" name="phone" placeholder="+2010329*****">
                          @error('phone')
                            <small class="text-danger">{{$message}}</small>
                          @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ old('country') }}"  name="country" placeholder="Enter Your country">
                        @error('country')
                          <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ old('city') }}"  name="city" placeholder="Enter Your City">
                        @error('city')
                          <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="mb-3">
                          <label for="address"  class="form-label">Address <span class="text-danger">*</span></label>
                          <textarea class="form-control" id="address" name="address" placeholder="Enter Your Full Address"  rows="4">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                          <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                      <input type="submit" value="Order Now" class="btn btn-primary w-100">
                    </div>
                </form>
            </div>

            <!-- Review Cart -->
            <div class="col-md-5">
                <h5 class="mb-4">Review your cart</h5>
                      @foreach ($cartItems as $item)
                        @php

                            $variantStock = null;
                            $isOutOfStock = false;

                            if(isset($item->attributes->type) && $item->attributes->type === 'variant' && isset($item->attributes->variant_id)) {
                                $variant = \App\Models\ProductVariant::find($item->attributes->variant_id);
                                $variantStock = $variant ? $variant->stock : null;
                                $isOutOfStock = ($variantStock === 0);

                              }
                                @endphp

                        <div class="cart-item">
                            <img src="{{ URL::asset(ProductImagePath() . $item->attributes->image) }}" alt="{{ $item->name }}">
                            <div class="cart-item-details">
                                <p class="cart-item-title">{{ $item->name }}</p>
                                <p class="cart-item-quantity">{{ $item->quantity }}x</p>
                                @php
                                  $variantAttributes = collect($item->attributes->variant_attributes ?? [])->toArray();
                                @endphp
                                @if(!empty($variantAttributes))
                                <ul>
                                    @foreach($variantAttributes as $attr)
                                        <li>
                                            {{ $attr['attribute'] ?? '' }}:
                                            @if(!empty($attr['color_code']))
                                                <span class="Color_Cirec" style="background: {{ $attr['color_code'] }};"></span>
                                            @endif
                                            {{ $attr['value'] ?? '' }}
                                        </li>
                                    @endforeach
                                @endif
                              </ul>
                              <p class="cart-item-price">${{ number_format($item->price, 2) }}</p>
                            </div>
                            <p class="mb-0"> <b> ${{ number_format((float)$item->price * (int)$item->quantity, 2) }}</b></p>
                        </div>

                    @endforeach

                <hr>
                <div class="d-flex justify-content-between">
                    <p>Subtotal</p>
                    <p>${{ $cartTotal, 2 }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p>Shipping</p>
                    <p>Free</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p>Payment</p>
                    <p>Cash On Delivery (COD)</p>
                </div>
                {{-- <div class="d-flex justify-content-between">
                    <p>Discount</p>
                    <p>-$10.00</p>
                </div> --}}
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <p>Total</p>
                    <p>${{ $cartTotal, 2 }}</p>
                </div>


            </div>
        </div>
    </div>
    </div>
@stop
