@extends('admin.layouts.master')
@section('title', 'Edit Order')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="input-div">
      <label>User</label>
      <select name="user_id" class="form-control">
        @foreach ($users as $user)
          <option value="{{ $user->id }}" {{ $user->id == $order->user_id ? 'selected' : '' }}>
            {{ $user->name }} - {{ $user->email }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="input-div">
      <label>Status</label>
      <select name="status" class="form-control">
        @foreach (['pending', 'complete', 'cancelled'] as $status)
          <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
            {{ ucfirst($status) }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="input-div">
      <label>Products</label>
      <select name="products[]" id="products" multiple class="form-control select2">
        @foreach ($products as $product)
          <option value="{{ $product->id }}" data-price="{{ $product->sale }}"
            @if(in_array($product->title, $order->items->pluck('product_title')->toArray())) selected @endif>
            {{ $product->title }} ({{ $product->sale }} EGP)
          </option>
        @endforeach
      </select>
    </div>

    <div class="input-div">
      <label>Quantities (comma-separated)</label>
      <input type="text" name="quantities" value="{{ implode(',', $order->items->pluck('quantity')->toArray()) }}">
    </div>

    <button type="submit" class="btn btn-primary mt-2">Update Order</button>
  </form>
</div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $('.select2').select2();
  </script>
@endsection
