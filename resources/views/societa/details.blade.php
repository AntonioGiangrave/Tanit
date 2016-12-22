{{
       Form::model($datiRecuperati,
       ['method' => 'put', 'url' =>'societa/'. $datiRecuperati['id']])
       }}

<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            {{ Form::label('ragione_sociale', 'Ragione sociale:') }}
            {{ Form::text('ragione_sociale', null, ['class' => 'form-control']) }}
        </div>

    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ Form::label('tipo', 'Tipo azienda:') }}
            {{ Form::text('tipo', null, ['class' => 'form-control']) }}
        </div>
    </div>
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
            {{ Form::select('ateco_id',  $lista_ateco ,$datiRecuperati->ateco_id, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            {{ Form::label('settore_id', 'Settore:') }}
            {{ Form::select('settore_id', $lista_settori ,$datiRecuperati->settore_id, ['class' => 'form-control']) }}
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
            {{ Form::label('fondo_interprofessionale', 'Fondo interprofessionale:') }}
            {{ Form::text('fondo_interprofessionale', null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ Form::label('fi_dipendenti', 'Dipendenti:') }}
            {{ Form::text('fi_dipendenti', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            {{ Form::label('fi_dirigenti', 'Dirigenti:') }}
            {{ Form::text('fi_dirigenti', null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>





<div class="pull-right">
    {{ Form::button('<i class="fa fa-save"></i> Aggiorna', ['class' => 'btn btn-success', 'type'=>'submit', 'type'=>'submit']) }}

    {{ Form::close() }}

</div>

