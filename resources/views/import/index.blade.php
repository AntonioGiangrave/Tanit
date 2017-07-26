@extends('cache.index')

@section('page_heading')
    Importa nuovi utenti
@stop

@section('body')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        {{
        Form::open(array('url' => '/do_import',   'method'=>'post' ,  'class' => ' '))
        }}



        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    {{ Form::label('tipo', 'Tipologia dati:') }}
                    {{ Form::select('tipo',
                        ['utenti' => 'utenti', 'societa' => 'societa'] , 'utenti' ,
                        ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('societa', 'Societa (solo se importi utenti):') }}
                    {{ Form::select('societa',  $societa , null , ['class' => 'form-control']) }}
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('newdata', 'Dati:') }}
                    {{ Form::textarea('newdata',
                    'nome,cognome,email
mario,rossi,mrossi@gmail.com
linda,repetto,lrepetto@gmail.com',
                     ['class' => 'form-control'


                     ]) }}
                </div>
            </div>

        </div>

        <hr>


        {{ Form::submit('Importa', array('class' => 'btn btn-danger btn-xs')) }}
        {{ Form::close() }}

        <hr><hr>

        <div class="row">
            <div class="col-md-12">
                {{ Form::label('Campi disponibili per importazione utente:') }}
                {{ $userfield  }}

            </div></div>
        <div class="row">
            <div class="col-md-12">

                {{ Form::label('Campi disponibili per importazione societa:') }}
                {{ $societafield  }}

            </div>
        </div>
        <br>

    </div>

@stop



