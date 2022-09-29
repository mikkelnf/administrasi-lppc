<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Login | Administrasi LPPC</title>

    <!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
	<!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="login">
    <section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="lppc">
						<img src="{{ asset('img') }}/logolppc.png" alt="logo">
					</div>
                    <hr class="logo-under">
					<form action="/login" method="post">
						@csrf
						<div class="card fat">
							<div class="card-body">
								<h4 class="card-title">Login</h4>
								<form method="POST" novalidate="">
									<div class="form-group">
										<label for="username">Username</label>
										<input id="username" type="username" class="form-control" name="username" value="" required autofocus>
									</div>
									<div class="form-group">
										<label for="password">Password
										</label>
										<input id="password" type="password" class="form-control" name="password" required data-eye>
									</div>
									
									@if(session('pesan'))
									<div class="alert alert-danger" role="alert" id="edit-alert-periode">
										<span class="invalid">{{ session('pesan')}}</span>
									</div> 
									@endif
									
									<div class="form-group m-0">
										<button type="submit" class="btn btn-outline-primary btn-block">
											Login
										</button>
									</div>
									<div class="subtitle">Laboratorium Pengembangan Pengolahan Citra</div>
								</form>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</body>

</html>