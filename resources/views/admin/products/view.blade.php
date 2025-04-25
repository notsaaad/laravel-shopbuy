@extends('admin.layouts.master')

@section('title', 'view Products')

@section('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="title">
        <h1>Products</h1>
    </div>
    <div class="buttons-content">
        <a href="{{ route('admin.product.add')}}" class="link our-btn add-product">
            Add new Product<span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
        </a>
        {{-- <button class="our-btn export-csv">
            Export CSV<span class="icon"><i class="fa-solid fa-file-export"></i></span>
        </button> --}}
    </div>
    <div class="taxonemy-content">
        <div class="taxonmies-div-title">Product:</div>
        <div class="taxonmies">
            <div class="single-tax">
                <span class="tax-name">
                    <a  href="{{ route('admin.products.index') }}">All
                      <span class="tax-count">({{ $allCount }})</span>
                    </a>

                </span>
                <div class="tax-sperator">|</div>
            </div>
            <div class="single-tax">
                <span class="tax-name">
                    <a  href="{{ route('admin.products.index', ['status' => '0']) }}">Publish
                      <span class="tax-count">({{ $publishCount }})</span>
                    </a>

                </span>
                <div class="tax-sperator">|</div>
            </div>
            <div class="single-tax">
                <span class="tax-name">
                    <a  href="{{ route('admin.products.index' , ['status' => '1']) }}">Draft
                      <span class="tax-count">({{ $draftCount }})</span>
                    </a>

                </span>
            </div>

        </div>
    </div>
    <div class="Dropdown_seciton">

        <div class="dropdown">
            <button class="our-btn dropdown-toggle  toggle-btn" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Bulk Action
            </button>
            <ul class="dropdown-menu">
                {{-- <li><a class="link" class="dropdown-item" href="#">Edit</a></li> --}}
                <li><a class="link Deletebtn-checks"     message="Product" action="{{ route('admin.products.deleteAll') }}" >Delete</a></li>
                <li><a class="link setPublishbtn-checks" message="Product" action="{{ route('admin.products.SetAllPublish') }}" >Change to Publish</a></li>
                <li><a class="link setDrafthbtn-checks"  message="Product" action="{{ route('admin.products.SetAllDraft') }}" >Change to Draft</a></li>
                <li><a class="link clear-btn">Cancel</a></li>
            </ul>
        </div>

        {{-- <button class="apply-btn our-btn">Apply <i class="fa-solid fa-chevron-right"></i></button> --}}
        <button class="clear-btn our-btn">Clear</button>
    </div>
    <section class="table_titil">
        <span>View Users: <span class="count"></span></span>
        <div class="outputs">
            <div class="search_block">
                <input type="text" class="search"placeholder="Search Product" onkeyup="SearchTable(this)">
            </div>
        </div>
          <div class="table_header">
            <table>
                <thead>
                    <tr class="design_header">
                        <th><input type="checkbox" name="ids" id="check_all_ids"></th>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Image</th>
                        <th>Category</th>
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
                      <td><input type="checkbox"  name="row_id" value="{{ $product->id }}"> </td>
                      <td>{{$index}}</td>
                      <td>{{$product->id}}</td>
                      <td>{{$product->title}}</td>
                      <td>{{$product->price}}</td>
                      <td>{{$product->sale}}</td>
                      <td><img width="150" height="150" src="{{ URL::asset(ProductImagePath().$product->image) }}" alt="something went wrong"></td>
                      {{-- <td>{{$product->category->name}}</td> --}}
                      <td>
                        {{ $product->categories->pluck('name')->implode(', ') }}
                      </td>
                      <td class="center">
                        @if ($product->is_draft == 0)
                          <span class="Status SPublish"></span>
                        @else
                        <span class="Status SDraft"></span>
                        @endif
                      </td>
                      <td>
                        <span class="Actions">
                          <a class="link" href="{{ route('admin.products.edit', $product->id) }}"><i class="fa-solid fa-file-pen"></i></a>
                              <form method="POST" action="{{ route('admin.products.delete') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <button class="Trash"><i  class="fa-solid fa-trash-can"></i></button>
                              </form>
                        </span>
                      </td>
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

          <div class="center link">
            {{ $products->withQueryString()->links() }}
          </div>

        @section('js')
        <script>
          let count        = {{ count($products) }};
          let displayCount = $('tbody tr');
          $('.count').text(`${displayCount.length} / ${count}`)
        </script>
        @stop
@stop
