<div class="row">
    <div class="col-md-4">
        {{ Form::label('Autorizzazioni', 'Gruppi:') }}
        <div class='form-group'>
            @foreach ($roles as $key => $val)
                <br>
                {{ Form::checkbox('groups[]', $key) }}
                {{ Form::label('groups', $val) }}
            @endforeach
        </div>
    </div>
</div>
<hr>

{{--<h4>Tutor aziendale</h4>--}}
{{ Form::label('_tutor_societa', 'Tutor società:') }}
@if($datiRecuperati->hasRole('azienda'))
    <div class="row">
        <div class="col-md-12">
            <div class="form-group filterlist">

                {{ Form::select('_tutor_societa[]',$lista_societa,  $datiRecuperati->_tutor_societa->lists('id')->toArray() ,  ['class' => 'form-control, list-group', 'multiple']) }}
            </div>
        </div>
    </div>
@else
    <p class="bg-warning">Solo per gli account con profilo "AZIENDA" è possibile specificare per quali Societa sono tutor. <br>
        Se hai assegnato ora il gruppo Azienda, salva/aggiorna e ritorna su questa pagina.</p>
@endif
