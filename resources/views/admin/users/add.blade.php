@extends('admin.layouts.master')
@section('title', 'User Add')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
<div class="only-form">
  <form action="{{ route('users.store') }}"  method="post" class="add_user">
    @csrf
      <div class="two-input">
        <div class="input-div w-half">
          <label for="user_username" class="riq">Username</label>
          <input type="text" autocomplete="off" value="{{ old('user_username') }}" id="user_username" name="user_username" placeholder="Enter username">
          @error('user_username')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        <div class="input-div w-half">
          <label for="email" class="riq">Email</label>
          <input type="text" autocomplete="off" value="{{$errors->any() ?  old('user_email') : '' }}" id="email" name="user_email" placeholder="Enter email">
          @error('user_email')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>

      </div>
      <div class="two-input">
        <div class="input-div w-half">
          <label for="password" class="riq">Password</label>
          <div class="password-with-icon">
            <input autocomplete="off" value="{{ $errors->any() ? old('user_password') : '' }}" type="password" id="Password" class="password"  name="user_password" placeholder="Enter Password">
          </div>
          @error('user_password')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>

        <div class="input-div w-half">
          <label for="conf-password" class="riq">Confrim Password</label>
          <div class="password-with-icon">
            <input autocomplete="off" type="password" id="conf_password" class="password"  name="conf_password" placeholder="Confrim the Password">
          </div>
          @error('conf_password')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>

      <div class="input-div">
        <label for="role" class="riq">Role</label>
        <select value="{{ old('role') }}" name="role" id="role">
          <option selected value="customer">Customer</option>
          <option value="admin">Admin</option>
        </select>
        @error('role')
          <small class="text-danger">{{$message}}</small>
        @enderror
      </div>
      <button type="submit" >Add User</button>
    </form>
</div>
@stop
