@extends('user.layouts.master')

@section('title', 'Thank You')

@section('css')
  <style>
    .main-invoce-box{
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 50px;
    }
    .invoice-box {
      width: 95%;
      padding: 30px;
      font-size: 16px;
      line-height: 24px;
      font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
      color: #555;
      background: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
      border: 1px solid black;
      border-radius: 8px;
      margin: 20px 0;
    }

    @media screen and (min-width:1100px){
      .invoice-box{
        width: 900px;
      }
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border-collapse: collapse;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        font-weight: bold;
        border-bottom: 1px solid #ddd;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.total td:nth-child(2) {
        font-weight: bold;
    }

    .color-circle {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        margin-left: 5px;
        vertical-align: middle;
        border: 1px solid #333;
    }
  </style>
@stop

@section('content')
<br>
<br>
<br>
  <div class="main-invoce-box">
    <div class="invoice-box">
    <h2>Thank you for your order!</h2>
    <p>Your order has been placed successfully.</p>

    <hr>

    <h4>Order Information</h4>
    <table>
        <tr>
            <td><strong>Order Number:</strong> #{{ $order->id }}</td>
            <td><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Status:</strong> {{ ucfirst($order->status) }}</td>
            <td><strong>Payment Method:</strong> Cash On Delivery</td>
        </tr>
    </table>

    <hr>

    <h4>Customer Information</h4>
    <table>
        <tr>
            <td><strong>Name:</strong> {{ $order->userMeta->name }}</td>
            <td><strong>Phone:</strong> {{ $order->userMeta->phone }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong> {{ $order->userMeta->email }}</td>
            <td><strong>Address:</strong> {{ $order->userMeta->address }}, {{ $order->userMeta->country }}</td>
        </tr>
    </table>

    <hr>

    <h4>Order Items</h4>
    <table>
        <tr class="heading">
            <td>Product</td>
            <td>Qty</td>
            <td>Unit Price</td>
            <td>Total</td>
        </tr>

        @foreach($order->items as $item)
        <tr class="item">
            <td>
                <strong>{{ $item->product_title }}</strong>
                @if (!empty($item->variant_attributes))
                    <ul style="margin: 0; padding: 0 0 0 15px;">
                        @foreach($item->variant_attributes as $attr)
                            <li>
                                {{ $attr['attribute'] }}:
                                {{ $attr['value'] }}
                                @if (!empty($attr['color_code']))
                                    <span class="color-circle" style="background-color: {{ $attr['color_code'] }}"></span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </td>
            <td>{{ $item->quantity }}</td>
            <td>${{ number_format($item->unit_price, 2) }}</td>
            <td>${{ number_format($item->total_price, 2) }}</td>
        </tr>
        @endforeach

        <tr class="total">
            <td colspan="3" style="text-align: right;">Grand Total:</td>
            <td>${{ number_format($order->total_price, 2) }}</td>
        </tr>
    </table>
</div>
  </div>
@stop
