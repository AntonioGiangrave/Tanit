@extends('layouts.dashboard')
@section('page_heading','Inserisci nuova commessa')


@section('section')


    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        {{ Form::open(['url' =>'commesse/'])}}

        <div class="row">

            <div class="col-md-6">


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
                    {{ Form::select('cliente_id', $clienti_list, null, ['class' => 'form-control']) }}
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                    {{ Form::label('referente', 'Referente:') }}
                    {{ Form::select('referente', $user, null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('stato', 'Stato:') }}
                    {{ Form::select('stato', array('In corso' => 'In corso', 'Preventivo' => 'Preventivo', 'Chiusa' => 'Chiusa') , null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('colore', 'Colore:') }}
                    {{ Form::text('colore',  null, ['class' => 'form-control', 'placeholder' => '#1F3G4A']) }}
                </div>

            </div>
        </div>


        <div class="pull-right" id="q">
            {{ Form::submit('inserisci', ['class' => 'btn btn-success']) }}

            {{ Form::close() }}


        </div>


        <div class="col-md-6">
            {{ Form::label('Riepilogo commesse esistenti') }}
            <div class="pre-scrollable">
                @foreach($commesse as $commessa)
                    <p> {{$commessa->protocollo}} - {{ $commessa->oggetto }}</p>
                @endforeach
            </div>
        </div>




@stop