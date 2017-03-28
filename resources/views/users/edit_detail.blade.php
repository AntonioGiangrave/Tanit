
<hr>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('data_nascita', 'Data di nascita:') }}
            {{ Form::text('data_nascita', $datiRecuperati->user_profiles->data_nascita, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('citta_nascita', 'Città di nascita:') }}
            {{ Form::text('citta_nascita',  $datiRecuperati->user_profiles->citta_nascita, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-4">

        <div class="form-group">
            {{ Form::label('sesso', 'Sesso:') }}
            {{ Form::select('sesso', array(['F', 'M']), $datiRecuperati->user_profiles->sesso ,['class' => 'form-control' ]) }}
        </div>

        <div class="form-group">
            {{ Form::label('codicefiscale', 'Codicefiscale:') }}
            {{ Form::text('codicefiscale',  $datiRecuperati->user_profiles->codicefiscale, ['class' => 'form-control']) }}
        </div>
    </div>
</div>



<hr>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('nazione_residenza', 'Nazione residenza:') }}
            {{ Form::text('nazione_residenza', $datiRecuperati->user_profiles->nazione_residenza, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('citta_residenza', 'Città residenza:') }}
            {{ Form::text('citta_residenza',  $datiRecuperati->user_profiles->citta_residenza, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-4">

        <div class="form-group">
            {{ Form::label('cap_residenza', 'Cap residenza:') }}
            {{ Form::text('cap_residenza',  $datiRecuperati->user_profiles->cap_residenza ,['class' => 'form-control' ]) }}
        </div>

        <div class="form-group">
            {{ Form::label('telefono', 'Telefono:') }}
            {{ Form::text('telefono',  $datiRecuperati->user_profiles->telefono, ['class' => 'form-control']) }}
        </div>
    </div>
</div>


<hr>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('titolo_studio', 'Titolo studio:') }}
            {{ Form::text('titolo_studio', $datiRecuperati->user_profiles->titolo_studio, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('status_id', 'Status:') }}
            {{ Form::select('status_id',$status, $datiRecuperati->user_profiles->status_id, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-4">

        <div class="form-group">
            {{ Form::label('costo_orario_lordo', 'Costo orario lordo:') }}
            {{ Form::text('costo_orario_lordo',  $datiRecuperati->user_profiles->costo_orario_lordo ,['class' => 'form-control' ]) }}
        </div>

        <div class="form-group">
            {{ Form::label('inquadramento', 'Inquadramento:') }}
            {{ Form::text('inquadramento',  $datiRecuperati->user_profiles->inquadramento, ['class' => 'form-control']) }}
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('ccnl', 'CCNL:') }}
            {{ Form::text('ccnl', $datiRecuperati->user_profiles->ccnl, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('divisione', 'Divisione:') }}
            {{ Form::text('divisione',  $datiRecuperati->user_profiles->divisione ,['class' => 'form-control' ]) }}
        </div>
    </div>
</div>
