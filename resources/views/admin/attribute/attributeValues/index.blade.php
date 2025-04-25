@extends('admin.layouts.master')

@section('title', 'view '.$att->name . ' values')

@section('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="title">
        <h1>{{$att->name}} values</h1>
    </div>
    <div class="buttons-content">
        <a href="{{ route('att_values.add', $att->id) }}" class="link our-btn add-product">
            Add new values For {{$att->name}}<span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
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
                <li><a class="link Deletebtn-checks" message="Values " action="{{ route('att_value_delete_all') }}" >Delete</a></li>
                <li><a class="link clear-btn">Cancel</a></li>
            </ul>
        </div>

        {{-- <button class="apply-btn our-btn">Apply <i class="fa-solid fa-chevron-right"></i></button> --}}
        <button class="clear-btn our-btn">Clear</button>
    </div>
    <section class="table_titil">
        <span>View {{ $att->name }} Values <span class="count"></span></span>
        <div class="outputs">
            <div class="search_block">
                <input type="text" class="search"placeholder="Search Attribute Values" onkeyup="SearchTable(this)">
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
                        <th>view</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @php $index = 1 @endphp
                  @foreach ( $att->values as $value )

                    <tr id="row_id{{$value->id}}">
                      <td><input type="checkbox"  name="row_id" value="{{ $value->id }}"> </td>
                      <td>{{$index}}</td>
                      <td>{{$value->id}}</td>
                      <td>{{$value->value}}</td>
                        @if ($att->display_type == "text")
                          <td>{{$value->value}}</td>
                        @elseif ($att->display_type == "color")
                        <td ><span class="colorDisplay"  title="{{$value->color_code}}" onclick="CopyHexColorValue('{{$value->color_code}}')" style="background-color:{{$value->color_code}};"></span> </td>

                        @else
                          <td><img src="{{ URL::asset(AttributeImagePath() . $value->image_path) }}"  alt="img"></td>
                        @endif
                      <td class='center'>
                        <span class="Actions"><a class="link" href="{{ route('att_value_edit', $value->id) }}"><i class="fa-solid fa-file-pen"></i></a>
                          <form method="POST" action="{{ route('att_value_delete', $value->id) }}">
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
                  @empty($att->values)
                    <tr>
                      <td colspan="6">No Attrbute Values  Found</td>
                    </tr>
                  @endempty
                </tbody>
            </table>
          </div>
    </section>

          {{-- <div class="center link">
            {{ $Attributes->withQueryString()->links() }}
          </div> --}}

        {{-- @section('js')
        <script>
          let count        = {{ count($users) }};
          let displayCount = $('tbody tr');
          $('.count').text(`${displayCount.length} / ${count}`)
        </script>
        @stop --}}
@stop


@section('js')
  <script>
    function CopyHexColorValue(hexColor){
      $(document).ready(function () {
        console.log(hexColor);
        navigator.clipboard.writeText(hexColor);
        toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "progressBar": true,
        "showDuration": "100",
        "preventDuplicates": false,
        "hideDuration": "2500",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
        toastr.success("Color Copied");
      });
    }
  </script>
@stop
