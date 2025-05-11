@extends('admin.layouts.master')

@section('title', 'Dashbord')

@section('content')
<div class="title">
  <h1>Dashbord</h1>
</div>


  <div class="row mt-3">
    <div class="col-sm-12 col-md-8 col-lg-9 row g-3">
      <a href="{{ route('admin.products.index') }}" class=" link box-total col-sm-12 col-md-6">
        <div class="box-counter">
          <h2>Total Product</h2>
          <span class="total_cont">*  {{ $allProducts }}  *</span>
        </div>
      </a>
      <div class="col-sm-12 col-md-6">
        <div class="box-counter">
          <h2>Total Orders</h2>
          <span class="total_cont">*  500  *</span>
        </div>
      </div>
      <a href="{{ route('users.index') }}" class="link box-total col-sm-12 col-md-6">
        <div class="box-counter">
          <h2>Total Users</h2>
          <span class="total_cont">*  {{$allUsers}}  *</span>
        </div>
      </a>
      <a  href="{{ route('attribute.add') }}" class="link box-total col-sm-12 col-md-6">
        <div class="box-counter">
          <h2>Total Attributes</h2>
          <span class="total_cont">*  {{ $Attributes }}  *</span>
        </div>
      </a>
      <div class="col-sm-12 col-md-6"></div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-3">
      <ul class="Home_add_btns">
        <li>
          <a href="{{ route('index') }}" >
            Back To Site
          </a>
        </li>
        <li>
          <a href="{{ route('add_product') }}" class="link our-btn add-product">
            Add new Product
            <span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
          </a>
        </li>
        <li>
          <a href="{{ route('category.create') }}" class="link our-btn add-product">
            Add new Category
            <span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
          </a>
        </li>
        <li>
          <a href="{{ route('attribute.add') }}" class="link our-btn add-product">
            Add new Attribute
            <span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
          </a>
        </li>
        <li>
          <a href="{{ route('users.create') }}" class="link our-btn add-product">
            Add new User
            <span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
          </a>
        </li>
      </ul>


    </div>
  </div>



      <section class="table_titil mt-3">
        <h2 class="text-center">Our Products</h2>
        <span></span>
        <div class="outputs">
            <div class="search_block">
                <input type="text" class="search"placeholder="Search Product" onkeyup="SearchTable(this)">
            </div>
        </div>
          <div class="table_header">
            <table>
                <thead>
                    <tr class="design_header">
                        {{-- <th><input type="checkbox" name="ids" id="check_all_ids"></th> --}}
                        <th>#</th>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                    $index     = 1;
                    $status = request()->query('status');
                  @endphp
                  @foreach ( $products as $product )
                    @if ($status ===null || $product->is_draft==$status)
                    <tr id="row_id{{$product->id}}">
                      {{-- <td><input type="checkbox"  name="row_id" value="{{ $product->id }}"> </td> --}}
                      <td>{{$index}}</td>
                      <td>{{$product->id}}</td>
                      <td><img width="150" height="150" src="{{ URL::asset(ProductImagePath().$product->image) }}" alt="something went wrong"></td>
                      <td>{{$product->title}}</td>
                      <td>{{$product->price}}</td>
                      <td>{{$product->sale}}</td>
                      <td>
                        {{ $product->categories->pluck('name')->implode(', ') }}
                      </td>
                      <td>{{$product->type}}</td>
                      <td>
                        <div class="center">
                          @if ($product->is_draft == 0)
                          <span class="Status SPublish"></span>
                        @else
                        <span class="Status SDraft"></span>
                        @endif
                        </div>
                      </td>
                      <td>{{$product->created_at}}</td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                    @endif
                  @endforeach
                  @empty($products)
                    <tr>
                      <td colspan="10">No Products Found</td>
                    </tr>
                  @endempty
                </tbody>
            </table>
          </div>
    </section>


@stop
