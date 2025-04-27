@extends('user.layouts.master')

@section('title', 'Cart')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('/public/user/css/cart.css') }}">
@stop
@php $hideMessages = true;                             $variant = array(); @endphp
@section('content')
<br><br><br>
<div class="main-content">
    <div class="container">
        {{-- رسائل النجاح والخطأ --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

      @if(session('error'))
        <div class="alert alert-danger">{!! session('error') !!}</div>
      @endif

        <div class="cart-page">
            <div class="main-cart">
                <div class="cart">
                    <h2>Your Cart</h2>
                    @forelse ($cartItems as $item)
                        @php

                            $variantStock = null;
                            $isOutOfStock = false;

                            if(isset($item->attributes->type) && $item->attributes->type === 'variant' && isset($item->attributes->variant_id)) {
                                $variant = \App\Models\ProductVariant::find($item->attributes->variant_id);
                                $variantStock = $variant ? $variant->stock : null;
                                $isOutOfStock = ($variantStock === 0);

                              }
                                @endphp

                        <div class="cart-item" @if($isOutOfStock)  style="opacity:0.6;" @else notOut  @endif  >
                            <a href="{{ route('cart_remove', $item->id) }}" class="removeProduct">X</a>
                            <div class="product-info">
                                <img src="{{ URL::asset(ProductImagePath() . $item->attributes->image) }}" alt="img">
                                <p class="product-name">
                                    <strong>{{ $item->name }}</strong>

                                    @php
                                        $variantAttributes = collect($item->attributes->variant_attributes ?? [])->toArray();
                                    @endphp
                                    @if(!empty($variantAttributes))
                                        @foreach($variantAttributes as $attr)
                                            <span >
                                                {{ $attr['attribute'] ?? '' }}:
                                                @if(!empty($attr['color_code']))
                                                    <span class="Color_Cirec" style="background: {{ $attr['color_code'] }};"></span>
                                                @endif
                                                {{ $attr['value'] ?? '' }}
                                            </span>
                                            {{-- <br> --}}
                                        @endforeach
                                    @endif

                                    {{-- Stock --}}
                                    @if($variantStock !== null)
                                        @if($isOutOfStock)
                                            <span style="color: red; font-weight: bold;">Out of Stock</span>
                                        @else
                                            <span >Available Stock: {{ $variantStock }}</span>
                                        @endif
                                    @endif
                                </p>
                            </div>

                            {{-- التحكم في الكمية --}}
                            @if(!$isOutOfStock)
                                <form method="POST" action="{{ route('cart_update', $item->id) }}">
                                    @csrf
                                    <div class="product-controls">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $variantStock ?? 1000 }}">
                                        <button type="submit" class="btn btn-sm btn-primary mt-2">Update</button>
                                    </div>
                                </form>
                            @else
                                <div class="product-controls">
                                    <span style="color: red;">Can't update quantity</span>
                                </div>
                            @endif

                            <p class="price">${{ number_format($item->price, 2) }}</p>
                        </div>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            Your Cart is Empty
                            <br>
                            <a class="btn btn-primary" href="{{ route('store') }}">Shop Now</a>

                        </div>
                        <style>
                        .order-summary { display: none }
                        </style>
                    @endforelse
                </div>
            </div>

            {{-- Order Summary --}}
            @if(count($cartItems) > 0)
                <form class="order-summary">
                    <h2 class="order-summary-title">Order Summary</h2>
                    <div class="divider"></div>
                    <p><strong>Items:</strong> <span>${{ $cartTotal, 2 }}</span></p>
                    <p><strong>Shipping:</strong> <span>FREE</span></p>
                    <p><strong>Estimated Tax:</strong> <span>$0.00</span></p>
                    <div class="divider"></div>
                    <p class="total"><strong>Total:</strong> <span>${{ $cartTotal, 2 }}</span></p>
                    <div class="checkout-buttons">
                        <button class="checkout-btn">Checkout</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@stop
