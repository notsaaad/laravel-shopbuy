@extends('admin.layouts.master')
@section('title', 'update  ' . $cat->name)

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('category.update', $cat->id) }}"  method="post" class="add_user">
    @method('put')
    @csrf
        <div class="input-div w-half">
          <label for="name" class="riq">Category name</label>
          <input type="text" autocomplete="off" value="{{ old('name') ?? $cat->name }}" id="name" name="name" placeholder="Enter category name">
          @error('name')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      <button type="submit" >Update Category</button>
    </form>
</div>
@stop
