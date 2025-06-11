@extends('admin.layouts.master')

@section('title', 'view Attribute')

@section('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="title">
        <h1>Attribute</h1>
    </div>
    <div class="buttons-content">
        <a href="{{ route('attribute.add') }}" class="link our-btn add-product">
            Add new Attribute<span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
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
                <li><a class="link Deletebtn-checks" message="Attibutes" action="{{ route('attributes.DeleteALL') }}" >Delete</a></li>
                <li><a class="link clear-btn">Cancel</a></li>
            </ul>
        </div>

        {{-- <button class="apply-btn our-btn">Apply <i class="fa-solid fa-chevron-right"></i></button> --}}
        <button class="clear-btn our-btn">Clear</button>
    </div>
    <section class="table_titil">
        <span>View Attributes <span class="count"></span></span>
        <div class="outputs">
            <div class="search_block">
                <input type="text" class="search"placeholder="Search Attributes" onkeyup="SearchTable(this)">
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
                        <th>Type</th>
                        <th>View</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @php $index = 1 @endphp
                  @foreach ( $Attributes as $att )

                    <tr id="row_id{{$att->id}}">
                      <td><input type="checkbox"  name="row_id" value="{{ $att->id }}"> </td>
                      <td>{{$index}}</td>
                      <td>{{$att->id}}</td>
                      <td><a href="{{ route('att-values.view', $att->id) }}">{{$att->name}}</a></td>
                      <td>{{$att->display_type}}</td>
                      <td><a href="{{ route('att-values.view', $att->id) }}" class="btn btn-primary link">View</a></td>
                      <td class='center'>
                        <span class="Actions"><a class="link" href="{{ route('Attribut.edit', $att->id) }}"><i class="fa-solid fa-file-pen"></i></a>
                          <form method="POST" action="{{ route('attribute.destroy', $att->id) }}">
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
                  @empty($Attributes)
                    <tr>
                      <td colspan="6">No Attrbutes Found</td>
                    </tr>
                  @endempty
                </tbody>
            </table>
          </div>
    </section>

          <div class="center link">
            {{ $Attributes->withQueryString()->links() }}
          </div>

        {{-- @section('js')
        <script>
          let count        = {{ count($users) }};
          let displayCount = $('tbody tr');
          $('.count').text(`${displayCount.length} / ${count}`)
        </script>
        @stop --}}
@stop
