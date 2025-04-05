<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin | Login</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="{{ URL::asset('public/admin/css/master.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('public/admin/css/log_in.css') }}">
  <link rel="shortcut icon" href="{{URL::asset('public/user/images/logo.png')}}" type="image/x-icon">
</head>
	<body>
		<div class="form">
			<div class="section_img">
					<p>Welcome to Admin <br> <span class="site-name">SHOP & BUY</span></p>
						<img src="{{ URL::asset('public/admin/imges/login.img/login-33fdac8a.webp') }}" alt="something went wrong">
			</div>
			<div class="section_log_in">
					<h2>Welcome back!</h2>
					<form class="log_in" method="POST" action="{{ route('admin.post.login') }}">
            @csrf
						<div class="input-div">
							<label for="E-mail">E-mail</label>
							<input autocomplete="off" type="text" id="E-mail" name="email" placeholder="Your E-mail address">
						</div>
						<div class="input-div">
							<label for="Password">Password</label>
							<div class="password-with-icon">
								<input autocomplete="off" type="password" id="Password" class="password"  name="password" placeholder="Your Password">
							</div>
						</div>
						<button type="submit" class="login-button">Log In</button>
					</form>
          <a href="{{ route('index') }}" class="btn btn-primary">Back to site</a>

			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="{{ URL::asset('public/admin/js/main.js') }}"></script>
		<script src="{{ URL::asset('public/admin/js/log-in.js') }}"></script>
    @include('admin.messages.success')
    @include('admin.messages.error')

	</body>
</html>
