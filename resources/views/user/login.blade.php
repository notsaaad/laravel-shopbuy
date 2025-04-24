@extends('user.layouts.master')


@section('title', 'login')





@section('css')
  {{-- From Home Blade --}}
  <link rel="stylesheet" href="{{URL::asset('public/user/css/creat account.css')}}">

@stop
@section('content')
<br>
<br>
<br>
<div class="main-content">
  <div class="container">
    <div class="form-container">
      <h2 class="form-title">Sign in </h2>
      <form action="{{ route('loign_post') }}" method="POST" >

        @csrf
          <div class="input-group">
              <input  class="form-control" type="text" name="email" placeholder="Email Address" required>
          </div>
          @error('email')
            <small class="text-danger">{{$message}}</small>
          @enderror
          <div class="input-group">
            <div class="password-with-icon">
              <input type="password" class="form-control"  id="Password" class="password" name="password" placeholder="Your Password">
            </div>
            @error('password')
            <small class="text-danger">{{$message}}</small>
          @enderror
          </div>





          <button class="btn btn-primary" type="submit">Sign in</button>

          <div class="or-section">or</div>

          <p class="signin-text">Does not  have an account? <a href="{{route('Signup')}}">Sign up</a></p>
      </form>
    </div>
  </div>
</div>

@stop
