@extends('admin.layouts.master')
@section('title', 'Add Category')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('category.store') }}"  method="post" class="add_user">
    @method('POST')
    @csrf
        <div class="input-div w-half">
          <label for="name" class="riq">Category name</label>
          <input type="text" autocomplete="off" id="name" name="name" placeholder="Enter category name">
          @error('name')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      <button type="submit" >Add Category</button>
    </form>
</div>
@stop
