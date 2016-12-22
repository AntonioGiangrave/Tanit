@extends('cache.index')

@section('page_heading','Accesso')
@section('body')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">

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
								<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
									Login
								</button>

<!--								<a href="/password/email">Forgot Your Password?</a>-->
							</div>
						</div>
					</form>
				</div>
			</div>
	</div>

@endsection
