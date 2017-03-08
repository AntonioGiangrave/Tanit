
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
				<div id="fh5co-logo"><a href="/"><img src="/images/logo.png" alt="Logo Kairos"></a></div>
				<nav id="fh5co-main-nav" role="navigation">
					<ul>

						@role(['admin' , 'superuser', 'gestoremultiplo' , 'azienda'])
						<li><a href="/users">Dipendenti</a></li>
						@endrole

						@role(['admin' , 'superuser', 'gestoremultiplo' ])
						<li><a href="/societa">Aziende</a></li>
						@endrole

						@role(['azienda'])
						<li><a href="/societa/{{ Auth::user()->societa_id }}/edit">Dettagli azienda</a></li>
						@endrole

						@role(['admin','superuser'])
						<li><a href="/corsi">Corsi</a></li>
						@endrole

						@role(['admin', 'superuser', 'gestoremultiplo'])
						<li><a href="/registro_formazione">Prenotazione corsi</a></li>
						@endrole


						@if(Auth::guest())
							<li><a href="/login">Accedi</a></li>

							<li><a href="/register">Registrati</a></li>
						@endif



						@role(['admin','superuser'])

						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="fa fa-cogs fa-fw"></i> Risorse <i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-user">

								<li><a href="/mansioni">Mansioni</a></li>
								<br>

								<li><a href="/ateco">Ateco</a></li>
								<br>

								<li><a href="/aule">Aule</a></li>
								<br>

								<li><a href="/fad">Fad</a></li>
								<br>

								<li><a href="/aule_sessioni">Sessioni aula / prenotazioni </a></li>
								<br>

							</ul>
						</li>
						@endrole

								<!--
            <li class="has-sub">
                <div class="drop-down-menu">
                    <a href="#">Strumenti</a>
                    <div class="dropdown-menu-wrap">
                        <ul>
                            <li><a href="/societa">Aziende</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            -->

						<ul class="nav navbar-top-links navbar-right">
							@if( Auth::check() )
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">
										<i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
									</a>



									<ul class="dropdown-menu dropdown-user">
										<li><a href="users/{{ Auth::user()->id }}/edit"><i class="fa fa-user fa-fw"></i> User Profile</a>
										</li>

										<li class="divider"></li>
										<li><a href="{{ url ('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout </a></li>
									</ul>

									<!-- /.dropdown-user -->
								</li>

								@endif
										<!-- /.dropdown -->
						</ul>


					</ul>
				</nav>
			</div>
		</header>
		<!-- Header -->






		<div class="col-sm-12">

			<h2 class="page-header">@yield('page_heading')</h2>
			<div class="pull-right">@yield('action_button')</div>


		</div>



		<div class="row bodygg">
			<div class="col-sm-12">
				@if(count($errors->all()) > 0)
					<div class="alert alert-danger" role="alert">
						<p><b>OOOPS!</b></p>
						<ul>
							@foreach($errors->all() as $e)
								<li>{{$e}}</li>
							@endforeach
						</ul>
					</div>
				@endif

				@if (session('ok_message'))
					<div class="alert alert-success">
						{{ session('ok_message') }}
					</div>
				@endif

				@if (session('error_message'))
					<div class="alert alert-warning">
						{{ session('error_message') }}
					</div>
				@endif

				@yield('body')

			</div>
		</div>


		<footer id="fh5co-footer" role="contentinfo">
			<div class="container">
				<div class="row row-bottom-padded-sm">
					<div class="col-md-4 col-sm-12">
						<div class="fh5co-footer-widget">
							<h3>TANIT</h3>
							<p>Via Carlo Innocenzo Frugoni 15/5 - 16121 GENOVA
								Telefono- Fax:  010. 8683343
								Email: segreteria@kairosformazione.it
								PEC:consorziokairosge@pec.it
								Website: www.kairosformazione.it</p>
						</div>
					</div>
					<div class="col-md-3 col-md-push-1 col-sm-12 col-sm-push-0">
						<div class="fh5co-footer-widget">
							<h3>Links</h3>
							<ul class="fh5co-footer-link">
								<li><a href="#">Home</a></li>
								<li><a href="#">-</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-3 col-md-push-2 col-sm-12 col-sm-push-0">

						<div class="fh5co-footer-widget">
							<h3>Follow us</h3>
							<ul class="fh5co-social">
								<li class="facebook"><a href="#"><i class="icon-facebook2"></i></a></li>
								<li class="twitter"><a href="#"><i class="icon-twitter"></i></a></li>
								<li class="linkedin"><a href="#"><i class="icon-linkedin"></i></a></li>
								<li class="message"><a href="#"><i class="icon-mail"></i></a></li>
							</ul>
						</div>
					</div>
				</div>



				<div class="row">
					<div class="col-md-2">
						<p class="pull-left">Accedi come:</p>
					</div>
					<div class="col-md-2">
						<a href="/loginuser">Utente</a>
					</div>
					<div class="col-md-2">
						<a href="/loginazienda">Azienda</a>
					</div>
					<div class="col-md-2">
						<a href="/logingestoremultiplo">Gestore Multiplo</a>
					</div>
					<div class="col-md-2">
						<a href="/loginsuperuser">SuperUser</a>
					</div>
					<div class="col-md-2">
						<a href="/loginadmin">Admin</a>
					</div>
				</div>



				<div class="row">
					<div class="col-md-12">
						<div class="fh5co-copyright">
							<p class="pull-left">&copy; 2016. All Rights Reserved. </p>
							<p class="pull-right">Designed by <a href="http://www.gallerygroup.it" target="_blank">GGallery</a> </p>
						</div>
					</div>
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

