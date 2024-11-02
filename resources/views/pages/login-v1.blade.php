@extends('layouts.default', [
	'paceTop' => true,
	'appSidebarHide' => true,
	'appHeaderHide' => true,
	'appContentClass' => 'p-0'
])

@section('title', 'Login Page')

@section('content')
	<!-- BEGIN login -->
	<div class="login login-v1">
		<!-- BEGIN login-container -->
		<div class="login-container">
			<!-- BEGIN login-header -->
			<div class="login-header">
				<div class="brand">
					<div class="d-flex align-items-center">
						<span class="logo"></span> <b>Aby</b> Resto
					</div>
					<small>Selamat datang di halaman login</small>
				</div>
				<div class="icon">
					<i class="fa fa-lock"></i>
				</div>
			</div>
			<!-- END login-header -->
			
			<!-- BEGIN login-body -->
			<div class="login-body">
				<!-- BEGIN login-content -->
				<div class="login-content fs-13px">
					<form action="/" method="GET">
						<div class="form-floating mb-20px">
							<input type="email" class="form-control fs-13px h-45px" id="emailAddress" placeholder="Email Address" />
							<label for="emailAddress" class="d-flex align-items-center py-0">Email Address</label>
						</div>
						<div class="form-floating mb-20px">
							<input type="password" class="form-control fs-13px h-45px" id="password" placeholder="Password" />
							<label for="password" class="d-flex align-items-center py-0">Password</label>
						</div>
						<div class="form-check mb-20px">
							<input class="form-check-input" type="checkbox" value="" id="rememberMe" />
							<label class="form-check-label" for="rememberMe">
							</label>
						</div>
						<div class="mb-20px">
							<label class="form-check-label">
								<a href="{{ url('register') }}" class="text-decoration-none">Don't have an account?</a>
							</label>
						</div>
						<div class="login-buttons">
							<button type="submit" class="btn h-45px btn-success d-block w-100 btn-lg">Sign me in</button>
						</div>
					</form>
				</div>
				<!-- END login-content -->
			</div>
			<!-- END login-body -->
		</div>
		<!-- END login-container -->
	</div>
	<!-- END login -->
@endsection