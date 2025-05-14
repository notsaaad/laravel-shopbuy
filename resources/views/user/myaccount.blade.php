@extends('user.layouts.master')

@section('title', 'My-Account')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('public/user/css/myaccount.css') }}">
@stop

@section('content')

<br><br><br>
<div class="main-content">

    <section class="tg-may-account-wrapp tg">
    <div class="inner">
        <div class="tg-account">
            <!-- Accont banner start -->
            <div class="account-banner">
                <div class="inner-banner">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 detail">
                                <div class="inner">
                                    <h1 class="page-title">My Account</h1>
                                    <h3 class="user-name">Hello {{ auth()->user()->name}}</h3>
                                </div>
                            </div>
                            {{-- <!-- Column end -->
                            <div class="col-md-4 profile">
                                <div class="profile">
                                    <span class="image">
                                    <img src="https://res.cloudinary.com/templategalaxy/image/upload/v1631257421/codepen-my-account/images/profile_pdpo9w.png" alt="Yash">
                                </span>
                                </div>
                            </div>
                            <!-- Column end --> --}}
                        </div>
                        <!-- Row end -->

                        <!-- Navbar Start -->
                        <div class="nav-area">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="dashboard-link" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="my-order" data-toggle="tab" href="#my-orders" role="tab" aria-controls="my-orders" aria-selected="false"><i class="fas fa-file-invoice"></i> <span>Orders</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="my-address" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false"><i class="fas fa-map-marker-alt"></i> <span>Address</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="account-detail" data-toggle="tab" href="#account-details" role="tab" aria-controls="account-details" aria-selected="false"><i class="fas fa-user-alt"></i> <span>Account Details</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="logout" data-toggle="tab" href="{{ route('logout') }}" role="tab" aria-controls="logout" aria-selected="false"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
                                </li>
                            </ul>
                        </div>
                        <!-- Navbar End -->
                    </div>
                </div>
            </div>
            <!-- Banner end   -->

            <!-- Tabs Content start -->
            <div class="tabs tg-tabs-content-wrapp">
              <div class="inner">
                <div class="container">
                  <div class="inner">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-link">
                          <div class="my-account-dashboard">
                              <div class="inner">
                                  <div class="row">
                                      <div class="col-md-4 mb-3">
                                          <div class="card" area-toggle="my-order">
                                              <div class="card-body">
                                                  <div class="text-center">
                                                      <a><img src="https://res.cloudinary.com/templategalaxy/image/upload/v1631257421/codepen-my-account/images/orders_n2aopq.png"></a>
                                                  </div>
                                                  <h2>Your Orders</h2>

                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-4 mb-3">
                                          <div class="card" area-toggle="my-address">
                                              <div class="card-body">
                                                  <div class="text-center">
                                                      <a><img src="https://res.cloudinary.com/templategalaxy/image/upload/v1631257421/codepen-my-account/images/notebook_psrhv5.png"></a>
                                                  </div>
                                                  <h2>Your Addresses</h2>

                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-4 mb-3">
                                          <div class="card" area-toggle="account-detail">
                                              <div class="card-body">
                                                  <div class="text-center">
                                                      <a><img src="https://res.cloudinary.com/templategalaxy/image/upload/v1631257421/codepen-my-account/images/login_aq9v9z.png"></a>
                                                  </div>
                                                  <h2>Account Details</h2>

                                              </div>
                                          </div>
                                      </div>

                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="my-orders" role="tabpanel" aria-labelledby="my-order">
                            <table id="my-orders-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th class="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  @forelse ( $orders as $order )
                                    <tr>
                                        <td>#{{$order->id}}</td>
                                        <td>{{$order->created_at->format('Y-m-d')}}</td>
                                        <td>{{$order->status}}</td>
                                        <td>${{$order->total_price}}</td>
                                        <td class="action"><a href="{{ route('thank.you.page', $order->id) }}" class="view-order">View Order</a></td>
                                    </tr>

                                  @empty
                                    <td style="text-align: center" colspan="5">Your orders is empty</td>
                                  @endforelse

                                    {{-- <tr>
                                        <td>#8083</td>
                                        <td>Sep 9, 2021</td>
                                        <td>Completed</td>
                                        <td>$350</td>
                                        <td class="action"><a href="#" class="view-order">View Order</a></td>
                                    </tr> --}}

                                    {{-- <tr>
                                        <td>#8283</td>
                                        <td>Sep 8, 2021</td>
                                        <td>Pending</td>
                                        <td>$190</td>
                                        <td class="action"><a href="#" class="view-order">View Order</a></td>
                                    </tr>

                                    <tr>
                                        <td>#8483</td>
                                        <td>Sep 7, 2021</td>
                                        <td>Completed</td>
                                        <td>$399</td>
                                        <td class="action"><a href="#" class="view-order">View Order</a></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="my-address">
                            <div class="address-form">
                                <div class="inner">
                                    <form class="tg-form" action="" method="">

                                        <div class="form-group">
                                            <label for="inputAddress">Address</label>
                                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress2">Address 2</label>
                                            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity">City</label>
                                                <input type="text" class="form-control" id="inputCity">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputState">State</label>
                                                <select id="inputState" class="form-control">
                                                <option selected>Choose...</option>
                                                <option>...</option>
                                              </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="inputZip">Zip</label>
                                                <input type="text" class="form-control" id="inputZip">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-details" role="tabpanel" aria-labelledby="account-detail">
                            <div class="account-detail-form">
                                <div class="inner">
                                    <form class="tg-form" action="" method="">
                                        <div class="form-row">
                                            <div class="form-group col-md-12 mt-2">
                                                <label for="inputdname">Display Name</label>
                                                <input type="text" value={{  auth()->user()->name }} name="name" class="form-control" id="inputdname" placeholder="Display Name">
                                            </div>

                                            <div class="form-group col-md-12 mt-2">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" value={{ auth()->user()->email }}  nemae="email" class="form-control" id="inputEmail4" placeholder="Email">
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  </section>

@stop

@section('js')
    <script>
          $(document).ready(function () {
          function getUrlParameter(name) {
              name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
              var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
              var results = regex.exec(location.search);
              return results === null ? null : decodeURIComponent(results[1].replace(/\+/g, ' '));
          }

          var tabParam = getUrlParameter('tab');
          if (tabParam) {
              // هذا يفترض أن لديك رابط داخل #myTab مع href يحتوي على ID التبويب
              $('#myTab a[href="#' + tabParam + '"]').tab('show');
          }
          });
        $('#myTab a:not(#logout)').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        });

        /**
         * Datatable call
         */
        $(document).ready(function() {
            $('#my-orders-table').DataTable();
        });

        /**
         * My account nav click
         */
        $(document).ready(function() {
            $('.tg-tabs-content-wrapp .my-account-dashboard .card').click(function() {

                var ariaClick = $(this).attr('area-toggle');
                $('.tg-account .account-banner .nav-area  a#' + ariaClick).click();
            });
        });
      </script>
@stop
