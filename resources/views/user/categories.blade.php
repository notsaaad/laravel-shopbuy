@extends('user.layouts.master')


@section('title', 'Home')





@section('css')
  {{-- From Home Blade --}}
  <link rel="stylesheet" href="{{URL::asset('public/user/css/home.css')}}">

@stop
<br>

@section('content')
<div class="main-content">

    <div class="container mt-5">
      <h2 class="text-center mb-4">Our Categories</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">

            @foreach ( $categories as $cat )
              <a href="{{ route('store', $cat->id) }}" class="col-sm-12 col-md-6 col-lg-3" >
                  <div class="card text-center border-1 shadow" >
                      <img src="{{ URL::asset(CategoryImagePath().$cat->image) }}" alt="{{ $cat->name }}" class="card-img-top single-category-image">
                      <div class="card-body">
                          <h6 class="card-title">{{$cat->name}}</h6>
                          <p title="count" class="card-text text-muted">{{$cat->products_count}}</p>
                      </div>
                  </div>
              </a>
            @endforeach
            @empty($categories)
              <p class="text-center">No Category Found</p>
            @endempty
        </div>
    </div>


</div>

