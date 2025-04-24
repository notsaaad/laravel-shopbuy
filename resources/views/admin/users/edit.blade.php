@extends('admin.layouts.master')
@section('title', 'update  ' . $user->name)

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('public/admin/css/editor.css') }}">
@endsection

@section('content')
  @if (Auth::id() == $user->id)
    <h3>My Account</h3>
  @endif
<div class="only-form">
  <form action="{{ route('users.update', $user->id) }}"  method="post" class="add_user">
    @method('put')
    @csrf
      <div class="two-input">
        <div class="input-div w-half">
          <label for="user_username" class="riq">Username</label>
          <input type="text" autocomplete="off" value="{{ old('user_username') ?? $user->name }}" id="user_username" name="user_username" placeholder="Enter username">
          @error('user_username')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        <div class="input-div w-half">
          <label for="email" class="riq">Email</label>
          <input type="text" autocomplete="off" value="{{old('user_email') ?? $user->email }}" id="email" name="user_email" placeholder="Enter email">
          @error('user_email')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>

      </div>
      @if (Auth::id() == $user->id)
      <div class="two-input">
        <div class="input-div w-half">
          <label for="password" class="riq">Password</label>
          <div class="password-with-icon">

            <input autocomplete="off" value="{{ old('user_password')}}" type="password" id="Password" class="password"  name="user_password" placeholder="Enter Password">
          </div>
          @error('user_password')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>

        <div class="input-div w-half">
          <label for="conf-password" class="riq">Confrim Password</label>
          <div class="password-with-icon">
            <input autocomplete="off" value="{{ old('password_confirmation')}}" type="password" id="password_confirmation" class="password_confirmation"  name="password_confirmation" placeholder="Confrim the Password">
          </div>
          @error('password_confirmation')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>
      @endif


      <div class="input-div">
        <label for="role" class="riq">Role</label>
        <select value="{{ old('role') }}" name="role" id="role">
          <option {{ $user->role == 'customer' ? 'selected' : '' }} value="customer">Customer</option>
          <option {{ $user->role == 'admin'    ? 'selected' : '' }} value="admin">Admin</option>
        </select>
        @error('role')
          <small class="text-danger">{{$message}}</small>
        @enderror
      </div>
      <button type="submit" >Update User</button>
    </form>
</div>
@stop
