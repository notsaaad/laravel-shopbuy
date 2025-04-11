@extends('admin.layouts.master')

@section('title', 'view Category')

@section('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="title">
        <h1>Category</h1>
    </div>
    <div class="buttons-content">
        <a href="{{ route('category.create') }}" class="link our-btn add-product">
            Add new Category<span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
        </a>
        {{-- <button class="our-btn export-csv">
            Export CSV<span class="icon"><i class="fa-solid fa-file-export"></i></span>
        </button> --}}
    </div>

    <div class="Dropdown_seciton">

        <div class="dropdown">
            <button class="our-btn dropdown-toggle  toggle-btn" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Bulk Action
            </button>
            <ul class="dropdown-menu">
                {{-- <li><a class="link" class="dropdown-item" href="#">Edit</a></li> --}}
                <li><a class="link Deletebtn-checks" message="Category" action="{{ route('admin.category.deleteAll') }}" >Delete</a></li>
                <li><a class="link clear-btn">Cancel</a></li>
            </ul>
        </div>

        {{-- <button class="apply-btn our-btn">Apply <i class="fa-solid fa-chevron-right"></i></button> --}}
        <button class="clear-btn our-btn">Clear</button>
    </div>
    <section class="table_titil">
        <span>View Catrogy <span class="count"></span></span>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @php $index = 1 @endphp
                  @foreach ( $categories as $cat )

                    <tr id="row_id{{$cat->id}}">
                      <td><input type="checkbox"  name="row_id" value="{{ $cat->id }}"> </td>
                      <td>{{$index}}</td>
                      <td>{{$cat->id}}</td>
                      <td>{{$cat->name}}</td>
                      <td>
                        <span class="Actions"><a class="link" href="{{ route('category.edit', $cat->id) }}"><i class="fa-solid fa-file-pen"></i></a>
                          <form method="POST" action="{{ route('category.destroy', $cat->id) }}">
                              @csrf
                              @method('DELETE')
                              <button class="Trash"><i  class="fa-solid fa-trash-can"></i></button>
                          </form>
                        </span>
                      </td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                  @endforeach
                  @empty($categories)
                    <tr>
                      <td colspan="5">No Category Found</td>
                    </tr>
                  @endempty
                </tbody>
            </table>
          </div>
    </section>

          <div class="center link">
            {{ $categories->withQueryString()->links() }}
          </div>

        {{-- @section('js')
        <script>
          let count        = {{ count($users) }};
          let displayCount = $('tbody tr');
          $('.count').text(`${displayCount.length} / ${count}`)
        </script>
        @stop --}}
@stop
