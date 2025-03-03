@extends('user.layouts.master')


@section('title', 'New Account')





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
      <h2 class="form-title">Create an Account</h2>
      <form action="{{route('signup_post')}}"  method="POST">
        @csrf
          <div class="input-group">
              <input  class="form-control" type="text" name="name" placeholder="Enter your name" required>
          </div>

          <div class="input-group">
              <input  class="form-control" type="email" name="email" placeholder="Email Address" required>
          </div>

          <div class="input-group">
            <div class="password-with-icon">
              <input type="password" class="form-control"  id="Password" class="password" name="password" placeholder="Your Password">
            </div>

          </div>

          <div class="input-group ">
              <div class="password-with-icon">
                <input  class="form-control" type="password" name="confirm-password" placeholder="Confirm Password" required>
              </div>

          </div>


          <button class="btn btn-primary" type="submit">Create an Account</button>

          <div class="or-section">or</div>

          <p class="signin-text">Already have an account? <a href="{{route('login')}}">Sign in</a></p>
      </form>
    </div>
  </div>
</div>


@stop
