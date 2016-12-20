
<div class="form-group filterlist">
    {{ Form::label('_mansioni', 'Mansioni:') }}
    <div class="row">
        <div class="col-sm-4">
            {{ Form::text('txtSearch',null,  [ 'id'=> 'txtSearch', 'class' => 'form-control', 'placeholder' => 'Filtra']) }}
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3">
            <a class="btn btn-warning btn-xs" id="resetfilter" href="#">visualizza tutti</a>
        </div>
        <div class="col-sm-3">
            <a class="btn btn-warning btn-xs" id="soloselezionati" href="#">visualizza selezionati</a>
        </div>

    </div>
    <hr>

    {{ Form::select('_mansioni[]',$lista_mansioni, $datiRecuperati->_mansioni->lists('id')->toArray(),  ['class' => 'form-control, list-group', 'multiple']) }}

</div>