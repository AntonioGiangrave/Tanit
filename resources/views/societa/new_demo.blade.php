@extends('cache.index')

@section('page_heading','Nuova societa demo: ' )
@section('body')

    {{
           Form::open(['method' => 'post', 'url' =>'societa'])
           }}

    {{ Form::hidden('demo', 1, ['class' => 'form-control']) }}

    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                {{ Form::label('ragione_sociale', 'Ragione sociale:') }}
                {{ Form::text('ragione_sociale', null, ['class' => 'form-control']) }}
            </div>

        </div>
        {{--<div class="col-sm-4">--}}
        {{--<div class="form-group">--}}
        {{--{{ Form::label('tipo', 'Tipo azienda:') }}--}}
        {{--{{ Form::text('tipo', null, ['class' => 'form-control']) }}--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>

    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                {{ Form::label('descrizione_attivita', 'Descrizione attività:') }}
                {{ Form::text('descrizione_attivita', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                {{ Form::label('indirizzo_sede_legale', 'Indirizzo sede legale:') }}
                {{ Form::text('indirizzo_sede_legale' ,null ,['class' => 'form-control' ]) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('n_dipendenti', 'Numero dipendenti:') }}
                {{ Form::text('n_dipendenti' ,null ,['class' => 'form-control' ]) }}
            </div>
        </div>
    </div>

    <hr>
    <h4>Dettagli</h4>
    <div class="row">


        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('piva', 'Partita IVA:') }}
                {{ Form::text('piva', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('cod_fiscale', 'Codice Fiscale:') }}
                {{ Form::text('cod_fiscale' ,null ,['class' => 'form-control' ]) }}
            </div>
        </div>
        <div class="col-sm-4">

        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('telefono', 'Telefono:') }}
                {{ Form::text('telefono', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('cellulare', 'Cellulare:') }}
                {{ Form::text('cellulare', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('email', 'Email:') }}
                {{ Form::text('email', null, ['class' => 'form-control']) }}
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('citta', 'Citta:') }}
                {{ Form::text('citta', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('cap', 'Cap:') }}
                {{ Form::text('cap', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('regione', 'Regione:') }}
                {{ Form::text('regione', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('sito', 'Sito:') }}
                {{ Form::text('sito', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('ref_aziendale', 'Referente aziendale:') }}
                {{ Form::text('ref_aziendale', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>

    <hr>
    <h4>Caratteristiche</h4>
    <div class="row">

        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('ateco_id', 'Codice ATECO:') }}
                {{ Form::select('ateco_id',  $lista_ateco ,null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('settore_id', 'Settore:') }}
                {{ Form::select('settore_id', $lista_settori ,null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">

            </div>
        </div>

    </div>

    <hr>
    <h4>Sede operativa</h4>
    <div class="row">


        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('so_indirizzo', 'Indirizzo:') }}
                {{ Form::text('so_indirizzo', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('so_citta', 'Citta:') }}
                {{ Form::text('so_citta', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('so_cap', 'Cap:') }}
                {{ Form::text('so_cap', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>

    <hr>
    <h4>Fondo Interprofessionale</h4>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('fondo_id', 'Codice ATECO:') }}
                {{ Form::select('fondo_id',  $lista_fondi , null , ['class' => 'form-control']) }}
            </div>
        </div>
    </div>





    <div class="pull-right">
        {{ Form::button('<i class="fa fa-save"></i> Salva', ['class' => 'btn btn-tanit', 'type'=>'submit', 'type'=>'submit']) }}

        {{ Form::close() }}

    </div>



@stop