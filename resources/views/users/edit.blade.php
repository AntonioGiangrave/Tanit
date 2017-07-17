@extends('cache.index')

@section('page_heading')
    {{$datiRecuperati['nome']}} {{$datiRecuperati['cognome']}}

    @role('admin')
    <span class="small">
        [gruppi: {{ implode(", ", $datiRecuperati->groups->lists('name')->all()) }}]

        @if($datiRecuperati->_tutor_societa->count() > 0)
            [tutor per: {{ implode(", ", $datiRecuperati->_tutor_societa->lists('ragione_sociale')->all()) }}]
        @endif
    </span>
    @endrole


@stop

@section('action_button')
    <a class="btn btn-tanit" href="/usersformazione/{{$datiRecuperati['id']}}"> Libretto formativo </a>
    @role(['admin', 'azienda'])
    <a class="btn btn-tanit" href="/users?societa_id={{$datiRecuperati['societa_id']}}"> Monitora la formazione dei dipendenti </a>
    @endrole
@stop


@section('body')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        {{
        Form::model($datiRecuperati,
        ['method' => 'put', 'url' =>'users/'. $datiRecuperati['id']])
        }}

        <div class="row">
            <div class="col-md-4">

                <div class="form-group">
                    {{ Form::label('nome', 'Il tuo nome:') }}
                    {{ Form::text('nome', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('cognome', 'Il tuo cognome:') }}
                    {{ Form::text('cognome', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('email', 'La tua email:') }}

                    {{ Form::text('email', null, ['class' => 'form-control']) }}
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">

                <div class="form-group">
                    @if(Auth::user()->hasAnyRole(['admin']))

                        {{ Form::label('societa_id', 'Società di appartenenza:') }}
                        {{ Form::select('societa_id', $societa, null, ['class' => 'form-control' ]) }}

                    @else

                        {{ Form::select('societa_id', $societa, null, ['class' => 'form-control hide' ]) }}

                    @endif

                </div>

            </div>

        </div>

        <hr>


        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#t1"><i class="fa fa-user" aria-hidden="true"></i> Dettaglio profilo</a></li>

            @role('admin')
            <li><a data-toggle="tab" href="#t2"><i class="fa fa-users" aria-hidden="true"></i> Gruppi</a></li>
            @endrole
            <li><a data-toggle="tab" href="#t3"><i class="fa fa-wrench" aria-hidden="true"></i> Mansioni</a></li>
            <li><a data-toggle="tab" href="#t4"><i class="fa fa-shield" aria-hidden="true"></i> Incarichi sicurezza</a></li>
            <li><a data-toggle="tab" href="#t5"><i class="fa fa-thermometer-half" aria-hidden="true"></i> Classe di rischio</a></li>
            <li><a data-toggle="tab" href="#t6"><i class="fa fa-sign-out" aria-hidden="true"></i> Esoneri per laurea</a></li>
            <li><a data-toggle="tab" href="#t7"><i class="fa fa-drivers-license" aria-hidden="true"></i> Albi professionali</a></li>
        </ul>

        <div class="tab-content">
            <div id="t1" class="tab-pane fade in active">
                @include('users.edit_detail',  $datiRecuperati)
            </div>

            <div id="t2" class="tab-pane fade">
                @include('users.edit_gruppi_tutor',  $datiRecuperati)
            </div>

            <div id="t3" class="tab-pane fade ">
                @include('users.edit_mansioni',  $datiRecuperati)
            </div>

            <div id="t4" class="tab-pane fade ">
                @include('users.edit_incarichi_sicurezza',  $datiRecuperati)
            </div>

            <div id="t5" class="tab-pane fade ">
                @include('users.edit_classe_rischio',  $datiRecuperati)
            </div>

            <div id="t6" class="tab-pane fade ">
                @include('users.edit_esoneri_laurea',  $datiRecuperati)
            </div>

            <div id="t7" class="tab-pane fade ">
                @include('users.edit_albi',  $datiRecuperati)
            </div>

        </div>

        <div class="row">
            <div class="pull-right">

                {{ Form::button('<i class="fa fa-save"></i> Aggiorna', ['class' => 'btn btn-tanit btn-xs', 'type'=>'submit', 'type'=>'submit']) }}
                {{ Form::close() }}

            </div>
        </div>

        @role(['admin', 'azienda'])
        <br><br><br>
        <div class="row">
            <div class="text-center bg-danger">
                <hr>

                <b>CLICCANDO SUL PULSANTE ELIMINERAI DEFINITIVAMENTE QUESTO UTENTE</b> <br>


                {{ Form::open(array('url' => 'users/' . $datiRecuperati['id'], 'class' => 'bg-danger')) }}

                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('CANCELLA', array('class' => 'btn btn-danger btn-xs')) }}
                {{ Form::close() }}

            </div>
        </div>
        @endrole


    </div>

@stop



