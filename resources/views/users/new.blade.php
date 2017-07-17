@extends('cache.index')

@section('page_heading', 'Creazione nuovo utente')
@section('body')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        {{
        Form::open(['url' =>'users/'])
        }}

        <div class="row">
            <div class="col-md-4">

                <div class="form-group">
                    {{ Form::label('nome', 'Nome:') }}
                    {{ Form::text('nome', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('cognome', 'Cognome:') }}
                    {{ Form::text('cognome', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('email', 'Email:') }}

                    {{ Form::text('email', null, ['class' => 'form-control']) }}
                </div>

            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('societa_id', 'Società di appartenenza:') }}
                    {{ Form::select('societa_id', $societa, Auth::user()->societa_id, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <hr>


        {{--<ul class="nav nav-tabs">--}}
            {{--<li class="active"><a data-toggle="tab" href="#t1"><i class="fa fa-user" aria-hidden="true"></i> Dettaglio profilo</a></li>--}}
            {{--<li><a data-toggle="tab" href="#t2"><i class="fa fa-users" aria-hidden="true"></i> Gruppi</a></li>--}}
            {{--<li><a data-toggle="tab" href="#t3"><i class="fa fa-wrench" aria-hidden="true"></i> Mansioni</a></li>--}}
            {{--<li><a data-toggle="tab" href="#t4"><i class="fa fa-shield" aria-hidden="true"></i> Incarichi sicurezza</a></li>--}}
            {{--<li><a data-toggle="tab" href="#t5"><i class="fa fa-thermometer-half" aria-hidden="true"></i> Classe di rischio</a></li>--}}
            {{--<li><a data-toggle="tab" href="#t6"><i class="fa fa-sign-out" aria-hidden="true"></i> Esoneri per laurea</a></li>--}}
            {{--<li><a data-toggle="tab" href="#t7"><i class="fa fa-drivers-license" aria-hidden="true"></i> Albi professionali</a></li>--}}
        {{--</ul>--}}

        {{--<div class="tab-content">--}}
            {{--<div id="t1" class="tab-pane fade in active">--}}
                {{--@include('users.edit_detail',  $datiRecuperati)--}}
            {{--</div>--}}

            {{--<div id="t2" class="tab-pane fade">--}}
                {{--@include('users.edit_gruppi_tutor',  $datiRecuperati)--}}
            {{--</div>--}}

            {{--<div id="t3" class="tab-pane fade ">--}}
                {{--@include('users.edit_mansioni',  $datiRecuperati)--}}
            {{--</div>--}}

            {{--<div id="t4" class="tab-pane fade ">--}}
                {{--@include('users.edit_incarichi_sicurezza',  $datiRecuperati)--}}
            {{--</div>--}}

            {{--<div id="t5" class="tab-pane fade ">--}}
                {{--@include('users.edit_classe_rischio',  $datiRecuperati)--}}
            {{--</div>--}}

            {{--<div id="t6" class="tab-pane fade ">--}}
                {{--@include('users.edit_esoneri_laurea',  $datiRecuperati)--}}
            {{--</div>--}}

            {{--<div id="t7" class="tab-pane fade ">--}}
                {{--@include('users.edit_albi',  $datiRecuperati)--}}
            {{--</div>--}}

        {{--</div>--}}

        <div class="row">
            <div class="pull-right">

                {{ Form::button('<i class="fa fa-save"></i> Aggiorna', ['class' => 'btn btn-tanit btn-xs', 'type'=>'submit', 'type'=>'submit']) }}
                {{ Form::close() }}

            </div>
        </div>
    </div>

@stop



