@extends('admin.layouts.master')

@section('title', 'view Users')

@section('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="title">
        <h1>Users</h1>
    </div>
    <div class="buttons-content">
        <a href="{{ route('users.create')}}" class="link our-btn add-product">
            Add new User<span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
        </a>
        {{-- <button class="our-btn export-csv">
            Export CSV<span class="icon"><i class="fa-solid fa-file-export"></i></span>
        </button> --}}
    </div>
    <div class="taxonemy-content">
        <div class="taxonmies-div-title">Users:</div>
        <div class="taxonmies">
            <div class="single-tax">
                <span class="tax-name">
                    <a  href="{{ route('users.index') }}">All
                      <span class="tax-count">({{ $allCount }})</span>
                    </a>

                </span>
                <div class="tax-sperator">|</div>
            </div>
            <div class="single-tax">
                <span class="tax-name">
                    <a  href="{{ route('users.index', ['role' => 'customer']) }}">Customer
                      <span class="tax-count">({{ $customerCount }})</span>
                    </a>

                </span>
                <div class="tax-sperator">|</div>
            </div>
            <div class="single-tax">
                <span class="tax-name">
                    <a  href="{{ route('users.index' , ['role' => 'admin']) }}">Admin
                      <span class="tax-count">({{ $adminCount }})</span>
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
                <li><a class="link Deletebtn-checks" message="user" action="{{ route('admin.users.deleteAll') }}" >Delete</a></li>
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
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                    $index     = 1;
                    $roleParam = request()->query('role');
                  @endphp
                  @foreach ( $users as $user )
                    @if (!$roleParam || $user->role===$roleParam)
                    <tr id="row_id{{$user->id}}">
                      <td><input type="checkbox"  name="row_id" value="{{ $user->id }}"> </td>
                      <td>{{$index}}</td>
                      <td>{{$user->id}}</td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->role}}</td>
                      <td>{{$user->created_at}}</td>
                      <td><span class="Actions"><a class="link" href="{{ route('users.edit', $user->id) }}"><i class="fa-solid fa-file-pen"></i></a>
                              <form method="POST" action="{{ route('users.destroy', $user->id) }}">
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
                    @endif
                  @endforeach
                  @empty($users)
                    <p>no users found  add now</p>
                  @endempty
                </tbody>
            </table>
          </div>
    </section>

          <div class="center link">
            {{ $users->withQueryString()->links() }}
          </div>

        @section('js')
        <script>
          let count        = {{ count($users) }};
          let displayCount = $('tbody tr');
          $('.count').text(`${displayCount.length} / ${count}`)
        </script>
        @stop
@stop
