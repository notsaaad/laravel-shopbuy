@extends('admin.layouts.master')

@section('title', 'view Orders')

@section('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .status{
      padding: 5px;
      border-radius: 6px;
      background-color: #efefe3;
      color:white;
      font-size: 16px !important;
    }
    .status.pending{
      background-color: #0984e3;
    }
    .status.complete{
      background-color: green;
    }
    .status.cancelled{
      background-color: red
    }
  </style>
@endsection

@section('content')

    <div class="title">
        <h1>Orders</h1>
    </div>
    <div class="buttons-content">
        {{-- <a href="{{ route('attribute.add') }}" class="link our-btn add-product">
            Add new Attribute<span class="icon"><i class="fa-solid fa-circle-plus"></i></span>
        </a> --}}
        {{-- <button class="our-btn export-csv">
            Export CSV<span class="icon"><i class="fa-solid fa-file-export"></i></span>
        </button> --}}
    </div>
    <div class="taxonemy-content">
        <div class="taxonmies-div-title">Orders:</div>
        <div class="taxonmies">
            <div class="single-tax">
                <span class="tax-name">
                    <a href="?status=status=pending">Pending
                      <span class="tax-count">({{ $pendingCount }})</span>
                    </a>

                </span>
                <div class="tax-sperator">|</div>
            </div>
            <div class="single-tax">
                <span class="tax-name">
                    <a href="?status=complete">Complete
                      <span class="tax-count">({{$completeCount}})</span>
                    </a>

                </span>
                <div class="tax-sperator">|</div>
            </div>
            <div class="single-tax">
                <span class="tax-name">
                    <a href="?status=cancelled">Cancled
                      <span class="tax-count">({{ $cancledCount }})</span>
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
                <li><a class="link Deletebtn-checks" message="Attibutes" action="{{ route('orders_value_delete_all') }}" >Delete</a></li>
                <li><a class="link clear-btn">Cancel</a></li>
            </ul>
        </div>

        {{-- <button class="apply-btn our-btn">Apply <i class="fa-solid fa-chevron-right"></i></button> --}}
        <a  href="{{ route('admin_order_view') }}" class="clear-btn our-btn link">Clear</a>
    </div>
    <section class="table_titil">
        <span>View Orders <span class="count"></span></span>
        <div class="outputs">
            <div class="search_block">
                <input type="text" class="search"placeholder="Search Orders" onkeyup="SearchTable(this)">
            </div>
        </div>
          <div class="table_header">
            <table>
                <thead>
                    <tr class="design_header">
                        <th><input type="checkbox" name="ids" id="check_all_ids"></th>
                        <th>#</th>
                        <th>ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>View</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @php $index = 1 @endphp
                  @foreach ( $orders as $order )

                    <tr id="row_id{{$order->id}}">
                      <td><input type="checkbox"  name="row_id" value="{{ $order->id }}"> </td>
                      <td>{{$index}}</td>
                      <td>{{$order->id}}</td>
                      <td>{{$order->user->name}}</td>
                      <td>{{$order->total_price}}</td>
                      <td><a target="_blank" href="{{ route('thank.you.page', $order->id) }}" class="btn btn-primary link">View</a></td>
                      <td><span class="status {{$order->status}}">{{$order->status}}</span></td>
                      <td>{{$order->created_at}}</td>
                      <td class='center'>
                        <span class="Actions"><a class="link" href="{{ route('admin.order.edit', $order->id) }}"><i class="fa-solid fa-file-pen"></i></a>
                          <form method="POST" action="{{ route('order.destroy', $order->id) }}">
                              @csrf
                              @method('DELETE')
                              <button class="Trash"><i class="fa-solid fa-trash-can"></i></button>
                          </form>
                        </span>
                      </td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                  @endforeach
                  @empty($orders)
                    <tr>
                      <td colspan="9">No Orders Found</td>
                    </tr>
                  @endempty
                </tbody>
            </table>
          </div>
    </section>

          <div class="center link">
            {{ $orders->withQueryString()->links() }}
          </div>

        {{-- @section('js')
        <script>
          let count        = {{ count($users) }};
          let displayCount = $('tbody tr');
          $('.count').text(`${displayCount.length} / ${count}`)
        </script>
        @stop --}}
@stop
