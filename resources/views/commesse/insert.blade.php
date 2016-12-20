@extends('layouts.dashboard')
@section('page_heading','Modifica commessa')


@section('section')


    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        {{ Form::model($datiRecuperati,
        ['method' => 'put', 'url' =>'commesse/'. $datiRecuperati['id']])
        }}

        <div class="form-group">
            {{ Form::label('protocollo', 'Protocollo:') }}
            {{ Form::text('protocollo', null, ['class' => 'form-control']) }}
        </div>


        <div class="form-group">
            {{ Form::label('oggetto', 'Oggetto:') }}

            {{ Form::text('oggetto', null, ['class' => 'form-control']) }}
        </div>


        <div class="form-group">
            {{ Form::label('cliente', 'Cliente:') }}

            {{ Form::select('cliente_id', $clienti_list, Input::old('cliente_id') , ['class' => 'form-control']) }}
        </div>


        <div class="pull-right" id="q">
            {{ Form::submit('aggiorna', ['class' => 'btn btn-success']) }}

            {{ Form::close() }}

            {{ Form::open([
            'method' => 'DELETE',
            'route' => ['users', $datiRecuperati['id']]
            ]) }}
            {{ Form::submit('Cancella', ['class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    </div>

@stop