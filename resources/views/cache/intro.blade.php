
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Tanit Formazione</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="TANIT" />
	<meta name="keywords" content="formazione job" />
	<meta name="author" content="GGallery" />

	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<!-- <link rel="shortcut icon" href="favicon.ico"> -->

	<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />


</head>
<body class="boxed">


<!-- Loader -->
<div class="fh5co-loader"></div>



<div id="wrap">

	<div id="fh5co-page">
		<header id="fh5co-header" role="banner">
			<div class="container">
				<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle dark"><i></i></a>
				{{--<div id="fh5co-logo"><a href="/"><img src="/images/logo.png" alt="Logo Tanit"></a></div>--}}
				<nav id="fh5co-main-nav" role="navigation">
					<ul>

						@if(Auth::guest())
							<li><a href="/login">Accedi</a></li>
							<li><a href="/register">Registrati</a></li>
						@endif


					</ul>
				</nav>
			</div>
		</header>
		<!-- Header -->


		<div class="row bodygg intro">
			<div class="col-sm-12">
				{{--@if(count($errors->all()) > 0)--}}
					{{--<div class="alert alert-danger" role="alert">--}}
						{{--<p><b>OOOPS!</b></p>--}}
						{{--<ul>--}}
							{{--@foreach($errors->all() as $e)--}}
								{{--<li>{{$e}}</li>--}}
							{{--@endforeach--}}
						{{--</ul>--}}
					{{--</div>--}}
				{{--@endif--}}

				<div class="container-fluid">

					<div class="titolo">QUID</div>
					<div class="payoff">The training app</div>

					<div class="row backgroundwhite ">
						<div class="col-md-6 ">

							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<strong>Whoops!</strong> Ahi, ci sono dei problemi col tuo login.<br><br>
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<form class="form-horizontal" role="form" method="POST" action="/login">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

								<div class="form-group">
									<label class="col-md-4 control-label">Indirizzo E-Mail</label>
									<div class="col-md-8">
										<input type="email" class="form-control" name="email" value="{{ old('email') }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Password</label>
									<div class="col-md-8">
										<input type="password" class="form-control" name="password">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-8 col-md-offset-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="remember"> Ricordami
											</label>
										</div>
									</div>
								</div>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">


								<div class="form-group">
									<div class="col-md-8 col-md-offset-4">
										<button type="submit" class="btn btn-tanit" style="margin-right: 15px;">
											Login
										</button>

										<!--								<a href="/password/email">Forgot Your Password?</a>-->
									</div>
								</div>
							</form>
						</div>


						<div class="col-md-6 text-center">

							<a href="/new_societa_demo">
								<img width="250px" src="images/demo.png"/>
							</a>

						</div>
					</div>
				</div>
			</div>
		</div>


		<footer id="fh5co-footer" role="contentinfo">
			<div class="container">

				<div class="col-md-2 col-md-push-10 col-sm-6">
					<div id="fh5co-logo"><a href="/"><img src="/images/logo.png" alt="Logo Tanit"></a></div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="fh5co-copyright">
							<p class="pull-left">&copy; 2016. All Rights Reserved. </p>
							<p class="pull-right">Designed by <b><a href="http://www.gallerygroup.it" target="_blank">GGallery</a></b> </p>
						</div>
					</div>
				</div>




			</div>

		</footer>


	</div>
</div>




<div class="gototop js-top">
	<a href="#" class="js-gotop"><i class="icon-chevron-down"></i></a>
</div>

<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@yield('script')


</body>
</html>

