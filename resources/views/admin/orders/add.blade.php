@extends('admin.layouts.master')
@section('title', 'Create New Order')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('admin.order.store') }}" method="post">
    @csrf

    <div class="input-div">
      <label for="user_id">User</label>
      <select name="user_id" id="user_id" class="form-control">
        @foreach ($users as $user)
          <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
        @endforeach
      </select>
      @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="input-div">
      <label for="status">Order Status</label>
      <select name="status" id="status" class="form-control">
        <option value="pending">Pending</option>
        <option value="complete">Complete</option>
        <option value="cancelled">Cancelled</option>
      </select>
      @error('status') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <hr>

    <div class="input-div">
      <label for="products">Products</label>
      <select name="products[]" id="products" multiple class="form-control select2">
        @foreach ($products as $product)
          <option value="{{ $product->id }}" data-price="{{ $product->sale }}">{{ $product->title }} ({{ $product->sale }} EGP)</option>
        @endforeach
      </select>
      @error('products') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="input-div">
      <label for="quantities[]">Quantities (for each product)</label>
      <input type="text" name="quantities" placeholder="e.g. 1,2,1 if you selected 3 products" class="form-control">
      @error('quantities') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="input-div">
      <label for="total_price">Total Price (auto)</label>
      <input type="text" name="total_price" id="total_price" class="form-control" readonly>
    </div>

    <button class="btn btn-success mt-3" type="submit">Submit Order</button>
  </form>
</div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $('.select2').select2();

    $('#products').on('change', function() {
      let total = 0;
      $('#products option:selected').each(function () {
        total += parseFloat($(this).data('price') || 0);
      });
      $('#total_price').val(total.toFixed(2));
    });
  </script>
@endsection
