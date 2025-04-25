@extends('admin.layouts.master')
@section('title', 'Edit'. $att->name)

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('attribute.post_edit', $att->id) }}"  method="post" class="add_user">
    @csrf
      <div class="two-input">
        <div class="input-div w-half">
          <label for="user_username" class="riq">name</label>
          <input type="text" autocomplete="off" value="{{ old('name', $att->name) }}" id="name" name="name" placeholder="Enter Attribute name">
          @error('name')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        {{-- <div class="input-div w-half">
          <label for="type" class="riq">Display Type</label>
          <select value="{{ old('type') }}" name="type" id="type">
            <option selected value="text">Text</option>
            <option value="color">Color</option>
            <option value="image">Image</option>
          </select>
          @error('type')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div> --}}

      </div>



      <button type="submit" >Edit Attribute</button>
    </form>
</div>
@stop
