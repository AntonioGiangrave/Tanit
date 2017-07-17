@extends('cache.index')


@section('body')


    @if(Auth::guest())
        {{--VISTA GUEST --}}



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

        <h1 class="text-center">BENVENUTO IN TANIT </h1>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <h2>ACCEDI</h2>


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
                <h2>PROVA LA DEMO</h2>
                <a href="/new_societa_demo">
                    <img width="200px" src="images/demo.png"/>
                </a>

                <br><br>
            </div>
        </div>

    @else
        {{--VISTA DA LOGGATO--}}




        @role('user')

        <a href="/users/{{ Auth::user()->id }}/edit">
            <div class="boxhome"><i class="fa fa-user fa-5x"></i>
                <h4>  Gestisci il tuo profilo</h4>
            </div>
        </a>
        <a href="/usersformazione/{{ Auth::user()->id }}">
            <div class="boxhome"><i class="fa fa-mortar-board fa-5x"></i>
                <h4> Monitora la tua formazione </h4>
            </div>
        </a>
        @endrole


        <div class="clearfix"></div>


        @role('azienda')
        <a href="/societa/">
            <div class="boxhome"><i class="fa fa-building-o  fa-5x"></i>
                <h4>Gestisci il profilo della tua azienda</h4>
            </div>
        </a>

        <a href="/users/">
            <div class="boxhome"><i class="fa fa-users fa-5x"></i>
                <h4>Monitora la formazione dei dipendenti</h4>
            </div>
        </a>

        @endrole

        <div class="clearfix"></div>

        @role(['gestoremultiplo', 'admin'])
        <a href="/societa/">
            <div class="boxhome"><i class="fa fa-building-o  fa-5x"></i>
                <h4>Gestisci un'azienda</h4>
            </div>
        </a>

        <a href="/users/">
            <div class="boxhome"><i class="fa fa-users fa-5x"></i>
                <h4>Monitora i dipendenti</h4>
            </div>
        </a>
        @endrole

    @endif




@stop



@section('script')
    <script type="text/javascript">
        $( ".help" ).hide("slow", function() {
            $( ".help" ).slideToggle("slow");
        })

    </script>
@stop


@if(Auth::guest())

@section('help')
    Sei nella pagina iniziale, da qui puoi accedere o fare una registrazione per una demo.
    <br>
    <strong>In questo box potrai trovare una guida su ogni pagina che stai visionando, clicca sul salvagente per nascondere/visualizzare questo spazio.</strong>
@stop

@else

@section('help')
    Sei nella pagina iniziale, da qui puoi accedere ad alcune delle principali funzionalità cliccando direttamente sulle icone.
    Altrimenti puoi accedere a tutte le funzionalità cliccando sul menù in alto.<br>
    <strong>In questo box potrai trovare una guida su ogni pagina che stai visionando, clicca sul salvagente per nascondere/visualizzare questo spazio.</strong>
@endsection

@endif